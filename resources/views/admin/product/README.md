### Tạo Controller Product
```
hoacode@192 laravel % php artisan make:controller Admin/ProductController --resource

   INFO  Controller [app/Http/Controllers/Admin/ProductController.php] created successfully.  
```

### Tạo dữ liệu demo với Factory
```
hoacode@192 laravel % php artisan make:factory ProductFactory

   INFO  Factory [database/factories/ProductFactory.php] created successfully.  

```
Sẽ được một file trong thư mục : database/factories/ProducFactory.php , chúng ta sẽ cấu hình các column cần dữ liệu mẫu, tương ứng với từng column trong table "products" của database

```php
<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(4),
            'keywords' => $this->faker->words(5, true),
            'slug' => $this->faker->unique()->slug,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(640, 480, 'products'),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'body' => $this->faker->text(500),
            'category_id' => 1,
            'user_id' => 1

        ];
    }
}

```

### Tạo Seeder để chạy lệnh tạo dữ liệu mẫu
```
hoacode@192 laravel % php artisan make:seeder ProductSeeder  
   INFO  Seeder [database/seeders/ProductSeeder.php] created successfully.
```
Sau đó ta cấu hình trong tệp database/seeders/ProductSeeder.php 
```php
class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // tạo dữ liệu demo
        Product::factory(30)->create();
    }
}
```
Sau khi cấu hình xong, ta sẽ chạy lệnh 
```
hoacode@192 laravel % php artisan db:seed ProductSeeder

   INFO  Seeding database.  
```
Sau khi chạy câu lện thành công, sẽ tự thêm dữ liệu mẫu cho ta trong table "products"

### TẠO FORM REQUEST CHO CRUD
```
hoacode@192 laravel % php artisan make:request CreateProductRequest

   INFO  Request [app/Http/Requests/CreateProductRequest.php] created successfully.  

hoacode@192 laravel % php artisan make:request UpdateProductRequest

   INFO  Request [app/Http/Requests/UpdateProductRequest.php] created successfully.
```
