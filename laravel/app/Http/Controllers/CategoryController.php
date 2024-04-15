<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Repositories\CategoryRepository;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Jobs\CategoryDelete;

class CategoryController extends Controller
{
    use SoftDeletes;
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $idArray = idCategoryList();
        $value = implode(",",$idArray);
        $categories = Category::whereIn('id', $idArray)
                        ->orderByRaw("FIELD(id, $value)")
                        ->get();
        return $categories;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Log::info("create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $level = $this->categoryRepository->getLevel($request->parent_id);
        $data = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'level' => $level,
        ]);
        return $data;
    }

    public function categoryDetail( $id )
    {
        $array = [];
        categoryChild($array,intval($id));
        $idArray = idCategoryList();
        $result = array_diff($idArray, $array);
        $value = implode(",",$result);
        $categories = Category::whereIn('id', $result)
                        ->orderByRaw("FIELD(id, $value)")
                        ->get();
        return $categories;
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        Log::info("edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Log::info("update");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        CategoryDelete::dispatch($category->id);
    }

    public function delete(Request $request)
    {
        $list = $request->list;
        foreach ($list as $id) {
            CategoryDelete::dispatch($id);
        }
    }
}
