<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'user_id',
        'order_date',
        'delivery_date',
        'cost',
        'status_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function processingType()
    {
        return $this->belongsTo(ProcessingType::class);
    }
}
