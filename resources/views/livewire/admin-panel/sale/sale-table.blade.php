<div>
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Sales</h1>
        

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="row">
                <div class="col-sm-8">
                    <button style="width: fit-content;margin-left: 1.2rem;margin-top: 1.2rem"  class="btn btn-primary" wire:click="PrintPdf"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</button> 
                    
                </div>
                <div class="col-sm-2">
                    <label style="width: 8rem">Date Start:</label><input type="date" class="form-control" id="date" wire:model="start_date" wire:change="start_date" style="width: 9rem">    
                </div>
                <div class="col-sm-2">
                    <label style="width: 8rem">Date End:</label><input type="date" class="form-control" id="date" wire:model="end_date" wire:change="end_date" style="width: 9rem">    
                </div>
            </div>
            <div class="card-body">
                
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Receipt No</th>
                                <th>Info</th>
                                <th>Product Category</th>
                                <th>Item Name</th>
                                <th>Qty</th>
                                <th>Whole Sale</th>
                                <th>Sales</th>
                                <th>Date Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($PurchaseProductUsedData as $data)
                                <tr>
                                    <td>{{ $data->id }}</td>
                                    <td>{{ $data->getPurchaseProduct->receipt_no }}</td>
                                    <td>{{ $data->getPurchaseProduct->info }}</td>
                                    <td>{{ $data->getProductCategory->product_category_name }}</td>
                                    <td>{{ $data->getInventory->item_name }} - {{ $data->getInventory->description }}</td>
                                    <td>{{ $data->qty }}</td>
                                    <td>&#8369 {{ $data->qty*$data->getInventory->whole_sale }} <?php $this->total_wholesales+=$data->qty*$data->getInventory->whole_sale; ?></td>
                                    <td>&#8369 {{ $data->qty*$data->price }} <?php $this->total_sales+=$data->qty*$data->price; ?></td>
                                    <td>{{ $data->created_at->format('d/m/y h:i A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            {{-- <tr>
                                <th colspan="6" style="text-align: end">Total:</th>
                                <th colspan="2">&#8369 {{ number_format($this->total_sales, 2, '.', ',') }}</th>
                            </tr> --}}
                            
                            <tr>
                                <th colspan="6">Total:</th>
                                <th>&#8369 {{ number_format($this->total_wholesales, 2, '.', ',') }}</th>
                                <th colspan="1">&#8369 {{ number_format($this->total_sales, 2, '.', ',') }}</th>
                                <th></th>
                            </tr>
                            <tr>
                                <th colspan="6">Total Profit:</th>
                                <th colspan="2" style="text-align: center">&#8369 {{ number_format($this->total_sales-$this->total_wholesales, 2, '.', ',') }}</th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    
    </div>
    
    
</div>
@section('custom_script')
    @include('layouts.scripts.sales-table-scripts'); 
@endsection