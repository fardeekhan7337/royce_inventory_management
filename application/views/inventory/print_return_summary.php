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

        <a href="javascript:void(0)" class="btn btn-sm btn-primary hide_content" id="print_driver_stock_req_details_"
            style="float:right!important;margin-right:10px;">Print</a>

    </span>

    <h2 style="text-align:center;margin-top:10px;"><?= $page_title ?>
    </h2>

    <h4 style="text-align:center;margin-top:10px;margin-right:80px">
      (<?= getDateTimeFormat($from,'date') ?> / <?= getDateTimeFormat($to,'date') ?>)
    </h4>

    <br><br>

    <div class="row">

        <?php foreach($drivers as $key => $v): ?>

        <div class="col-sm-3">

            <div class="rows driver_main_col mb-2">
                <div class="col-sm-12">
                    <span><strong><?= $v->name ?></strong></span>
                </div>

                <?php if(isset($driver_return_summary[$key]) && !empty($driver_return_summary[$key])): ?>
                <ul>
                    <?php
                    $total_pro = 0;
                    $total_qty = 0;
                    $total_price = 0;
                     foreach($driver_return_summary[$key] as $key1 => $v1):
                        $price = $v1->product_price * $v1->qty;

                        $total_pro += 1;
                        $total_qty += $v1->qty;
                        $total_price += $price;

                        ?>
                    <li><?= $v1->product_name?> qty(<?= $v1->qty ?>)</li>
                    <?php endforeach; ?>
                    <hr>
                    <li>Total Product : <?= $total_pro ?></li>
                    <li>Total Qty : <?= $total_qty ?></li>
                    <!-- <li>Total Price : <= $total_price ?></li> -->
                </ul>

                <?php else: ?>
                <ul>
                    <li>No Return Summary</li>
                </ul>
                <?php endif; ?>

            </div>

        </div>

        <?php endforeach; ?>

    </div>


</body>

<!-- Library Bundle Script -->
<script src="<?= base_url('assets/js/core/libs.min.js') ?>"></script>

<script type="text/javascript">
$('#print_driver_stock_req_details_').click(function() {

    window.print()

})
</script>

</html>
