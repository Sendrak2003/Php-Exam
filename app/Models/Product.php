<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model {
    public $timestamps = false;
    protected $fillable = [
        'serialNumber',
        'yearOfRelease',
        'price',
        'name',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function models()
    {
        return $this->belongsToMany(Models::class);
    }
}
