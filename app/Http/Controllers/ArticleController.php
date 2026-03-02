<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use App\Models\Article;

class ArticleController extends Controller
{
    public function index()
    {
        abort_if(request()->user()->role < 10, 403, 'Unauthorized action.');

        $articles = request()->user()->articles()->latest()->get();
        return view('articles.index', compact('articles'));
    }

    public function create()
    {
        abort_if(request()->user()->role < 10, 403, 'Unauthorized action.');

        return view('articles.create');
    }

    public function show(Article $article)
    {
        abort_unless($article->is_published, 404);

        $article->load('user');

        return view('articles.show', compact('article'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()->role < 10, 403, 'Unauthorized action.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image' => ['required', 'image', 'max:2048'], // 2MB max
            'is_published' => ['nullable', 'boolean'],
        ]);

        // Generate a unique slug
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;
        while (Article::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // Handle image upload
        $imagePath = $request->file('image')->store('articles', 'public');

        $request->user()->articles()->create([
            'title' => $validated['title'],
            'slug' => $slug,
            'description' => $validated['description'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'is_published' => $request->has('is_published'),
        ]);

        return redirect()->route('articles.index')
            ->with('status', 'article-created');
    }

    public function edit(Article $article)
    {
        abort_if(request()->user()->id !== $article->user_id, 403, 'Unauthorized action.');

        return view('articles.edit', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        abort_if($request->user()->id !== $article->user_id, 403, 'Unauthorized action.');

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'image' => ['nullable', 'image', 'max:2048'], // Image is optional on update
            'is_published' => ['nullable', 'boolean'],
        ]);

        $dataToUpdate = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'content' => $validated['content'],
            'is_published' => $request->has('is_published'),
        ];

        // Only generate a new slug if the title actually changed
        if ($validated['title'] !== $article->title) {
            $slug = Str::slug($validated['title']);
            $originalSlug = $slug;
            $counter = 1;
            // Exclude current article ID from the uniqueness check
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $dataToUpdate['slug'] = $slug;
        }

        // Handle image replacement
        if ($request->hasFile('image')) {
            // Delete old image
            if ($article->image_path) {
                Storage::disk('public')->delete($article->image_path);
            }

            // Store new image
            $dataToUpdate['image_path'] = $request->file('image')->store('articles', 'public');
        }

        $article->update($dataToUpdate);

        return redirect()->route('articles.index')
            ->with('status', 'article-updated');
    }

    public function destroy(Article $article): RedirectResponse
    {
        abort_if(request()->user()->id !== $article->user_id, 403, 'Unauthorized action.');

        // Delete the associated image from storage
        if ($article->image_path) {
            Storage::disk('public')->delete($article->image_path);
        }

        $article->delete();

        return redirect()->route('articles.index')
            ->with('status', 'article-deleted');
    }
}
