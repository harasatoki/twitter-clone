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
        $userId = auth()->id();
        $tweetId = $request->tweet_id;
        $isFavorite = $favorite->isFavorite($userId, $tweetId);

        if( !$isFavorite ){
            $favorite->storeFavorite($userId, $tweetId);
        }

        $countFavorite = $favorite->countFavorite($userId, $tweetId);

        return response()->json(['countFavorite' => $countFavorite]);
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
        $tweetId = $request->tweet_id;
        $userId = auth()->id();
        $favoriteId = $favorite->fetchFavoriteId($userId, $tweetId);
        $isFavorite = $favorite->isFavorite($userId, $tweetId);

        if( $isFavorite ) {
            $favorite->destroyFavorite($favoriteId[0]);
        }
        $countFavorite = $favorite->countFavorite($userId, $tweetId);

        return response()->json(['countFavorite' => $countFavorite]);
    }
}
