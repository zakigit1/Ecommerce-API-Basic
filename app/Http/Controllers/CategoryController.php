<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        // $categories = Category::orderBy('id','DESC')-> paginate(10);
        $categories = Category::all();

        return response()->json([
            'data'=>$categories
        ],201);
    }


    public function store(CategoryRequest $request){
        // return $request;

        try{

            $fileName='';
            if ($request->has('image')) {
                
                $fileName = $this->uploadImage($request->file('image'),'categories'); 

            }

            // return $fileName ;

            $category = Category::create([
                'name'=>$request->name,
                'image'=>$fileName,
            ]);

            return response()->json([
                'message'=>'Category Saved Successfully!',
            ]);


        }catch(\Exception $ex){
            return Response()->Json($ex);
        }
    }


    public function show($id){

        $category=Category::find($id);

        if(!$category){

            return response()->json([
                'message'=>'Category Not Found!',
            ]);
        }

        return response()->json([
            $category
        ],201);

    }

    public function update(CategoryRequest $request , string $id){

        // return $request;

        try{

            $category=Category::find($id);
            
            if(!$category){
                return response()->json([
                    'message'=>'Category Not Found!',
                ]);
            }
            

            if($request->has('image')){

                
                // Delete Old Photo :
                $image = Str::after($category->image,"8000/");
                

                $PcImagePath=base_path('public/'.$image);

                unlink($PcImagePath);//Delete Image From Folder

                //--------------------------------------------
                // add the new photo  :

                $fileName = $this->uploadImage($request->file('image'),'categories');
                //'maincategories' : is the key of the folder we do it in config\filesystem

                DB::beginTransaction();
                
                $to_update=Category::where('id',$id)->update([
                    'image' => $fileName,
                ]);                
                 
               
            }

            $update_category = Category::where('id',$id)->update($request->only('name'));

            DB::commit();

            return Response()->json([
                'message'=>'Category Is Updated Successfuly!'
            ]);

        }catch(\Exception $ex){
            DB::rollBack();
            return Response()->Json($ex);
        }


    }

    public function destroy(int $id){

        $category= Category::find($id);

        if(!$category){
            return Response()->Json([
                'message'=>'Category Not Found!',
            ]);
        }
        //we  delete the image of category first 
        $image = Str::after($category->image,"8000/");
        $PcImagePath=base_path('public/'.$image);
        unlink($PcImagePath);//Delete Image From Folder


        $category->delete();

        return Response()->Json([
            'message'=>'Category Has Been Deleted Successfully!',
        ]);


    }









    public function uploadImage($image , $folder){

        // saving the image in owr project folder(Method 1)
        // $image->store('/', $folder);
       

        ##M1
        //hash name of file or photo to upload so : example : hashName(zaki.jpg) --> 1055489.jpg
        $hashphoto = $image->hashName();
        // saving the image in owr project folder (Method 2)
        $image->move('assets/images/categories',$hashphoto);
        
        // ##M2
        
            // $file=$image;
            // $ext=$image->getClientOriginalExtension();
            // $fileName=time().'.'.$ext;


        return $hashphoto;   
    }

}
