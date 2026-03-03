@extends ('layouts.app')

@section('title', $title)

@section('content')
    <header class="row tm-welcome-section">
        <h2 class="col-12 text-center tm-section-title">Add new article</h2>
        <p class="col-12 text-center">
            Fill in the form below to create a new post.
        </p>
    </header>

    <div class="tm-container-inner-2 tm-contact-section">
        <div class="row">
            <div class="col-12">
                <form id="postForm" action="{{ route('posts.update', ['post' => $post->slug->getValue()]) }}" method="POST" enctype="multipart/form-data" class="tm-contact-form">
                    <div id="form-messages"></div>

                    @csrf
                    @method('PUT')

                    <!-- Title -->
                    <div class="form-group">
                        <input type="text" name="title" class="form-control" placeholder="Title" value="{{ $post->title }}" required>
                    </div>

                    <!-- Content -->
                    <div class="form-group">
                        <textarea rows="5" name="content" class="form-control" placeholder="Article text" required>{{ $post->content }}</textarea>
                    </div>

                    <!-- Image -->
                    <div class="col-12 img-block">
                        <div id="current-image-wrapper">
                            <figure class="tm-description-figure">
                                <img src="{{ $post->image_url }}" alt="Post image" class="img-fluid rounded" />
                            </figure>
                            <button type="button" class="btn tm-btn-default" id="replace-img-btn">Replace image</button>
                        </div>
                        <div id="upload-image-wrapper" style="display: none;">
                            <div class="form-group">
                                <input type="file" name="file" class="form-control">
                            </div>
                            <button type="button" class="btn tm-btn-primary" id="cancel-upload-btn">Отменить</button>
                        </div>
                    </div>

                    <!-- Categories -->
                    <div class="form-group">
                        <label for="categories" class="font-weight-bold mb-2">Categories:</label>
                        <select name="categories[]" id="categories" class="form-control" multiple size="5">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}"
                                    @selected($post->categories->contains($category->id))>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Tags -->
                    <div class="form-group">
                        <label for="tags" class="font-weight-bold mb-2">Tags:</label>
                        <select name="tags[]" id="tags" class="form-control" multiple size="7">
                            @foreach($tags as $tag)
                                <option value="{{ $tag->id }}"
                                    @selected($post->tags->contains($tag->id))>
                                    #{{ $tag->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Submit -->
                    <div class="form-group tm-d-flex">
                        <button type="submit" class="tm-btn tm-btn-success tm-btn-right">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function () {
            const currentImageWrapper = $('#current-image-wrapper');
            const uploadImageWrapper = $('#upload-image-wrapper');

            $('#replace-img-btn').on('click', function () {
                currentImageWrapper.hide();
                uploadImageWrapper.show();
            });

            $('#cancel-upload-btn').on('click', function () {
                currentImageWrapper.show();
                uploadImageWrapper.hide();
                $('#file-input').val('');
            });

            $('#postForm').on('submit', function (e) {
                e.preventDefault();

                let form = $(this);
                let formData = new FormData(this);
                let messages = $('#form-messages');

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        messages
                            .removeClass('tm-text-danger')
                            .addClass('tm-text-success')
                            .html(`${response.message}`);

                        form[0].reset();
                    },
                    error: function (xhr) {
                        let res = xhr.responseJSON;
                        messages.removeClass('tm-text-success').addClass('tm-text-danger');

                        if (res && res.errors) {
                            let html = '<ul>';
                            for (const [field, errors] of Object.entries(res.errors)) {
                                html += `<li>${errors.join('<br>')}</li>`;
                            }
                            html += '</ul>';
                            messages.html(html);
                        } else {
                            messages.html('<p>An error occurred while submitting the form.</p>');
                        }
                    }
                });
            });
        });
    </script>
@endpush
