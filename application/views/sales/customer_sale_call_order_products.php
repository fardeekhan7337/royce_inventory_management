<?php $total = 0;$call_order_id = 0; foreach ($products as $key => $v): ?>

<?php if ($v->qty != 0):
  $call_order_id = $v->call_order_id;
  $amount = $v->product_price * $v->qty;
  $total += $amount; ?>

<div class="row">

  <?php

    echo getHiddenField('product_id[]',$v->product_id);
    echo getHiddenField('price[]',$v->product_price,'price_');

    echo getInputField([
      'label' => 'Product',
      'value' => $v->product_name,
      'column' => 'sm-4',
      'attr' => 'readonly'
    ]);

    echo getInputField([
      'label' => 'Available Qty',
      'name' => 'available_qty[]',
      'column' => 'sm-2',
      'attr' => 'readonly',
      'value' => $v->qty
    ]);

    echo getInputField([
      'label' => 'Sale Qty',
      'name' => 'sale_qty[]',
      'column' => 'sm-2',
      'classes' => 'sale_qty_',
      'value' => 0
    ]);

    echo getHiddenField('exchange_qty[]',0,'exchange_qty_');

    echo getInputField([
      'label' => 'Foc Qty',
      'name' => 'foc_qty[]',
      'column' => 'sm-2',
      'classes' => 'foc_qty_',
      'value' => 0
    ]);

    echo getInputField([
      'label' => 'Total',
      'name' => 'total[]',
      'column' => 'sm-2',
      'classes' => 'total_qty_',
      'attr' => 'readonly,min="'. $v->qty .'",max="'.$v->qty.'"'

    ]);

    echo getHiddenField('amount[]',$amount,'amount_');

    ?>

</div>

<?php endif; ?>
<?php endforeach;
echo getHiddenField('total_amount',number_format(floatval($total),2,'.',''));
echo getHiddenField('main_id',$call_order_id);
?>
