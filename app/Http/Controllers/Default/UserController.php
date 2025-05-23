<?php

namespace App\Http\Controllers\Default;

use App\Http\Controllers\Controller;
use App\Models\Default\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $request->user()->allow('view-user', true);

        $query = User::query()->with(['role', 'store']);

        if ($request->q) {
            $query->where('name', 'like', "%{$request->q}%");
        }

        $query->orderBy('created_at', 'desc');

        return inertia('User/Index', [
            'data' => $query->paginate(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|max:255',
            'role_id' => 'required|ulid|exists:roles,id',
            'store_id' => 'required|ulid|exists:stores,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role_id' => $request->role_id,
            'store_id' => $request->store_id,
        ]);

        return redirect()->route('user.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed created']);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|max:255',
            'store_id' => 'required|ulid|exists:stores,id',
        ]);

        if ($user->role != null) {
            $request->validate([
                'role_id' => 'required|ulid|exists:roles,id',
            ]);
        }

        $user->fill([
            'email' => $request->email,
            'name' => $request->name,
            'role_id' => $request->role_id,
            'store_id' => $request->store_id,
        ]);

        if ($request->password != '') {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return redirect()->route('user.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed updated']);
    }

    public function destroy(User $user): RedirectResponse
    {
        if ($user->role_id == null) {
            return redirect()->route('user.index')
                ->with('message', ['type' => 'error', 'message' => 'Item default can\'t deleted']);
        }

        $user->delete();

        return redirect()->route('user.index')
            ->with('message', ['type' => 'success', 'message' => 'Item has beed deleted']);
    }
}
