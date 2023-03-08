<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title><?= $page_title ?></title>

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/hope-ui.min.css?v=1.2.0') ?>" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.min.css?v=1.2.0') ?>" />

    <!-- to set deisgn in print -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-print.min.css') ?>" media="print">

    <style type="text/css">
    body {
        background: none !important;
    }

    .table-img-design {
        width: 45px !important;
        border-radius: 23px !important;
    }

    .table-img-txt-design {
        margin-left: 3px !important;
    }

    @media print {
        .hide_content {
            display: none !important;
        }

    }

    body {
        padding-left: 10px;
        padding-right: 10px;
    }
    </style>
</head>

<body>

    <span>

      <a href="javascript:void(0)" class="btn btn-sm btn-primary hide_content" id="print_log_details"
          style="float:right!important;margin-right:10px;">Print</a>

    </span>

    <h2 align="center" style="margin-top:10px;"><?= $page_title ?></h2>

    <br><br>

    <table width="30%" id="log-details-filter">
        <tr>
            <th>Product:</th>
            <td>
                <?php

              if(!empty($products))
              {

                foreach ($products as $key => $v)
                {

                  if(isset($products[$key + 1]))
                  {
                    echo $v->name.' ,&nbsp';
                  }else
                  {
                    echo $v->name;

                  }

                }

              }
              else
              {
                echo 'All';
              }

             ?>
            </td>
        </tr>
        <tr>
            <th>Customer:</th>
            <th>
                <?php

                if(!empty($customer))
                {

                  echo $customer->address.'-'.$customer->shop_name.'-'.$customer->shop_acronym;

                }
                else
                {
                echo 'All';
                }

                ?>
            </th>
        </tr>
        <tr>
            <th>Driver:</th>
            <th>
                <?php

                if(!empty($drivers))
                {

                  foreach ($drivers as $key => $v)
                  {

                    if(isset($drivers[$key + 1]))
                    {
                      echo $v->name.' ,&nbsp';
                    }else
                    {
                      echo $v->name;

                    }

                  }

                }
                else
                {
                  echo 'All';
                }

             ?>
            </th>
        </tr>
        <tr>
            <th>Type:</th>
            <th><?php
            if(!empty($type))
            {

              foreach ($types as $key => $v)
              {

                $typ = '';

                switch ($v) {

                  case 'add_stock':
                    $typ = 'Add Stock';
                  break;
                  case 'remove_stock':
                    $typ = 'Remove Stock';
                  break;
                  case 'request':
                    $typ = 'Driver Request';
                  break;
                  case 'assign':
                    $typ = 'Assign To Driver';
                  break;
                  case 'return':
                    $typ = 'Return Stock';
                  break;
                  case 'call_order':
                    $typ = 'Add Call Order';
                  break;
                  case 'assign_stock_confirmed':
                    $typ = 'Assign Stock Confirmed';
                  break;
                  case 'call_order_confirmed':
                    $typ = 'Call Order Confirmed';
                  break;
                  case 'pending_call_order_confirmed':
                    $typ = 'Pending Request Call Order Confirmed';
                  break;
                  case 'add_sale':
                    $typ = 'Add Sale';
                  break;
                  case 'edit_sale':
                    $typ = 'Edit Sale';
                  break;
                  case 'mark_sale_done':
                    $typ = 'Mark Sale Done';
                  break;
                  case 'goods_return':
                    $typ = 'Goods Return';
                  break;

                }

                if(isset($types[$key + 1]))
                {
                  echo $typ.' ,&nbsp';
                }else
                {
                  echo $typ;

                }

              }

            }
            else
            {
              echo 'All';
            }
            ?></th>
        </tr>
        <tr>
            <th>Date From:</th>
            <th><?= getDateTimeFormat($from,'date') ?></th>
        </tr>
        <tr>
            <th>Date To:</th>
            <th><?= getDateTimeFormat($to,'date') ?></th>
        </tr>
    </table>
    <br>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Product Type</th>
                    <th>Product Name</th>
                    <th>Qty</th>
                    <th>Qty (TYPE)</th>
                    <th>Type</th>
                    <th>Customer</th>
                    <th>Driver</th>
                    <th>User</th>
                    <th>Date</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $total_qty = 0;
                $total_return_qty = 0;
                $total_missing_qty = 0;
                $total_exchange_qty = 0;
                $total_foc_qty = 0;
                $total_sale_qty = 0;
                $total_bottle_qty = 0;
                $total_can_qty = 0;
                $total_bag_qty = 0;

                 if (!empty($logs)): ?>

                <?php foreach ($logs as $key => $v):

                  if($v->product_type == 'Bottle')
                  {
                    $total_bottle_qty += $v->qty;

                  }
                  else if($v->product_type == 'Can')
                  {
                    $total_can_qty += $v->qty;

                  }
                  else if($v->product_type == 'Bag')
                  {
                    $total_bag_qty += $v->qty;
                  }

                  $total_qty += $v->qty;

                  if($v->qty_type == 'return_qty')
                  {

                    $total_return_qty += $v->qty;

                  }
                  else if ($v->qty_type == 'missing_qty')
                  {
                    $total_missing_qty += $v->qty;

                  }
                  else if ($v->qty_type == 'exchange_qty')
                  {

                    $total_exchange_qty += $v->qty;
                  }

                  else if ($v->qty_type == 'foc_qty')
                  {

                    $total_foc_qty += $v->qty;
                  }

                  else if ($v->qty_type == 'sale_qty')
                  {

                    $total_sale_qty += $v->qty;
                  }

                  ?>

                <tr>
                    <td><?= $key + 1 ?></td>
                    <td><?= $v->product_type ?></td>
                    <td>
                        <?= $v->product_name ?>
                    </td>
                    <td><?= $v->qty ?></td>
                    <td>
                        <?= $v->qty_type != ''?str_replace('_',' ',$v->qty_type):''; ?>
                    </td>
                    <td><?php

                      $typ = '';
                      switch ($v->type) {

                        case 'add_stock':
                          $typ = 'Add Stock';
                        break;
                        case 'remove_stock':
                          $typ = 'Remove Stock';
                        break;
                        case 'request':
                          $typ = 'Driver Request';
                        break;
                        case 'assign':
                          $typ = 'Assign To Driver';
                        break;
                        case 'return':
                          $typ = 'Return Stock';
                        break;
                        case 'call_order':
                          $typ = 'Add Call Order';
                        break;
                        case 'assign_stock_confirmed':
                          $typ = 'Assign Stock Confirmed';
                        break;
                        case 'call_order_confirmed':
                          $typ = 'Call Order Confirmed';
                        break;
                        case 'pending_call_order_confirmed':
                          $typ = 'Pending Request Call Order Confirmed';
                        break;
                        case 'add_sale':
                          $typ = 'Add Sale';
                        break;
                        case 'edit_sale':
                          $typ = 'Edit Sale';
                        break;
                        case 'mark_sale_done':
                          $typ = 'Mark Sale Done';
                        break;
                        case 'goods_return':
                          $typ = 'Goods Return';
                        break;

                      }

                      echo $typ;

                    ?></td>
                    <td><?= $v->customer_name ?></td>
                    <td><?= $v->driver_name ?></td>
                    <td><?= $v->username ?></td>
                    <td><?= getDateTimeFormat($v->added_at,'date') ?></td>
                    <td><?= getDateTimeFormat($v->added_at,'only_time') ?></td>
                </tr>

                <?php endforeach; ?>
                <?php else: ?>

                <tr>
                    <td colspan="10">No log found...</td>
                </tr>

                <?php endif; ?>

            </tbody>
            <tfoot>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total</b></th>
                  <th><b><?= $total_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Return</b></th>
                  <th><b><?= $total_return_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Missing</b></th>
                  <th><b><?= $total_missing_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Exchange</b></th>
                  <th><b><?= $total_exchange_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Foc</b></th>
                  <th><b><?= $total_foc_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Sale</b></th>
                  <th><b><?= $total_sale_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Bottles</b></th>
                  <th><b><?= $total_bottle_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Can</b></th>
                  <th><b><?= $total_can_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>
              <tr>
                  <th colspan="3" style="text-align:right;"><b>Total Bags</b></th>
                  <th><b><?= $total_bag_qty ?></b></th>
                  <th colspan="7"></th>
              </tr>

            </tfoot>
        </table>
    </div>


</body>

<!-- Library Bundle Script -->
<script src=" <?= base_url('assets/js/core/libs.min.js') ?>">
</script>

<script type="text/javascript">
$('#print_log_details').click(function() {

    window.print()

})
</script>

</html>
