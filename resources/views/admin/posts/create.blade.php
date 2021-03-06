@extends('layouts.dashboard')

@section('content')
    <div class="container">
       <div class="row">
          <div class="col-12">
             <h1>Creazione nuovo post</h1>
            
             {{-- Un modo per visualizzare un errore quando non si digita nulla nei campi --}}
             {{-- @if ($errors->any())
             <div class="alert alert-danger">
                 <ul>
                     @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                     @endforeach
                 </ul>
             </div>
            @endif --}}

             <form action="{{ route("admin.posts.store") }}" method="post" enctype="multipart/form-data">
               @csrf
               @method("POST")

               {{-- Titolo --}}
               <div class="form-group">
                  <label for="title">Titolo</label>
                  <input type="text" id="title" name="title" class="form-control @error("title") is-invalid @enderror" value="{{ old("title") }}">
                  @error('title')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
               </div>

               {{-- Contenuto --}}
               <div class="form-group">
                  <label for="content">Contenuto</label>
                  <textarea id="content" name="content" class="form-control @error("content") is-invalid @enderror">{{ old("content") }}</textarea>
                  @error('content')
                      <div class="alert alert-danger">{{ $message }}</div>
                  @enderror
               </div>

               {{-- Category --}}
               <div class="form-group">
                    <label for="category_id">Categoria</label>
                    <select name="category_id" id="category_id" class="form-control @error("category_id") is-invalid @enderror">
                        <option value="">-- Seleziona Categoria --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category["id"] }}" 
                                {{old("category_id") == $category["id"] ? "selected" : null}}
                            >{{ $category["name"] }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
               </div>

               {{-- Upload file --}}
               <div class="form-group">
                   <label for="" class="d-block" >Immagine di copertina</label>
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
                        <input id="{{ 'tag' . $tag["id"] }}" value="{{ $tag["id"] }}" type="checkbox" name="tags[]" class="form-check-input"
                        {{ in_array($tag["id"], old("tags", [])) ? "checked" : null  }}
                        >
                        <label for="{{ 'tag' . $tag["id"] }}" class="form-check-label">{{ $tag["name"] }}</label>
                    </div>
                @endforeach
               </div>

               {{-- Bottone Crea Post --}}
               <div class="form-group">
                  <button type="submit" class="btn btn-primary">Crea Post</button>
               </div>

            </form>
          </div>
       </div>
    </div>
@endsection