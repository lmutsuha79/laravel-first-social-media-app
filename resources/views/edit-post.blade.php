<x-layout>

    <div class="container py-md-5 container--narrow">
        <form action="/posts/edit/{{ $post->id }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <a href="/posts/{{ $post->id }}">&laquo;go back to original post</a>
            </div>
            <div class="form-group">
                <label for="post-title" class="text-muted mb-1"><small>Title</small></label>
                <input value="{{ $post->title }}" required name="title" id="post-title"
                    class="form-control form-control-lg form-control-title" type="text" placeholder=""
                    autocomplete="off" />
                @error('title')
                    <p class="alert m-0 alert-danger shadow-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="post-body" class="text-muted mb-1"><small>Body Content</small></label>
                <textarea required name="body" id="post-body" class="body-content tall-textarea form-control" type="text">
            {{ $post->body }}
          </textarea>
                @error('body')
                    <p class="alert m-0 alert-danger shadow-sm">{{ $message }}</p>
                @enderror
            </div>

            <button class="btn btn-primary">save this new version</button>
        </form>
    </div>
</x-layout>
