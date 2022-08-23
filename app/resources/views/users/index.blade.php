@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach ($users as $user)
                    <div class="card">
                        <div class="card-haeder p-3 w-100 d-flex">
                            <a href="{{ route('users.show',$user->id) }}">
                                @if ( $user->profile_image == 'https://placehold.jp/50x50.png' || $user->profile_image == null )
                                    <img src="{{ asset('storage/profile_image/noImage.jpeg' )}}" class="rounded-circle" width="50" height="50">
                                @else
                                    <img src="{{ asset('storage/profile_image/' .$user->profile_image) }}" class="rounded-circle" width="50" height="50">
                                @endif
                            </a>
                            <div class="ml-2 d-flex flex-column">
                                <p class="mb-0">{{ $user->name }}</p>
                                <a href="{{ route('users.show',$user->id)}}" class="text-secondary">{{ $user->screen_name }}</a>
                            </div>
                            @if (auth()->user()->isFollowed($user->id))
                                <div class="px-2">
                                    <span class="px-1 bg-secondary text-light">フォローされています</span>
                                </div>
                            @endif
                            <div class="d-flex justify-content-end flex-grow-1" data-user="{{ $user->id }}">
                                @if (auth()->user()->isFollowing($user->id))
                                    <button class="btn btn-danger unfollow" id="unfollow-{{ $user->id }}"  data-id="{{ $user->id }}">フォロー解除</button>
                                    <button class="btn btn-primary follow" id="follow-{{ $user->id }}"  data-id="{{ $user->id }}"　style="display:none">フォローする</button>
                                @else
                                    <button class="btn btn-danger unfollow" id="unfollow-{{ $user->id }}"  data-id="{{ $user->id }}" style="display:none">フォロー解除</button>
                                    <button class="btn btn-primary follow" id="follow-{{ $user->id }}"  data-id="{{ $user->id }}">フォローする</button>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="my-4 d-flex justify-content-center">
            {{ $users->links() }}
        </div>
    </div>
@endsection
<script src="{{ asset('/js/follow.js') }}" defer></script>
