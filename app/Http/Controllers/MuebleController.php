<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Resources\MuebleResource;
use App\Models\Mueble;
use Validator;

class MuebleController extends Controller
{
    //
    public function index() {
        return MuebleResource::collection(Mueble::all());
    }

    public function show($id) {
        
        $mueble = Mueble::find($id);

        if(!$mueble){
            return [
                'message' => 'Mueble does not existe',
            ];
        }

        return response()->json([
            'success' => 'true',
            'data' => new MuebleResource($mueble)
        ]);

    }

    public function store(Request $request) {

        $validateData = Validator::make($request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required'
            ]
        );

        if($validateData->fails()){
            return [
                'success' => 'Can not create the mueble',
                'error' => $validateData->errors()
            ];
        }

        $mueble = Mueble::create($request->all());

        return response()->json([
            'success' => 'Mueble created',
            'data' => new MuebleResource($mueble)
        ]);

    }


    public function update(Request $request, Mueble $mueble) {

        return [
            'data' => $request->all(),
            'muebel' => $mueble->all()
        ];
            
            

        $validateData = Validator::make($request->all(),
            [
                'name' => 'required',
                'description' => 'required',
                'category_id' => 'required'
            ]
        );

        if($validateData->fails()){
            return [
                'success' => 'Can not update the mueble',
                'error' => $validateData->errors()
            ];
        }
        
        $mueble->update($request->all());

        return response()->json([
            'success' => 'true',
            'data' => new MuebleResource($mueble)
        ]);

    }


    public function destroy(Mueble $mueble){

        $mueble->delete();

        return response()->json([
            'success' => "Mueble deleted"
        ]);

    }
}
