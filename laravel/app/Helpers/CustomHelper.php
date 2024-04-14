<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

if (!function_exists('getChild')) {
    function categoryChild(array &$array, $id)
    {
        array_push($array,$id);

        $rows = DB::table('categories')
                    ->where('parent_id',$id)
                    ->get();

        if($rows->count()>0){
            foreach ($rows as $row) {
                categoryChild($array,$row->id);
            }
        }
    }
}

if (!function_exists('customHelperFunction')) {
    function idCategoryList()
    {
        $array = [];

        $result = DB::table('categories')
                    ->where('parent_id',null)
                    ->orderBy('id', 'desc')
                    ->get();

        foreach ($result as $row) {
            categoryChild($array,$row->id);
        }

        return $array;
    }
}
