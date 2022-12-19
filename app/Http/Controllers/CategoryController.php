<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::orderBy('name')->get();
        return ResponseHelper::success(CategoryResource::collection($categories));
    }

    public function create(Request $request){
        $request->validate([
            'name' => 'required|string|unique:categories,name', 
        ]);
        
        DB::beginTransaction();
        try{
            $category = new Category();
            $category->name = $request->name;
            $category->save();
            
            DB::commit();
            return ResponseHelper::success([], 'successfully category created.');
            
        }catch(Exception $e){
            DB::rollBack();
            return ResponseHelper::fail($e->getMessage());
        }
       
    }

    public function edit(Request $request, $id){
        $category = Category::findOrFail($id);
        return ResponseHelper::success($category, 'Pls try update category.');
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required|string', 
        ]);
        // $category = Category::findOrFail($id)->update([
        //     'name' => $request->name,
        // ]);
        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->save();
        return ResponseHelper::success([], 'successfully category updated.');
    }
    public function delete($id){
        $category = Category::where('id', $id)->delete();
        return ResponseHelper::success([
            'message' => 'Category Deleted successfully'
        ]);
    }
}