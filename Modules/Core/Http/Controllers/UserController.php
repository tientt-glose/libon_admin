<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use stdClass;
use Illuminate\Http\Request;
use Modules\Core\Entities\User;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Modules\Core\Entities\Organization;
use Yajra\Datatables\Datatables;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function checkUserInfo(Request $request)
    {
        try {
            $result = new stdClass();

            switch ($request->status) {
                case $this->user::CHECK_BY_CODE:
                    $result->message = $this->user->getUserByCode($request->user_code);
                    $result->result = 1;
                    break;
                case $this->user::CHECK_BY_CARD:
                    $result->message = $this->user->getUserByCard($request->user_code);
                    $result->result = 1;
                    break;
                default:
                    $result->message = 'Không tìm thấy người dùng';
                    $result->result = 0;
                    break;
            }

            return \response()->json($result);
        } catch (\Throwable $th) {
            $result->detail = $th->getMessage();
            $result->message = 'Không tìm thấy người dùng';
            $result->result = 0;
            return \response()->json($result);
        }
    }

    public function index()
    {
        return view('core::user.index');
    }
    public function get()
    {
        return Datatables::of(User::select('*')->with('orders')->get())
            ->escapeColumns([])
            ->addColumn('actions', function ($user) {
                $html = $this->user->genColumnHtml($user);
                return $html;
            })
            ->make(true);
    }

    public function create()
    {
        $organization = Organization::all();
        return view('core::user.create', compact('organization'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            unset($params['_token']);
            $validatorArray = [
                'fullname' => 'required',
                'id_card' => 'required',
                'email' => 'required',
                'password' => 'required|min:6',
                'dob' => 'required',
                'career' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'organization_id' => 'required',
                'id_staff_student' => 'required',
                'admin' => 'required',
            ];
            $messages = [
                'fullname.required' => 'Thiếu họ tên',
                'id_card.required' => 'Thiếu mã thẻ mượn sách',
                'email.required' => 'Thiếu địa chỉ email',
                'password.required' => 'Thiếu mật khẩu',
                'password.min' => 'Mật khẩu quá ngắn',
                'dob.required' => 'Thiếu ngày tháng năm sinh',
                'career.required' => 'Thiếu công việc hiện tại',
                'gender.required' => 'Thiếu giới tính',
                'phone.required' => 'Thiếu số điện thoại',
                'organization_id.required' => 'Thiếu doanh nghiệp',
                'id_staff_student.required' => 'Thiếu mã thẻ CCCD/SV',
                'admin.required' => 'Thiếu lựa chọn có phải admin không',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            $user = $params;
            $user['password'] = Hash::make($params['password']);
            $this->user::insert($user);

            DB::commit();
            return redirect()->route('user.index')->with(['success' => 'Thêm người dùng thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[User Add]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function edit($id)
    {
        $user = $this->user->getUserById($id);
        $organization = Organization::all();
        return view('core::user.edit', compact('user', 'organization'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $params = $request->all();
            unset($params['password']);
            unset($params['_token']);

            $validatorArray = [
                'fullname' => 'required',
                'id_card' => 'required',
                'email' => 'required',
                'password' => 'min:6',
                'dob' => 'required',
                'career' => 'required',
                'gender' => 'required',
                'phone' => 'required',
                'organization_id' => 'required',
                'id_staff_student' => 'required',
                'admin' => 'required',
            ];
            $messages = [
                'fullname.required' => 'Thiếu họ tên',
                'id_card.required' => 'Thiếu mã thẻ mượn sách',
                'email.required' => 'Thiếu địa chỉ email',
                'password.min' => 'Mật khẩu quá ngắn',
                'dob.required' => 'Thiếu ngày tháng năm sinh',
                'career.required' => 'Thiếu công việc hiện tại',
                'gender.required' => 'Thiếu giới tính',
                'phone.required' => 'Thiếu số điện thoại',
                'organization_id.required' => 'Thiếu doanh nghiệp',
                'id_staff_student.required' => 'Thiếu mã thẻ CCCD/SV',
                'admin.required' => 'Thiếu lựa chọn có phải admin không',
            ];
            $validator = Validator::make($params, $validatorArray, $messages);
            if ($validator->fails()) {
                return redirect()->back()->withInput()->withErrors($validator->errors());
            }

            if (!empty($request->password)) {
                $params['password'] = Hash::make($request->password);
            }
            $this->user->updateUser($id, $params);

            DB::commit();
            return redirect()->route('user.index')->with(['success' => 'Sửa người dùng thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[User Edit]' . $th->getMessage());
            return redirect()->back()->withInput()->withErrors($th->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            if (empty($id)) {
                return redirect()->back()->withErrors('Xóa người dùng không thành công');
            }

            $countOrder = $this->user->find($id)->orders()->count();
            if ($countOrder > 0) {
                return redirect()->back()->withErrors('Không thể xóa người dùng đang có đơn mượn');
            }

            $this->user->deleteUser($id);
            DB::commit();
            return redirect()->back()->with(['success' => 'Xóa người dùng thành công']);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('[User Delete]' . $th->getMessage());
            return redirect()->back()->withErrors($th->getMessage());
        }
    }
}
