<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Models\Project;
use App\Models\ProjectTools;
use App\Mail\TestMail;
use App\Mail\ProjectAddedMail;
use App\ExtraUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ProjectController extends Controller
{
    protected $table = 'projects';

    public function list()
    {
        $perPage = request('limit');
        $project = new Project;
        $user = new ExtraUser;
        $projects = $project->paginate($perPage);

        foreach($projects as $proj) {
            $proj['responsible'] = $user->find($proj['employee']);
            $proj['clinics'] = $proj->projectClinics;
            $proj['dealer'] = $proj->projectDealer;
        }

        return response()->json(
            [
                "success" => true,
                "projects" => $projects
            ]
        );
    }

    public function tools() {
        $projectId = request('id');
        $project = new Project;
        $project->id = $projectId;

        $tools = $project->projectTools;

        foreach ($tools as $tool) {
            $tool['last_comment'] = $tool->lastComment;
        }

        return response()->json($tools);
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
        $user = new ExtraUser;

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
                $subdealer->external_id = 0;
                $subdealer->project_id = $project->id;
                $subdealer->name = $subdealerInfo->dealerName;
                $subdealer->urname = $subdealerInfo->dealerUr;
                $subdealer->address = $subdealerInfo->dealerAddress;
                $subdealer->inn = $subdealerInfo->dealerInn;
                $subdealer->is_subdealer = 1;
                $subdealer->save();
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

                $infoToMail = [
                    'project' => $project,
                    'tools' => $tools_array,
                    'clinic' => $clinic,
                    'user' => $user->find(request('employee'))
                ];

                Mail::to('osipovm33rus@gmail.com')->queue(new ProjectAddedMail($infoToMail));

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
    }

    public function get()
    {
        $id = request('id');

        if (isset($id) && $id !== '') {
            $project = new Project;
            $proj_res = $project->find($id);
            //$proj_res->created_at = $proj_res->created_at->format('d.m.Y');
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
