<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['stock_in_header_id', 'product_id', 'quantity', 'unit_price', 'subtotal'])]
class StockInDetail extends Model
{
    use HasFactory;

    public function header()
    {
        return $this->belongsTo(StockInHeader::class, 'stock_in_header_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
