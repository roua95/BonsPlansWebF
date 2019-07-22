<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category  extends Model
{
    //
    protected $table = 'categories';
    protected $fillable = [
        'id','category_name',
    ];
    public function plans()
    {
        return $this->belongsToMany(Plan::class)->withPivot("category_plan");
    }

    /**
     * @return array
     */
    public function getCategoryName()
    {
        return $this->category_name;
    }
    public function getAllCategories():array
    {
        return $this::all();
    }

    /**
     * @param array $fillable
     */
    public function setFillable(array $fillable): void
    {
        $this->fillable = $fillable;
    }

}