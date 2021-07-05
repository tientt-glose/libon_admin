<?php

namespace Modules\Core\Http\Controllers\Api;

use Illuminate\Http\Request;
use Modules\Core\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Support\Renderable;
use Modules\Core\Http\Controllers\ApiController;

class UserController extends ApiController
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login(Request $request)
    {
        try {
            $params = $request->all();

            $validatorArray = [
                'email' => 'required|email',
                'password' => 'required',
            ];
            $messages = [
                'email.required' => 'Thiếu địa chỉ email',
                'email.email' => 'Địa chỉ email không hợp lệ',
                'password.required' => 'Thiếu mật khẩu',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()->all()], 'Response Successfully');
            }

            $user = $this->user->getUserForAuth($params['email']);

            if (!empty($user)) {
                if (Hash::check($params['password'], $user->password)) {
                    do {
                        $user->access_token = bin2hex(openssl_random_pseudo_bytes(64));
                    } while (count($this->user->getUserByAccessToken($user->access_token)) != 0);

                    $data = [
                        'access_token' => $user->access_token,
                        'count_login' => $user->count_login + 1
                    ];

                    $this->user->updateUser($user->id, $data);
                    unset($user->password, $user->updated_at);

                    return $this->successResponse(['result' => $user], 'Response Successfully');
                } else {
                    return $this->successResponse(['errors' => 'Mật khẩu không đúng'], 'Response Successfully');
                }
            } else {
                return $this->successResponse(['errors' => 'Tên đăng nhập không đúng'], 'Response Successfully');
            }
        } catch (\Throwable $th) {
            Log::error('[Login]' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }

    public function signup(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();

            $validatorArray = [
                'fullname' => 'required',
                'email' => 'required|email',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'phone' => 'required|numeric',
                'card' => 'required|numeric',
                'organ' => 'required',
                'career' => 'required',
                'code' => 'required|numeric',
            ];
            $messages = [
                'fullname.required' => 'Thiếu họ và tên',
                'email.required' => 'Thiếu địa chỉ email',
                'email.email' => 'Địa chỉ email không hợp lệ',
                'password.required' => 'Thiếu mật khẩu',
                'password.confirmed' => 'Mật khẩu và mật khẩu xác nhận không trùng nhau',
                'password_confirmation.required' => 'Thiếu mật khẩu xác nhận',
                'phone.required' => 'Thiếu số điện thoại',
                'phone.numeric' => 'Số điện thoại phải là số',
                'card.required' => 'Thiếu số CMT, CCCD',
                'card.numeric' => 'Số CMT, CCCD phải là số',
                'organ.required' => 'Thiếu lựa chọn tổ chức',
                'career.required' => 'Thiếu lựa chọn nghề nghiệp',
                'code.required' => 'Thiếu MSSV, MCB',
                'code.numeric' => 'MSSV, MCB phải là số',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return $this->successResponse(["errors" => $validator->errors()->all()], 'Response Successfully');
            }

            $user = [
                'admin' => 0,
                'id_card' => $params['card'],
                'fullname' => $params['fullname'],
                'email' => $params['email'],
                'password' => bcrypt($params['password']),
                'phone' => $params['phone'],
                'organization_id' => $params['organ'],
                'career' => $params['career'],
                'id_staff_student' => $params['code'],

            ];

            $user = $this->user->insertGetId($user);

            DB::commit();
            return $this->successResponse(['success' => 1], 'Response Successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[Signup]' . $th->getMessage());
            return $this->successResponse(["errors" => $th->getMessage()], 'Response Successfully');
        }
    }
}
