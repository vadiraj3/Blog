@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}<a href="/blogs/create" class="btn btn-primary float-right">Create Blog</a></div>

                <div class="card-body">
                   
                @if (count($blogs)>0) 
                   <table class="table table-striped">
                       <tr><th>Title</th>
                           <th></th>
                        <th></th></tr>
                        @foreach ($blogs as $blog)
                            <tr><td ><a href="/blogs/{{$blog->id}}" class="ml-5">{{$blog->title}}</a>
                                <div class="col-md-4">
                                  
                                   
                                    <img style="height:200px;width:100%;" src="/storage/cover_images/{{$blog->title}}/{{$blog->cover_image}}" alt="">
                                </div>
                            </td>
                            @if ($blog->user_id==auth()->user()->id)
                            <td> <a href="/blogs/{{$blog->id}}/edit" class="btn btn-primary float-right"> Edit</a></td>
                            <td> {!! Form::open(['action' =>[ 'BlogsController@update',$blog->id],'method'=>'POST','class'=>'float-right']) !!}
                                {{Form::hidden('_method','DELETE')}}
                                {{Form::submit('Delete',['class'=>'btn btn-danger '])}}
                             {!!Form::close()!!} </td></tr>
                            @endif
                            
                                
                               
                          
                        @endforeach
                   </table>
                   @else
                       <div class="alert alert-info">
                           <h6>You don't have any Blogs</h6>
                       </div>
                   @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
