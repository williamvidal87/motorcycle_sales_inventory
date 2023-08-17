<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_category_id',
        'item_name',
        'description',
        'whole_sale',
        'price',
        'qty'
    ];
    
    public function getProductCategory()
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id');
    }
}
