@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <p>
                        <a href="{{ route('users.show',$user->id) }}">
                            {{ $user->name }}
                        </a>
                        のフォロー一覧
                    </p>
                </div>
                <div class="card">
                    <div class="card-header p-3 w-100 d-flex d-flex justify-content-around">
                        <div class="column card px-5 py-3 bg-black bg-opacity-25">
                            フォロー一覧
                        </div>
                        <a href="{{ route('users.follower',$user->id) }}">
                            <div class="column card px-5 py-3 bg-primary bg-opacity-25">
                                フォロワー一覧
                            </div>
                        </a>
                    </div>
                </div>
                @forelse ($followingUsers as $followingUser)
                    <div class="card">
                        <div class="card-header p-3 w-100 d-flex">
                            <a href="{{ route('users.show',$followingUser->id) }}">
                                @if ($followingUser->profile_image == 'https://placehold.jp/50x50.png' || $followingUser->profile_image == null)
                                    <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/' .$followingUser->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @endif
                            </a>
                            <div class="ml-2 d-flex flex-column flex-grow-1 col-4">
                                <p class="mb-0">{{ $followingUser->name }}</p>
                                <a href="{{ route('users.show',$followingUser->id)}}" class="text-secondary">{{ $followingUser->screen_name }}</a>
                            </div>
                            @if (auth()->user()->isFollowed($followingUser->id))
                                <div class="px-2 col-3">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                            @if (auth()->id() != $followingUser->id)
                                <div class="d-flex justify-content-end" data-user="{{ $followingUser->id }}">
                                    @if (auth()->user()->isFollowing($followingUser->id))
                                        <button class="btn btn-danger unfollow" id="unfollow-{{ $followingUser->id }}"  data-id="{{ $followingUser->id }}">フォロー解除</button>
                                        <button class="btn btn-primary follow" id="follow-{{ $followingUser->id }}"  data-id="{{ $followingUser->id }}"　style="display:none">フォローする</button>
                                    @else
                                        <button class="btn btn-danger unfollow" id="unfollow-{{ $followingUser->id }}"  data-id="{{ $followingUser->id }}" style="display:none">フォロー解除</button>
                                        <button class="btn btn-primary follow" id="follow-{{ $followingUser->id }}"  data-id="{{ $followingUser->id }}">フォローする</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-header p-3 w-100 d-flex">
                            誰もフォローしていません
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('/js/follow.js') }}" defer></script>
