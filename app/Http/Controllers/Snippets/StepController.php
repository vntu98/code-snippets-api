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
        $this->authorize('update', $step);

        $step->update($request->only('title', 'body'));
    }

    public function store(Request $request, Snippet $snippet)
    {
        $this->authorize('storeStep', $snippet);
        
        $step = $snippet->steps()->create($request->only('title', 'body') + [
            'order' => $this->getOrder($request)
        ]);

        return fractal()
            ->item($step)
            ->transformWith(new StepTransformer())
            ->toArray();
    }

    public function destroy(Snippet $snippet, Step $step)
    {
        $this->authorize('destroy', $step);

        if ($snippet->steps->count() === 1) {
            return response(null, 400);
        }

        $step->delete();
    }

    protected function getOrder(Request $request)
    {
        return Step::where('uuid', $request->before)
            ->orWhere('uuid', $request->after)
            ->first()
            ->{($request->before ? 'before' : 'after') . 'Order'}();
    }
}
