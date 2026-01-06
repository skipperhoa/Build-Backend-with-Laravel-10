# 🚀 Xây dựng Backend mạnh mẽ với Laravel 10

Trong series này, chúng ta sẽ đi từ **cơ bản đến nâng cao**, hướng dẫn bạn cách:  
- Thiết lập Laravel  
- Tạo API  
- Xác thực người dùng  
- Xử lý CRUD  
- Tối ưu hiệu suất  
- Triển khai lên server  

Dù bạn là **người mới bắt đầu** hay **lập trình viên có kinh nghiệm**, đây sẽ là hướng dẫn đầy đủ giúp bạn tạo một **backend chuyên nghiệp** cho ứng dụng **web** hoặc **mobile**. 🚀  


## 🔹 Những gì bạn sẽ học:
✅ **Cài đặt & cấu hình Laravel 10** 🏗️  
✅ **Tạo RESTful API với Laravel** 🔄  
✅ **Xác thực người dùng (Sanctum / Passport / JWT)** 🔑  
✅ **Kết nối với React Native / Mobile Apps** 📱  
✅ **Tối ưu hiệu suất & bảo mật API** 🔥  
✅ **Triển khai lên server thực tế** 🌍  

📌 **Đừng quên ĐĂNG KÝ kênh [Hòa Nguyễn Coder](https://www.youtube.com/@hoanguyencoder7136) để cập nhật video mới nhất nhé!** 🎯 

### DOWNLOAD PROJECT
Tải project từ Github về máy tính
```bash
git clone https://github.com/skipperhoa/Build-Backend-with-Laravel-10.git laravel10
git switch -c dev origin/dev
```

### INSTALL PROJECT

📌 Build thư viện Tailadmin

```bash
cd laravel10/public/tailadmin
npm install
npm run build
```

📌 Cấu hình project
```bash
cd laravel10
cp .env.example .env
```
📌 Chỉnh sửa thông tin kết nối database
```bash
// .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_app
DB_USERNAME=root
DB_PASSWORD=Hoa@1234
```
📌 Chạy lệnh tạo table 
```bash
cd laravel10
php artisan migrate
```

📌 Chạy lệnh tạo dữ liệu mẫu
```bash
cd laravel10
php artisan db:seed
```

📌 Chạy project
```bash
php artisan server
```
Nếu báo lỗi css giao diện hãy chạy lệnh build sau:
```bash
npm run build
```


### DEMO 
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/1.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/2.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/3.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/4.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/5.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/9.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/6.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/10.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/7.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/8.png)
![hoanguyenit.com](https://github.com/skipperhoa/Build-Backend-with-Laravel-10/blob/dev/demo/11.png)
