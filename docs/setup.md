### Tạo API Category
```
hoacode@192 laravel % php artisan make:controller Api/V1/CategoryController --resource

   INFO  Controller [app/Http/Controllers/Api/V1/CategoryController.php] created successfully.  

hoacode@192 laravel % php artisan make:controller Admin/ListAllApiController --resource

   INFO  Controller [app/Http/Controllers/Admin/ListAllApiController.php] created successfully.  
```

### Cấu hình route 
- Tạo file api_v1.php trong thư mục routes

```php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
/* setup api category */
Route::group([
    //'middleware' => 'auth:api',
    'prefix' => 'v1'
], function ($router) {
    Route::get('categories', [CategoryController::class, 'index']);
});


```
Sau đó gọi file api_v1.php vào tệp api.php
```php

// api.php 
// gọi api_v1.php
require __DIR__.'/api_v1.php';

```
# Chỉnh sử table Cart va thêm table Cart Item, để lưu các giỏ hảng của User
Trong hệ thống giỏ hàng của web bán hàng, mối quan hệ giữa Cart và Product là many-to-many (nhiều-nhiều):

Một Cart có thể chứa nhiều Product.
Một Product có thể nằm trong nhiều Cart khác nhau.

```
hoacode@192 laravel % php artisan migrate --path=/database/migrations/2025_05_02_033926_create_carts_table.php


   INFO  Running migrations.  

  2025_05_02_033926_create_carts_table ........................................................................... 50ms DONE
hoacode@192 laravel % php artisan make:migration create_cart_item_table --create=cart_item

   INFO  Migration [database/migrations/2025_09_22_024326_create_cart_item_table.php] created successfully.  

hoacode@192 laravel % php artisan migrate 

   INFO  Running migrations.  

  2025_09_22_024326_create_cart_item_table ....................................................................... 92ms DONE
  ```
