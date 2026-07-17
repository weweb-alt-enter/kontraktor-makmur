<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::published()
            ->latest('published_at')
            ->paginate(9);

        $recentPosts = Blog::published()
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularTags = Blog::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatMap(function ($tags) {
                return explode(',', $tags);
            })
            ->map(function($tag) {
                return trim($tag);
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        return view('frontend.blog-index', compact('blogs', 'recentPosts', 'popularTags'));
    }

    public function show($slug)
    {
        $blog = Blog::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $recentPosts = Blog::published()
            ->where('id', '!=', $blog->id)
            ->latest('published_at')
            ->take(5)
            ->get();

        $popularTags = Blog::published()
            ->whereNotNull('tags')
            ->pluck('tags')
            ->flatMap(function ($tags) {
                return explode(',', $tags);
            })
            ->map(function($tag) {
                return trim($tag);
            })
            ->countBy()
            ->sortDesc()
            ->take(10);

        return view('frontend.blog-show', compact('blog', 'recentPosts', 'popularTags'));
    }
}