@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3 text-end">
            <a href="{{ route('users.index') }}">ユーザ一覧 <i class="fas fa-users" class="fa-fw"></i> </a>
        </div>
        @if (isset($timelines))
            @forelse ($timelines as $timeline)
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <a href="{{ route('users.show',$timeline->user->id) }}">
                                @if ($timeline->user->profile_image == 'https://placehold.jp/50x50.png' || $timeline->user->profile_image == null)
                                    <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/' .$timeline->user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @endif
                            </a>
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $timeline->user->name }}</p>
                                <a href="{{ route('users.show',[$timeline->user->id]) }}" class="text-secondary">{{ $timeline->user->screen_name }}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! nl2br(e($timeline->text)) !!}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            @if ($timeline->user->id === Auth::user()->id)
                                <div class="dropdown mr-3 d-flex align-items-center">
                                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-fw"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <form method="POST" action="{{route('tweets.destroy', ['tweetId'=>$timeline->id]) }}" class="mb-0">
                                            @csrf
                                            {{method_field('DELETE')}}

                                            <a href="{{ route('tweets.edit',[$timeline->id]) }}" class="dropdown-item">編集</a>
                                            <button type="submit" class="dropdown-item del-btn">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ route('tweets.show' ,[$timeline->id]) }}"><i class="far fa-comment fa-fw"></i></a>
                                <p class="mb-0 text-secondary">{{ count($timeline->comments) }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                @if (!in_array($user->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                                    <button class="btn p-0 border-0 text-primary favorite" id="favorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}" ><i class="far fa-heart fa-fw" ></i></button>
                                    <button class="btn p-0 border-0 text-danger unfavorite" id="unfavorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}" style="display: none"><i class="fas fa-heart fa-fw"></i></button>
                                @else
                                    <button class="btn p-0 border-0 text-primary favorite" id="favorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}"  style="display: none"><i class="far fa-heart fa-fw" ></i></button>
                                    <button class="btn p-0 border-0 text-danger unfavorite" id="unfavorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}" ><i class="fas fa-heart fa-fw"></i></button>
                                @endif
                                <p class="mb-0 text-secondary" id="favorite-count-{{ $timeline->id }}">{{ count($timeline->favorites) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
            <div class="card">
                <div class="card-haeder p-3 w-100 d-flex">
                    誰もツイートしていません
                </div>
            </div>
            @endforelse
        @endif
    </div>
    <div class="my-4 d-flex justify-content-center">
        {{ $timelines->links() }}
    </div>
</div>
@endsection
<script src="{{ asset('/js/favorite.js') }}" defer></script>
