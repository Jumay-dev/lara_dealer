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

    }

    public function delete() {

    }
}
