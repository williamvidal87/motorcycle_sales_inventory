<?php

namespace App\Http\Livewire\AdminPanel\ProductCategory;

use App\Models\ProductCategory;
use App\Models\UserActivityLogsDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductCategoryForm extends Component
{
    public  $data = [];
    public  $product_category_name;
    public  $ProductCategoryID;
    
    protected $listeners = ['editProductCategoryData'];
    
    public function render()
    {
        return view('livewire.admin-panel.product-category.product-category-form');
    }

    public function editProductCategoryData($ProductCategoryID)
    {
        $this->ProductCategoryID=$ProductCategoryID;
        $DATA=ProductCategory::find($this->ProductCategoryID);
        $this->product_category_name = $DATA['product_category_name'];

    }
    
    public function store()
    {
        $this->validate([
            'product_category_name'     => 'required',
        ]);
        
        $this->data = ([
            'product_category_name'     => $this->product_category_name
        ]);
        
        try {
            if($this->ProductCategoryID){
                ProductCategory::find($this->ProductCategoryID)->update($this->data);
                $this->emit('alert_update');
                
            }else{
                $show=ProductCategory::create($this->data);
                $this->emit('alert_store');
                
            }
            
        } catch (\Exception $e) {
			dd($e);
			return back();
        }

        $this->emit('closeProductCategoryModal');
        $this->emit('refresh_productcategory_table');
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
    
    
    public function closeProductCategoryForm(){
        $this->emit('closeProductCategoryModal');
        $this->emit('refresh_productcategory_table');
        $this->reset();
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
