@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Show Post Page')

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.posts.index') }}">Posts</a></li>
                        <li class="breadcrumb-item active">Post #{{ $post->id }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="card card-solid">
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-6">
                        <h3 class="d-inline-block d-sm-none">{{ $post->title }}</h3>
                        <div class="col-12">
                            <img src="{{ $post->imageUrl }}" class="product-image" alt="Post Image">
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <h3 class="my-3">{{ $post->title }}</h3>
                        <p>{{ $post->content }}</p>

                        <hr>

                        <h4>Post Categories</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @forelse($post->categories as $i => $category)
                                <label class="btn btn-default text-center active">
                                    <input type="checkbox" name="color_option" id="category_option_{{ $i }}" autocomplete="off" checked="">
                                    {{ $category->name }}
                                    <br>
                                    <i class="fas fa-folder"></i>
                                </label>
                            @empty
                                <span class="text-gray-500">No categories</span>
                            @endforelse
                        </div>
                        <h4>Post Tags</h4>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            @forelse($post->tags as $tag)
                                <label class="btn btn-default text-center">
                                    <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                                    <span class="text-xl"><i class="fas fa-tag"></i></span>
                                    <br>
                                    {{ $tag->name }}
                                </label>
                            @empty
                                <span class="text-gray-500">No tags</span>
                            @endforelse
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('admin.posts.edit', ['post' => $post->slug->getValue()]) }}" class="btn btn-warning btn-lg btn-flat">
                                <i class="fas fa-eye fa-lg mr-2"></i>
                                Edit
                            </a>

                            <div class="d-inline-block">
                                <form action="{{ route('admin.posts.destroy', ['post' => $post->slug->getValue()]) }}" method="POST" >
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn-lg btn-flat" onclick="return confirm('Are you sure?')">
                                        <i class="fas fa-trash fa-lg mr-2"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <nav class="w-100">
                        <div class="nav nav-tabs" id="product-tab" role="tablist">
                            <a class="nav-item nav-link active" id="product-comments-tab" data-toggle="tab" href="#product-comments" role="tab" aria-controls="product-comments" aria-selected="true">Comments</a>
                            <a class="nav-item nav-link" id="product-desc-tab" data-toggle="tab" href="#product-desc" role="tab" aria-controls="product-desc" aria-selected="false">Description</a>
                        </div>
                    </nav>
                    <div class="tab-content p-3" id="nav-tabContent">
                        <div class="tab-pane fade active show" id="product-comments" role="tabpanel" aria-labelledby="product-comments-tab">
                            <form class="form-horizontal">
                                <div class="input-group input-group-sm mb-0">
                                    <input class="form-control form-control-sm" placeholder="Type a comment">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-info">Send</button>
                                    </div>
                                </div>
                            </form>
                            <hr>
                            @forelse($comments as $comment)
                                <!-- Post -->
                                <div class="post">
                                    <div class="user-block">
                                        <img class="img-circle img-bordered-sm" src="{{ asset('assets/admin/dist/img/user2-160x160.jpg') }}" alt="user image">
                                        <span class="username">
                                            <a href="#">{{ $comment->userName }}</a>
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
                        <div class="tab-pane fade" id="product-desc" role="tabpanel" aria-labelledby="product-desc-tab">
                            {{ $post->content }}
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
    </section>
    <!-- /.content -->
@endsection
