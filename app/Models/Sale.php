<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'total_price',
        'total_pay',
        'total_return',
        'customer_id',
        'user_id',
        'total_poin',
        'poin'
    ];

    public function detailSale()
    {
        return $this->hasMany(DetailSale::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
