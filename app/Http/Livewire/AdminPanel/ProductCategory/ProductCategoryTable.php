<?php

namespace App\Http\Livewire\AdminPanel\ProductCategory;

use App\Models\ProductCategory;
use App\Models\UserActivityLogsDatabase;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductCategoryTable extends Component
{
    protected $listeners = [
        'refresh_productcategory_table' => '$refresh',
        'DeleteData'
    ];
    
    public function render()
    {
        $this->emit('EmitTable');
        return view('livewire.admin-panel.product-category.product-category-table',[
            'ProductCategoryData' =>  ProductCategory::all()
        ]);
    }

    public function editProductCategory($ProductCategoryID){
        $this->emit('openProductCategoryModal');
        $this->emit('editProductCategoryData',$ProductCategoryID);
    }

    public function createProductCategory(){
        $this->emit('openProductCategoryModal');
    }

    public function deleteProductCategory($ProductCategoryID){
        $this->emit('openSwalDelete',$ProductCategoryID);
    }

    public function DeleteData($ProductCategoryID){
        ProductCategory::destroy($ProductCategoryID);
        $this->emit('EmitTable');
        $this->emit('alert_delete');
    }
}
