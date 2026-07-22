<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['transaction_code', 'transaction_date', 'recipient_department', 'user_id', 'total_amount', 'notes'])]
class StockOutHeader extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(StockOutDetail::class, 'stock_out_header_id');
    }
}
