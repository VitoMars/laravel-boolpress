@extends('layouts.dashboard')

@section('content')
   <h1>Lista dei Posts</h1>

   {{-- Alert di modifica --}}
   @if(session("inserted"))
         <div class="alert alert-success">
            {{ session("inserted") }}
         </div>
   @endif

   @if(session("updated"))
      <div class="alert alert-success">
         {{ session("updated") }}
      </div>
   @endif

   @if(session("deleted"))
      <div class="alert alert-danger">
         {{ session("deleted") }}
      </div>
   @endif

   <table class="table table-striped">
      <thead> 
         <tr>
            <th scope="col">#</th>
            <th scope="col">Name</th>
            <th scope="col">Slug</th>
            <th scope="col">Actions</th>
         </tr>
      </thead>
      {{-- Body --}}
      <tbody>
         @foreach ($categories as $category)
            <tr>
               <td scope="row"> {{ $category["id"] }}</td>
               <td>{{ $category["name"] }}</td>
               <td>{{ $category["slug"] }}</td>
               {{-- <td>{{ $category["category"] }}</td> --}}
               {{-- Details --}}
               <td>
               <a href="{{ route("admin.categories.show", $category->id) }}" class="btn btn-info">Details</a>
               {{-- Modify --}}
               <a href="" class="btn btn-warning">Modify</a>
               {{-- Delete --}}
               <a class="btn btn-danger" data-toggle="modal" data-target="#deletePost{{$category->id}}" href="#deletePost">Delete</a>
               </td>
               {{-- <td>
                  <form action="{{ route("admin.posts.destroy", $category["id"]) }}" method="post" class="d-inline-block">
                     @csrf
                     @method("DELETE")
                     <button type="submit" onclick="window.confirmDelete()" class="btn btn-danger">Delete</button>
                  </form>
               </td> --}}
            </tr>

            <!-- Modal -->
            <div class="modal fade" id="deletePost{{$category->id}}" tabindex="-1" aria-labelledby="deletePostLabel" aria-hidden="true">
               <div class="modal-dialog">
                  <div class="modal-content">
                     <div class="modal-header">
                        <h5 class="modal-title" id="deletePostLabel">Delete confirmation: Post # {{$category->id}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                        </button>
                  </div>
                  <div class="modal-body">
                     <p>You are about to <strong>permanently</strong> delete the post from the database.</p>
                     <p>Are you sure you want to delete it?</p>
                     <p><strong>The action cannot be reversed</strong></p>
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                     <form action="" method="POST">
                         @csrf
                         @method('DELETE')
                         <button type="submit" class="btn btn-danger">Delete</button>
                     </form>
                  </div>
               </div>
            </div>
         @endforeach
      </tbody>
   </table>
@endsection 