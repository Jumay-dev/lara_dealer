<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $table = 'projects';

    public function create() {
        $project = new \App\Models\Project;
        $project->comment = request('comment');;
        $project->datetime_start = request('datetime_start');;
        $project->datetime_end = request('datetime_end');;
        $project->manager_id = request('manager_id');;
        $project->clinic_id = request('clinic_id');;
        $project->external_id = request('external_id');;
        try {
            $project->saveOrFail();
            if ($project->id) {
                return response()->json([
                    'success' => true,
                    'result' => "Проект создан"
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'result' => "Ошибка создания проекта"
                ]);
            }

        } catch(\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e
            ]);
        }
    }

    public function get() {
        $id = request('id');

        if(isset($id) && $id !== '') {
            $project = new \App\Models\Project;
            $proj_res = $project->find($id);
            if ($proj_res) {
                return response()->json([
                   'success' => true,
                   'result' => $proj_res,
                    'clinic' => $proj_res->clinic
                ]);
            }
            return response()->json([
                'success' => false,
                'result' => 'Проект не найден'
            ]);
        }
        return response()->json([
            'success' => false,
            'result' => "Не указан ID проекта"
        ]);
    }

    public function update() {
        $id = request('id');

        if(isset($id) && $id !== '') {
            $project = new \App\Models\Project;
            $proj_res = $project->find($id);

            if ($proj_res) {
                $proj_res->comment = request('comment');
                $proj_res->datetime_start = request('datetime_start');
                $proj_res->datetime_end = request('datetime_end');
                $proj_res->manager_id = request('manager_id');
                $proj_res->clinic_id = request('clinic_id');

                $proj_res->saveOrFail();
                return response()->json([
                    'success' => true,
                    'result' => "Измененя сохранены"
                ]);
            }
            return response()->json([
                'success' => false,
                'result' => 'Проект не найден'
            ]);
        }
        return response()->json([
            'success' => false,
            'result' => "Не указан ID проекта"
        ]);
    }

    public function delete() {
        $id = request('id');

        if(isset($id) && $id !== '') {
            $project = new \App\Models\Project;
            $project->destroy($id);

            return response()->json([
                'success' => true,
                'result' => "Проект удален"
            ]);
        }
        return response()->json([
            'success' => false,
            'result' => "Не указан ID проекта"
        ]);
    }
}
