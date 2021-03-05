<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
Use  App\Blog;
use App\User;

class BlogsController extends Controller
{
    
    public function __construct(){
        $this->middleware('auth',['except'=>['index','show']]);
    } 


    public function index()
    {
        $blogs= Blog::all();
      
       return view('Blogs.home')->with('blogs',$blogs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('Blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'required|unique:blogs',
            'body'=>'required',
            'about'=>'required',
            'cover_image'=>'image|nullable|max:2000',
            'images.*'=>'image|nullable|max:2000'
        ]);

            //image
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
        $blog->user_id= auth()->user()->id;
        $blog->cover_image=$fileNametoStore;
      
        $blog->photos=$photostring;
        $blog->about=$request['about'];
        $blog->save();

        return redirect('/dashboard')->with('success','Blog Created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blog= Blog::find($id);
        $names=$blog->photos;
        $body=$blog->body;
        $str=(explode(",",$names));
        $photoNum= count($str);
        $bodylength=strlen($body);
    
        $bodystrings= floor($bodylength/($photoNum)); 
       
      
      
        $blogs=array(
            'blogs'=>$blog,
            'body'=>$body,
            'photos'=>$str,
            'photoNum'=>$photoNum,
            'bodylength'=>$bodylength,
            'strings'=> $bodystrings
        );
      
        return view('Blogs.show')->with('blog',$blogs);

       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(auth()->user()->id !== $post->user_id){
            return redirect('/home')->with('error','Unauthorized access');
        }
        $post= Blog::find($id);
        return view('Blogs.edit')->with('post',$post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'title'=>'required',
            'body'=>'required',
            'about'=>'required',
            'cover_image'=>'image|nullable|max:2000',
            'images.*'=>'image|nullable|max:2000'
        ]);

            //image
            if($request->hasFile('cover_image')){
                $filenameWithExt= $request['cover_image']->getClientOriginalName();

                $filename= pathinfo($filenameWithExt, PATHINFO_FILENAME);

                $extension= $request->file('cover_image')->getClientOriginalExtension();
                
                $fileNametoStore= $filename.'_'.time().'_'.$extension;

                $path= $request->file('cover_image')->storeAs('public/cover_images/'.$request['title'],$fileNametoStore);
           
            }
                else{
                    $fileNametoStore="noimage.jpg";
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

           

        $blog= Blog::find($id);
        $blog->title= $request['title'];
        $blog->body=$request['body'];
        $blog->user_id= auth()->user()->id;
        
        $blog->cover_image=$fileNametoStore;
        $blog->photos=$photostring;
        $blog->about=$request['about'];
        $blog->save();

        return redirect('/dashboard')->with('success','Blog Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {   
       
        $post= Blog::find($id);

        if(auth()->user()->id !== $post->user_id){
            return redirect('/home')->with('error','Unauthorized access');
        }

           Storage::deleteDirectory('public/cover_images/'.$post->title);
          
           Storage::deleteDirectory('public/photos/'.$post->title);
            $post->delete();
            return redirect('/dashboard')->with('success','Blog Deleted');
        
     
    }
}
