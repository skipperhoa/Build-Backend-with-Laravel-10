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
