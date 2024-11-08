<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsCollection;
use App\Models\Post;
use App\Models\User;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct(
        private FileService $fileService
    ) {}

    public function show(string $id)
    {
        $user = User::find($id);

        if (! $user) {
            return redirect()->route('home');
        }

        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return Inertia::render('User', [
            'user' => $user,
            'postsByUser' => new AllPostsCollection($posts)
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:jpg,jpeg,png']
        ]);

        $user = $this->fileService->updateFile(auth()->user(), $request, 'user');
        $user->save();

        return redirect()->route('users.show', [
            'id' => auth()->user()->id
        ]);
    }
}
