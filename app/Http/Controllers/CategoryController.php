<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
   
   public function index(){
  
   $data = Category::all() ; 

   return response()->json(['data' => $data]);

   }


    public function store(Request $request){

           $request->validate([
            'name' => 'required|string',
            'description'=>'required|string', 
           ]
           );


           $category = Category::create([
            'name' =>$request->name ,
            'description'=>$request->description,
        ]);
        

        return response()->json([
            'message' => 'Category created successfully',  
            'data' => $category,  
        ], 201); // HTTP 201: Created
    
    } 

    public function update(Request $request , $id){

       $category = Category::find($id) ; 


    if(!$category){

        return response()->json(['message'=>'do not have  category that you want to update i']);
    }

    $fill = request()->all() ; 

    $category->update($fill);

    return response()->json([
        'message'=>'your update successful ',
        ]);
        
        }

        public function destroy($id){
            $category = Category::find($id) ; 
            if(!$category){

                return response()->json(['message'=>'do not have  category that you want to update i']);
            }

            $category->delete() ;


            return response()->json([
                'message'=>'deleted ',
                ]);
            
        }
    }

    


