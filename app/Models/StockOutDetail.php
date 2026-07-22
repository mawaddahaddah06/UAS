<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['stock_out_header_id', 'product_id', 'quantity', 'unit_price', 'subtotal'])]
class StockOutDetail extends Model
{
    use HasFactory;

    public function header()
    {
        return $this->belongsTo(StockOutHeader::class, 'stock_out_header_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
