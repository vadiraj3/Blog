@extends('layouts.app')

@section('content')
            {!! Form::open(['action' =>[ 'BlogsController@update',$post->id],'method'=>'POST','enctype'=>'multipart/form-data']) !!}
            <div class="form-group">
            {{ Form::label('Title:', '')}}
            {{Form::text('title', $post->title,['class'=>'form-control'])}}
            </div>

            <div class="form-group">
                {{ Form::label('About:', '')}}
                {{Form::text('about', $post->about,['class'=>'form-control'])}}
                </div>
    
            <div class="form-group">
            {{ Form::label('Body:', '')}}
            {{Form::textarea('body', $post->body,['class'=>'form-control'])}}
            </div>

            <div class="form-group">
                {{Form::file('cover_image',['class'=>'form-control'])}}
            </div>

            <div class="form-group">
                {{Form::file('images[]',['class'=>'form-control','multiple'=>true])}}
               </div>

            {{Form::hidden('_method','PUT')}}
           

            <div class="form-group">
                {{Form::submit('Submit',['class'=>'btn btn-primary'])}}
            </div>


            
            
            {!! Form::close() !!}
@endsection
