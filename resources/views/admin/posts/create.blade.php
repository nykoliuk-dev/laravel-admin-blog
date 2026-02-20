@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Create New Post')

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
                        <li class="breadcrumb-item active">Create</li>
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add new post</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.posts.store') }}" method="POST" id="tagForm">
                            @csrf
                            <div class="card-body">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="inputName">Post title</label>
                                    <input
                                        type="text"
                                        name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="inputName"
                                        value="{{ old('title') }}"
                                        placeholder="Enter post title"
                                        required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="textareaContent" class="form-label">Enter post content</label>
                                    <textarea
                                        name="content"
                                        class="form-control @error('content') is-invalid @enderror"
                                        id="textareaContent"
                                        rows="5"
                                        required>{{ old('content') }}</textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="form-group">
                                    <label for="inputFile">File input</label>
                                    <div class="custom-file">
                                        <input
                                            type="file"
                                            name="file"
                                            class="form-control custom-file-input"
                                            id="inputFile"
                                            required>
                                        <label class="custom-file-label" for="inputFile">Choose file</label>
                                    </div>
                                </div>

                                <!-- Categories -->
                                <div class="form-group">
                                    <label for="categories">Select Post Categories</label>
                                    <select
                                        multiple size="5"
                                        name="categories[]"
                                        class="form-control"
                                        id="categories"
                                        data-gtm-form-interact-field-id="0"
                                        required>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">
                                                {{ str_repeat('— ', $category->depth) . $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Tags -->
                                <div class="form-group">
                                    <label for="tags">Select Post Tags</label>
                                    <select
                                        multiple size="7"
                                        name="tags[]"
                                        class="form-control"
                                        id="tags"
                                        data-gtm-form-interact-field-id="0"
                                        required>
                                        @foreach($tags as $tag)
                                            <option value="{{ $tag->id }}">
                                                #{{ $tag->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
@endsection
