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

    public function show(Snippet $snippet)
    {
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
        $this->validate($request, [
            'title' => 'nullable'
        ]);

        $snippet->update($request->only('title'));

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
}
