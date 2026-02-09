<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTagRequest;
use App\ValueObjects\Slug;
use Illuminate\Http\Request;
use App\Domain\Tags\Queries\TagListQuery;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, TagListQuery $query): View
    {
        $tagPaginator = $query->execute(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('perPage', 3),
            path: $request->url(),
            query: $request->query(),
        );

        return view('admin.tags.index', [
            'title' => 'Tag List Page',
            'tags' => $tagPaginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        $name = $request->validated('name');

        Tag::query()->create([
            'name' => $name,
            'slug' => new Slug(Str::slug($name)),
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {

    }

    /**
     * Update the specified resource in storage.
     */
    public function update()
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }
}
