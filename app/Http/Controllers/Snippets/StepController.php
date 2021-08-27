<?php

namespace App\Http\Controllers\Snippets;

use App\Http\Controllers\Controller;
use App\Models\Snippet;
use App\Models\Step;
use App\Transformers\Snippets\StepTransformer;
use Illuminate\Http\Request;

class StepController extends Controller
{
    public function update(Request $request, Snippet $snippet, Step $step)
    {
        $step->update($request->only('title', 'body'));
    }

    public function store(Request $request, Snippet $snippet)
    {
        $step = $snippet->steps()->create($request->only('title', 'body') + [
            'order' => 1
        ]);

        return fractal()
            ->item($step)
            ->transformWith(new StepTransformer())
            ->toArray();
    }
}
