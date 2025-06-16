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
