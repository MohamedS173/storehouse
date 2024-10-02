<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    use HasFactory;
    protected $fillable = ['goods_id', 'quantity', 'status'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function goods() {
        return $this->belongsTo(Goods::class);
    }
}
