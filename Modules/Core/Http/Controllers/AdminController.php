<?php

namespace Modules\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Support\Renderable;
use Modules\Core\Http\Requests\LoginRequest;

class AdminController extends Controller
{
    public function index()
    {
        return view('core::index');
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        } else {
            return view('core::user.login');
        }
    }

    public function loginPost(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'admin' => 1], $request->remember_me)) {
            return redirect()->route('home')->with(['success' => 'Đăng nhập thành công']);
        } else {
            return redirect()->back()->withInput()->withErrors('Tài khoản hoặc mật khẩu không hợp lệ');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with(['success' => 'Đăng xuất thành công']);
    }
}
