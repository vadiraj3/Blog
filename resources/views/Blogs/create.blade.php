@extends('layouts.app')

@section('content')
     
           @if (Auth::guest())
               <div class="alert alert-info text-center"><h6>U must Be Registerd To Create a Blog</h6></div>
           @else
           {!! Form::open(['action' => 'BlogsController@store','method'=>'POST','enctype'=>'multipart/form-data']) !!}
           @csrf
           <div class="form-group">
           {{ Form::label('Title:', '')}}
           {{Form::text('title', '',['class'=>'form-control'])}}
           </div>
           
           <div class="form-group">
            {{ Form::label('About:', '')}}
            {{Form::text('about', '',['class'=>'form-control'])}}
            </div>

           <div class="form-group">
           {{ Form::label('Body:', '')}}
           {{Form::textarea('body', '',['class'=>'form-control'])}}
           </div>

           <div class="form-group">
            {{Form::file('cover_image',['class'=>'form-control'])}}
           </div>

           <div class="form-group">
            {{Form::file('images[]',['class'=>'form-control','multiple'=>true])}}
           </div>
          

            <div class="form-group">
               {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
           </div>
          
            {!! Form::close() !!}
           @endif

          
           
@endsection
