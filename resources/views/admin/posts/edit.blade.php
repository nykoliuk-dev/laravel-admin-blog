@extends ('layouts.admin')

@section('title', 'AdminLTE 3 | Edit Post Page')

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
                        <li class="breadcrumb-item active">Edit</li>
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
                            <h3 class="card-title">Edit post #{{ $post->id }}</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{ route('admin.posts.update', ['post' => $post->slug->getValue()]) }}" method="POST" id="postForm">
                            @csrf
                            @method('PUT')

                            <div class="card-body">
                                <!-- Title -->
                                <div class="form-group">
                                    <label for="inputName">Post title</label>
                                    <input
                                        type="text"
                                        name="title"
                                        class="form-control @error('title') is-invalid @enderror"
                                        id="inputName"
                                        value="{{ old('title', $post->title) }}"
                                        placeholder="Enter post title"
                                        required>
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Slug -->
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="editSlugCheckbox" name="editSlug">
                                        <label class="custom-control-label" for="editSlugCheckbox">Edit slug manually</label>
                                    </div>
                                    <input type="text"
                                           class="form-control"
                                           id="editSlugInput"
                                           name="slug"
                                           value="{{ $post->slug->getValue() }}"
                                           disabled
                                    >
                                </div>

                                <!-- Content -->
                                <div class="form-group">
                                    <label for="textareaContent" class="form-label">Enter post content</label>
                                    <textarea
                                        name="content"
                                        class="form-control @error('content') is-invalid @enderror"
                                        id="textareaContent"
                                        rows="5"
                                        required>{{ old('content', $post->content) }}</textarea>
                                    @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Image -->
                                <div class="form-group img-block">
                                    <div id="current-image-wrapper">
                                        <figure class="tm-description-figure">
                                            <img src="{{ $post->imageUrl }}" alt="Post image" class="img-fluid rounded" />
                                        </figure>
                                        <button type="button" class="btn btn-info" id="replace-img-btn">Change image</button>
                                    </div>
                                    <div id="upload-image-wrapper" style="display: none;">
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
                                        <button type="button" class="btn btn-danger" id="cancel-upload-btn">Cancel</button>
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
                                            <option value="{{ $category->id }}" @selected(array_key_exists($category->id, $post->categories))>
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
                                            <option value="{{ $tag->id }}" @selected(array_key_exists($tag->id, $post->tags))>
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

@push('scripts')
    <script>
        $(function () {
            // File
            const currentImageWrapper = $('#current-image-wrapper');
            const uploadImageWrapper = $('#upload-image-wrapper');

            $('#replace-img-btn').on('click', function () {
                currentImageWrapper.hide();
                uploadImageWrapper.show();
            });

            $('#cancel-upload-btn').on('click', function () {
                currentImageWrapper.show();
                uploadImageWrapper.hide();
                $('#inputFile').val('');
            });

            // Slug
            $('#editSlugCheckbox').on('click', function () {
                if (this.checked) {
                    const result = confirm('⚠️ Changing the URL may break existing links');
                    if (!result) {
                        this.checked = false;
                        return;
                    }
                }

                $('#editSlugInput').prop('disabled', !this.checked);
            });
        });
    </script>
@endpush
