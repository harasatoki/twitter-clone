@extends('layouts.app')

<link href="{{ asset('css/popup.css') }}" rel="stylesheet">
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-3" >
            <div class="card">
                <div class="d-inline-flex">
                    <div class="p-3 d-flex flex-column">
                        <button class="show_pop">
                            @if ($user->profile_image == 'https://placehold.jp/50x50.png' || $user->profile_image == null)
                                <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                            @else
                                <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                            @endif
                        </button>
                        <div class="mt-3 d-flex flex-column">
                            <h4 class="mb-0 font-weight-bold">{{ $user->name }}</h4>
                            <span class="text-secondary">{{ $user->screen_name }}</span>
                        </div>
                    </div>
                    <div class="p-3 d-flex flex-column justify-content-between">
                        <div class="d-flex">
                            <div>
                                @if ($user->id === Auth::user()->id)
                                    <a href="{{ route('users.edit',$user->id)}}" class="btn btn-primary">プロフィールを編集する</a>
                                @else
                                    @if ($isFollowing)
                                        <button class="btn btn-danger unfollow" id="unfollow-{{ $user->id }}"  data-id="{{ $user->id }}">フォロー解除</button>
                                        <button class="btn btn-primary follow" id="follow-{{ $user->id }}"  data-id="{{ $user->id }}"　style="display:none">フォローする</button>
                                    @else
                                        <button class="btn btn-danger unfollow" id="unfollow-{{ $user->id }}"  data-id="{{ $user->id }}" style="display:none">フォロー解除</button>
                                        <button class="btn btn-primary follow" id="follow-{{ $user->id }}"  data-id="{{ $user->id }}">フォローする</button>
                                    @endif

                                    @if ($isFollowed)
                                        <span class="mt-2 px-1 bg-secondary text-light">フォローされています</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                        <div class= "d-flex flex-row text-secondary">
                            <p><font size="3">
                                <h4 class="font-weight-bold">{{ substr($user->created_at, 0,10)}}からTwicloを利用しています</h4>
                            </font></p>
                        </div>
                        <div class="d-flex justify-content-end">
                            <div class="p-2 d-flex flex-column align-items-center">
                                <p class="font-weight-bold">ツイート数</p>
                                <span>{{ $tweetCount }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <a href="{{ route('users.following',$user->id) }}">
                                    <p class="font-weight-bold">フォロー数</p>
                                </a>
                                <span>{{ $followCount }}</span>
                            </div>
                            <div class="p-2 d-flex flex-column align-items-center">
                                <a href="{{ route('users.follower',$user->id) }}">
                                    <p class="font-weight-bold">フォロワー数</p>
                                </a>
                                <span id="followerCount">{{ $followerCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @if (isset($timelines))
            @foreach ($timelines as $timeline)
                <div class="col-md-8 mb-3">
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <a href="#">
                                @if ($user->profile_image == 'https://placehold.jp/50x50.png' || $user->profile_image == null)
                                    <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @endif
                            </a>
                            <div class="ml-2 d-flex flex-column flex-grow-1">
                                <p class="mb-0">{{ $timeline->user->name }}</p>
                                <a href="{{route('users.show',$timeline->user->id) }}" class="text-secondary">{{ $timeline->user->screen_name }}</a>
                            </div>
                            <div class="d-flex justify-content-end flex-grow-1">
                                <p class="mb-0 text-secondary">{{ $timeline->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $timeline->text }}
                        </div>
                        <div class="card-footer py-1 d-flex justify-content-end bg-white">
                            @if ($timeline->user->id === Auth::user()->id)
                                <div class="dropdown mr-3 d-flex align-items-center">
                                    <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v fa-fw"></i>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                        <form method="POST" action="{{route('tweets.destroy',['tweetId'=>$timeline->id]) }}" class="mb-0">
                                            @csrf
                                            @method('DELETE')

                                            <a href="{{ route('tweets.edit',$timeline->id )}}" class="dropdown-item">編集</a>
                                            <button type="submit" class="dropdown-item del-btn">削除</button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            <div class="mr-3 d-flex align-items-center">
                                <a href="{{ route('tweets.show',$timeline->id )}}"><i class="far fa-comment fa-fw"></i></a>
                                <p class="mb-0 text-secondary">{{ count($timeline->comments) }}</p>
                            </div>
                            <div class="d-flex align-items-center">
                                @if (!in_array(Auth::user()->id, array_column($timeline->favorites->toArray(), 'user_id'), TRUE))
                                    <button class="btn p-0 border-0 text-primary favorite" id="favorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}" ><i class="far fa-heart fa-fw" ></i></button>
                                    <button class="btn p-0 border-0 text-danger unfavorite" id="unfavorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}"  style="display: none"><i class="fas fa-heart fa-fw"></i></button>
                                @else
                                    <button class="btn p-0 border-0 text-primary favorite" id="favorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}"  style="display: none"><i class="far fa-heart fa-fw" ></i></button>
                                    <button class="btn p-0 border-0 text-danger unfavorite" id="unfavorite-{{ $timeline->id }}" data-tweetid="{{ $timeline->id }}" ><i class="fas fa-heart fa-fw"></i></button>
                                @endif
                                <p class="mb-0 text-secondary" id="favorite-count-{{ $timeline->id }}">{{ count($timeline->favorites) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
    <div class="my-4 d-flex justify-content-center">
        {{ $timelines->links() }}
    </div>
</div>
<div class="modal_pop">
    <div class="bg js-modal-close">
        <button class=" close">×</button>
    </div>
    <div class="modal_pop_main">
        @if ($user->profile_image == 'https://placehold.jp/50x50.png' || $user->profile_image == null)
            <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}">
        @else
            <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}">
        @endif
    </div>
</div>
@endsection
<script src="{{ asset('/js/follow.js') }}" defer></script>
<script src="{{ asset('/js/favorite.js') }}" defer></script>
<script src="{{ asset('/js/popup.js') }}" defer></script>
