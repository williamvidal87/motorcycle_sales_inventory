<?php

namespace App\Http\Livewire\DashBoard;

use App\Models\Inventory;
use App\Models\ProductCategory;
use App\Models\PurchaseProductUsed;
use App\Models\Transaction;
use App\Models\TransactionPayment;
use App\Models\User;
use Livewire\Component;

class DashBoard extends Component
{
    public $date;
    public $total_now=0;
    public function render()
    {
        return view('livewire.dash-board.dash-board',[
            'users' =>  User::where('rule_id',1)->get(),
            'category' =>  ProductCategory::all(),
            'item' =>  Inventory::all()
        ]);
    }
    
    public function mount()
    {
        
        date_default_timezone_set('Asia/Manila');
        $this->date= date('Y-m-d');
        $show=PurchaseProductUsed::whereDate('created_at',date('Y-m-d'))->get();
        // dd($show);
        
        foreach ($show as $data) {
            $this->total_now+=$data->qty*$data->price;
        }
    }
}
