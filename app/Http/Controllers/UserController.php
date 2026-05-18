<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\SearchRequest;
use App\Http\Requests\User\StoreRequest;
use App\Http\Requests\User\UpdateRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
{
    $keyword = $request->input('search');

    if ($keyword) {
        $users = User::whereRaw("MATCH(name,email) AGAINST(? IN BOOLEAN MODE)", [$keyword])
            ->paginate(10)
            ->withQueryString();
    } else {
        $users = User::query()->paginate(10)->withQueryString();
    }

    return view('users.index', compact('users'));

    }
    
      /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['password'] = Hash::make($data['password']);

        User::create($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil dibuat');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }
     /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user)
    {
        $data = $request->validated();

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()->route('admin.users')->with('success', 'User berhasil diupdate');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return back()->with('success', 'User berhasil dihapus');
    }
}