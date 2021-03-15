<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;

class ToolsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tools = [];

        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'Dr.Camscope DCS-103E - универсальная эндоскопическая система Full HD',
            'category_id' => '1',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'Скрининговый аудиометр MA 25',
            'category_id' => '1',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'Аппарат регистрации ОАЭ ERO-Scan',
            'category_id' => '1',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'ЛОР-комбайн Medstar UE-3000 базовая версия',
            'category_id' => '12',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'ЛОР-комбайн New Millennium Grand',
            'category_id' => '12',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'ЛОР-комбайн Medstar UE-3000 стандартная версия',
            'category_id' => '12',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        $tools[] = [
            'external_id' => '0',
            'tool_name' => 'ЛОР-комбайн Medstar UE-3000 расширенная версия',
            'category_id' => '12',
            'tool_provider' => '0',
            'tool_sort' => '0',
            'visibility' => '1'
        ];
        \DB::table('tools')->insert($tools);
    }
}
