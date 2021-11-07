@extends('layouts.dashboard')


@section('content')
    <div class="container">
      <h1>Lista dei Comics</h1>
      {{-- @dump($comics) --}}
      <div class="row">
        <div class="col-12">
          <table class="table table-striped">
            <thead>
              <tr class="">
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Slug</th>
                <th scope="col">Actions</th>
              </tr>
            </thead>
            <tbody>

              @foreach ($posts as $post)
              <tr>
                <th scope="row">{{$post["id"]}}</th>
                <td>{{$post["title"]}}</td>
                <td>{{$post["slug"]}}</td>
                <td>{{$post["type"]}}</td>
                {{-- Provare senza ID --}}
                <td><a href="{{ route("admin.posts.show", $post["id"]) }}" class="btn btn-info">Details</a></td>
                <td><a href="{{ route("admin.posts.edit", $post["id"]) }}" class="btn btn-warning">Modify</a></td>
                <td>
                  <form action="{{ route("admin.posts.destroy", $post["id"]) }}" method="post">
                    @csrf
                    @method("DELETE")
                    <button type="submit" onclick="window.confirmDelete()" class="btn btn-danger" data-bs-toggle="modal">Delete</button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      
    </div>
@endsection 