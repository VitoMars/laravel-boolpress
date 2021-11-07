@extends('layouts.dashboard')

@section('content')
   <h1>Lista dei Posts</h1>
   <table class="table table-striped">
      <thead> 
         <tr>
            <th scope="col">#</th>
            <th scope="col">Title</th>
            <th scope="col">Slug</th>
            <th scope="col">Actions</th>
         </tr>
      </thead>
      {{-- Body --}}
      <tbody>
         @foreach ($posts as $post)
            <tr>
               <td scope="row"> {{ $post["id"] }}</td>
               <td>{{ $post["title"] }}</td>
               <td>{{ $post["slug"] }}</td>
               {{-- Details --}}
               <td><a href="{{ route("admin.posts.show", $post["id"]) }}" class="btn btn-info">Details</a></td>
               {{-- Modify --}}
               <td><a href="{{ route("admin.posts.edit", $post["id"]) }}" class="btn btn-warning">Modify</a></td>
               {{-- Delete --}}
               <td>
                  <form action="{{ route("admin.posts.destroy", $post["id"]) }}" method="post" class="d-inline-block">
                     @csrf
                     @method("DELETE")
                     <button type="submit" onclick="window.confirmDelete()" class="btn btn-danger">Delete</button>
                  </form>
               </td>
            </tr>
          @endforeach
      </tbody>
   </table>
@endsection 