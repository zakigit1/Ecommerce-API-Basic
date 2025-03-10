<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocationRequest;
use App\Models\Location;

use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{



    public function index(){
    
        $locations = Location::get();
        
        return Response()->json($locations,200);
    
    }



    public function store(LocationRequest $request){

        try{

            $location= Location::create([
                'user_id'=>Auth::id(),
                'street'=>$request->street,
                'building'=>$request->building,
                'area'=>$request->area,
            ]);
            
            return Response()->json([
                'status'=>true,
                'message'=>'Location Saved Successfully!'
            ]);
        }catch(\Exception $ex){
            return Response()->json($ex);
        }
    }

    public function update(LocationRequest $request , int $id){

        // return $request;

        try{

            $location = Location::find($id);

            if(!$location){
                return Response()->json([
                    'status'=>false,
                    'message'=>'Location For The User  Is Not Found!'
                ]);
            }

            $location->update($request->except('user_id','id'));
            
            return Response()->json([
                'status'=>true,
                'message'=>'Location Has Been Updated Successfully!'
            ]);


        }catch(\Exception $ex){
            return response()->json($ex);
        }
    }
    public function destroy(int $id){

        $location=Location::find($id);

        if(!$location){
            return Response()->json([
                'message'=>'Location For The User  Is Not Found!'
            ]);
        }

        $location->delete();

        return Response()->json([
            'message'=>'Location Has Been Deleted Successfully!'
        ]);


    }
}
