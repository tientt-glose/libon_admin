<p align="center"><a href="http://libon-vn.tk/" target="_blank"><img src="https://raw.githubusercontent.com/tientt-glose/libon-admin/mvp_2/public/img/logo.png" width="400"></a></p>

## Về LibOn

LibOn là hệ thống thư viện điện tử tiện lợi với tính năng đặt mượn sách Pickup Book. Pickup Book với quy trình đặt mượn sách dễ dàng, nhanh chóng, hiện đại sẽ giải quyết vấn đề của bạn.

Hãy trải nghiệm sản phẩm ngay tại http://libon-vn.tk/!

## Hướng dẫn chạy project LibOn Server

1. Cd vào thư mục
1. Thiết lập file env từ file env example đặc biệt là thông tin kết nối CSDL
1. `php artisan key:generate`
1. `php artisan migrate`
1. Nhập data ở ./DB vào CSDL
1. `php artisan serve --port= port đã set trong file env`
1. Truy cập với thông tin tài khoản admin
```
User: admin@admin.com
Pass: 123456
```

Tham khảo một số câu lệnh làm việc với Laravel Modules https://nwidart.com/laravel-modules/v6/advanced-tools/artisan-commands

## Thông tin liên hệ

Số điện thoại: 0945391533

Email: tiennguyenbka198@gmail.com
