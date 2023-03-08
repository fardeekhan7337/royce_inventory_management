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
    @media print {
        .hide_content {
            display: none !important;
        }

    }

    body {
        background: none !important;
        padding-left: 10px;
        padding-right: 10px;
    }

    .driver_main_col {
        border: 1px solid black;
        padding: 8px;
    }

    ul {
        padding: 0;
    }

    ul li {
        list-style: none;

    }
    </style>
</head>

<body>

    <span>

        <a href="javascript:void(0)" class="btn btn-sm btn-primary hide_content" id="print_available_stock_"
            style="float:right!important;margin-right:10px;">Print</a>

    </span>

    <h2 style="text-align:center;margin-top:10px;"><?= $page_title ?>
    </h2>

    <h4 style="text-align:center;margin-top:10px;margin-right:80px">
        (<?= date('d-m-Y') ?>)
    </h4>


    <br><br>

    <div class="row">

        <div class="col-sm-12">

            <div class="rows driver_main_col mb-2">

                <?php if(!empty($available_inventory)): ?>
                <ul>
                    <?php
                    $total_pro = 0;
                    $total_pro_qty = 0;
                     foreach($available_inventory as $key => $v):

                        $total_add = $v->total_add_stock_qty + $v->total_return;
                        $total_remove = $v->total_remove_stock_qty + $v->total_assign_stock_confirmed + $v->total_pending_call_order_confirmed + $v->total_return_missing;

                        $total_qty = $total_add - $total_remove;

                        $total_pro += 1;
                        $total_pro_qty += $total_qty;

                        ?>
                    <li><?= $v->product_name?> qty(<?= $total_qty ?>)</li>
                    <?php endforeach; ?>
                    <hr>
                    <li>Total Product : <?= $total_pro ?></li>
                    <li>Total Qty : <?= $total_pro_qty ?></li>
                    <!-- <li>Total Price : <= $total_price ?></li> -->
                </ul>

                <?php else: ?>
                <ul>
                    <li>No Inventory Available</li>
                </ul>
                <?php endif; ?>

            </div>

        </div>
    </div>


</body>

<!-- Library Bundle Script -->
<script src="<?= base_url('assets/js/core/libs.min.js') ?>"></script>

<script type="text/javascript">
$('#print_available_stock_').click(function() {

    window.print()

})
</script>

</html>
