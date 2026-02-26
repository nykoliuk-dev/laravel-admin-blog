@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Category List Page')

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Category Management</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                    <li class="breadcrumb-item active">Categories</li>
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
                        <h3 class="card-title">Category Table</h3>
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary ml-auto">Add Category</a>
                    </div>
                    <!-- /.card-header -->
                    @if($categories)
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent Category</th>
                                <th>Posts Count</th>
                                <th style="width: 40px">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->id }}.</td>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug->getValue() }}
                                <td>{{ $category->parentName }}</td>
                                <td>{{ $category->postsCount }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.categories.show', ['category' => $category->slug->getValue()]) }}" class="btn btn-outline-info btn-sm mx-1">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.categories.edit', ['category' => $category->slug->getValue()]) }}" class="btn btn-outline-warning btn-sm mx-1">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', ['category' => $category->slug->getValue()]) }}" method="POST" >
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
                    <!-- /.card-body -->
                    @if ($categories->hasPages())
                    {{ $categories->links('components.pagination.admin') }}
                    @endif
                    @else
                    <p>No categories yet...</p>
                    @endif
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>

</section>
<!-- /.content -->
@endsection
