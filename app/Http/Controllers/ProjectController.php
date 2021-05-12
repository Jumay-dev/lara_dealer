<?php

namespace App\Http\Controllers;

use App\ExtraUser;
use App\Mail\ProjectAddedMail;
use App\Models\Clinic;
use App\Models\Comments;
use App\Models\Project;
use App\Models\ProjectTools;
use Illuminate\Support\Facades\Mail;
use Illuminate\Mail\Mailable;
use Spatie\Searchable\Search;

class ProjectController extends Controller
{
    protected $table = 'projects';

    public function list()
    {
        $perPage = request('limit');
        $luName = request('lu_name');
        $project = new Project;
        $user = new ExtraUser;
        $projects = $project->where('projectDealer.id', 'LIKE', '%' . 1 . '%')->paginate($perPage);

//        $searchResults = (new Search())->registerModel(Project::class, 'projectClinics')->search('');

        foreach ($projects as $proj) {
            $proj['responsible'] = $user->find($proj['employee']);
            $proj['clinics'] = $proj->projectClinics;
            $proj['dealer'] = $proj->projectDealer;
            $proj['last_comment'] = $proj->lastComment;
        }

        return response()->json(
            [
                "success" => true,
                "projects" => $projects
            ]
        );
    }

    public function tools()
    {
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
//        DB::beginTransaction();
//        try {
//            $model1 = new Type();
//            $model1->test = 'great';
//
//            $model2 = new Type();
//            $model2->test2 = 'awesome';
//
//            if ($model1->save() && $model2->save()) {
//                DB::commit();
//            } else {
//                DB::rollBack();
//            }
//        } catch(Exception $e){
//            DB::rollBack();
//        }
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

    public function comment()
    {
        $entity_id = request('entity_id');
        $commentText = request('comment');
        $comment = new Comments;
        $comment->entity_id = $entity_id;
        $comment->entity_type = 'PROJECT_COMMENT';
        $comment->comment = $commentText;
        try {
            $comment->saveOrFail();
            return [
                'success' => true
            ];
        } catch (\Exception $error) {
            return [
                'success' => false,
                'message' => $error->getMessage()
            ];
        }
    }

    public function getCommentsList() {
        $entity_id = request('entity_id');
        $project = new Project;
        try {
            $pr = $project->find($entity_id);
            return response()->json(
                [
                    'success' => true,
                    'comments' => $pr->commentList,
                    'project' => $pr
                ]
            );
        } catch (\Exception $error) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $error
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
