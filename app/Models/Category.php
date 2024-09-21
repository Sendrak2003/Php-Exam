<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public $timestamps = false;

    public function models()
    {
        return $this->hasMany(Models::class, 'cat_id');
    }
}
