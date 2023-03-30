<x-layout :sharedData="$sharedData">
    <div class="container py-md-5 container--narrow">
        <h2>
            <img class="avatar-small" src="{{ $sharedData['avatar'] }}" />
            {{ $sharedData['username'] }}

            @auth
                {{-- show this btns only for auth users  --}}
                @if ($sharedData['username'] != auth()->user()->username)
                    {{-- user cannot follow or unfollow him self --}}


                    @if (!$sharedData['currentlyFollowing'])
                        <form class="ml-2 d-inline" action="/follow/{{ $sharedData['username'] }}" method="POST">
                            @csrf
                            <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
                        </form>
                    @endif

                    @if ($sharedData['currentlyFollowing'])
                        <form class="ml-2 d-inline" action="/unfollow/{{ $sharedData['username'] }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button>
                        </form>
                    @endif
                @endif

                {{-- upload avatar btn --}}
                @if ($sharedData['username'] === auth()->user()->username)
                    <a href="/manage-avatar" class="btn btn-secondary btn-sm">Upload Profile Photo</a>
                @endif


            @endauth
        </h2>

        <div class="profile-nav nav nav-tabs pt-2 mb-4">
            <a href="/profile/{{$sharedData['username']}}"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == '' ? 'active' : '' }}">Posts:
                {{ $sharedData['numberOfPosts'] }}</a>
            <a href="/profile/{{ $sharedData['username'] }}/followers"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == 'followers' ? 'active' : '' }}">Followers:
                {{ $sharedData['numberOfFollowers'] }}</a>
            <a href="/profile/{{ $sharedData['username'] }}/following"
                class="profile-nav-link nav-item nav-link {{ Request::segment(3) == 'following' ? 'active' : '' }}">Following:
                {{ $sharedData['numberOfFollowing'] }}</a>
        </div>

        {{ $slot }}
    </div>
</x-layout>
