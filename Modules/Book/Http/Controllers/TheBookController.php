<?php

namespace Modules\Book\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Book\Entities\Book;
use Yajra\Datatables\Datatables;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Book\Entities\TheBook;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;

class TheBookController extends Controller
{
    protected $book;
    protected $theBook;

    public function __construct(Book $book, TheBook $theBook)
    {
        $this->book = $book;
        $this->theBook = $theBook;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index($bookId)
    {
        $book = $this->book->getBookWithPubById($bookId);
        if (!empty($book->pic_link)) {
            $book->pic_link = json_decode($book->pic_link);
        }
        $this->changeStatusOfBook($bookId);

        return view('book::the-books.index', compact('bookId', 'book'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('book::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request, $bookId)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            // dd($params);

            $validatorArray = [
                'barcode' => 'required',
            ];

            $messages = [
                'barcode.required' => 'Thiếu barcode của sách',
            ];

            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }
            // dd($params['barcode']);
            // 00001000020000300004000050000600007
            $listBarcode = preg_split('/\R/', $params['barcode']);
            $listBarcode = array_unique($listBarcode);
            // $test = explode(PHP_EOL, $params['barcode']);
            // dd($test);

            $listTheBook = array();

            foreach ($listBarcode as $barcode) {
                $theBook = [
                    'barcode' => trim($barcode),
                    'publishing_year' => $params['pub_year'],
                    'book_id' => $bookId,
                ];
                array_push($listTheBook, $theBook);
            }

            $this->theBook->insert($listTheBook);

            $countTheBook = $this->theBook->countTheBookWithBookId($bookId);
            $this->book->updateQuantity($bookId, $countTheBook);
            $this->changeStatusOfBook($bookId);

            DB::commit();
            return redirect()->back()->with(['success' => 'Thêm sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[The Book Add]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('book::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('book::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $bookId)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $validatorArray = [
                'barcode' => 'required',
            ];

            $messages = [
                'barcode.required' => 'Thiếu barcode của sách',
            ];

            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $theBook = [
                'barcode' => trim($params['barcode']),
                'publishing_year' => $params['pub_year'],
            ];

            $this->theBook->updateTheBook($params['the_book_id'], $theBook);

            DB::commit();
            return redirect()->back()->with(['success' => 'Sửa sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[The Book edit Edit]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if (empty($id)) {
                return redirect()->back()->withErrors('Xóa sách không thành công');
            }

            //check the book whether available or not, if unavailable -> error
            $theBook = $this->theBook->find($id);

            if ($theBook->status != $this->theBook::AVAILABLE) {
                return redirect()->back()->withErrors('Bạn không được phép xóa sách đang có người mượn');
            }

            $this->theBook->deleteTheBook($id);

            $countTheBook = $this->theBook->countTheBookWithBookId($request->book_id);
            $this->book->updateQuantity($request->book_id, $countTheBook);
            $this->changeStatusOfBook($request->book_id);

            DB::commit();
            return redirect()->back()->with(['success' => 'Xóa sách thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[The Book Delete]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }

    public function get(Request $request)
    {
        $query = $this->book->find($request->book_id)->theBooks();
        // dd($query);

        return Datatables::of($query)
            ->escapeColumns([])
            ->addColumn('actions', function ($theBook) {
                $html = $this->theBook->genColumnHtml($theBook);
                return $html;
            })
            ->addColumn('status', function ($theBook) {
                $html = '';
                if ($theBook->status == $this->theBook::AVAILABLE) {
                    $html .= '<span class="badge badge-success">Khả dụng</span>';
                    return $html;
                } else if ($theBook->can_borrow == $this->theBook::UNBORROWABLE) {
                    $html .= '<span class="badge badge-info">Đang được mượn</span>';
                    return $html;
                }
            })
            ->make(true);
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
