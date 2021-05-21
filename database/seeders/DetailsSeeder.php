<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DetailsSeeder extends Seeder
{
    public function run()
    {
        $details = [];
        $details[] = [
            'external_id' => '0',
            'company_id' => '1',
            'name' => 'Общество с ограниченной ответственностью "Медицинские решения"',
            'shortname' => 'ООО "Медицинские решения"',
            'legal_form' => 'Общество с ограниченной ответственностью',
            'director' => 'Иванов Иван Иванович',
            'address' => '142200, Московская область, г. Серпухов, ш. Борисовское, д. 1, пом. 7, офис 1',
            'post_address' => '142200, Московская область, г. Серпухов, ш. Борисовское, д. 1, пом. 7, офис 1',
            'phone' => '+7 499 686 08 80',
            'email' => 'info@ds-med.ru , law@ds-med.ru',
            'inn' => '	ИНН 7724417426 / КПП 504301001',
            'ogrn' => 'ОГРН 1177746863250, ОКАТО 45296571000',
            'bank_details' => 'р/с 40702810740000007467 в ПАО Сбербанк г. Москва, к/с 30101810400000000225, БИК 044525225',
            'licenses' => ''
        ];
        $details[] = [
            'external_id' => '0',
            'company_id' => '1',
            'name' => 'Общество с ограниченной ответственностью «ДС.Мед»',
            'shortname' => 'ООО «ДС.Мед»',
            'legal_form' => 'Общество с ограниченной ответственностью',
            'director' => 'Сёмочкин Евгений Иванович',
            'address' => '142207, Московская обл., г. Серпухов, Борисовское шоссе, д. 17, офис 605',
            'post_address' => '142207, Московская обл., г. Серпухов, Борисовское шоссе, д. 17, офис 605',
            'phone' => '+7 (495) 248-12-21',
            'email' => 'e.semochkin@ds-med.ru',
            'inn' => 'ИНН 5043035712 / КПП 504301001',
            'ogrn' => 'ОГРН 1085043003352, ОКАТО 46470000000',
            'bank_details' => 'р/с 40702810040000004924 в ПАО Сбербанк г. Москва, к/с 30101810400000000225, БИК 044525225',
            'licenses' => ''
        ];
        \DB::table('bank_details')->insert($details);
    }
}
