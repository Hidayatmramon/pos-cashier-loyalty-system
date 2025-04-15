<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'poin',
        'no_hp',
    ];

    public function sale()
    {
        return $this->hasMany(Sale::class);
    }
}
