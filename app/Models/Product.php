<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description','image'
    ];

    public function product_attributes(){
        return $this->hasMany(ProductAttributes::class, "product_id", "id");
    }
}
