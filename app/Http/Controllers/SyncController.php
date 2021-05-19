<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Tools;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

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
        $cats = self::syncCategoriesWithOldDealer();
//        $tools = self::syncToolsWithOldDealer();
        return response()->json([
            'cats' => $cats,
                                ]);
    }

    public static function syncWithWP()
    {
    }

    private static function syncCategoriesWithOldDealer() {
        $oldDealerCategories = Http::get(self::$oldDealerRoute . '?type=CATEGORIES')->json();
        $catIdsfromDB = array_column(DB::table('categories')->select('external_id')->get()->toArray(), 'external_id');
        foreach ($oldDealerCategories as $externalCategory) {
            $key = !empty($externalCategory["id"]) ? "id" : "sub_id";

            if (!in_array(md5($externalCategory['block_name'] . $externalCategory[$key]), $catIdsfromDB)) {
                $newCategory = new Categories;
                if (!empty($externalCategory['sub_id'])) {
                    $newCategory->external_id = md5($externalCategory['block_name'] . $externalCategory['sub_id']);
                } else {
                    $newCategory->external_id = md5($externalCategory['block_name'] . $externalCategory['id']);
                }
                $newCategory->category_name = $externalCategory['block_name'];
                $newCategory->visibility = 0;
                $newCategory->save();
            }
        }
        return true;
//        return $oldDealerCategories;
    }

    private static function syncToolsWithOldDealer() {
        $oldDealerTools = Http::get(self::$oldDealerRoute . '?type=TOOLS')->json();
        return $oldDealerTools;
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
