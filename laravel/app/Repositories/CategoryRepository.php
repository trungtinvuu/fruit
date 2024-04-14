<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryRepository
{
    public function getAll()
    {
        return Category::all();
    }

    public function getLevel($parentId)
    {
        if(is_null($parentId)){
            return 0;
        }
        $category = Category::find($parentId);
        $level = $category->level;
        return ++$level;
    }

    public function setRoot(Category $category)
    {
        $parentId = $category->parent_id;
        if(is_null($parentId)){
            $rootId = $category->id;
        }else{
            $parent = Category::find($parentId);
            $rootId = $parent->root_id;
        }
        $category->update([
            'root_id' => $rootId,
        ]);
    }
}
