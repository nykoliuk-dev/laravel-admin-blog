<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Categories\Queries\CategoryListQuery;
use App\Domain\Categories\Queries\CategoryTreeQuery;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
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
        $categoryTree = $query->handle();

        return view('admin.categories.create', [
            'title' => 'Create New Category',
            'categories' => $categoryTree,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store()
    {

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
