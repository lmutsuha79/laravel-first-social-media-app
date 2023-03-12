<x-layout>
    <div class="container py-md-5 container--narrow">
        <h2>
            <img class="avatar-small" src="{{ $avatar }}" />
            {{ $username }}

            @auth
                {{-- show this btns only for auth users  --}}
                @if ($username != auth()->user()->username)
                    {{-- user cannot follow or unfollow him self --}}


                    @if (!$currentlyFollowing)
                        <form class="ml-2 d-inline" action="/follow/{{ $username }}" method="POST">
                            @csrf
                            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
                        </form>
                    @endif

                    @if ($currentlyFollowing)
                        <form class="ml-2 d-inline" action="/unfollow/{{ $username }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
                        </form>
                    @endif
                @endif

                {{-- upload avatar btn --}}
                @if ($username === auth()->user()->username)
                    <a href="/manage-avatar" class="btn btn-secondary btn-sm">Upload Profile Photo</a>
                @endif


            @endauth
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            <a href="#" class="profile-nav-link nav-item nav-link active">Posts: {{ $posts->count() }}</a>
            <a href="#" class="profile-nav-link nav-item nav-link">Followers: 3</a>
            <a href="#" class="profile-nav-link nav-item nav-link">Following: 2</a>
        </div>

        <div class="list-group">
            @foreach ($posts as $post)
                <a href="/posts/{{ $post->id }}" class="list-group-item list-group-item-action">
                    <img class="avatar-tiny" src="{{ $avatar }}" />
                    <strong>{{ $post->title }}</strong> on {{ $post->created_at->format('M/j/Y') }}
                </a>
            @endforeach

        </div>
    </div>
</x-layout>
