<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use App\Models\Article;

#[Layout('layouts.dashboard', ['title' => 'Articles'])]
class ArticleBrowser extends Component
{
    use WithPagination;

    public string $search = '';
    public string $sort = 'newest';

    // Reset pagination whenever any filter changes
    public function updating(string $field): void
    {
        if (in_array($field, ['search', 'sort'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        $query = Article::with('user')
            ->where('is_published', true);

        // Text search: title or description
        if (!empty($this->search)) {
            $term = $this->search;
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
            });
        }

        // Sorting
        match ($this->sort) {
            'oldest' => $query->orderBy('created_at', 'asc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $articles = $query->paginate(8);

        return view('livewire.article-browser', [
            'articles' => $articles,
        ]);
    }
}
