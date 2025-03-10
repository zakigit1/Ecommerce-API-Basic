<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index(){

        $brands= Brand::paginate(10);

        return response()->json([
            $brands
        ], 201);


    }

    public function store(BrandRequest $request){
        try{
            
            // $brand=Brand::create($request->except(['_token']));

            // $brand= Brand::create([
            //     'name'=>$request->name,
            // ]);

            $brand = new Brand();
            $brand->name =strip_tags($request->input('name'));
            $brand->save();
            

            return response()->json([
                'message' => 'تم حفظ الماركة بنجاح',
                'brand' => $brand
            ], 201);
    

           

        }catch(\Exception $ex){

            // return $ex;
            return response()->json([
                'message' => 'هناك خطا ما يرجي المحاوله فيما بعد',
            ]);
    
            
        }

    }

    public function show(string $id){

        $brand=Brand::find($id);
        if(!$brand){

            return response()->json([
                'message'=>'Brand Not Found!',
            ]);
        }

        return response()->json([
            $brand
        ],201);

    }

    public function update(BrandRequest $request , string $id ){
    
        try{ 
            $brand=Brand::find($id);
            if(!$brand){

                return response()->json([
                    'message'=>'Brand Not Found!',
                ]);
            }

            $brand_updated = $brand::where('id',$id)->update($request->only([
                'name'
            ]));

            return response()->json([
                'message' => 'Brand is updated',
            ],201);

        }catch(\Exception $ex){
            return Response()->Json($ex);
        }

    }

    public function destory(string $id){
        $brand = Brand::find($id);

        if(!$brand){
            return response()->json([
                'message'=>'Brand Not Found!',
            ]);
        }

        $brand->delete();

        return response()->json([
            'message'=>'Brand Is Deleted succefully!',
        ]);

    }

}
