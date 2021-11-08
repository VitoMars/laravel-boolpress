@extends('layouts.dashboard')

@section('content')
   <div class="container">
      <div class="row">
         <div class="col-12">
            <h1>Visualizzazione post {{ $post["id"] }}</h1>
            <h2>{{ $post["title"] }}</h2>
            <p>{!! $post["content"] !!}</p>
            <small>Lo slug è: {{ $post->slug }}</small>
            <br>
            <small>Categoria di appartenenza: 
               <a href="{{ route("admin.categories.show", $post->category->id) }}">{{ $post->category->name }}</a>
            </small>
         </div>
      </div>
   </div>
   
@endsection