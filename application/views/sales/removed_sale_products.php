
<div class="row">

  <?php

    echo getHiddenField('product_id[]',$pro['product_id']);
    echo getHiddenField('price[]',$pro['product_price'],'price_');

    echo getInputField([
      'label' => 'Product',
      'custom_label' => '<a href="javascript:void(0)" class="remove_customer_sale_product" data-PID="'. $pro['product_id'] .'" data-PNAME="'. $pro['product_name'] .'" data-Qty="'. $pro['available_qty']. '" data-price="'. $pro['product_price'] .'">
          <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
        </a>',
      'value' => $pro['product_name'],
      'column' => 'sm-4',
      'attr' => 'readonly'
    ]);
    echo getInputField([
      'label' => 'Available Qty',
      'name' => 'available_qty[]',
      'column' => 'sm-2',
      'col_classes' => '',
      'classes' => 'available_qty_',
      'attr' => 'readonly',
      'value' => $pro['available_qty']
    ]);
    echo getInputField([
      'label' => 'Sale Qty',
      'name' => 'sale_qty[]',
      'column' => 'sm-2',
      'col_classes' => '',
      'classes' => 'sale_qty_',
      'value' => 0
    ]);
    echo getInputField([
      'label' => 'Exchange Qty',
      'name' => 'exchange_qty[]',
      'column' => 'sm-2',
      'col_classes' => '',
      'classes' => 'exchange_qty_',
      'value' => 0
    ]);
    echo getInputField([
      'label' => 'Foc Qty',
      'name' => 'foc_qty[]',
      'column' => 'sm-2',
      'col_classes' => '',
      'classes' => 'foc_qty_',
      'value' => 0
    ]);
    echo getInputField([
      'label' => 'Total',
      'name' => 'total[]',
      'column' => 'sm-2',
      'col_classes' => '',
      'classes' => 'total_qty_',
      'attr' => 'readonly,min="1",max="'.$pro['available_qty'].'"'

    ]);

    echo getHiddenField('amount[]',0,'amount_');

    ?>
    <!-- <div class="col-sm-1 col-1" style="padding:0px!important;width:1%!important">
    <a href="javascript:void(0)" class="remove_customer_sale_product">
    <i class="fa-solid fa-x" style="font-size: 20px;margin-top: 38px;margin-left:8px;;color:#fd6262!important;"></i>
  </a>
</div> -->

</div>
