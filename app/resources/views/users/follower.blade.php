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
                        のフォロワー一覧
                    </p>
                </div>
                <div class="card">
                    <div class="card-haeder p-3 w-100 d-flex d-flex justify-content-around">
                        <a href="{{ route('users.following',$user->id) }}">
                            <div class="column card px-5 py-3 bg-primary bg-opacity-25">
                                フォロー一覧
                            </div>
                        </a>
                        <div class="column card px-5 py-3 bg-black bg-opacity-25">
                            フォロワー一覧
                        </div>
                    </div>
                </div>
                @forelse ($followerUsers as $followerUser)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <a href="{{ route('users.show',$followerUser->id) }}">
                                @if ( $followerUser->profile_image == 'https://placehold.jp/50x50.png' || $followerUser->profile_image == null )
                                    <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/' .$followerUser->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @endif
                            </a>
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $followerUser->name }}</p>
                                <a href="{{ route('users.show',$followerUser->id)}}" class="text-secondary">{{ $followerUser->screen_name }}</a>
                            </div>
                            @if (auth()->user()->isFollowed($followerUser->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                            @if (auth()->id() != $followerUser->id)
                                <div class="d-flex justify-content-end flex-grow-1" data-user="{{ $followerUser->id }}">
                                    @if (auth()->user()->isFollowing($followerUser->id))
                                        <button class="btn btn-danger unfollow" id="unfollow-{{ $followerUser->id }}"  data-id="{{ $followerUser->id }}">フォロー解除</button>
                                        <button class="btn btn-primary follow" id="follow-{{ $followerUser->id }}"  data-id="{{ $followerUser->id }}"　style="display:none">フォローする</button>
                                    @else
                                        <button class="btn btn-danger unfollow" id="unfollow-{{ $followerUser->id }}"  data-id="{{ $followerUser->id }}" style="display:none">フォロー解除</button>
                                        <button class="btn btn-primary follow" id="follow-{{ $followerUser->id }}"  data-id="{{ $followerUser->id }}">フォローする</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            誰もフォロワーが居ません
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
<script src="{{ asset('/js/follow.js') }}" defer></script>
