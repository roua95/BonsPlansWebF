<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;
use ChristianKuri\LaravelFavorite\Traits\Favoriteable;

class Plan extends Model
    //implements ReactableContract,LikeableContract

{
    //
    use Rateable;
    use Favoriteable;
    protected $fillable = [
        'id', 'title', 'adresse', 'rate', 'description', 'region', 'longitude', 'lattitude','approvedBy','user_id','approvedBy'
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class)->withPivot("category_plan");
    }

    public function authorizeCategory($category)

    {

        if (is_array($category)) {

            return $this->hasAnyCategory($category) ||
                abort(401, 'This action is unauthorized.');

        }

        return $this->hasCategory($category) ||
            abort(401, 'This action is unauthorized.');

    }

    /**
     * Check multiple roles
     * @param array $roles
     */

    public function hasAnyCategory($category)

    {

        return null !== $this->category()->whereIn("caetgory_name", $category)->first();

    }

    /**
     * Check one role
     * @param string $role
     */

    public function hasCategory($category)

    {

        return null !== $this->category()->where("category_name", $category)->first();

    }

    public function images()
    {
        return $this->belongsToMany(image::class);
    }
    public function comments()
    {
        return $this->belongsToMany(comment::class);
    }



    ///likes methods
    public function likes()
    {
        return $this->belongsToMany('App\User', 'likes');
    }


    public function getIsLikedAttribute()
    {
        $like = $this->likes()->whereUserId(Auth::id())->first();
        return (!is_null($like)) ? true : false;
    }

    public function favourites()
    {
        return $this->morphToMany(User::class, 'favouriteable');
    }
    public function favouritedBy(User $user)
    {
        return $this->favourites->contains($user);
    }
    public function city()
    {
        return $this->belongsToMany(City::class);
    }

}