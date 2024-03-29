@extends('layouts.app')

<link href="{{ asset('css/comment.css') }}" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center mb-5">
        <div class="col-md-8 mb-3">
            <div class="card">
                <div class="card-header p-3 w-100 d-flex">
                    <a href="{{ route('users.show',$tweet->user->id) }}">
                        @if ($tweet->user->profile_image == 'https://placehold.jp/50x50.png' || $tweet->user->profile_image == null)
                            <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                        @else
                            <img src="{{ asset('storage/profile_image/' .$tweet->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                        @endif
                    </a>
                    <div class="ml-2 d-flex flex-column">
                        <p class="mb-0">{{ $tweet->user->name }}</p>
                        <a href="{{ route('users.show' ,[$tweet->user->id]) }}" class="text-secondary">{{ $tweet->user->screen_name }}</a>
                    </div>
                    <div class="d-flex justify-content-end flex-grow-1">
                        <p class="mb-0 text-secondary">{{ $tweet->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                </div>
                <div class="card-body">
                    {!! nl2br(e($tweet->text)) !!}
                </div>
                <div class="card-footer py-1 d-flex justify-content-end bg-white">
                    @if ($tweet->user->id === Auth::user()->id)
                        <div class="nav-item dropdown mr-3 d-flex align-items-center">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fas fa-ellipsis-v fa-fw"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuLink">
                                <form method="POST" action="{{ route('tweets.destroy', ['tweetId'=>$tweet->id]) }}" class="mb-0">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('tweets.edit',[$tweet->id]) }}" class="dropdown-item">編集</a>
                                    <button type="submit" class="dropdown-item del-btn">削除</button>
                                </form>
                            </div>
                        </div>
                    @endif
                    <div class="mr-3 d-flex align-items-center">
                        <a href="{{ route('tweets.show' ,[$tweet->id]) }}"><i class="far fa-comment fa-fw"></i></a>
                        <p class="mb-0 text-secondary">{{ count($tweet->comments) }}</p>
                    </div>
                    <div class="d-flex align-items-center">
                        @if (!in_array($user->id, array_column($tweet->favorites->toArray(), 'user_id'), TRUE))
                            <button class="btn p-0 border-0 text-primary favorite" id="favorite-{{ $tweet->id }}" data-tweetid="{{ $tweet->id }}"><i class="far fa-heart fa-fw" ></i></button>
                            <button class="btn p-0 border-0 text-danger unfavorite" id="unfavorite-{{ $tweet->id }}" data-tweetid="{{ $tweet->id }}" style="display: none"><i class="fas fa-heart fa-fw"></i></button>
                        @else
                            <button class="btn p-0 border-0 text-primary favorite" id="favorite-{{ $tweet->id }}" data-tweetid="{{ $tweet->id }}" style="display: none"><i class="far fa-heart fa-fw" ></i></button>
                            <button class="btn p-0 border-0 text-danger unfavorite" id="unfavorite-{{ $tweet->id }}" data-tweetid="{{ $tweet->id }}"><i class="fas fa-heart fa-fw"></i></button>
                        @endif
                        <p class="mb-0 text-secondary" id="favorite-count-{{ $tweet->id }}">{{ count($tweet->favorites) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8 mb-3">
            <ul class="list-group">
                @forelse ($comments as $comment)
                    <li class="list-group-item">
                        <div class="py-3 w-100 d-flex">
                            <a href="{{ route('users.show',$comment->user->id) }}">
                                @if ($comment->user->profile_image == 'https://placehold.jp/50x50.png' || $comment->user->profile_image == null)
                                    <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/' .$comment->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @endif
                            </a>
                            <div class="ml-2 d-flex flex-column col-6">
                                <p class="mb-0">{{ $comment->user->name }}</p>
                                <a href="{{ route('users.show' ,[$comment->user->id]) }}" class="text-secondary">{{ $comment->user->screen_name }}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $comment->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="py-3 comment-list">
                            {!! nl2br(e($comment->text)) !!}
                        </div>
                    </li>
                @empty
                    <li class="list-group-item">
                        <p class="mb-0 text-secondary">コメントはまだありません。</p>
                    </li>
                @endforelse
                <li class="list-group-item">
                    <div class="py-3">
                        <form method="POST" action="{{ route('comments.store') }}">
                            @csrf

                            <div class="form-group row mb-0">
                                <div class="col-md-12 p-3 w-100 d-flex">
                                    <a href="{{ route('users.show',$user->id) }}">
                                        @if ($user->profile_image == 'https://placehold.jp/50x50.png' || $user->profile_image == null)
                                            <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                        @else
                                            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                        @endif
                                    </a>
                                    <div class="ml-2 d-flex flex-column">
                                        <p class="mb-0">{{ $user->name }}</p>
                                        <a href="{{ route('users.show' ,[$user->id]) }}" class="text-secondary">{{ $user->screen_name }}</a>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <input type="hidden" name="tweet_id" value="{{ $tweet->id }}">
                                    <textarea class="form-control @error('text') is-invalid @enderror" name="text" required autocomplete="text" rows="4">{{ old('text') }}</textarea>

                                    @error('text')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-12 text-right">
                                    <p class="mb-4 text-danger">140文字以内</p>
                                    <button type="submit" class="btn btn-primary">
                                        ツイートする
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </li>

            </ul>
        </div>
    </div>
</div>
@endsection
<script src="{{ asset('/js/favorite.js') }}" defer></script>
