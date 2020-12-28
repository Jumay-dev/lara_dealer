<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CompanyController extends Controller
{
    protected $table = 'meta_companies';

    public function create() {
        $company = new \App\Models\MetaCompany;
        $company->external_id = request('external_id');
        $company->brand = request('name');
        $company->ur_name = request('ur_name');
        $company->inn = request('inn');
        $company->region = request('region');
        $company->city = request('city');
        $company->street = request('street');
        $company->house = request('house');
        $company->block = request('house_block');
        $company->office = request('office');
        $company->phone = request('phone');
        $company->email = request('email');
        $company->website = request('website');
        $company->director_id = request('director_id');
        try {
            $company->saveOrFail();
            if ($company->id) {
                return response()->json([
                    'success' => true,
                    'result' => "ЛУ создано"
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'result' => "Ошибка создания ЛУ"
                ]);
            }

        }
        catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }
    }

    public function get() {
        $id = request('id');

        if(isset($id) && $id !== '') {
            $company = new \App\Models\MetaCompany;
            $company_res = $company->find($id);
            if ($company_res) {
                return response()->json([
                    'success' => true,
                    'result' => $company_res,
                ]);
            }
            return response()->json([
                'success' => false,
                'result' => 'ЛУ не найдена'
            ]);
        }
        return response()->json([
            'success' => false,
            'result' => "Не указан ID ЛУ"
        ]);
    }

    public function update() {
        $id = request('id');

        if(isset($id) && $id !== '') {
            $company = new \App\Models\MetaCompany;
            $company_res = $company->find($id);

            if ($company_res) {
                $company_res->external_id = request('external_id');
                $company_res->brand = request('name');
                $company_res->ur_name = request('ur_name');
                $company_res->inn = request('inn');
                $company_res->region = request('region');
                $company_res->city = request('city');
                $company_res->street = request('street');
                $company_res->house = request('house');
                $company_res->block = request('house_block');
                $company_res->office = request('office');
                $company_res->phone = request('phone');
                $company_res->email = request('email');
                $company_res->website = request('website');
                $company_res->director_id = request('director_id');

                $company_res->saveOrFail();
                return response()->json([
                    'success' => true,
                    'result' => "Изменения сохранены"
                ]);
            }
            return response()->json([
                'success' => false,
                'result' => 'ЛУ не найдено'
            ]);
        }
        return response()->json([
            'success' => false,
            'result' => "Не указан ID ЛУ"
        ]);
    }

    public function delete() {
        $id = request('id');

        if(isset($id) && $id !== '') {
            $company = new \App\Models\MetaCompany;
            $company->destroy($id);

            return response()->json([
                'success' => true,
                'result' => "ЛУ удалено"
            ]);
        }
        return response()->json([
            'success' => false,
            'result' => "Не указан ID ЛУ"
        ]);
    }

    public function search() {
        // Здесь возможно нужно обращение к API Bitrix или сделаем это на фронте?
    }
}
