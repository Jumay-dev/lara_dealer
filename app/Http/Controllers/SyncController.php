<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Clinic;
use App\Models\Project;
use App\Models\ProjectTools;
use App\Models\Tools;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Exception;

class SyncController extends Controller
{
    private static $BXApiRoute = 'https://crm.dsmed.ru/rest/3/salvy8pkuk7myzov/';
    private static $BXContentQuery = 'dealerLara.categories';
    private static $oldDealerRoute = 'http://dealer.dsmed.ru/sync/';

    public static function syncWithBX()
    {
        $BXresponse = Http::get(self::$BXApiRoute . self::$BXContentQuery)->json();
        $BXcategories = $BXresponse['result']['categories'];
        $BXtools = $BXresponse['result']['tools'];

        $arSyncedCategories = self::syncCategories($BXcategories);
        self::syncTools($BXtools, $arSyncedCategories);

        return $BXtools;
    }

    public static function syncWithOldDealer() {
//        $cats = self::syncCategoriesWithOldDealer();
//        $tools = self::syncToolsWithOldDealer();
        $projects = self::syncProjectsWithOldDealer();
        return response()->json([
//            'cats' => $cats,
//            'tools' => $tools
        'projects' => $projects
                                ]);
    }

    public static function syncWithWP()
    {
    }

    private static function syncCategoriesWithOldDealer() {
        $oldDealerCategories = Http::get(self::$oldDealerRoute . '?type=CATEGORIES')->json();
        $catIdsfromDB = array_column(DB::table('categories')->where('entity_type', '=', 'DEALER')->select('external_id')->get()->toArray(), 'external_id');
        foreach ($oldDealerCategories as $externalCategory) {
            $key = !empty($externalCategory["id"]) ? "id" : "sub_id";

            if (!in_array(md5($externalCategory['block_name'] . $externalCategory[$key]), $catIdsfromDB)) {
                $newCategory = new Categories;
                if (!empty($externalCategory['sub_id'])) {
                    $newCategory->external_id = $externalCategory['sub_id'];
                } else {
                    $newCategory->external_id =  $externalCategory['id'];
                }
                $newCategory->category_name = $externalCategory['block_name'];
                $newCategory->visibility = 0;
                $newCategory->entity_type = "DEALER";
                $newCategory->save();
            }
        }
        return true;
//        return $oldDealerCategories;
    }

    private static function syncToolsWithOldDealer() {
        $oldDealerTools = Http::get(self::$oldDealerRoute . '?type=TOOLS')->json();
        $catIdsWithKeysfromDB = array_column(DB::table('categories')->where('entity_type', '=', 'DEALER')
                                         ->select('id', 'external_id')->get()->toArray(), 'id', 'external_id');
        $toolsIdsFromDB = array_column(DB::table('tools')->where('entity_type', '=', 'DEALER')
                                           ->select('external_id')->get()->toArray(), 'external_id');
        foreach ($oldDealerTools as $externalTool) {
            if (!in_array($externalTool['id'], $toolsIdsFromDB)) {
                $newtool = new Tools();
                $newtool->external_id = $externalTool['id'];
                $newtool->tool_name = $externalTool['tool_name'];
                $newtool->category_id = $catIdsWithKeysfromDB[$externalTool['tool_view_sub_block']];
                $newtool->tool_provider = '0';
                $newtool->tool_sort = '0';
                $newtool->visibility = '0';
                $newtool->price = '0.00';
                $newtool->price_cur = 'RUB';
                $newtool->entity_type = "DEALER";
                $newtool->save();
            }
        }
        return true;
    }

    private static function syncProjectsWithOldDealer() {
        $oldDealerProjects = Http::get(self::$oldDealerRoute . '?type=PROJECTS')->json();
        $projectsExternalIDs = array_column(DB::table('projects')
                                                ->where('entity_type', '=', 'DEALER')
                                                ->select('external_id')->get()->toArray(), 'external_id');
        $localToolsExternalIDs = array_column(DB::table('tools')
                                             ->where('entity_type', '=', 'DEALER')
                                             ->select('external_id', 'id')->get()->toArray(), 'id', 'external_id');
        foreach ($oldDealerProjects as $externalProject) {
//            var_dump($externalProject['ur_name']);
//            die();
            if (!in_array($externalProject['id'], $projectsExternalIDs)) {
                DB::beginTransaction();
                try {
                    $newproj = new Project();
                    $newclinic = new Clinic();

                    $newproj->external_id = $externalProject['id'];
                    $newproj->dealer = '1';
                    $newproj->employee = '1';
                    $newproj->created_at = $externalProject['date'];
                    $newproj->manager_id = '0';
                    $newproj->actualised_at = time();
                    $newproj->expires_at = time();
                    $newproj->created_by = '1';
                    $newproj->updated_by = '1';
                    $newproj->entity_type = 'DEALER';
                    $newproj->status = '4';
                    $newproj->client = '1';
                    if (!$newproj->save()) throw new \Exception('Project creating error');

                    $newclinic->external_id = '0';
                    $newclinic->name = $externalProject['brend_name'];
                    $newclinic->urname = $externalProject['ur_name'];
                    $newclinic->address = 'Экспортировано';
                    $newclinic->inn = $externalProject['inn'];
                    $newclinic->is_subdealer = '0';
                    $newclinic->entity_type = 'DEALER';
                    $newclinic->project_id = $newproj->id;
                    if (!$newclinic->save()) throw new \Exception('Clinic creating error');

                    $externalToolsIDs  = explode(',', $externalProject['tids']);
                    foreach ($externalToolsIDs as $toolID) {
                        $newPTool = new ProjectTools();
                        $newPTool->project_id = $newproj->id;
                        $newPTool->tool_id = $localToolsExternalIDs[$toolID];
                        $newPTool->status_id = 0;
                        if (!$newPTool->save()) throw new \Exception('Error in project tools generation');
                    }
                    DB::commit();
                } catch (\Exception $error) {
                    DB::rollBack();
                    return $error->getMessage();
                }
            }
        }
        return true;
    }

    public static function syncCategories($BXcategories): array
    {
        $LRCategoriesInstance = new Categories();
        $LRAllLocalCategories = array_column(
            $LRCategoriesInstance->all(
                [
                    'id',
                    'external_id'
                ]
            )->toArray(),
            'external_id',
            'id'
        );

        foreach ($BXcategories as $BXCat) {
            if ($BXCat['ID'] !== 0) {
                $foundCatKey = array_search($BXCat['ID'], $LRAllLocalCategories, false);
                try {
                    $LRCategory = Categories::find($foundCatKey);
                    $LRCategory->category_name = $BXCat['NAME'];
                    $LRCategory->visibility = $BXCat['ACTIVE'] === "Y" ? 1 : 0;
                    $LRCategory->entity_type = 'BITRIX';
                    $LRCategory->save();
                } catch (\Exception $error) {
                    $LRNewCategory = new Categories();
                    $LRNewCategory->external_id = $BXCat['ID'];
                    $LRNewCategory->category_name = $BXCat['NAME'];
                    $LRNewCategory->visibility = $BXCat['ACTIVE'] === "Y" ? 1 : 0;
                    $LRNewCategory->save();
                }
            }
        }

        return array_column(
            $LRCategoriesInstance->all(
                [
                    'id',
                    'external_id'
                ]
            )->toArray(),
            'external_id',
            'id'
        );;
    }

    public static function syncTools($BXTools, $LRCategories) {
        $LRtoolsInstance = new Tools;
        $LRAllLocalTools = array_column(
            $LRtoolsInstance->all(
                [
                    'id',
                    'external_id'
                ]
            )->toArray(),
            'external_id',
            'id'
        );

        foreach ($BXTools as $BXTool) {
            $foundToolKey = array_search($BXTool['ID'], $LRAllLocalTools, false);
            try {
                $LRTool = Tools::find($foundToolKey);
                $LRTool->tool_name = $BXTool['NAME'];
                $LRCategory = array_search($BXTool["IBLOCK_SECTION_ID_AR"], $LRCategories);
                $LRCatOthers = array_search(164, $LRCategories);
                if ($LRCategory !== false) {
                    $LRTool->category_id = $LRCategory;
                } else {
                    $LRTool->category_id = $LRCatOthers;
                }
//                $LRTool->visibility = $BXTool['ACTIVE'] === "Y" ? 1 : 0;
                $LRTool->price = $BXTool["PRICE_VAL"];
                $LRTool->price_cur = $BXTool["PRICE_CUR"];
                $LRTool->price = $BXTool["PRICE_VAL"];
                $LRTool->price_cur = $BXTool["PRICE_CUR"];
                $LRTool->save();
            } catch (\Exception $error) {
                $LRTool = new Tools();
                $LRTool->tool_name = $BXTool['NAME'];
                $LRTool->external_id = $BXTool['ID'];
                $LRCategory = array_search($BXTool["IBLOCK_SECTION_ID_AR"], $LRCategories);
                $LRCatOthers = array_search(164, $LRCategories);
                if ($LRCategory !== false) {
                    $LRTool->category_id = $LRCategory;
                } else {
                    $LRTool->category_id = $LRCatOthers;
                }
//                $LRTool->visibility = $BXTool['ACTIVE'] === "Y" ? 1 : 0;
                $LRTool->price = $BXTool["PRICE_VAL"];
                $LRTool->price_cur = $BXTool["PRICE_CUR"];

                $LRTool->tool_provider = 0;
                $LRTool->tool_sort = 0;
                $LRTool->visibility = 1;

                $LRTool->save();
            }
        }
    }
}
