<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'product_id',
    'user_id',
    'reference_number',
    'type',
    'quantity_before',
    'quantity_change',
    'quantity_after',
    'notes'
])]
class StockLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
