<div class="row mb-3">
    <div class="col-sm-9"></div>
    <div class="col-sm-3">
        <button class="btn btn-sm btn-primary remove_empty_products" type="button">
            Remove Empty Products
        </button>
    </div>
</div>
<div class="row mb-3">
    <div class="col-sm-8"></div>
    <?= getSelectField([
    'label' => 'Add Remove Products',
    'name' => 'remove_products_',
    'select2_class' => 'remove_sale_products_select2_',
    'classes' => 'remove_sale_products_',
    'column' => 'sm-4',
    'required' => false
    ])?>
</div>

<?php $assign_stock_id = 0;
if (!empty($products)) {
  foreach ($products as $key => $v): ?>

<?php if ($v->available_qty != 0):

  $assign_stock_id = $v->assign_stock_id;
  ?>



<div class="row">



    <?php

    $pclr = 'style="color:'. $v->product_color .'"';
    
    echo getHiddenField('product_id[]',$v->product_id);
    echo getHiddenField('price[]',$v->product_price,'price_');

    echo getInputField([
      'label' => 'Product',
      'custom_label' => '<a href="javascript:void(0)" class="remove_customer_sale_product" data-PID="'. $v->product_id .'" data-PNAME="'. $v->product_name .'" data-Qty="'. $v->available_qty. '" data-price="'. $v->product_price .'">
          <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
        </a>',
      'value' => $v->product_name,
      'column' => 'sm-4',
      'attr' => 'readonly,'.$pclr
    ]);
    echo getInputField([
      'label' => 'Available Qty',
      'name' => 'available_qty[]',
      'column' => 'sm-2',
      'col_classes' => '',
      'classes' => 'available_qty_',
      'attr' => 'readonly',
      'value' => $v->available_qty
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
      'attr' => 'readonly,min="1",max="'.$v->available_qty.'"'

    ]);

    echo getHiddenField('amount[]',0,'amount_');

    ?>
    <!-- <div class="col-sm-1 col-1" style="padding:0px!important;width:1%!important">
    <a href="javascript:void(0)" class="remove_customer_sale_product">
    <i class="fa-solid fa-x" style="font-size: 20px;margin-top: 38px;margin-left:8px;;color:#fd6262!important;"></i>
  </a>
</div> -->

</div>

<?php endif; ?>
<?php endforeach;
}
echo getHiddenField('main_id',$assign_stock_id);
?>