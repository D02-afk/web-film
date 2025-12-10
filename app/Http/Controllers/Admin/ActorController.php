<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ActorController extends Controller
{
    public function index()
    {
        $actors = Actor::withCount('movies')->latest()->paginate(20);

        return view('admin.actors.index', compact('actors'));
    }

    public function create()
    {
        return view('admin.actors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:actors,name',
            'avatar'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'birthday' => 'nullable|date',
            'country'  => 'nullable|string|max:100',
            'bio'      => 'nullable|string',
        ]);

        $data = $request->only(['name', 'birthday', 'country', 'bio']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('actors', 'public');
        }

        Actor::create($data);

        return redirect()->route('admin.actors.index')
                         ->with('success', 'Thêm diễn viên thành công!');
    }

    public function edit(Actor $actor)
    {
        return view('admin.actors.edit', compact('actor'));
    }

    public function update(Request $request, Actor $actor)
    {
        $request->validate([
            'name'     => 'required|string|max:255|unique:actors,name,' . $actor->id,
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'birthday' => 'nullable|date',
            'country'  => 'nullable|string|max:100',
            'bio'      => 'nullable|string',
        ]);

        $data = $request->only(['name', 'birthday', 'country', 'bio']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('avatar')) {
            // Xóa ảnh cũ nếu có
            if ($actor->avatar) {
                Storage::disk('public')->delete($actor->avatar);
            }
            $data['avatar'] = $request->file('avatar')->store('actors', 'public');
        }

        $actor->update($data);

        return redirect()->route('admin.actors.index')
                         ->with('success', 'Cập nhật diễn viên thành công!');
    }

    public function destroy(Actor $actor)
    {
        if ($actor->avatar) {
            Storage::disk('public')->delete($actor->avatar);
        }

        $actor->delete();

        return back()->with('success', 'Xóa diễn viên thành công!');
    }
}