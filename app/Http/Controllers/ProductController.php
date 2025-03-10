<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $products = Product::paginate(10);
        $products = Product::all();
        return Response()->json([
            'products' => $products,
        ],200);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // return $request;
        try{
            if(!$request->has('is_trendy')){
                $request->request->add(['is_trendy' => 0]);
            }else{    
                $request->request->add(['is_trendy' => 1]);
            }
            if(!$request->has('is_available')){
                $request->request->add(['is_available' => 0]);
            }else{    
                $request->request->add(['is_available' => 1]);
            }

            $fileName='';
            if ($request->has('image')) {
                $fileName = $this->uploadImage($request->file('image'),'products'); 
            }

            $product = Product::create([
                'name' => $request->name,
                'category_id'=>$request->category_id,
                'brand_id'=>$request->brand_id,
                'price'=>$request->price,
                'amount'=>$request->amount,
                'discount'=>$request->discount,
                'image'=>$fileName,
                'is_trendy'=>$request->is_trendy,
                'is_available'=>$request->is_available,
            ]);




            return Response()->Json([
                'message' => 'Product Added Successfully!'
            ],201);
        }catch(\Exception $ex){
            return Response()->json( $ex);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product=Product::find($product->id);
        if(!$product){
            return Response()->json([
                'message' => 'Product Not Found!'
            ],404);
        }

        return Response()->Json([
            'product'=>$product,
        ],200);
    }

 

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        // return $request;

        try{

            if(!$request->has('is_trendy')){
                $request->request->add(['is_trendy' => 0]);
            }else{    
                $request->request->add(['is_trendy' => 1]);
            }
            if(!$request->has('is_available')){
                $request->request->add(['is_available' => 0]);
            }else{    
                $request->request->add(['is_available' => 1]);
            }

            $product=Product::find($id);
            
            if(!$product){
                return response()->json([
                    'message'=>'Product Not Found!',
                ]);
            }
            

            if($request->has('image')){

                
                // Delete Old Photo :
                $image = Str::after($product->image,"8000/");
                

                $PcImagePath = base_path('public/'.$image);

                unlink($PcImagePath);//Delete Image From Folder

                //--------------------------------------------
                // add the new photo  :

                $fileName = $this->uploadImage($request->file('image'),'products');
                //'maincategories' : is the key of the folder we do it in config\filesystem

                DB::beginTransaction();
                
                $to_update=Product::where('id',$product->id)->update([
                    'image' => $fileName,
                ]);                
                 
               
            }

            $update_category = Product::where('id',$product->id)->update($request->only([
                'name',
                'price',
                'amount',
                'discount',
                'is_trendy',
                'is_available',
            ]));

            DB::commit();

            return Response()->json([
                'message'=>'Category Is Updated Successfuly!'
            ]);

        }catch(\Exception $ex){
            DB::rollBack();
            return Response()->Json($ex);
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product=Product::find($product->id);

        if(!$product){
            return Response()->json([
                'message' => 'Product Not Found!'
            ],404);
        }

        //we need to delete the image of product first 
        $image = Str::after($product->image,"8000/");
        $PcImagePath=base_path('public/'.$image);
        unlink($PcImagePath);//Delete Image From Folder

        $product->delete();

        return Response()->Json([
            'message' => 'Product Deleted Successfully!'
        ],200);
    }








    public function uploadImage($image , $folder){

        // saving the image in owr project folder(Method 1)
        $image->store('/', $folder);
       
        ##M1
        //hash name of file or photo to upload so : example : hashName(zaki.jpg) --> 1055489.jpg
        $hashphoto = $image->hashName();

        return $hashphoto;   
    }
}
