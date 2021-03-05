@extends('layouts.app')

@section('content')

        <a href="/dashboard" class="btn btn-primary"><small>Go back</small></a>
        <hr>
        <div class="row ">
            <h2 style="margin: auto;">{{$blog['blogs']->title}}</h2>
            <div class="col-md-12" style="overflow: hidden;">
         <img style="height:75vh;width:100%;" src="/storage/cover_images/{{$blog['blogs']->title}}/{{$blog['blogs']->cover_image}}" alt="">
           
        </div >
    </div>
    @php
    $start=0;
    $end=$blog['strings'];
 
    $temp=$end;
    @endphp
    
        <div class="col-md-12">
           @for ($i = 0; $i < $blog['photoNum']; $i++)
                    <h4 class="bg-white p-5">{{substr($blog['blogs']->body,$start,$end)}}</h4>
                    @if ($i<($blog['photoNum']-1))
                    <div class="text-center">
                    <img style="height:40vh;width:50%;" src="/storage/photos/{{$blog['blogs']->title}}/{{$blog['photos'][$i]}}" alt="">
                     </div>  
                    @endif
                   
                   
                   
                    @if (!$start==$end)
                        @php
                        $start=$end;
                        @endphp
                    @else
                        @php
                        $start= $start+$temp;
                        @endphp
                
                    @endif
                  
                   
           @endfor
         
           <hr>
           <p class="text-center">Created by {{$blog['blogs']->user->name}} on {{$blog['blogs']->created_at}}</p>
        </div>
    </div> 
    
@endsection

