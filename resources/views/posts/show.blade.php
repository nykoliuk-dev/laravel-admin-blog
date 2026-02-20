@extends ('layouts.app')

@section('title', $title)

@section('content')
<header class="row tm-welcome-section">
    <h2 class="col-12 text-center tm-section-title">{{ $post->title }}</h2>
    <p class="col-12 text-center">View article about food and cooking.</p>
</header>

@can('create', \App\Models\Post::class)
<div class="tm-paging-links">
    <nav>
        <ul>
            <li class="tm-paging-item"><a href="{{ route('posts.create') }}" class="tm-paging-link">Add a post</a></li>
        </ul>
    </nav>
</div>
@endcan

<div class="tm-section tm-container-inner">
    <div class="row">
        <!-- Left Column: Image and Metadata -->
        <div class="col-md-6">
            <figure class="tm-description-figure">
                <img src="{{ $post->image_url }}" alt="Изображение поста" class="img-fluid rounded" />
            </figure>

            <div class="mt-4 p-3 bg-gray-100 rounded shadow-sm">
                <h5 class="font-bold mb-2 text-xl">Categories:</h5>
                <div class="flex flex-wrap gap-2">
                    @forelse($categories as $category)
                    <span class="px-3 py-1 bg-yellow-600 text-white rounded-full text-sm hover:bg-yellow-700 transition duration-300">
                                {{ $category->name }}
                            </span>
                    @empty
                    <span class="text-gray-500">No categories</span>
                    @endforelse
                </div>

                <h5 class="font-bold mt-4 mb-2 text-xl">Tegs:</h5>
                <div class="flex flex-wrap gap-2">
                    @forelse($tags as $tag)
                    <span class="px-3 py-1 bg-green-600 text-white rounded-full text-sm hover:bg-green-700 transition duration-300">
                                #{{ $tag->name }}
                            </span>
                    @empty
                    <span class="text-gray-500">No tags</span>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Right column: Post content -->
        <div class="col-md-6">
            <div class="tm-description-box">
                <h4 class="tm-gallery-title mb-4 text-3xl font-semibold">{{ $post->title }}</h4>
                <div class="tm-mb-45 text-lg leading-relaxed">
                    {{ $post->content }}
                </div>
            </div>
            <div class="row">
                @can('update', $post)
                    <div class="tm-feature">
                        <i class="fas fa-4x fa-pepper-hot tm-feature-icon"></i>
                        <a href="{{ route('posts.edit', ['post' => $post->slug->getValue()]) }}" class="tm-btn tm-btn-primary">Edit</a>
                    </div>
                @endcan
                @can('delete', \App\Models\Post::class)
                    <div class="tm-feature">
                        <i class="fas fa-4x fa-cocktail tm-feature-icon"></i>
                        <form method="POST" action="{{ route('posts.destroy', ['post' => $post->slug->getValue()]) }}">
                            @csrf
                            @method('delete')
                            <button class="tm-btn tm-btn-danger">Delete</button>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>

    <!-- Section Comments -->
    <div class="row mt-10">
        <div class="col-12" id="comments-section">
            <h3 class="text-3xl font-bold mb-6 border-b pb-2">Comments</h3>

            <!-- List of comments -->
            @forelse($comments as $comment)
            <div class="mb-4 p-4 bg-white rounded shadow-md border-l-4 border-yellow-600 comment-item">
                <p class="text-gray-700 mb-2">{{ $comment->content }}</p>
                <p class="text-sm text-gray-500">
                    — Author:
                    **{{ $comment->user?->name ?? 'Guest' }}**
                    <span class="ml-2">({{ $comment->created_at }})</span>
                </p>
            </div>
            @empty
            <p class="text-gray-600" id="no-comments-message">There are no comments yet. Be the first to leave a review!</p>
            @endforelse

            <!-- Comment form -->
            <div class="mt-8 p-5 bg-gray-50 rounded shadow">
                <h4 class="text-xl font-semibold mb-4">Leave a comment</h4>

                <div id="comment-message" class="mb-4 hidden p-3 rounded text-white font-bold"></div>

                <form id="comment-form" action="{{ route('posts.comments.store', $post) }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 font-medium mb-2">Your comment:</label>
                        <textarea id="content" name="content" rows="4" class="w-full p-3 border border-gray-300 rounded focus:ring-yellow-500 focus:border-yellow-500" required></textarea>
                        <div id="content-error" class="text-red-500 text-sm mt-1"></div>
                    </div>

                    <button type="submit" class="tm-btn tm-btn-success">
                        Leave a comment
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('comment-form');
        const contentTextarea = document.getElementById('content');
        const messageBox = document.getElementById('comment-message');
        const contentError = document.getElementById('content-error');
        const commentsSection = document.getElementById('comments-section');
        const noCommentsMessage = document.getElementById('no-comments-message');

        const currentUserId = @json(auth()->id());
        const authorText = currentUserId !== null ? `**Пользователь ID: ${currentUserId}**` : `**Гость**`;

        function clearErrors() {
            contentError.textContent = '';
            messageBox.classList.add('hidden');
            messageBox.textContent = '';
            messageBox.classList.remove('bg-green-500', 'bg-red-500');
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            clearErrors();

            const formData = new FormData(form);
            const content = formData.get('content');

            try {
                const safeResponse = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                });

                const result = await safeResponse.json();

                if (!safeResponse.ok || !result.success) {

                    let errorMessage = 'Неизвестная ошибка сервера.';
                    if (result.errors) {
                        if (result.errors.content) {
                            contentError.textContent = result.errors.content;
                            errorMessage = 'Ошибка валидации.';
                        } else if (result.errors.system) {
                            errorMessage = result.errors.system;
                        }
                    }

                    messageBox.textContent = errorMessage;
                    messageBox.classList.remove('hidden');
                    messageBox.classList.add('bg-red-500');

                } else {
                    messageBox.textContent = result.message || 'Комментарий успешно добавлен.';
                    messageBox.classList.remove('hidden');
                    messageBox.classList.add('bg-green-500');

                    form.reset();

                    const now = new Date();
                    const formattedDate = `${now.toLocaleDateString('ru-RU')} ${now.toLocaleTimeString('ru-RU')}`;

                    const newCommentHtml = `
                    <div class="mb-4 p-4 bg-white rounded shadow-md border-l-4 border-yellow-600 comment-item">
                        <p class="text-gray-700 mb-2">${content}</p>
                        <p class="text-sm text-gray-500">
                            — Автор: ${authorText}
                            <span class="ml-2">(${formattedDate})</span>
                        </p>
                    </div>
                `;

                    const commentsHeader = commentsSection.querySelector('h3');

                    if (noCommentsMessage) {
                        noCommentsMessage.remove();
                    }

                    commentsHeader.insertAdjacentHTML('afterend', newCommentHtml);
                }
            } catch (error) {
                console.error('Fetch error:', error);
                messageBox.textContent = 'Network error. Unable to send comment.';
                messageBox.classList.remove('hidden');
                messageBox.classList.add('bg-red-500');
            }
        });
    });
</script>
@endpush
