@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Show User Page')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>User Management</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                        <li class="breadcrumb-item active">User #{{ $user->id }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('assets/admin/dist/img/user4-128x128.jpg') }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{ $user->name }}</h3>

                            <p class="text-muted text-center">{{ $user->rolesAsString() }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">About Me</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fas fa-user mr-1"></i> Name</strong>

                            <p class="text-muted">{{ $user->name }}</p>

                            <hr>

                            <strong><i class="fas fa-envelope mr-1"></i> Email</strong>

                            <p class="text-muted">{{ $user->email }}</p>

                            <hr>

                            <strong><i class="fas fa-calendar-plus mr-1"></i> Created At</strong>

                            <p class="text-muted">{{ $user->createdAt }}</p>

                            <hr>

                            <strong><i class="far fa-clock mr-1"></i> Updated At</strong>

                            <p class="text-muted">{{ $user->updatedAt }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item"><a class="nav-link active" href="#comments" data-toggle="tab">Comments</a></li>
                                <li class="nav-item"><a class="nav-link" href="#posts" data-toggle="tab">Posts</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="comments">
                                    @forelse($comments as $comment)
                                        <!-- Post -->
                                        <div class="post">
                                            <div class="user-block">
                                                <img class="img-circle img-bordered-sm" src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" alt="user image">
                                                <span class="username">
                                            <a href="#">{{ $user->name }}</a>
                                        </span>
                                                <span class="description">Shared publicly - @if($comment->updatedAt->isToday())
                                                        {{ $comment->updatedAt->format('g:i A') }} today
                                                    @else
                                                        {{ $comment->updatedAt->format('g:i A d.m.Y') }}
                                                    @endif</span>
                                            </div>
                                            <!-- /.user-block -->
                                            <p>
                                                {{ $comment->content }}
                                            </p>

                                            <input class="form-control form-control-sm" type="text" placeholder="Type a comment">
                                        </div>
                                        <!-- /.post -->
                                    @empty
                                        <span class="text-gray-500">No comments yet...</span>
                                    @endforelse
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="posts">
                                    <!-- Posts -->
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
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
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
