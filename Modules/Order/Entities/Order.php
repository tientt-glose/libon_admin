<?php

namespace Modules\Order\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Entities\User;

class Order extends Model
{
    protected $guarded = [];

    const CANCEL = 0; //Bi huy
    const BORROW_ORDER_CREATED_STATUS = 1; //Tao don muon thanh cong
    const BORROWING = 2; //Dang muon
    const DEADLINE_IS_COMMING = 3; //Sap toi han tra
    const OVERDUE = 4; //Qua han
    const RESTORED = 5; //Da tra

    const DEFAULT_DEADLINE = 60; //60 ngay
    const DEFAULT_QUANTITY = 8; //8 quyen

    const PICKUP = 1; //tu den lay
    const SHIPPING = 2; //ship

    public static function listStatus()
    {
        return array(
            0 => 'Bị hủy',
            1 => 'Tạo đơn mượn thành công',
            2 => 'Đang mượn',
            3 => 'Sắp tới hạn trả',
            4 => 'Quá hạn',
            5 => 'Đã trả'
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function booksInOrders()
    {
        return $this->hasMany(BookInOrder::class);
    }

    public function booksInOrdersTrashed()
    {
        return $this->hasMany(BookInOrder::class)->withTrashed();
    }

    public function getOrderById($orderId)
    {
        return $this->where('id', $orderId)->first();
    }

    public function getOrderWithUserAndBookById($orderId)
    {
        return $this->where('id', $orderId)->with('user:id,id_card,fullname,id_staff_student,email', 'booksInOrders.theBook:id,barcode', 'booksInOrders.book:id,pic_link,name,author')->first();
    }

    public function getOrderWithUserAndBookByIdWithTrash($orderId)
    {
        return $this->where('id', $orderId)->with('user:id,id_card,fullname,id_staff_student,email', 'booksInOrdersTrashed.theBook:id,barcode', 'booksInOrdersTrashed.book:id,pic_link,name,author')->first();
    }

    public function getOrderWithBookByUserId($userId)
    {
        return $this->where('user_id', $userId)->with('booksInOrders.book:id,name,author')->get();
    }

    public function updateOrder($id, $order)
    {
        return $this->where('id', $id)->update($order);
    }

    public static function genStatusHtml($status)
    {
        $html = '';
        switch ($status) {
            case self::CANCEL:
                $html .= '<span class="badge badge-danger"><i class="fas fa-times"></i>&nbsp;Bị hủy</span>';
                break;
            case self::BORROW_ORDER_CREATED_STATUS:
                $html .= '<span class="badge badge-info"><i class="fas fa-plus"></i>&nbsp;Tạo thành công</span>';
                break;
            case self::BORROWING:
                $html .= '<span class="badge badge-success"><i class="fas fa-sync-alt fa-spin"></i>&nbsp;&nbsp;Đang mượn</span>';
                break;
            case self::DEADLINE_IS_COMMING:
                $html .= '<span class="badge badge-warning"><i class="fas fa-clock"></i>&nbsp;Sắp tới hạn trả</span>';
                break;
            case self::OVERDUE:
                $html .= '<span class="badge badge-danger"><i class="fas fa-clock"></i>&nbsp;Quá hạn</span>';
                break;
            case self::RESTORED:
                $html .= '<span class="badge badge-success"><i class="fas fa-check"></i>&nbsp;Đã trả</span>';
                break;
            default:
                # code...
                break;
        }
        return $html;
    }

    public static function genColumnHtml($data)
    {
        $column = "";
        if (!empty($data)) {
            $column .= '<a href="' . route('order.orders.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit" title="Sửa đơn mượn"></i></a>';
        }
        return $column;
    }
}
