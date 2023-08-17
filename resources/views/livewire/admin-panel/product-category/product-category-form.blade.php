<div>
    <div class="modal-header">
        <h1 class="modal-title" id="exampleModalLabel">Product Category</h1>
        <button class="close" data-dismiss="modal" aria-label="Close" wire:click="closeProductCategoryForm"><span aria-hidden="true">&times;</span></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <label for="product_category_name">Product Category</label>
            <input type="text" class="form-control" id="product_category_name" wire:model="product_category_name">
            @error('product_category_name') <span style="color: red">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-default" wire:click="closeProductCategoryForm">Close</button>
        @if(!empty($this->ProductCategoryID))
            <button class="btn btn-primary" wire:click="store">Save changes</button>
        @else
            <button class="btn btn-primary" wire:click="store">Submit</button>
        @endif
    </div>
</div>
