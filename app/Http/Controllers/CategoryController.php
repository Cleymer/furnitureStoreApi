<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Validator;

class CategoryController extends Controller
{
    //
    public function index() {
        return CategoryResource::collection(Category::all());
    }

    public function show($id) {
        

        $category = Category::find($id);

        if(!$category){
            return [
                'success' => 'false',
                'message' => 'Category does not exist'
            ];
        }

        return [
            'success' =>'true',
            'data' => new CategoryResource($category)
        ];

    }

    public function store(Request $request) {

        $validateData = Validator::make($request->all(),
            [
                'name' => 'required',
                'description' => 'required'
            ]
        );

        if($validateData->fails()){
            return [
                'success' => 'Can not create the category',
                'error' => $validateData->errors()
            ];
        }

        $category = Category::create($request->all());

        return response()->json([
            'success' => 'Category created',
            'data' => new CategoryResource($category)
        ]);

    }

    public function update(Request $request, Category $category) {


        $validateData = Validator::make($request->all(),
            [
                'name' => 'required',
                'description' => 'required'
            ]
        );

        if($validateData->fails()){
            return [
                'success' => 'Can not create the category',
                'error' => $validateData->errors()
            ];
        }

        $category->update($request->all());

        return response()->json([
            'success' => 'Category updated',
            'data' => new CategoryResource($category)
        ]);

    }

    public function destroy(Category $category){
        
        $category->delete();

        return response()->json([
            'succes' => "Category deleted"
        ], 200);

    }

}
