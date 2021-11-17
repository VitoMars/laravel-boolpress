@extends('layouts.dashboard')

@section('content')
    <div class="container">
       <div class="row">
          <div class="col-12">
             <h1>Modifica post</h1>
             <form action="{{ route("admin.posts.update", $post["id"]) }}" method="post" enctype="multipart/form-data">
               @csrf
               @method("PUT")

               {{-- Titolo --}}
               <div class="form-group">
                  <label for="title">Titolo</label>
                  <input type="text" name="title" id="title" class="form-control @error("title") is-invalid @enderror" value="{{ old("title", $post["title"]) }}">
                  @error('title')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
               </div>

               {{-- Contenuto --}}
               <div class="form-group">
                  <label for="content">Contenuto</label>
                  <textarea id="content" name="content" class="form-control @error("content") is-invalid @enderror">{!! old("content", $post["content"]) !!}</textarea>
                  @error('content')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
               </div>

                {{-- Categoria --}}
                <div class="form-group">
                  <label for="category_id">Categoria</label>
                  <select name="category_id" id="category_id" class="form-control @error("category_id") is-invalid @enderror">
                      <option value="">-- Seleziona Categoria --</option>
                      @foreach ($categories as $category)
                          <option value="{{ $category["id"] }}" 
                              {{old("category_id", $post["category_id"]) == $category["id"] ? "selected" : null}}
                          >{{ $category["name"] }}</option>
                      @endforeach
                  </select>
                  @error('category_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
               </div>
               
               {{-- Upload file --}}
               <div class="form-group">
                  @if ($post->cover)
                     <p>Immagine di copertina presente:</p>
                     <img class="mb-3" src="{{ asset("storage/" . $post["cover"]) }}" alt="">
                     @else
                        <p>Immagine di copertina non presente!</p>
                  @endif
                  <input type="file" id="image" name="image" class="@error("image") is-invalid @enderror">
                  @error('image')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
              </div>

               {{-- Tag --}}
               <div class="form-group">
                  <p>Seleziona i tag:</p>
                  @foreach ($tags as $tag)
                      <div class="form-check form-check-inline">
                         @if($errors->any())
                              <input 
                              {{ in_array($tag["id"], old("tags", [])) ? "checked" : null}}
                              id="{{ 'tag' . $tag["id"] }}" value="{{ $tag["id"] }}" type="checkbox" 
                              name="tags[]" class="form-check-input">
                              <label for="{{ 'tag' . $tag["id"] }}" class="form-check-label">{{ $tag["name"] }}</label>
                           @else
                              <input 
                              {{ $post->tags->contains($tag["id"]) ? "checked" : null}}
                              id="{{ 'tag' . $tag["id"] }}" value="{{ $tag["id"] }}" type="checkbox" 
                              name="tags[]" class="form-check-input">
                              <label for="{{ 'tag' . $tag["id"] }}" class="form-check-label">{{ $tag["name"] }}</label>
                           @endif
                      </div>
                  @endforeach
                 </div>

               {{-- Bottone Modifica Post --}}
               <div class="form-group">
                  <button type="submit" class="btn btn-primary">Modifica Post</button>
               </div>

            </form>
          </div>
       </div>
    </div>
@endsection