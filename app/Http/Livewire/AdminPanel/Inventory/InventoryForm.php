<?php

namespace App\Http\Livewire\AdminPanel\Inventory;

use App\Models\Inventory;
use App\Models\ProductCategory;
use Livewire\Component;

class InventoryForm extends Component
{
    public  $data = [];
    public  $product_category_id,
            $item_name,
            $description,
            $price,
            $whole_sale,
            $qty,
            $add_qty=null;
    public  $InventoryID;
    
    protected $listeners = ['editInventoryData'];
    
    public function render()
    {
        return view('livewire.admin-panel.inventory.inventory-form',[
            'ProductCategoryData' =>  ProductCategory::all()
        ]);
    }

    public function editInventoryData($InventoryID)
    {
        $this->InventoryID=$InventoryID;
        $DATA=Inventory::find($this->InventoryID);
        $this->product_category_id  = $DATA['product_category_id'];
        $this->item_name            = $DATA['item_name'];
        $this->description          = $DATA['description'];
        $this->price                = $DATA['price'];
        $this->qty                  = $DATA['qty'];
        $this->whole_sale           = $DATA['whole_sale'];

    }
    
    public function store()
    {
        $this->validate([
            'product_category_id'       => 'required',
            'item_name'                 => 'required',
            'description'               => 'required',
            'price'                     => 'required',
            'qty'                       => 'required',
            'whole_sale'                => 'required',
        ]);
        if ($this->add_qty==null) {
            $this->add_qty=0;
        }
        $this->data = ([
            'product_category_id'       => $this->product_category_id,
            'item_name'                 => $this->item_name,
            'description'               => $this->description,
            'price'                     => $this->price,
            'qty'                       => $this->qty+$this->add_qty,
            'whole_sale'                => $this->whole_sale
        ]);
        
        try {
            if($this->InventoryID){
                Inventory::find($this->InventoryID)->update($this->data);
                $this->emit('alert_update');
                
            }else{
                $show=Inventory::create($this->data);
                $this->emit('alert_store');
                
            }
            
        } catch (\Exception $e) {
			dd($e);
			return back();
        }

        $this->emit('closeInventoryModal');
        $this->emit('refresh_inventory_table');
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    
    public function closeInventoryForm(){
        $this->emit('closeInventoryModal');
        $this->emit('refresh_inventory_table');
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
