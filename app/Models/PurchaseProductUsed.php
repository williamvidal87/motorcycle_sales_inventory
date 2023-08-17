<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseProductUsed extends Model
{
    use HasFactory;
    protected $fillable = [
        'purchase_product_id',
        'product_category_id',
        'item_id',
        'price',
        'qty'
    ];
    
    public function getPurchaseProduct()
    {
        return $this->belongsTo(PurchaseProduct::class,'purchase_product_id');
    }
    
    public function getProductCategory()
    {
        return $this->belongsTo(ProductCategory::class,'product_category_id');
    }
    
    public function getInventory()
    {
        return $this->belongsTo(Inventory::class,'item_id')->with('getProductCategory');
    }
}
