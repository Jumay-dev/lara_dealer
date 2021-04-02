<?php

namespace App\Http\Controllers;

use App\Models\ProjectTools;
use Illuminate\Http\Request;

class ProjectToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProjectTools $projectTools
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectTools $projectTools)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProjectTools $projectTools
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectTools $projectTools)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProjectTools $projectTools
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectTools $projectTools)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProjectTools $projectTools
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectTools $projectTools)
    {
        //
    }

    public function changeStatus()
    {
        $arToolsToUpdate = json_decode(request('tools'));
        $status = request('status');
        $comment = request('comment');
        try {
            if ($status !== '') {
                if (count($arToolsToUpdate) !== 0) {
                    foreach ($arToolsToUpdate as $tool) {
                        $localTool = ProjectTools::find($tool);
                        $localTool->status_id = $status;
                        $localTool->save();
                    }

                    return response()->json(
                        [
                            'success' => true,
                            'message' => 'Tools status sucessfully updated'
                        ]
                    );
                } else {
                    throw new \Exception('Tools not setted');
                }
            } else {
                throw new \Exception('Status not setted');
            }
        } catch (\Exception $error) {
            return response()->json(
                [
                    'success' => false,
                    'error' => $error,
                    'ert' => $arToolsToUpdate,
                    'stat' => $status
                ]
            );
        }
    }
}
