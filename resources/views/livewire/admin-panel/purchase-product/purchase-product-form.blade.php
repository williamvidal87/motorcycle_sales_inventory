<div>
    <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Purchase Product</h1>
        <button class="close" data-dismiss="modal" aria-label="Close" wire:click="closePurchaseProductForm"><span aria-hidden="true">&times;</span></button>
    </div>
    <form wire:submit.prevent="store" enctype="multipart/form-data">
        <div class="modal-body">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="receipt_no">Receipt No. <small>(Optional)</small></label>
                        <input type="text" class="form-control" id="receipt_no" wire:model="receipt_no">
                        @error('receipt_no') <span style="color: red">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="info">Info <small>(Optional)</small></label>
                        <input type="text" class="form-control" id="info" wire:model="info">
                        @error('info') <span style="color: red">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <table class="table" id="products_table">
                    <thead>
                        <tr>
                            <th width="18%">Product Category</th>
                            <th width="30%">Item Name</th>
                            <th width="15%">Price</th>
                            <th width="12%">Qty</th>
                            <th width="12%">Total</th>
                            <th width="13%">Action</th>
                        </tr>
                    </thead>
                </table>
                <div style="height: 205px; overflow-y: scroll;">
                    <table class="table" id="products_table">
                        <tbody>
                            @foreach ($orderProducts as $index => $orderProduct)
                                <tr>
                                    <td width="18%">
                                        <select wire:change="ResetDetails({{$index}})" name="orderProducts[{{$index}}][product_category_id]"
                                            wire:model="orderProducts.{{$index}}.product_category_id"
                                            class="form-control" required>
                                            <option value="">Select Category</option>
                                            @foreach ($ProductCategoryData as $product)
                                            <option value="{{ $product->id }}">{{ $product->product_category_name }}</option>
                                            @endforeach
                                        </select>
                                        @error('orderProducts'.'.'.$index.'.'.'product_category_id') <span style="color: red">Required</span> @enderror
                                    </td>
                                    <td width="30%">
                                        <select name="orderProducts[{{$index}}][item_id]"
                                        wire:model="orderProducts.{{$index}}.item_id"
                                        class="form-control" required>
                                            <option value="">Select Details</option>
                                                @foreach ($InventoryData as $product2)
                                                    @if ($this->orderProducts[$index]['product_category_id']==$product2->product_category_id)
                                                            <option <?php
                                                                for ($i=0; $i < count($this->orderProducts); $i++) {
                                                                    if(!empty($this->orderProducts[$i]['item_id'])){
                                                                        if ($product2->id == $this->orderProducts[$i]['item_id']) {
                                                                            if ($this->orderProducts[$index]['item_id'] == $this->orderProducts[$i]['item_id']) {
                                                                                // echo "none";
                                                                            } else {
                                                                                echo "disabled";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            ?> value="{{ $product2->id }}">{{ $product2->item_name }} - {{ $product2->description }} - Qty: {{ $product2->qty }}<?php
                                                                for ($i=0; $i < count($this->orderProducts); $i++) {
                                                                    if(!empty($this->orderProducts[$i]['item_id'])){
                                                                        if ($product2->id == $this->orderProducts[$i]['item_id']) {
                                                                            if ($this->orderProducts[$index]['item_id'] == $this->orderProducts[$i]['item_id']) {
                                                                                // echo "none";
                                                                            } else {
                                                                                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;You Already taken.";
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            ?></option>
                                                    @endif
                                                @endforeach
                                        </select>
                                        @error('orderProducts'.'.'.$index.'.'.'item_id') <span style="color: red">Required</span> @enderror
                                    </td>
                                    <td width="15%">
                                        <div class="row">
                                            <div class="col-sm-1">
                                                &#8369;
                                            </div>
                                            <div class="col-sm-9">
                                                <?php
                                                    if ($this->orderProducts[$index]['item_id']&&$this->orderProducts[$index]['product_category_id']) {
                                                            foreach ($InventoryData as $paymentdetaildata) {
                                                                if ($this->orderProducts[$index]['item_id']==$paymentdetaildata->id) {
                                                                    if ($paymentdetaildata->price!=null) {
                                                                        $this->orderProducts[$index]['price']=$paymentdetaildata->price;
                                                                    }
                                                                }
                                                            }
                                                    }
                                                ?>
                                                <input wire:ignore.self wire:model="orderProducts.{{$index}}.price" type="number" class="form-control" onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
                                            </div>
                                        </div>
                                    </td>
                                    <td width="12%">
                                        <input type="number" step="any" name="orderProducts[{{$index}}][qty]" wire:model="orderProducts.{{$index}}.qty" type="text" class="form-control" required max="<?php
                                        foreach ($InventoryData as $product2) {
                                                if ($product2->id == $this->orderProducts[$index]['item_id']) {
                                                    echo $product2->qty;
                                                }
                                        }
                                    ?>">
                                        @error('orderProducts'.'.'.$index.'.'.'qty') <span style="color: red">Required</span> @enderror
                                    </td>
                                    <td width="12%">
                                        <?php
                                            if ($this->orderProducts[$index]['item_id']&&$this->orderProducts[$index]['product_category_id']) {
                                                foreach ($InventoryData as $paymentdetaildata) {
                                                    if ($this->orderProducts[$index]['item_id']==$paymentdetaildata->id) {
                                                        if ($this->orderProducts[$index]['qty']!=null) {
                                                            if ($this->orderProducts[$index]['price']) {
                                                                    echo "&#8369;";
                                                                    echo number_format($this->orderProducts[$index]['price']*$this->orderProducts[$index]['qty'], 2, '.', ',');
                                                                    $total_all+=$this->orderProducts[$index]['price']*$this->orderProducts[$index]['qty'];
                                                                } else {
                                                                    echo "&#8369;";
                                                                    echo number_format($paymentdetaildata->price*$this->orderProducts[$index]['qty'], 2, '.', ',');
                                                                    $total_all+=$paymentdetaildata->price*$this->orderProducts[$index]['qty'];
                                                                }
                                                        }
                                                    }
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td width="13%">
                                        <button wire:click.prevent="removeProduct({{$index}})" class="py-0 btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i>Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <table class="table" id="products_table">
                    <tfoot>
                        <tr>
                            <th width="63%"></th>
                            <th width="12%">Total:</th>
                            <th width="12%">&#8369;{{ number_format($total_all, 2, '.', ',') ?? '0' }}</th>
                            <th width="13%"></th>
                        </tr>
                    </tfoot>
                </table>
                <div class="row">
                    <div class="col-md-12">
                        <button class="btn btn-sm btn-primary" wire:click.prevent="addProduct">+ Add Items</button>
                        @error('orderProducts') <span style="color: red">Please Add Items</span> @enderror
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-between">
            <button type="button" class="btn btn-default" wire:click="closePurchaseProductForm">Close</button>
            @if(!empty($this->PurchaseProductID))
                {{-- <button class="btn btn-primary" wire:click="store">Save changes</button> --}}
                <input type="submit" class="btn btn-primary"  value="Save Changes">
            @else
                {{-- <button class="btn btn-primary" wire:click="store">Submit</button> --}}
                <input type="submit" class="btn btn-primary"  value="Submit">
            @endif
        </div>
    </form>
</div>
