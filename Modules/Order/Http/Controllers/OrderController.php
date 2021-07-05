<?php

namespace Modules\Order\Http\Controllers;

use stdClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Modules\Book\Entities\Book;
use Yajra\Datatables\Datatables;
use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Book\Entities\TheBook;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\BookInOrder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class OrderController extends Controller
{
    protected $book;
    protected $order;
    protected $theBook;
    protected $bookInOrder;

    public function __construct(Book $book, TheBook $theBook, Order $order, BookInOrder $bookInOrder)
    {
        $this->book = $book;
        $this->order = $order;
        $this->theBook = $theBook;
        $this->bookInOrder = $bookInOrder;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $actions = request()->route()->getAction();
        $controller = (explode("@", $actions['controller']));
        $controller = $controller[0];
        $listStatus = $this->order->listStatus();
        return view('order::orders.index', compact('listStatus'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('order::orders.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $validatorArray = [
                'user_id' => 'required',
                'barcode' => 'required',
                'book_id' => 'required',
                'delivery' => 'integer',
                'address' => Rule::requiredIf($params['delivery'] == $this->order::SHIPPING)
            ];
            $messages = [
                'user_id.required' => 'Thiếu thông tin người đặt mượn',
                'barcode.required' => 'Thiếu mã sách (barcode)',
                'book_id.required' => 'Thiếu mã đầu sách',
                'delivery.integer' => 'Thiếu dữ liệu hình thức lấy sách',
                'address.required' => 'Thiếu địa chỉ nhận sách'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            if (count($params['barcode']) != count(array_unique($params['barcode']))) {
                return redirect()->back()->withInput()->withErrors('Trong đơn có trường hợp mã sách giống nhau');
            }

            if (count($params['book_id']) != count(array_unique($params['book_id']))) {
                return redirect()->back()->withInput()->withErrors('Mỗi đơn chỉ được mượn 1 đầu sách');
            }

            //Them order va thay doi trang thai order
            $order = [
                'status' => $this->order::BORROWING,
                'restore_deadline' => Carbon::now()->tomorrow()->addDays($this->order::DEFAULT_DEADLINE),
                'pick_time' => Carbon::now(),
                'created_at' => Carbon::now(),
                'user_id' => $params['user_id'],
                'delivery' => $params['delivery'],
                'address' => array_key_exists('address', $params) ? $params['address'] : null
            ];

            $orderId = $this->order->insertGetId($order);

            //Them the book vao bang book in order
            $listBookInOrder = [];

            for ($i = 0; $i < count($params['barcode']); $i++) {
                $book = [
                    'order_id' => $orderId,
                    'the_book_id' => $this->theBook->getTheBook($params['barcode'][$i])->id,
                    'book_id' => $params['book_id'][$i],
                    'created_at' => Carbon::now()
                ];
                array_push($listBookInOrder, $book);
            }
            // dd($listBookInOrder);
            $this->bookInOrder->insert($listBookInOrder);

            // thay doi trang thai cua the book
            foreach ($params['barcode'] as $value) {
                $this->theBook->updateStatusByBarcode($value, $this->theBook::UNBORROWABLE);
            }

            //update status, borrowed cua book
            foreach ($params['book_id'] as $value) {
                $this->changeStatusOfBook($value);
                $this->book->updateBorrowed($value, $this->book->getBookById($value)->borrowed + 1);
            }

            DB::commit();
            return redirect()->route('order.orders.index')->with(['success' => 'Thêm đơn mượn thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Order Add]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $query = $this->order->getOrderWithUserAndBookByIdWithTrash($id);
        // dd($query);
        foreach ($query->booksInOrdersTrashed as $value) {
            $img = json_decode($value->book->pic_link);
            $img = url($img[0]);
            $value->book->pic_link = $img;
        }

        switch ($query->status) {
            case $this->order::BORROW_ORDER_CREATED_STATUS:
                return redirect()->route('order.orders.edit', $id);
                break;
            case $this->order::BORROWING:
            case $this->order::DEADLINE_IS_COMMING:
            case $this->order::OVERDUE:
                return redirect()->route('order.orders.edit', $id);
                break;
            case $this->order::RESTORED:
            case $this->order::CANCEL:
                return view('order::orders.show', compact('query'));
                break;
            default:
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $query = $this->order->getOrderWithUserAndBookById($id);
        foreach ($query->booksInOrders as $value) {
            $img = json_decode($value->book->pic_link);
            $img = url($img[0]);
            $value->book->pic_link = $img;
        }

        switch ($query->status) {
            case $this->order::BORROW_ORDER_CREATED_STATUS:
                return view('order::orders.edit-input', compact('query'));
                break;
            case $this->order::BORROWING:
            case $this->order::DEADLINE_IS_COMMING:
            case $this->order::OVERDUE:
                return view('order::orders.edit-output', compact('query'));
                break;
            case $this->order::RESTORED:
            case $this->order::CANCEL:
                return redirect()->route('order.orders.show', $id);
                break;
            default:
                break;
        }
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $orderId)
    {
        // dd($request->all(), $orderId);

        DB::beginTransaction();
        try {
            $params = $request->all();

            if (empty($params['barcode'][0])) {
                unset($params['barcode'][0]);
            }

            $validatorArray = [
                'barcode' => 'required',
                'order_status' => 'integer|size:1',
                'delivery' => 'integer',
                'address' => Rule::requiredIf($params['delivery'] == $this->order::SHIPPING)
            ];
            $messages = [
                'barcode.required' => 'Thiếu mã sách (barcode)',
                'order_status.integer' => 'Lỗi. (status phải là số)',
                'order_status.size' => 'Lỗi. (status phải bằng 1)',
                'delivery.integer' => 'Thiếu dữ liệu hình thức lấy sách',
                'address.required' => 'Thiếu địa chỉ nhận sách'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $order = [
                'status' => $this->order::BORROWING,
                'restore_deadline' => Carbon::now()->tomorrow()->addDays($this->order::DEFAULT_DEADLINE),
                'pick_time' => Carbon::now(),
                'delivery' => $params['delivery'],
                'address' => array_key_exists('address', $params) ? $params['address'] : null
            ];

            $this->order->updateOrder($orderId, $order);

            foreach ($params['barcode'] as $bookId => $barcode) {
                $theBookId = $this->theBook->getTheBookByBarcodeAndBookId($barcode, $bookId)->id;
                if ($this->theBook->getStatusTheBookByBarcode($barcode)->status == $this->theBook::UNBORROWABLE) {
                    return redirect()->back()->withInput()->withErrors($barcode . 'Không khả dụng. Lỗi nhập sách');
                }
                $this->bookInOrder->inputBarcode($orderId, $bookId, $theBookId);
            }

            // thay doi trang thai cua the book
            foreach ($params['barcode'] as $barcode) {
                $this->theBook->updateStatusByBarcode($barcode, $this->theBook::UNBORROWABLE);
            }

            //update status, borrowed cua book
            foreach ($params['barcode'] as $bookId => $barcode) {
                $this->changeStatusOfBook($bookId);
                $this->book->updateBorrowed($bookId, $this->book->getBookById($bookId)->borrowed + 1);
            }

            DB::commit();
            return redirect()->back()->with(['success' => 'Nhập sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Order Input Book]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }


    public function updateOutput(Request $request, $orderId)
    {
        // dd($request->all());

        DB::beginTransaction();
        try {
            $params = $request->all();

            if (empty($params['barcode'][0])) {
                unset($params['barcode'][0]);
            }

            $validatorArray = [
                'barcode' => 'required',
                'order_status' => 'integer'
            ];
            $messages = [
                'barcode.required' => 'Thiếu mã sách (barcode)',
                'order_status.integer' => 'Lỗi. (status phải là số)'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $order = [
                'status' => $this->order::RESTORED,
                'restore_time' => Carbon::now()
            ];

            $this->order->updateOrder($orderId, $order);

            foreach ($params['barcode'] as $bookId => $barcode) {
                $this->theBook->getTheBookByBarcodeAndBookId($barcode, $bookId)->id;
                if ($this->theBook->getStatusTheBookByBarcode($barcode)->status == $this->theBook::AVAILABLE) {
                    return redirect()->back()->withInput()->withErrors($barcode . 'Sách này đang khả dụng. Lỗi trả sách');
                }
            }

            // thay doi trang thai cua the book
            foreach ($params['barcode'] as $barcode) {
                $this->theBook->updateStatusByBarcode($barcode, $this->theBook::AVAILABLE);
            }

            //update status, borrowed cua book
            foreach ($params['barcode'] as $bookId => $barcode) {
                $this->changeStatusOfBook($bookId);
                $this->book->updateBorrowed($bookId, $this->book->getBookById($bookId)->borrowed - 1);
            }

            DB::commit();
            return redirect()->route('order.orders.show', $orderId)->with(['success' => 'Trả sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Order Output Book]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function destroy($orderId)
    {
        // dd($orderId);
        DB::beginTransaction();
        try {
            if ($this->order->getOrderById($orderId)->status == $this->order::BORROW_ORDER_CREATED_STATUS) {
                $order = [
                    'status' => $this->order::CANCEL,
                ];
                $this->order->updateOrder($orderId, $order);
                $this->order->getOrderById($orderId)->booksInOrders()->delete();
            } else {
                return redirect()->back()->withInput()->withErrors('Hủy đơn không thành công');
            }

            DB::commit();
            return redirect()->route('order.orders.show', $orderId)->with(['success' => 'Hủy đơn mượn thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Order Cancel]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function get(Request $request)
    {
        $query = $this->order->with('user:id,id_card,fullname,id_staff_student');

        return Datatables::of($query)
            ->filter(function ($query) use ($request) {
                foreach ($request->all() as $key => $value) {
                    if (!($value == '' || $value == -1 || $value == null)) {
                        switch ($key) {
                            case 'status':
                                $query->where('status', $value);
                                break;
                            case 'user_name':
                                $query->whereHas('user', function ($q) use ($value) {
                                    $q->where('fullname', 'LIKE', '%' . $value . '%');
                                });
                                break;
                            case 'created_at':
                                $date = explode(' - ', $value);
                                // dd($date, $value);
                                if ($date[0] != $date[1]) {
                                    // 11/05/2021 00:00
                                    // dd($date[0]);
                                    $start_date = Carbon::createFromFormat('d/m/Y H:i', $date[0])->format('Y-m-d H:i');
                                    // $start_date = Carbon::hasFormatWithModifiers('11/05/2021 00:00', 'd#m#Y! H:i');
                                    // $end_date = Carbon::hasFormatWithModifiers('21/05/1975', 'd#m#Y');
                                    $end_date = Carbon::createFromFormat('d/m/Y H:i', $date[1])->format('Y-m-d H:i');
                                    // dd($date[0],$start_date, $end_date);
                                    $query->whereBetween('created_at', array($start_date, $end_date));
                                }
                                break;
                            case 'order_id':
                                $query->where('id', 'LIKE', '%' . $value . '%');
                                break;
                            case 'card':
                                $query->whereHas('user', function ($q) use ($value) {
                                    $q->where('id_card', 'LIKE', '%' . $value . '%');
                                });
                                break;
                            case 'code':
                                $query->whereHas('user', function ($q) use ($value) {
                                    $q->where('id_staff_student', 'LIKE', '%' . $value . '%');
                                });
                                break;
                            default:
                                break;
                        }
                    }
                }
            })
            ->escapeColumns([])
            ->addColumn('actions', function ($order) {
                $html = $this->order->genColumnHtml($order);
                return $html;
            })
            ->editColumn('status', function ($order) {
                $html = $this->order->genStatusHtml($order->status);
                return $html;
            })
            ->editColumn('restore_deadline', function ($order) {
                if (!empty($order->restore_deadline)) {
                    return Carbon::parse($order->restore_deadline)->format('d-m-Y H:i');
                }
            })
            ->editColumn('pick_time', function ($order) {
                if (!empty($order->pick_time)) {
                    return Carbon::parse($order->pick_time)->format('d-m-Y H:i');
                }
            })
            ->editColumn('restore_time', function ($order) {
                if (!empty($order->restore_time)) {
                    return Carbon::parse($order->restore_time)->format('d-m-Y H:i');
                }
            })
            ->editColumn('created_at', function ($order) {
                if (!empty($order->created_at)) {
                    return Carbon::parse($order->created_at)->format('d-m-Y H:i');
                }
            })
            ->addColumn('user_name', function ($order) {
                if (!empty($order->user)) {
                    return $order->user->fullname;
                } else {
                    return '';
                }
            })
            ->addColumn('user_card', function ($order) {
                if (!empty($order->user)) {
                    return $order->user->id_card;
                } else {
                    return '';
                }
            })
            ->addColumn('user_code', function ($order) {
                if (!empty($order->user)) {
                    return $order->user->id_staff_student;
                } else {
                    return '';
                }
            })
            ->make(true);
    }

    public function addTheBookToOrder(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'list_barcode' => 'required',
            ];

            $messages = [
                'list_barcode.required' => 'Thiếu barcode của sách',
            ];

            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                $result->result = 0;
                $result->detail = $validator->errors();
                $result->message = 'Thiếu barcode của sách';
                return \response()->json($result);
            }
            $listBarcode = array_unique(preg_split('/\R/', $params['list_barcode']));

            $result->errorMess = array();
            $result->html = '';

            $i = $request->index;
            foreach ($listBarcode as $value) {
                $theBook = $this->theBook->getTheBookByBarcode($value);

                if (!empty($theBook)) {
                    if ($theBook->status == 1) {
                        if ($this->book->checkPending($theBook->book->id)) {
                            array_push($result->errorMess, $value . ': Sách với barcode này đang trong hàng đợi đơn trước');
                        } else {
                            $img = json_decode($theBook->book->pic_link);
                            $img = url($img[0]);

                            $result->html .= '<tr><td>' . ++$i . '</td>' .
                                '<td>' . $theBook->barcode . '<input type="hidden" name="barcode[]" value="' . $theBook->barcode . '"/></td>' .
                                '<td>' . $theBook->book->id . '<input type="hidden" name="book_id[]" value="' . $theBook->book->id . '"/></td>' .
                                '<td><img class="image-book" src="' . $img . '"></td>' .
                                '<td>' . $theBook->book->name . '</td>' .
                                '<td>' . $theBook->book->author . '</td>' .
                                '<td><button type="button" class="btn btn-danger btn-xs" onclick="deleteRow($(this))" title="Xóa sách"><i
                            class="fas fa-trash"></i></button></td></tr>';
                        }
                    } else {
                        array_push($result->errorMess, $value . ': Sách với barcode này không khả dụng');
                    };
                } else {
                    array_push($result->errorMess, $value . ': Không tồn tại cuốn sách có mã barcode này');
                }
            }

            $result->errorMess = nl2br(implode(PHP_EOL, $result->errorMess));
            $result->result = 1;
            return \response()->json($result);
        } catch (\Throwable $th) {
            $result->detail = $th->getMessage();
            $result->message = 'Lỗi nhập sách. Vui lòng thử lại';
            $result->result = 0;
            return \response()->json($result);
        }
    }

    public function inputTheBook(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'list_barcode' => 'required',
            ];

            $messages = [
                'list_barcode.required' => 'Thiếu barcode của sách',
            ];

            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                $result->result = 0;
                $result->detail = $validator->errors();
                $result->message = 'Thiếu barcode của sách';
                return \response()->json($result);
            }
            $listBarcode = array_unique(preg_split('/\R/', $params['list_barcode']));

            if (count($listBarcode) > $params['book_id']) {
                $result->result = 0;
                $result->message = 'Số sách nhập vào không được lớn hơn số sách trong đơn';
                return \response()->json($result);
            }

            $result->errorMess = array();
            $bindBookWithBarcode = array();

            foreach ($listBarcode as $key => $barcode) {
                if (empty($this->theBook->getTheBook($barcode))) {
                    array_push($result->errorMess, $barcode . ': Barcode này không tồn tại');
                    unset($listBarcode[$key]);
                }
            }

            foreach ($params['book_id'] as  $bookId) {
                foreach ($listBarcode as $key => $barcode) {
                    if (!empty($this->theBook->getTheBookByBarcodeAndBookId($barcode, $bookId))) {
                        if ($this->theBook->getStatusTheBookByBarcode($barcode)->status != $this->theBook::UNBORROWABLE) {
                            if (empty($bindBookWithBarcode[$bookId])) {
                                $bindBookWithBarcode[$bookId] = $barcode;
                            } else {
                                array_push($result->errorMess, $barcode . ': Barcode này không được gán vì sách ' . $bookId .
                                    ' đã được gán cho barcode ' . $bindBookWithBarcode[$bookId]);
                                unset($listBarcode[$key]);
                            }
                        } else {
                            array_push($result->errorMess, $barcode . ': Barcode này không khả dụng');
                            // Loai bo barcode nay
                            unset($listBarcode[$key]);
                        }
                    }
                }
            }

            foreach ($listBarcode as $barcode) {
                if (!in_array($barcode, $bindBookWithBarcode)) {
                    array_push($result->errorMess, $barcode . ': Barcode này không khớp với bất kỳ sách nào trong đơn');
                }
            }
            // dd($bindBookWithBarcode, $result->errorMess);

            $result->message = $bindBookWithBarcode;
            $result->errorMess = nl2br(implode(PHP_EOL, $result->errorMess));
            $result->result = 1;
            return \response()->json($result);
        } catch (\Throwable $th) {
            $result->detail = $th->getMessage();
            $result->message = 'Lỗi nhập sách. Vui lòng thử lại';
            $result->result = 0;
            return \response()->json($result);
        }
    }

    public function changeStatusOfBook($bookId)
    {
        if ($this->book->checkStatusOfBook($bookId)) {
            $this->book->updateStatus($bookId, $this->book::BORROWABLE);
        } else {
            $this->book->updateStatus($bookId, $this->book::UNBORROWABLE);
        }
    }
}
