<div>
    <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Item</h1>
        <button class="close" data-dismiss="modal" aria-label="Close" wire:click="closeInventoryForm"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="product_category_id">Product Category</label>
            <select class="form-control" id="product_category_id" wire:model="product_category_id">
                <option>Select Product Category</option>
                @foreach($ProductCategoryData as $data)
                    <option value="{{ $data->id }}">{{ $data->product_category_name }}</option>
                @endforeach
            </select>
            @error('product_category_id') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="item_name">Item Name</label>
            <input type="text" class="form-control" id="item_name" wire:model="item_name">
            @error('item_name') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" wire:model="description"></textarea>
            @error('description') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="whole_sale">Whole Sale</label>
            <input wire:model="whole_sale" type="number" class="form-control" id="whole_sale" onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
            @error('whole_sale') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="price"> Retail Price</label>
            <input wire:model="price" type="number" class="form-control" id="price" onkeypress='return event.charCode >= 46 && event.charCode <= 57'>
            @error('price') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        @if(!empty($this->InventoryID))
        <div class="form-group">
            <label for="qty">Qty</label>
            <input wire:model="qty" type="number" class="form-control" id="qty" onkeypress='return event.charCode >= 47 && event.charCode <= 57' disabled>
            @error('qty') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        <div class="form-group">
            <label for="add_qty">Add Qty</label>
            <input wire:model="add_qty" type="number" class="form-control" id="add_qty" onkeypress='return event.charCode >= 47 && event.charCode <= 57'>
        </div>
        @else
        <div class="form-group">
            <label for="qty">Qty</label>
            <input wire:model="qty" type="number" class="form-control" id="qty" onkeypress='return event.charCode >= 47 && event.charCode <= 57'>
            @error('qty') <span style="color: red">{{ $message }}</span> @enderror
        </div>
        @endif
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" wire:click="closeInventoryForm">Close</button>
        @if(!empty($this->InventoryID))
            <button class="btn btn-primary" wire:click="store">Save changes</button>
        @else
            <button class="btn btn-primary" wire:click="store">Submit</button>
        @endif
    </div>
</div>
