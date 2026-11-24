<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(Request $request): View
    {
        $category = $request->query('categorie');
        $category = array_key_exists((string) $category, Post::CATEGORIES) ? $category : null;

        $posts = Post::query()->published()
            ->when($category, fn ($q) => $q->where('category', $category))
            ->orderByDesc('published_at')->paginate(12)->withQueryString();

        return view('pages.blog.index', ['posts' => $posts, 'category' => $category]);
    }

    public function show(string $slug): View
    {
        $post = Post::query()->published()->where('slug', $slug)->firstOrFail();

        $related = Post::query()->published()->where('id', '!=', $post->id)
            ->orderByRaw('category = ? desc', [$post->category])
            ->orderByDesc('published_at')->limit(3)->get();

        return view('pages.blog.show', ['post' => $post, 'related' => $related]);
    }
}
