@extends('layouts.dashboard')

@section('content')
    <div class="container">
       <div class="row">
          <div class="col-12">
             <h1>Creazione nuovo post</h1>
             <form action="{{ route("admin.posts.store") }}" method="post">
               @csrf
               @method("POST")

               <div class="form-group">
                  <label for="title">Titolo</label>
                  <input type="text" name="title" class="form-control">
               </div>

               <div class="form-group">
                  <label for="content">Contenuto</label>
                  <textarea id="content" name="content" class="form-control"></textarea>
               </div>

               <div class="form-group">
                  <button type="submit" class="btn btn-primary">Crea Post</button>
               </div>

            </form>
          </div>
       </div>
    </div>
@endsection