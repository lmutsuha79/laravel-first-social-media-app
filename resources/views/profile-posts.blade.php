<x-profile>
    <div class="list-group">
        @foreach ($posts as $post)
            <a href="/posts/{{ $post->id }}" class="list-group-item list-group-item-action">
                <img class="avatar-tiny" src="{{ $sharedData['avatar'] }}" />
                <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('M/j/Y') }}
            </a>
        @endforeach

    </div>
</x-profile>
