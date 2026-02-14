<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Commands\UpdateCategoryCommand;
use App\Domain\Categories\Handlers\UpdateCategoryHandler;
use App\Domain\Categories\Queries\CategoryListQuery;
use App\Domain\Categories\Queries\CategoryPostsPaginatedQuery;
use App\Domain\Categories\Queries\CategoryTreeQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\ValueObjects\Slug;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, CategoryListQuery $query): View
    {
        $categoryPaginator = $query->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('perPage', 3),
        );

        return view('admin.categories.index', [
            'title' => 'Category List Page',
            'categories' => $categoryPaginator,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategoryTreeQuery $query): View
    {
        $categoryTree = $query->handle(null);

        return view('admin.categories.create', [
            'title' => 'Create New Category',
            'categories' => $categoryTree,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $data = $request->validated();

        Category::query()->create([
            'name' => $data('name'),
            'slug' => Slug::createFromString($data('name')),
            'parent_id' => $data('parent_id'),
        ]);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Category $category, CategoryPostsPaginatedQuery $query): View
    {
        $postPaginator = $query->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('perPage', 3),
            category: $category,
        );

        return view('admin.categories.show', [
            'title' => 'Tag List Page',
            'category' => $category,
            'posts' => $postPaginator,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategoryTreeQuery $query, Category $category): View
    {
        $categoryTree = $query->handle($category->id);

        return view('admin.categories.edit', [
            'title' => 'AdminLTE 3 | Edit Category Page',
            'currentCategory' => $category,
            'categoryTree' => $categoryTree,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $category, UpdateCategoryHandler $handler): RedirectResponse
    {
        $command = new UpdateCategoryCommand(
            currentCategorySlug: $category,
            name: $request->validated('name'),
            parentId: $request->validated('parent_id'),
            editSlug: $request->boolean('editSlug'),
            slug: $request->validated('slug'),
        );
        $handler->handle($command);

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', 'Category deleted successfully');
    }
}
