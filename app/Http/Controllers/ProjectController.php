<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTools;

class ProjectController extends Controller
{
    protected $table = 'projects';

    public function list()
    {
        $project = new Project;

        return response()->json(
            [
                "projects" => $project->all(),
                "success" => true
            ]
        );
    }

    public function tools() {
        $projectId = request('id');
        $project = new Project;
        $project->id = $projectId;

        return response()->json($project->projectTools);
    }

    public function create()
    {
        $project = new Project;

        $project->external_id = 0;
        $project->dealer = request('dealer');
        $project->employee = request('employee');
        $project->client = request('client');
        $project->manager_id = request('manager_id');
        $project->actualised_at = request('actualised_at');
        $project->expires_at = request('expires_at');

        try {
            $project->saveOrFail();
            if ($projectId = $project->id) {
                $tools_array = explode(',', \request('tools'));
                foreach ($tools_array as $projTool) {
                    $tool = new ProjectTools;
                    $tool->project_id = $projectId;
                    $tool->tool_id = trim($projTool);
                    $tool->status_id = 0;
                    $tool->save();
                }

                return response()->json(
                    [
                        'success' => true,
                        'result' => "Проект создан",
                        'test' => $tools_array
                    ]
                );
            } else {
                return response()->json(
                    [
                        'success' => true,
                        'result' => "Ошибка создания проекта"
                    ]
                );
            }
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $e
                ]
            );
        }
    }

    public function get()
    {
        $id = request('id');

        if (isset($id) && $id !== '') {
            $project = new Project;
            $proj_res = $project->find($id);
            if ($proj_res) {
                return response()->json(
                    [
                        'success' => true,
                        'result' => $proj_res,
                        'clinic' => $proj_res->clinic
                    ]
                );
            }
            return response()->json(
                [
                    'success' => false,
                    'result' => 'Проект не найден'
                ]
            );
        }
        return response()->json(
            [
                'success' => false,
                'result' => "Не указан ID проекта"
            ]
        );
    }

    public function update()
    {
        $id = request('id');

        if (isset($id) && $id !== '') {
            $project = new \App\Models\Project;
            $proj_res = $project->find($id);

            if ($proj_res) {
                $proj_res->comment = request('comment');
                $proj_res->datetime_start = request('datetime_start');
                $proj_res->datetime_end = request('datetime_end');
                $proj_res->manager_id = request('manager_id');
                $proj_res->clinic_id = request('clinic_id');

                $proj_res->saveOrFail();
                return response()->json(
                    [
                        'success' => true,
                        'result' => "Измененя сохранены"
                    ]
                );
            }
            return response()->json(
                [
                    'success' => false,
                    'result' => 'Проект не найден'
                ]
            );
        }
        return response()->json(
            [
                'success' => false,
                'result' => "Не указан ID проекта"
            ]
        );
    }

    public function delete()
    {
        $id = request('id');

        if (isset($id) && $id !== '') {
            $project = new \App\Models\Project;
            $project->destroy($id);

            return response()->json(
                [
                    'success' => true,
                    'result' => "Проект удален"
                ]
            );
        }
        return response()->json(
            [
                'success' => false,
                'result' => "Не указан ID проекта"
            ]
        );
    }
}
