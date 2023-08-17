<?php

namespace App\Http\Livewire\AdminPanel\PurchaseProduct;

use App\Models\ProductCategory;
use App\Models\Inventory;
use App\Models\PurchaseProduct;
use App\Models\PurchaseProductUsed;
use Livewire\Component;

class PurchaseProductForm extends Component
{
    public  $data = [];
    public  $receipt_no,
            $info;
    public  $PurchaseProductID;
    
    public  $orderProducts = [];
    public  $product_category_id = [];
    public  $item_id = [];
    public  $qty = [];
    public  $price = [];
    public  $total_all = 0;
    
    protected $listeners = ['editPurchaseProductData'];
    
    public function addProduct()
    {
        $this->orderProducts[] = ['id'=>'','purchase_product_id' => '','product_category_id'=>'', 'item_id' => '', 'qty' => '1', 'price' => ''];
    }
    
    public function removeProduct($index)
    {   
        unset($this->orderProducts[$index]);
        $this->orderProducts = array_values($this->orderProducts);
    }
    
    public function ResetDetails($index)
    {
        $this->orderProducts[$index]['item_id']=null;
        $this->orderProducts[$index]['price']=null;
    }
    
    public function render()
    {
        return view('livewire.admin-panel.purchase-product.purchase-product-form',[
            'ProductCategoryData' =>  ProductCategory::orderBy('product_category_name', 'ASC')->get(),
            'InventoryData' =>  Inventory::orderBy('item_name', 'ASC')->get()
        ]);
    }

    public function editPurchaseProductData($PurchaseProductID)
    {
        $this->PurchaseProductID=$PurchaseProductID;
        $DATA=PurchaseProduct::find($this->PurchaseProductID);
        $this->receipt_no = $DATA['receipt_no'];
        $this->info = $DATA['info'];
        
        $PurchaseProductUsed = PurchaseProductUsed::all()->where('purchase_product_id', $this->PurchaseProductID);
        $count_purchase=0;
        foreach ($PurchaseProductUsed as $data) {
            $this->orderProducts[$count_purchase++] = ['id'=>$data['id'],'purchase_product_id'=>$data['purchase_product_id'],'product_category_id' => $data['product_category_id'], 'item_id' => $data['item_id'], 'qty' => $data['qty'], 'price' => $data['price']];
        }

    }
    
    public function store()
    {
        $this->validate([
            'orderProducts'     => 'array|required',
            'orderProducts.*.product_category_id'     => 'required',
            'orderProducts.*.item_id'                   => 'required',
            'orderProducts.*.qty'                     => 'required',
        ]);
        
        $this->data = ([
            'receipt_no'        => $this->receipt_no,
            'info'              => $this->info
        ]);
        
        try {
            if($this->PurchaseProductID){
                PurchaseProduct::find($this->PurchaseProductID)->update($this->data);
                $CheckPurchase=PurchaseProductUsed::where('purchase_product_id', $this->PurchaseProductID)->get();
                
                foreach ($CheckPurchase as $data) {
                
                $inventory_qty=Inventory::find($data->item_id);
                $inventory_data=([
                    'qty'        => $data->qty+$inventory_qty->qty,
                ]);
                    Inventory::find($data->item_id)->update($inventory_data);
                }
                PurchaseProductUsed::where('purchase_product_id', $this->PurchaseProductID)->delete(); // Delete all
                // Copying PurchaseProductUsedID
                for ($i=0; $i < count($this->orderProducts); $i++) {
                    $this->orderProducts[$i]['purchase_product_id']=$this->PurchaseProductID;
                }
                foreach ($this->orderProducts as $orderproducts) {
                    PurchaseProductUsed::create($orderproducts);
                    $inventory_qty2=Inventory::find($orderproducts['item_id']);
                    $inventory_data2=([
                        'qty'        => $inventory_qty2->qty-$orderproducts['qty'],
                    ]);
                    // dd($inventory_data2);
                        Inventory::find($orderproducts['item_id'])->update($inventory_data2);
                    
                }
                $this->emit('alert_update');
                
            }else{
                $show=PurchaseProduct::create($this->data);
                // Copying PurchaseProductID
                for ($i=0; $i < count($this->orderProducts); $i++) {
                    $this->orderProducts[$i]['purchase_product_id']=$show['id'];
                }
                
                foreach ($this->orderProducts as $orderproducts) {
                    PurchaseProductUsed::create($orderproducts);
                    $inventory_qty2=Inventory::find($orderproducts['item_id']);
                    $inventory_data2=([
                        'qty'        => $inventory_qty2->qty-$orderproducts['qty'],
                    ]);
                    // dd($inventory_data2);
                        Inventory::find($orderproducts['item_id'])->update($inventory_data2);
                }
                
                $this->emit('alert_store');
                
            }
            
        } catch (\Exception $e) {
			dd($e);
			return back();
        }

        $this->emit('closePurchaseProductModal');
        $this->emit('refresh_purchaseproduct_table');
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    
    public function closePurchaseProductForm(){
        $this->emit('closePurchaseProductModal');
        $this->emit('refresh_purchaseproduct_table');
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
