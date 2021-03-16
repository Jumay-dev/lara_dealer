<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [];

        // 0
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Эксклюзивное оборудование',
            'visibility' => '1'
        ];

        // 1
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Обязательная авторизация',
            'visibility' => '1'
        ];

        // 2
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Прямые поставки',
            'visibility' => '1'
        ];

        // 3
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Аудиометрия',
            'visibility' => '1'
        ];

        // 4
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Денсинометрия',
            'visibility' => '1'
        ];

        // 5
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Гинекологическое оборудование',
            'visibility' => '1'
        ];

        // 6
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Рентген-аппараты и маммографы',
            'visibility' => '1'
        ];

        // 7
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Оборудование для хирургии',
            'visibility' => '1'
        ];

        // 8
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Прочее оборудование',
            'visibility' => '1'
        ];

        // 9
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Мониторы пациента',
            'visibility' => '1'
        ];

        // 10
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Электрохирургические аппараты',
            'visibility' => '1'
        ];

        // 11
        $categories[] = [
            'external_id' => '0',
            'category_name' => 'Гибкая ЛОР-эндоскопия',
            'visibility' => '1'
        ];
        \DB::table('categories')->insert($categories);
    }
}
