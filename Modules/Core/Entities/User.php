<?php

namespace Modules\Core\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Order\Entities\Order;

class User extends Model
{
    protected $fillable = [];

    protected $table = 'users';

    const CHECK_BY_CARD = 1;
    const CHECK_BY_CODE = 0;

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function getUserByCard($userCard)
    {
        return $this->where('id_card', $userCard)->firstOrFail();
    }

    public function getUserByCode($userCode)
    {
        return $this->where('id_staff_student', $userCode)->firstOrFail();
    }

    public function getUserForAuth($email)
    {
        return $this->where('email', '=', $email)->select(['id', 'email', 'password', 'access_token', 'fullname', 'count_login'])->first();
    }

    public function getUserByAccessToken($accessToken)
    {
        return $this->where('access_token', $accessToken)->get();
    }

    public function getUserWithOrder($userId)
    {
        return $this->where('id', $userId)->with('orders', 'orders.booksInOrders.book:id,name,author')->first();
    }

    public function getUserById($id)
    {
        return $this->where('id', $id)->with('organization')->first();
    }

    public function updateUser($id, $params)
    {
        return $this->where('id', $id)->update($params);
    }

    public function deleteUser($id)
    {
        return $this->where('id', $id)->delete();
    }

    public static function genColumnHtml($data)
    {
        $message = "'Bạn có chắc chắn muốn xóa người dùng này không?'";
        $column = "";
        if (!empty($data)) {
            $column .= '<a href="' . route('user.edit', $data->id) . '" class="btn btn-primary btn-sm"><i class="fas fa-edit" title="Sửa người dùng"></i></a>';
            if ($data->admin != 1 && empty(count($data->orders))) {
                $column .= '<a href="' . route('user.destroy', $data->id) . '" onclick="return confirm(' . $message . ')" class="btn btn-danger btn-sm"><i class="fas fa-trash" title="Xóa người dùng"></i></a>';
            }
        }
        return $column;
    }
}
