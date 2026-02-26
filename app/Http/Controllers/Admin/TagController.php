<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Tags\Commands\UpdateTagCommand;
use App\Domain\Tags\Handlers\UpdateTagHandler;
use App\Domain\Tags\Queries\TagPostsPaginatedQuery;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\ValueObjects\Slug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Domain\Tags\Queries\TagListQuery;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Contracts\View\View;

class TagController extends Controller
{
    public function index(Request $request, TagListQuery $query): View
    {
        $tagPaginator = $query->handle(
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

    public function create(): View
    {
        return view('admin.tags.create');
    }

    public function store(StoreTagRequest $request): RedirectResponse
    {
        $name = $request->validated('name');

        Tag::query()->create([
            'name' => $name,
            'slug' => Slug::createFromString($name),
        ]);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag created successfully');
    }

    public function show(Request $request, Tag $tag, TagPostsPaginatedQuery $query): View
    {
        $postPaginator = $query->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('perPage', 3),
            tagId: $tag->id,
        );

        return view('admin.tags.show', [
            'title' => 'Tag List Page',
            'tag' => $tag,
            'posts' => $postPaginator,
        ]);
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', [
            'title' => 'AdminLTE 3 | Edit Tag Page',
            'tag' => $tag,
        ]);
    }

    public function update(UpdateTagRequest $request, Tag $tag, UpdateTagHandler $handler): RedirectResponse
    {
        $command = new UpdateTagCommand(
            currentTag: $tag,
            name: $request->validated('name'),
            editSlug: $request->boolean('editSlug'),
            slug: $request->validated('slug'),
        );
        $handler->handle($command);

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag updated successfully');
    }

    public function destroy(Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()
            ->route('admin.tags.index')
            ->with('success', 'Tag deleted successfully');
    }
}
