@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Tag List Page')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Tag Management</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin') }}">Home</a></li>
                            <li class="breadcrumb-item active">Tags</li>
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
                            <div class="card-header d-flex">
                                <h3 class="card-title">Tags Table</h3>
                                <a href="{{ route('tags.create') }}" class="btn btn-primary ml-auto">Add tag</a>
                            </div>
                            <!-- /.card-header -->
                            @if($tags)
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Usage</th>
                                            <th style="width: 40px">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tags as $tag)
                                            <tr>
                                                <td>{{ $tag->id }}.</td>
                                                <td>{{ $tag->name }}</td>
                                                <td>{{ $tag->slug->getValue() }}
                                                <td>{{ $tag->usage }}</td>
                                                <td class="d-flex gap-2">
                                                    <a href="{{ route('tags.edit', ['tag' => $tag->slug->getValue()]) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                    <form action="{{ route('tags.destroy', ['tag' => $tag->slug->getValue()]) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                @if ($tags->hasPages())
                                    {{ $tags->links('components.pagination.admin') }}
                                @endif
                            @else
                                <p>No tags yet...</p>
                            @endif
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>

        </section>
        <!-- /.content -->
    </div>
@endsection
