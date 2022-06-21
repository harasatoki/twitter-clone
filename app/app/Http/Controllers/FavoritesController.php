<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;

class FavoritesController extends Controller
{
    /**
     * いいね情報の保存
     *
     * @param  \Illuminate\Http\Request  $request
     * @param Favorite $favorite
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Favorite $favorite)
    {
        $user = auth()->user();
        $tweetId = $request->tweet_id;
        $isFavorite = $favorite->isFavorite($user->id, $tweetId);

        if(!$isFavorite) {
            $favorite->storeFavorite($user->id, $tweetId);
        }

        $countFavorite=$favorite->countFavorite($user->id, $tweetId);

        return response()->json(['countFavorite'=>$countFavorite]);
    }

    /**
     * いいね情報の削除
     *
     * @param  Favorite $favorite
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Favorite $favorite, Request $request)
    {
        // 変更
        $tweetId = $request->tweet_id;
        $userId = auth()->user()->id;
        $favoriteId=$favorite->fetchFavorite($userId,$tweetId)->id;

        // $userId = $favorite->user_id;
        // $tweetId = $favorite->tweet_id;
        // $favoriteId = $favorite->id;
        $isFavorite = $favorite->isFavorite($userId, $tweetId);

        if($isFavorite) {
            $favorite->destroyFavorite($favoriteId);
        }
        $countFavorite=$favorite->countFavorite($userId, $tweetId);

        return response()->json(['countFavorite'=>$countFavorite]);
    }
}
