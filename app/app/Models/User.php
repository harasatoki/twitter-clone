<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'screen_name',
        'name',
        'profile_image',
        'email',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * フォロワーリレーション
     */
    public function followers()
    {
        return $this->belongsToMany(self::class, 'followers', 'followed_id', 'following_id');
    }

    /**
     * フォローリレーション
     */

    public function follows()
    {
        return $this->belongsToMany(self::class, 'followers', 'following_id', 'followed_id');
    }

    /**
     * 全ユーザーを取得
     *
     * @param int $userId
     * 
     * @return array
     */
    public function fetchAllUsers(int $userId)
    {
        return $this->Where('id', '<>', $userId)->paginate(5);
    }

    /**
     * フォローする
     *
     * @param int|null $userId
     * 
     * @return　void
     */
    public function follow(?int $userId) : void
    {
        $this->follows()->attach($userId);
    }

    /**
     * フォロー解除する
     *
     * @param int|null $userId
     * 
     * @return void
     */
    public function unfollow(?int $userId) : void
    {
        $this->follows()->detach($userId);
    }

    /**
     * フォローしているか
     *
     * @param int|null $userId
     * 
     * @return boolean
     */
    public function isFollowing(?int $userId) 
    {
        return $this->follows()->where('followed_id', $userId)->exists();
    }

    /**
     * フォローされているか
     *
     * @param int|null $userId
     * 
     * @return boolean
     */
    public function isFollowed(?int $userId) 
    {
        return $this->followers()->where('following_id', $userId)->exists();
    }

    /**
     * ユーザー情報の更新
     *
     * @param array $params
     * 
     * @return void
     */
    public function updateProfile(array $params) : void
    {
        if (isset($params['profile_image'])) {
            $fileName = $params['profile_image']->store('public/profile_image/');

            $this::where('id', $this->id)
                ->update([
                    'screen_name'   => $params['screen_name'],
                    'name'          => $params['name'],
                    'profile_image' => basename($fileName),
                    'email'         => $params['email'],
                ]);
        } else {
            $this::where('id', $this->id)
                ->update([
                    'screen_name'   => $params['screen_name'],
                    'name'          => $params['name'],
                    'email'         => $params['email'],
                ]); 
        }
    }
}
