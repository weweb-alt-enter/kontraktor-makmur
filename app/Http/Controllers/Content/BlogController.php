<?php

namespace App\Http\Controllers\Content;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Helpers\StorageHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('created_by', auth()->id())
            ->latest()
            ->paginate(10);

        return view('content.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('content.blog.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    $slug = Str::slug($value);
                    if (Blog::where('slug', $slug)->exists()) {
                        $fail('Judul artikel "' . $value . '" sudah digunakan. Silakan gunakan judul yang berbeda.');
                    }
                },
            ],
            'konten' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tags' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        $validated['slug'] = Str::slug($validated['judul']);
        $validated['created_by'] = auth()->id();
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        // Handle featured image with flexible storage
        if ($request->hasFile('featured_image')) {
            $uploaded = StorageHelper::upload($request->file('featured_image'), 'blog');
            $validated['featured_image'] = $uploaded['path'];
        }

        Blog::create($validated);

        return redirect()->route('content.blog.index')
            ->with('success', 'Artikel "' . $validated['judul'] . '" berhasil ditambahkan! 🎉');
    }

    public function edit(Blog $blog)
    {
        if ($blog->created_by !== auth()->id()) {
            abort(403);
        }

        return view('content.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        if ($blog->created_by !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'judul' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($blog) {
                    $slug = Str::slug($value);
                    $exists = Blog::where('slug', $slug)
                        ->where('id', '!=', $blog->id)
                        ->exists();

                    if ($exists) {
                        $fail('Judul artikel "' . $value . '" sudah digunakan oleh artikel lain. Silakan gunakan judul yang berbeda.');
                    }
                },
            ],
            'konten' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'tags' => 'nullable|string|max:255',
            'is_published' => 'boolean',
        ]);

        if ($blog->judul !== $validated['judul']) {
            $validated['slug'] = Str::slug($validated['judul']);
        }

        $wasPublished = $blog->is_published;
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && !$wasPublished) {
            $validated['published_at'] = now();
        }

        if (!$validated['is_published']) {
            $validated['published_at'] = null;
        }

        // Handle featured image
        if ($request->hasFile('featured_image')) {
            // Delete old image
            if ($blog->featured_image) {
                StorageHelper::delete($blog->featured_image);
            }
            
            $uploaded = StorageHelper::upload($request->file('featured_image'), 'blog');
            $validated['featured_image'] = $uploaded['path'];
        }

        $blog->update($validated);

        return redirect()->route('content.blog.index')
            ->with('success', 'Artikel "' . $validated['judul'] . '" berhasil diupdate! ✅');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->created_by !== auth()->id()) {
            abort(403);
        }

        if ($blog->featured_image) {
            StorageHelper::delete($blog->featured_image);
        }

        $blog->delete();

        return redirect()->route('content.blog.index')
            ->with('success', 'Blog berhasil dihapus');
    }
}