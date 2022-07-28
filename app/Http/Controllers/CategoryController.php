<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\CategoryResource;
use App\Models\Category;


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
}
