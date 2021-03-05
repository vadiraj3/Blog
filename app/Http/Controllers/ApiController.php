<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Blog;
Use App\User;
Use Validator;

class ApiController extends Controller
{
    
    public function get(string $id)
    {
        $user= User::find($id);
        $blogs=Blog::where('user_id',$id)->get();
        return response()->json($blogs) ;

    }

    

    
   

    public function stored(Request $request)
    {  
   
        
        $validator= Validator::make($request->all(),[
            'title'=>'required|unique:blogs',
            'body'=>'required',
            'about'=>'nullable',
            'user_id'=>'required',
            'cover_image'=>'image|nullable|max:2000',
            'images.*'=>'image|nullable|max:2000'
        ]);
        $user= $request['user_id'];
        $find=User::find($user);
        if($find){
        if($validator->fails()){
            $response= array('response'=>$validator->messages(),'success'=>false);
            return $response;
        }else{
            if($request->hasFile('cover_image')){
                $filenameWithExt= $request['cover_image']->getClientOriginalName();

                $filename= pathinfo($filenameWithExt, PATHINFO_FILENAME);

                $extension= $request->file('cover_image')->getClientOriginalExtension();
                
                $fileNametoStore= $filename.'_'.time().'_'.$extension;

                $path= $request->file('cover_image')->storeAs('public/cover_images/'.$request['title'],$fileNametoStore);
           
            }
                else{
                    $fileNametoStore="noimage.png";
                }
                    $files=[];
                    $photonames=[];
                   
                    if($request->hasFile('images'))
                        {
                            $i=0;
                        $files = $request->file('images');
                       
                        foreach($files as $file){
                        
                     
                           
                            $filenameWithExt= $file->getClientOriginalName();
                      
                        $filename= pathinfo($filenameWithExt, PATHINFO_FILENAME);
                        $extension= $file->getClientOriginalExtension();
                        $fileNametoStor= $filename.'_'.time().'_'.$extension;
                      
                       
                        $path= $file->storeAs('public/photos/'.$request['title'],$fileNametoStor);
                       
                        $photonames[$i]=   $fileNametoStor;
                       
                        $i++;
                          
                      }
                   
                    }
                  
                    $photostring="";
                    foreach($photonames as $photo){
                       
                        $photostring=$photostring.$photo.",";
                }

           

        $blog=  new Blog();
        $blog->title= $request['title'];
      //  $blog->user_id=auth()->user()->id;
        $blog->body=$request['body'];
        $blog->user_id= $request['user_id'];
        $blog->cover_image=$fileNametoStore;
      
        $blog->photos=$photostring;
        $blog->about=$request['about'];
        $blog->save();
        return "Blog inserted Successfully";
        }
    }else{
        return "User Not registered";
    }
    }
    
}
