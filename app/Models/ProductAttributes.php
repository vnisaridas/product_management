<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttributes extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'name'
    ];

    public function attributes(){
        return $this->hasMany(ProductAttributesOptions::class, "product_attribute_id", "id");
    }
}
