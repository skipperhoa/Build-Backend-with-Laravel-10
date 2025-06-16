###### TẠO CONTROLLER
```php
php artisan make:controller Admin/CategoryController --resource
```

###### TẠO THƯ MỤC CATEGORY
```
resources/views/admin/category/
---------/-----/-----/--------/create.blade.php
---------/-----/-----/--------/edit.blade.php
---------/-----/-----/--------/index.blade.php
---------/-----/-----/--------/README.md


```

###### CẤU HÌNH ROUTE

- Mở tệp routes/admin.php , thêm route sau

```php
use App\Http\Controllers\Admin\CategoryController;
Route::prefix('admin')->name('admin.')->middleware(['auth', 'verified'])->group(function () {
    ...
    Route::resource('categories', CategoryController::class)->names('categories');
});
```
###### THÊM DỮ LIỆU MẪU
Tạo file Seeder cho Category. Để thêm dữ liệu mẫu 
```php
php artisan make:seed CategorySeeder
```
- Chúng ta sẽ được một tệp trong thư mục databases/seeders
- Tiếp theo ta sẽ cấu hình các dữ liệu mẫu tại tệp databases/seeders/CategorySeeder.php
```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr_categories = [
            'Toyota' => ['Camry', 'Corolla'],
            'Honda' => ['Civic', 'CR-V'],
            'Ford' => ['Focus', 'Everest'],
            'Chevrolet' => ['Spark', 'Colorado'],
            'Nissan' => ['Almera', 'Navara'],
            'Hyundai' => ['Elantra', 'Santa Fe'],
            'Kia' => ['Seltos', 'Morning'],
            'Mazda' => ['CX-5', 'Mazda3'],
            'Mercedes-Benz' => ['C-Class', 'GLC'],
            'BMW' => ['3 Series', 'X5'],
            'Audi' => ['A4', 'Q5'],
            'Lexus' => ['RX', 'ES'],
            'Volkswagen' => ['Tiguan', 'Passat'],
            'Mitsubishi' => ['Xpander', 'Outlander'],
            'Suzuki' => ['Swift', 'XL7'],
            'Peugeot' => ['3008', '5008'],
            'Volvo' => ['XC60', 'S90'],
            'Subaru' => ['Forester', 'Outback'],
            'Isuzu' => ['D-Max', 'mu-X'],
            'Land Rover' => ['Range Rover', 'Discovery'],
            'Jaguar' => ['XE', 'F-Pace'],
            'Porsche' => ['Cayenne', '911'],
            'Tesla' => ['Model 3', 'Model Y'],
            'VinFast' => ['VF e34', 'VF 8'],
            'Chery' => ['Tiggo 4', 'Tiggo 8'],
            'Geely' => ['Coolray', 'Okavango'],
            'BYD' => ['Atto 3', 'Seal']
        ];

        foreach ($arr_categories as $key => $value) {

            // thêm dữ liệu cha
            $category = new \App\Models\Category();
            $category->title = $key;
            $category->slug = Str::slug($key);
            $category->category_id = null; // mặc định chúng ta đặt là null nha
            $category->save();

            // lấy ID sau khi thêm thằng cha
            $last_category_id = $category->id;

            // tiến hành thêm dữ liệu con cho thằng cha
            foreach ($value as $item) {
                $category = new \App\Models\Category();
                $category->title = $item;
                $category->slug = Str::slug($item);
                $category->category_id = $last_category_id;
                $category->save();
            }
        }


    }
}
```

Sau khi thiếp lập xong, chúng ta sẽ chạy câu lệnh thêm Category như sau
```php
php artisan db:seed --class=CategorySeeder
```

###### TẠO CHILD CATEGORY 
Chúng ta sẽ dung một template để hiện thị đa cấp category
```php
//views/admin/category/create.blade.php

<select name="category_id" >
    @foreach ($categories as $category)
       
        <option value="{{ $category->id }}">{{ $category->title }}</option>
        @if ($category->children->isNotEmpty())
            @include('admin.category.child-category', ['child_categories' => $category->children,'level'=>1])
        ])
        @endif
    @endforeach
</select>

// sau đó gọi child category
// views/admin/category/child-category.blade.php 
@foreach ($child_categories as $child)
    <option value="{{ $child->id }}">
        {{ str_repeat('-', $level + 2) }} {{ $child->title }}
    </option>
    @if ($child->children->isNotEmpty())
        @include('admin.category.child-category', [
            'child_categories' => $child->children,
            'level' => $level + 3
        ])
    @endif
@endforeach


```





