<?php

namespace App\Http\Controllers\Snippets;

use App\Http\Controllers\Controller;
use App\Models\Snippet;
use App\Transformers\Snippets\SnippetTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SnippetController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api'])->only('store');
    }

    public function index(Request $request)
    {
        return fractal()
            ->collection(
                Snippet::take($request->get('limit', 10))->latest()->public()->get()
            )
            ->transformWith(new SnippetTransformer())
            ->parseIncludes([
                'author'
            ])
            ->toArray();
    }

    public function show(Snippet $snippet)
    {
        $this->authorize('show', $snippet);

        return fractal()
            ->item($snippet)
            ->parseIncludes([
                'steps',
                'author',
                'user'
            ])
            ->transformWith(new SnippetTransformer())
            ->toArray();
    }

    public function store(Request $request)
    {
        $snippet = $request->user()->snippets()->create();

        return fractal()
            ->item($snippet)
            ->parseIncludes([
                'steps',
                'author',
                'user'
            ])
            ->transformWith(new SnippetTransformer())
            ->toArray();
    }

    public function update(Request $request, Snippet $snippet)
    {
        $this->authorize('update', $snippet);

        $this->validate($request, [
            'title' => 'nullable',
            'is_public' => 'nullable|boolean'
        ]);

        $snippet->update($request->only('title', 'is_public'));

        return fractal()
            ->item($snippet)
            ->parseIncludes([
                'steps',
                'author',
                'user'
            ])
            ->transformWith(new SnippetTransformer())
            ->toArray();
    }

    public function destroy(Snippet $snippet)
    {
        $this->authorize('destroy', $snippet);

        $snippet->delete();
    }
}
