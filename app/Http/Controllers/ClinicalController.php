<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClinicalController extends Controller
{
    protected $table = 'clinics';

    public function create() {
        $clinic = new \App\Models\Clinic;
        $clinic->external_id = request('external_id');
        $clinic->brand = request('brand');
        $clinic->ur_name = request('ur_name');
        $clinic->inn = request('inn');
        $clinic->region = request('region');
        $clinic->city = request('city');
        $clinic->street = request('street');
        $clinic->house = request('house');
        $clinic->block = request('block');
        $clinic->office = request('office');
        $clinic->comment = request('comment');
        try {
            $clinic->saveOrFail();
            if ($clinic->id) {
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
            $clinic = new \App\Models\Clinic;
            $proj_res = $clinic->find($id);
            if ($proj_res) {
                return response()->json([
                    'success' => true,
                    'result' => $proj_res,
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
            $clinic = new \App\Models\Clinic;
            $clinic_res = $clinic->find($id);

            if ($clinic_res) {
                $clinic_res->external_id = request('external_id');
                $clinic_res->brand = request('brand');
                $clinic_res->ur_name = request('ur_name');
                $clinic_res->inn = request('inn');
                $clinic_res->region = request('region');
                $clinic_res->city = request('city');
                $clinic_res->street = request('street');
                $clinic_res->house = request('house');
                $clinic_res->block = request('block');
                $clinic_res->office = request('office');
                $clinic_res->comment = request('comment');

                $clinic_res->saveOrFail();
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
            $clinic = new \App\Models\Clinic;
            $clinic->destroy($id);

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
