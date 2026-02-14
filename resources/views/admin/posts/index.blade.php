@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Post List Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Post Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item active">Posts</li>
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
                            <h3 class="card-title">Posts Table</h3>
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-primary ml-auto">Add post</a>
                        </div>
                        <!-- /.card-header -->
                        @if($posts)
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Image</th>
                                        <th>Title/Content</th>
                                        <th style="width: 40px">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($posts as $post)
                                        <tr>
                                            {{-- ID --}}
                                            <td class="align-middle text-muted" style="width: 60px;">
                                                {{ $post->id }}
                                            </td>

                                            {{-- Image --}}
                                            <td class="align-middle" style="width: 90px;">
                                                <img src="{{ $post->imageUrl }}"
                                                     alt="post-img"
                                                     class="img-thumbnail"
                                                     style="width:70px; height:70px; object-fit:cover;">
                                            </td>

                                            {{-- Title + Preview --}}
                                            <td class="align-middle">
                                                <div class="font-weight-bold">
                                                    {{ $post->title }}
                                                </div>

                                                <div class="text-muted small mt-1"
                                                     style="max-width: 500px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    {{ Str::limit(strip_tags($post->content), 140) }}
                                                </div>
                                            </td>

                                            {{-- Actions --}}
                                            <td class="align-middle text-right d-flex gap-2">
                                                <a href="{{ route('admin.posts.show', ['post' => $post->slug->getValue()]) }}"
                                                   class="btn btn-outline-info btn-sm mx-1"
                                                   title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('admin.posts.edit', ['post' => $post->slug->getValue()]) }}"
                                                   class="btn btn-outline-warning btn-sm mx-1"
                                                   title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <form action="{{ route('admin.posts.destroy', ['post' => $post->slug->getValue()]) }}" method="POST" >
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
                                @if ($posts->hasPages())
                                    {{ $posts->links('components.pagination.admin') }}
                                @endif
                            </div>
                            <!-- /.card-body -->

                        @else
                            <p>No posts yet...</p>
                        @endif
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
