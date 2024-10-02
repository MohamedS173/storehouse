<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['goods_id', 'quantity_change', 'status'];

    public function goods()
    {
        return $this->belongsTo(Goods::class);
    }
}
