<x-profile>
    <div class="list-group">
        @if (count($followers) != 0)
            @foreach ($followers as $follow)
                <a href="/profile/{{ $follow->userMakeTheFollow->username }}"
                    class="list-group-item list-group-item-action">
                    <img class="avatar-tiny" src="{{ $follow->userMakeTheFollow->avatar }}" />
                    <strong>{{ $follow->userMakeTheFollow->username }}</strong>
                </a>
            @endforeach
        @else
                <p>no followers</p>
        @endif

    </div>
</x-profile>
