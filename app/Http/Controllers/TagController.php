<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagRequest;
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

    public function store(TagRequest $request)
    {
        Tag::create($request->validated());
        return back()->with('success', __('Tag has added successfuly.'));
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', ['tag' => $tag]);
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        return redirect('/tags');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect('/tags');
    }
}
