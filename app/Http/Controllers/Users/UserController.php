<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Transformers\Users\PublicUserTransformer;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(User $user)
    {
        return fractal()
            ->item($user)
            ->transformWith(new PublicUserTransformer())
            ->toArray();
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('as', $user);

        $this->validate($request, [
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            'username' => 'required|alpha_dash|unique:users,username,' . $request->user()->id,
            'name' => 'required',
            'password' => 'nullable|min:6'
        ]);

        $user->update(
            $request->only('email', 'name', 'username', 'password')
        );
    }
}
