@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Comment List Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Comment Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Comments</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Comment Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div id="example2_wrapper" class="dataTables_wrapper dt-bootstrap4">
                                @if($comments)
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <table id="example2" class="table table-bordered table-hover dataTable dtr-inline" aria-describedby="example2_info">
                                                <thead>
                                                <tr>
                                                    <th class="sorting sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Rendering engine: activate to sort column descending" aria-sort="ascending">
                                                        Id
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">
                                                        Post Id
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">
                                                        User Name
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending">
                                                        Content
                                                    </th>
                                                    <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending">
                                                        Updated At
                                                    </th>
                                                    <th>
                                                        Action
                                                    </th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($comments as $i => $comment)
                                                        <tr class="{{ $i % 2 == 0 ? 'even' : 'odd' }}">
                                                            <td class="dtr-control sorting_1" tabindex="0">{{ $comment->id }}</td>
                                                            <td>{{ $comment->postId }}</td>
                                                            <td>{{ $comment->userName }}</td>
                                                            <td>{{ $comment->content }}</td>
                                                            <td>{{ $comment->updatedAt }}</td>
                                                            <td>
                                                                <form action="{{ route('admin.comments.destroy', ['comment' => $comment->id]) }}" method="POST" >
                                                                    @csrf
                                                                    @method('delete')
                                                                    <button type="submit" class="btn btn-outline-danger btn-sm mx-1" onclick="return confirm('Are you sure?')">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </button>
                                                                </form>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>

                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if ($comments->hasPages())
                                            <div class="col-sm-12 col-md-5">
                                                <div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Showing {{ $comments->firstItem() }} to {{ $comments->lastItem() }} of {{ $comments->total() }} comments
                                                </div>
                                            </div>
                                            <div class="col-sm-12 col-md-7">
                                                <div class="dataTables_paginate paging_simple_numbers" id="example2_paginate">
                                                    {{ $comments->links('components.pagination.admin') }}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <p>No comments yet...</p>
                                @endif
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </section>
    <!-- /.content -->
@endsection
