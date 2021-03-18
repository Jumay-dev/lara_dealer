<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Project;
use App\Models\ProjectTools;
use App\ExtraUser;

class ProjectController extends Controller
{
    protected $table = 'projects';

    public function list()
    {
        $project = new Project;
        $user = new ExtraUser;
        $projects = $project->all();

        foreach($projects as $proj) {
            $proj['responsible'] = $user->find($proj['employee']);
            $proj['clinics'] = $proj->projectClinics;
            $proj['dealer'] = $proj->projectDealer;
        }

        return response()->json(
            [
                "projects" => $projects,
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
        $project->status = "4";

        try {
            $project->saveOrFail();

            $clinicInfo = json_decode(request('clinic'));

            $clinic = new Clinic;
            $clinic->external_id = 0;
            $clinic->project_id = $project->id;
            $clinic->name = $clinicInfo->clinicName;
            $clinic->urname = $clinicInfo->clinicUr;
            $clinic->address = $clinicInfo->clinicAddress;
            $clinic->inn = $clinicInfo->clinicInn;
            $clinic->is_subdealer = 0;
            $clinic->save();

            $project->client = $clinic->id;
            $project->saveOrFail();

            if ($subdealerInfo = request('subdealer')) {
                $subdealer = new Clinic;
                $clinic->external_id = 0;
                $clinic->project_id = $project->id;
                $clinic->name = $clinicInfo['dealerName'];
                $clinic->urname = $clinicInfo['dealerUr'];
                $clinic->address = $clinicInfo['dealerAddress'];
                $clinic->inn = $clinicInfo['dealerInn'];
                $clinic->is_subdealer = 1;
                $clinic->save();
            }

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
                        'test' => json_decode(request('clinic'))
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
                        'clinic' => $proj_res->projectClinics
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
