<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\chuc_vu;
use App\Models\khuyen_mai;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    public function showFormRegister()
    {
        return view('auth.register');
    }




    // register có thêm tính năng tặng voucher cho khách hàng mới và ko bị giới hạn đăng kí đối với sdt
    public function register(Request $request)
    {
        $validatedData = $request->validate(
            [
                'ho_ten' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:users',
                'so_dien_thoai' => 'required|string|max:10',
                'password' => 'required|string|min:8|confirmed',
            ],
            [
                'ho_ten.required' => 'Họ tên không được để trống',
                'ho_ten.max' => 'Họ tên không được quá 255 ký tự',
                'email.required' => 'Email không được để trống',
                'email.email' => 'Email không đúng định dạng',
                'email.unique' => 'Email đã tồn tại',
                'so_dien_thoai.required' => 'Số điện thoại không được để trống',
                'so_dien_thoai.max' => 'Số điện thoại không được quá 10 ký tự',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'password.min' => 'Tối thiểu là 8 ký tự',
                'password.confirmed' => 'Mật khẩu xác nhận không khớp',
            ]
        );

        // Vai trò mặc định khi đăng ký là 'khach_hang'
        $khachHangRole = chuc_vu::where('ten_chuc_vu', 'khach_hang')->first();

        if (!$khachHangRole) {
            return redirect()->back()->withErrors(['error' => 'Không tìm thấy vai trò "khách hàng".']);
        }

        // Tạo người dùng mới
        $user = User::create([
            'ho_ten' => $validatedData['ho_ten'],
            'email' => $validatedData['email'],
            'so_dien_thoai' => $validatedData['so_dien_thoai'],
            'password' => Hash::make($validatedData['password']),
            'chuc_vu_id' => $khachHangRole->id,
        ]);

        // Kiểm tra xem số điện thoại đã nhận voucher trước đó hay chưa
        // Tìm user dựa trên số điện thoại
        $userWithPhoneNumber = User::where('so_dien_thoai', $validatedData['so_dien_thoai'])->first();

        if ($userWithPhoneNumber) {
            // Kiểm tra xem người dùng đã nhận voucher trước đó hay chưa dựa trên user_id
            $existingUserWithVoucher = khuyen_mai::where('user_id', $userWithPhoneNumber->id)
                ->where('ten_khuyen_mai', 'Khuyến mãi khách hàng mới')
                ->exists();
        } else {
            // Người dùng với số điện thoại này chưa tồn tại
            $existingUserWithVoucher = false;
        }


        if (!$existingUserWithVoucher) {
            // Tạo voucher đặc quyền cho tài khoản đầu tiên với số điện thoại này
            khuyen_mai::create([
                'ten_khuyen_mai' => 'Khuyến mãi khách hàng mới',
                'ma_khuyen_mai' => 'KHACHMOI' . strtoupper(Str::random(8)), // Generate random voucher code
                'gia_tri_khuyen_mai' => 50000,
                'so_luong_ma' => 1,
                'ngay_bat_dau' => now(),
                'ngay_ket_thuc' => now()->addDays(30), // Voucher valid for 30 days
                'is_active' => 1,
                'user_id' => $user->id,
                'so_dien_thoai' => $validatedData['so_dien_thoai'], // Store phone number
            ]);
        }

        // Tự động đăng nhập người dùng sau khi đăng ký
        Auth::login($user);

        return redirect()->route('welcome')->with('success', 'Đăng ký tài khoản thành công' . ($existingUserWithVoucher ? ', nhưng bạn không nhận được voucher.' : ' và bạn đã nhận được voucher khuyến mãi!'));
    }



    public function showFormLogin()
    {
        return view('auth.login');
    }


    public function login(Request $request)
    {



        $credentials = $request->validate(
            [
                'email' => 'required|string|email|max:255',
                'password' => 'required|string'
            ],
            [
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Email không hợp lệ',
                'email.max' => 'Email quá dài',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'password.string' => 'Mật khẩu phải là chuỗi ký tự',

            ]
        );

        if (Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password')
        ], $request->has('remember'))) {
            $user = Auth::user();

            // Phân quyênf cho từng chức vụ của người dùng
            switch ($user->chuc_vu->ten_chuc_vu) {
                case 'admin':
                    return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công');
                case 'nhan_vien':
                    return redirect()->route('admin.home')->with('success', 'Đăng nhập thành công');
                case 'khach_hang':
                    return redirect()->route('welcome')->with('success', 'Đăng nhập thành công');
                    // case 'thanh_vien':
                    //     return redirect()->route('welcome')->with('success', 'Đăng nhập thành công');
                default:
                    Auth::logout();
                    return redirect()->route('login')->withErrors(['error' => 'Chức vụ không tồn tại']);
            }
        }


        return redirect()->back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng',
        ]);
    }


     
    
}
