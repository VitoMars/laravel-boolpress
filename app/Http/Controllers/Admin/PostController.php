<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Category;
use App\Post;
use App\Tag;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view("admin.posts.index", compact("posts"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view("admin.posts.create", compact("categories", "tags"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Per prima cosa valido i dati che arrivano dal form
        $request->validate([
            "title" => "required",
            "content" => "required",
            "category_id" => "nullable|exists:categories,id",
            "tags" => "exists:tags,id",
            // "image" => "nullable|image"
        ]);

        $form_data = $request->all();

        $new_post = new Post();

        // Verifico se è stata caricata un'immagine
        if (array_key_exists("image", $form_data)) {
            // Salviamo l'immagine e recuperiamo il percorso
            $cover_path = Storage::put("post_covers", $form_data["image"]);
            // Aggiungiamo all'array che viene usato nella funzione fill
            // la chiave cover che contiene il percorso relativo dell'immagine caricata a partire da public/storage
            $form_data["cover"] = $cover_path;
        }

        $new_post->fill($form_data);

        // Titolo: il mio post
        // Slug: il-mio-post

        $slug = Str::slug($new_post->title, "-");
        // $slug_base = $slug;

        $slug_presente = Post::where("slug", $slug)->first();

        $contatore = 1;

        while ($slug_presente) {
            $slug = $slug . "-" . $contatore;
            $slug_presente = Post::where("slug", $slug)->first();
            $contatore++;
        }

        $new_post->slug = $slug;
        $new_post->save();

        $new_post->tags()->attach($form_data["tags"]);

        return redirect()->route("admin.posts.index")->with("inserted", "Il post è stato correttamente salvato");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::where("id", $id)->first();
        if (!$post) {
            abort(404);
        }
        return view("admin.posts.show", compact("post"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (!$post) {
            abort(404);
        }

        $categories = Category::all();
        $tags = Tag::all();

        // Quello che mi crea
        // $data = [
        //     "post" => $post,
        //     "categories" => $categories
        // ];

        return view("admin.posts.edit", compact("post", "categories", "tags"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            "title" => "required",
            "content" => "required",
            "category_id" => "nullable|exists:categories,id",
            "tags" => "exists:tags,id",
            // "image" => "nullable|image"
        ]);

        $form_data = $request->all();

        // Verifico se il titolo ricevuto dal form è diverso dal vecchio titolo

        if ($form_data["title"] != $post->title) {
            // è stato modificato il titolo, quindi devo modificare anche lo slug

            $slug = Str::slug($form_data["title"], "-");

            $slug_presente = Post::where("slug", $slug)->first();

            $contatore = 1;
            while ($slug_presente) {
                $slug = $slug . "-" . $contatore;
                $slug_presente = Post::where("slug", $slug)->first();
                $contatore++;
            }

            $form_data["slug"] = $slug;
        };

        // Verifico se è stata caricata un immagine
        if (array_key_exists("image", $form_data)) {
            // Salvo l'immagine e recopero il path
            Storage::delete($post->cover);
            $cover_path = Storage::put("post_covers", $form_data["image"]);
            $form_data["cover"] = $cover_path;
        }

        $post->update($form_data);

        if (array_key_exists("tags", $form_data)) {
            $post->tags()->sync($form_data["tags"]);
        } else {
            $post->tags()->sync([]);
        }

        return redirect()->route("admin.posts.index")->with("updated", "Post correttamente aggiornato");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route("admin.posts.index")->with("deleted", "Post eliminato");
    }
}
