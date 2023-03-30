<x-profile>
    <div class="list-group">
        @if (count($following) != 0)
            @foreach ($following as $follow)
                <a href="/profile/{{ $follow->userBeingFollowed->username }}"
                    class="list-group-item list-group-item-action">
                    <img class="avatar-tiny" src="{{ $follow->userBeingFollowed->avatar }}" />
                    <strong>{{ $follow->userBeingFollowed->username }}</strong>
                </a>
            @endforeach
        @else
                <p>the list of following is empty</p>
        @endif

    </div>
</x-profile>
