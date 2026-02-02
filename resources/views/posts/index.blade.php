@extends ('layouts.app')

@section('title', $title)

@section('content')
<header class="row tm-welcome-section">
    <h2 class="col-12 text-center tm-section-title">Welcome to Simple House</h2>
    <p class="col-12 text-center">Total 3 HTML pages are included in this template. Header image has a parallax effect. You can feel free to download, edit and use this TemplateMo layout for your commercial or non-commercial websites.</p>
</header>

@can('create', \App\Models\Post::class)
<div class="tm-paging-links">
    <nav>
        <ul>
            <li class="tm-paging-item"><a href="{{ route('posts.create') }}" class="tm-paging-link">Add article</a></li>
        </ul>
    </nav>
</div>
@endcan

<div class="tm-section tm-container-inner">
    @forelse ($posts as $post)
    <div class="row">
        <div class="col-md-6">
            <figure class="tm-description-figure">
                <img src="{{ $post->image_url }}" alt="Image" class="img-fluid" />
            </figure>
        </div>
        <div class="col-md-6">
            <div class="tm-description-box">
                <h4 class="tm-gallery-title">{{ $post->title }}</h4>
                <p class="tm-mb-45">{{ Str::limit($post->content, 150) }}</p>
                <a href="{{ route('posts.show', ['post' => $post->slug->getValue()]) }}" class="tm-btn tm-btn-default tm-right">Read More</a>
            </div>
        </div>
    </div>
    @empty
        <p>No posts yet</p>
    @endforelse
</div>
@endsection
