<?php

namespace App\Http\Livewire\AdminPanel\PurchaseProduct;

use App\Models\Inventory;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductUsed;
use Livewire\Component;

class PurchaseProductTable extends Component
{
    protected $listeners = [
        'refresh_purchaseproduct_table' => '$refresh',
        'DeleteData'
    ];
    
    public function render()
    {
        $this->emit('EmitTable');
        return view('livewire.admin-panel.purchase-product.purchase-product-table',[
            'PurchaseProductData' =>  PurchaseProduct::all(),
            'InventoryData' =>  Inventory::all()
        ]);
    }

    public function editPurchaseProduct($PurchaseProductID){
        $this->emit('openPurchaseProductModal');
        $this->emit('editPurchaseProductData',$PurchaseProductID);
    }

    public function createPurchaseProduct(){
        $this->emit('openPurchaseProductModal');
    }

    public function deletePurchaseProduct($PurchaseProductID){
        $this->emit('openSwalDelete',$PurchaseProductID);
    }

    public function DeleteData($PurchaseProductID){
        PurchaseProductUsed::where('purchase_product_id', $PurchaseProductID)->delete(); // Delete all
        PurchaseProduct::destroy($PurchaseProductID);
        $this->emit('EmitTable');
        $this->emit('alert_delete');
    }
}
