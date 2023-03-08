<?php foreach ($assign_products as $key => $v): ?>
<?php if ($v->qty != 0): ?>

<div class="row">
  <?php

    $q = $v->exchange_qty + $v->foc_qty;
    $sold_qty = $v->qty - $v->available_qty - $q;

    echo getHiddenField('product_id[]',$v->product_id);

    echo getInputField([
      'label' => 'Product',
      'column' => 'sm-4',
      'attr' => 'readonly',
      'value' => $v->product_name
    ]);
    echo getInputField([
      'label' => 'Assign Qty',
      'name' => 'assign_qty[]',
      'column' => 'sm-2',
      'attr' => 'readonly',
      'value' => $v->qty
    ]);
    echo getInputField([
      'label' => 'Sale Qty',
      'name' => 'sale_qty[]',
      'column' => 'sm-2',
      'classes' => 'sale_qty_',
      'attr' => 'readonly',
      'value' => $sold_qty
    ]);
    echo getInputField([
      'label' => 'Exchange Qty',
      'name' => 'exchange_qty[]',
      'column' => 'sm-2',
      'attr' => 'readonly',
      'classes' => 'exchange_qty_',
      'value' => $v->exchange_qty
    ]);
    echo getInputField([
      'label' => 'Foc Qty',
      'name' => 'foc_qty[]',
      'column' => 'sm-2',
      'attr' => 'readonly',
      'classes' => 'foc_qty_',
      'value' => $v->foc_qty
    ]);
    echo getInputField([
      'label' => 'Missing Qty',
      'name' => 'missing_qty[]',
      'column' => 'sm-2',
      'classes' => 'missing_qty_',
      'value' => 0
    ]);
    echo getInputField([
      'label' => 'Return Qty',
      'name' => 'return_qty[]',
      'column' => 'sm-2',
      'classes' => 'return_qty_',
      'value' => 0
    ]);
    echo getInputField([
      'label' => 'Total',
      'name' => 'total',
      'column' => 'sm-2',
      'attr' => 'readonly,min="'.$v->qty.'",max="'.$v->qty.'"',
      'classes' => 'total_qty_',
    ]);

    ?>

</div>
<hr>

<?php endif; ?>
<?php endforeach; ?>
