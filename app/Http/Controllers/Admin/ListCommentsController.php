<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Comments\Queries\ListCommentsQuery;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class ListCommentsController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, ListCommentsQuery $query)
    {
        $commentPaginator = $query->handle(
            page: (int) $request->query('page', 1),
            perPage: (int) $request->query('perPage', 3),
        );

        return view('admin.comments.index', [
            'title' => 'Comment List Page',
            'comments' => $commentPaginator,
        ]);
    }
}
