@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Show Tag Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tag Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.tags.index') }}">Tags</a></li>
                        <li class="breadcrumb-item active">Tag #{{ $tag->name }}</li>
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
                    <div class="card card-outline card-primary collapsed-card">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-tag mr-1"></i>
                                Tag: <strong>{{ $tag->name }}</strong>
                            </h3>

                            <div class="card-tools">
                                <span class="badge badge-secondary mr-2">
                                    {{ $posts->total() ?? count($posts) }} posts
                                </span>

                                <button type="button"
                                        class="btn btn-tool"
                                        data-card-widget="collapse"
                                        title="Toggle Description">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <p class="text-muted mb-0">
                                <strong>ID:</strong>{{ $tag->id }} |
                                <strong>Name:</strong>{{ $tag->name }} |
                                <strong>Slug:</strong>{{ $tag->slug->getValue() }}
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tag Posts Table</h3>

                            <div class="card-tools">
                                
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Title/Content</th>
                                    <th>Actions</th>
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
                                        <td class="align-middle text-right" style="width: 140px;">
                                            <a href="{{ route('admin.posts.show', ['post' => $post->slug->getValue()]) }}"
                                               class="btn btn-outline-info btn-sm"
                                               title="View">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                            <a href="{{ route('admin.posts.edit', ['post' => $post->slug->getValue()]) }}"
                                               class="btn btn-outline-warning btn-sm"
                                               title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
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
