<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'category_id',
    'warehouse_id',
    'sku',
    'name',
    'unit',
    'purchase_price',
    'selling_price',
    'stock_quantity',
    'min_stock',
    'description'
])]
class Product extends Model
{
    use HasFactory;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
