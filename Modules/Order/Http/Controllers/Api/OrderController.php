<?php

namespace Modules\Order\Http\Controllers\Api;

use stdClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Modules\Core\Entities\User;

use Modules\Order\Entities\Order;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Order\Entities\BookInOrder;
use Illuminate\Support\Facades\Validator;
use Modules\Core\Http\Controllers\ApiController;

class OrderController extends ApiController
{
    protected $order;
    protected $bookInOrder;
    protected $user;

    public function __construct(Order $order, BookInOrder $bookInOrder, User $user)
    {
        $this->order = $order;
        $this->bookInOrder = $bookInOrder;
        $this->user = $user;
    }

    public function createBorrowOrder(Request $request)
    {
        DB::beginTransaction();
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'books' => 'required',
                'user_id'  => 'required',
                'delivery' => 'integer',
                'address' => Rule::requiredIf($params['delivery'] == $this->order::SHIPPING)
            ];
            $messages = [
                'books.required' => 'Thiếu thông tin sách',
                'user_id.required'  => 'Thiếu thông tin người mượn',
                'delivery.integer' => 'Thiếu dữ liệu hình thức lấy sách',
                'address.required' => 'Thiếu địa chỉ nhận sách'
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()], 'Response Successfully');
            }

            $order = [
                'status' => $this->order::BORROW_ORDER_CREATED_STATUS,
                'user_id' => $params['user_id'],
                'created_at' => Carbon::now(),
                'delivery' => $params['delivery'],
                'address' => array_key_exists('address', $params) ? $params['address'] : null
            ];

            $orderId = $this->order::insertGetId($order);

            //Them the book vao bang book in order
            $listBookInOrder = [];

            foreach ($params['books'] as $id => $value) {
                $book = [
                    'order_id' => $orderId,
                    'book_id' => $id,
                    'created_at' => Carbon::now()
                ];
                array_push($listBookInOrder, $book);
            }

            $this->bookInOrder->insert($listBookInOrder);

            $result->quantity = count($params['books']);
            $result->bookName = implode(', ', $params['books']);
            $result->createdAt = $order['created_at'];
            $result->delivery = $order['delivery'];
            $result->address = $order['address'];
            $result->orderId = $orderId;
            $result->success = 1;

            DB::commit();
            return $this->successResponse($result, 'Response Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Borrow Order Client] ' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }

    public function index(Request $request)
    {
        try {
            $result = new stdClass();
            $params = $request->all();

            $validatorArray = [
                'user_id'  => 'required',
            ];
            $messages = [
                'user_id.required'  => 'Thiếu thông tin người mượn',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()], 'Response Successfully');
            }

            $result->orders = $this->order->getOrderWithBookByUserId($request->user_id);
            foreach ($result->orders as $order) {
                $bookNameArray = [];
                // dd($order);
                foreach ($order->booksInOrders as $booksInOrder) {
                    array_push($bookNameArray, $booksInOrder->book->name);
                }
                $bookName = implode(', ', $bookNameArray);
                $order['book_name'] = $bookName;
                $order['quantity'] = count($order->booksInOrders);
                $order['restore_deadline'] = $order['restore_deadline'] ? date('d-m-Y', strtotime($order['restore_deadline'])) : null;
                $order['pick_time'] = $order['pick_time'] ? date('d-m-Y H:i', strtotime($order['pick_time'])) : null;
                $order['restore_time'] = $order['restore_time'] ? date('d-m-Y H:i', strtotime($order['restore_time'])) : null;
                $order['created_at'] = $order['created_at'] ? date('d-m-Y H:i', strtotime($order['created_at'])) : null;
            }
            return $this->successResponse($result, 'Response Successfully');
        } catch (\Throwable $th) {
            Log::error('[Get Order List Client] ' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }
}
