<div>
  <style>
    *{
      font-size: 11pt;
      font-family: Arial, Helvetica, sans-serif;
    }
    .column {
      float: left;
      padding: 10px;
    }
    
    .left, .right {
      width: 25%;
    }
    
    .middle {
      width: 50%;
    }
    table, th, td {
      border: 1px solid black;
      border-collapse: collapse;
    }
    @page { 
      margin-top: 0.25in;
      margin-left: 0.25in;
      margin-bottom: 0.15in;
    }
    /* img {
    margin:0px;padding:0px
    } */
    
    /* .header,
    .footer {
        width: 100%;
        text-align: center;
        position: fixed;
    }
    .header {
        top: 0px;
    }
    .footer {
        bottom: 0px;
    }
    .pagenum:before {
        content: counter(page);
    } */
    
  </style>
  
  {{-- for header all --}}
  {{-- <div class="header">
    Page <span class="pagenum"></span>
  </div> --}}
  
  <div style="width: 7.5in;">
  
    <div class="row">
      <div class="column left">
        <img src="image/logo/chokenz.jpg" alt="chokenz" height="90" width="90" style="float: right;position: fixed;">
      </div>
      <div class="column middle" style="line-height: 1.6;">
          <p style="text-align: center;margin-top:0pt">
          <span style="font-family: serif;font-size: 12pt;font-weight: bold;">CHOKENZ</span>
          <br>MOTOR PARTS
          </p>
      </div>
      <div class="column right">
      </div>
    </div>
    
    <div style="margin-top: 85pt;width: 8in">
    
      <div class="row" style="text-align: center;">
        <span style="font-family: serif;font-size: 12pt;text-decoration: underline;">SALES</span>
      </div>
      <div class="row">
        <table style="width: 8in;margin-top:10pt">
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
                  <td>{{ $data->qty*$data->getInventory->whole_sale }} <?php $total_wholesales+=$data->qty*$data->getInventory->whole_sale; ?></td>
                  <td>{{ $data->qty*$data->price }} <?php $total_sales+=$data->qty*$data->price; ?></td>
                  <td>{{ $data->created_at->format('d/m/y h:i A') }}</td>
              </tr>
          @endforeach
        </tbody>
        <tfoot>
        <tr>
            <th style="text-align: left" colspan="6">Total:</th>
            <th style="text-align: left">{{ number_format($total_wholesales, 2, '.', ',') }}</th>
            <th style="text-align: left">{{ number_format($total_sales, 2, '.', ',') }}</th>
            <th></th>
        </tr>
        <tr>
            <th style="text-align: left" colspan="6">Total Profit:</th>
            <th style="text-align: center" colspan="2">{{ number_format($total_sales-$total_wholesales, 2, '.', ',') }}</th>
            <th></th>
        </tr>
        </tfoot>
        </table>
      </div>
      
    </div>
    
    
  </div>
  
  {{-- for footer all --}}
{{-- <div class="footer">
  Page <span class="pagenum"></span>
</div> --}}


</div>