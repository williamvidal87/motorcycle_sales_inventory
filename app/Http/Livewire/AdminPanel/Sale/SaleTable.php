<?php

namespace App\Http\Livewire\AdminPanel\Sale;

use App\Models\PurchaseProductUsed;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class SaleTable extends Component
{
    public $total_sales=0;
    public $total_wholesales=0;
    public $start_date;
    public $end_date;
    protected $listeners = [
        'refresh_productcategory_table' => '$refresh',
        'DeleteData'
    ];
    
    public function render()
    {
        $this->emit('EmitTable');
        $this->total_sales=0;
        $this->total_wholesales=0;
        return view('livewire.admin-panel.sale.sale-table',[
            'PurchaseProductUsedData' =>  PurchaseProductUsed::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->get()
        ])->with('getPurchaseProduct','getProductCategory','getInventory');
    }

    public function start_date()
    {
        $this->emit('refresh_productcategory_table');
        $this->total_sales=0;
        $this->total_wholesales=0;
    }

    public function end_date()
    {
        $this->emit('refresh_productcategory_table');
        $this->total_sales=0;
        $this->total_wholesales=0;
    }
    
    public function mount()
    {
    
        date_default_timezone_set('Etc/GMT-8');
        $this->start_date=date('Y-m-d');
        $this->end_date=date('Y-m-d');
    }
    
    public function PrintPdf()
    {
        $this->emit('EmitTable');
        $this->emit('refresh_productcategory_table');
        $this->total_sales=0;
        $this->total_wholesales=0;
    
        $pdfContent = PDF::loadView('livewire.admin-panel.sale.print-sale',[
            'PurchaseProductUsedData' => PurchaseProductUsed::whereDate('created_at', '>=', $this->start_date)->whereDate('created_at', '<=', $this->end_date)->get(),
            'total_sales' => 0,
            'total_wholesales' => 0
            ])->setPaper('Legal', 'Portrait')->output();
        return response()->streamDownload(fn () => print($pdfContent),"SALES.pdf");
    }
}
