<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::orderByDesc('id')->paginate(10);
        return view('tags.index', ['tags' => $tags]);
    }

    public function create()
    {
        return view('tags.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:tags|min:3'
        ]);
        Tag::create($request->all());
        return redirect('/tags');
    }

    public function show(Tag $tag)
    {
        //
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', ['tag' => $tag]);
    }

    public function update(Request $request, Tag $tag)
    {
        $request->validate([
            'name' => 'required|unique:tags|min:3'
        ]);
        $tag->update($request->all());
        return redirect('/tags');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect('/tags');
    }
}
