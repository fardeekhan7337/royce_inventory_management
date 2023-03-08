<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title><?= $page_title ?></title>

  <!-- Hope Ui Design System Css -->
  <link rel="stylesheet" href="<?= $root.'assets/css/pdf-bootstrap.min.css'; ?>" media="all" />

  <!-- Custom Css -->
  <link rel="stylesheet" href="<?= $root.'assets/css/custom.min.css?v=1.2.0' ?>" media="all" />

  <style type="text/css">

  body {
  font-family: sans-serif!important;
  }

    .row {
      --bs-gutter-x: 0px !important;
    }

    .company_logo {
      min-width: 100px;
      height: 100px;
      margin-top: 30px;
    }

    #company_head {
      text-align: right;
      text-transform: uppercase;
      margin-top: 30px;
    }

    #company_address {
      text-align: right!important;
      font-size: 13px;
    }

    .font_uppercase {
      text-transform: uppercase !important;
    }

    .font_design {
      color: black;
      font-size: 14px;
    }

    #customer_address {
      font-size: 13px;
    }

    #totals_color {
      color: black;
    }
  </style>
</head>

<body>

  <div class="row">
    <div class="col-sm-12 col-lg-12">
      <div class="card">
        <div class="card-header d-flex justify-content-between" style="background: #f5f6fa!important;padding: 1.5rem 1.5rem;padding-bottom:0px;">
          <div class="header-title" style="margin-bottom: 25px!important;">
            <h3 class="card-title" style="font-weight:500!important;">
              <?= $page_title ?></h3>
          </div>
        </div>
        <div class="card-body">

          <!-- company info row start -->
          <div class="row" >
            <div class="col-sm-12">
            <div class="" style="width:50%;float:left">

              <?php

                      $logo = companySetting('pdf_logo');
                      $company_logo = $root.''.$logo;

                    ?>

              <?php if ($logo): ?>

              <img src="<?= $company_logo ?>" alt="company_logo" class="company_logo">

              <?php endif; ?>

            </div>
            <div class="" style="width:50%;float:right">
              <h5 id="company_head" style="font-size: 1.25rem;font-weight:500"><?= companySetting('name') ?></h5>
              <p id="company_address" style="color: #8a92a6;">
                <?= companySetting('address') ?>
              </p>
            </div>
          </div>
          </div>
          <!-- company info row end -->

          <!-- invoice info row start -->
          <div class="row" style="margin-top:40px;">

            <div class="col-sm-12">

              <div style="width:40%;float:left">

                <div class="row mt-1">
                <div class="col-sm-12">

                  <h6 class="text-primary font_uppercase" style="font-size: 1rem;color: #3a57e9!important;">Invoice Information</h6>

                </div>
                <div class="col-sm-12 mt-1">
                  <div class="row">

                    <div class="col-sm-12" style="lfloat:left">
                      <span class="font_design font_uppercase">Invoice #: <?= $sale->invoice_no ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="row">

                    <div class="col-sm-12" style="float:left">
                      <span class="font_design font_uppercase">Invoice Date: <?= getDateTimeFormat($sale->added_at,'date') ?></span>
                    </div>
                  </div>
                </div>
                <br>
                <div class="col-sm-12">
                  <div class="row" style="margin-top:5px!important;">

                    <div class="col-sm-12">
                      <span class="font_design font_uppercase">Category:
                        <span class="font_design font_uppercase">
                          <?php if ($sale->customer_category == 'cash'){ ?>
                          <span class="badge rounded-pill bg-success">Cash</span>
                          <?php }elseif ($sale->customer_category == 'credit') { ?>
                          <span class="badge rounded-pill bg-warning">Credit</span>
                          <?php } ?>
                        </span></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="row" style="margin-top:5px!important;">

                    <div class="col-sm-12">
                      <span class="font_design font_uppercase">Status:
                        <span class="font_design font_uppercase">

                          <?php if ($sale->status == 'paid'){ ?>

                          <span class="badge rounded-pill bg-success">Paid</span>

                          <?php }elseif ($sale->status == 'unpaid' || $sale->status == 'credit') { ?>

                          <span class="badge rounded-pill bg-warning"><?= ucfirst($sale->status) ?></span>

                          <?php }elseif ($sale->status == 'pending') { ?>

                          <span class="badge rounded-pill bg-secondary">Pending</span>

                          <?php }
                                   ?>

                        </span>
                      </span>
                    </div>
                  </div>

                </div>
                <?php if ($sale->reason != '' && $sale->is_pay != 1): ?>

                <div class="col-12 col-sm-12">
                    <div class="row">

                      <div class="col-3 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <span class="font_design font_uppercase">Reason:</span>
                      </div>
                      <div class="col-9 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                        <span class="font_design">

                          <?= $sale->reason ?>

                        </span>
                      </div>
                    </div>
                </div>
                <?php endif ?>
                <div class="col-12 col-sm-12">
                    <div class="row">

                      <div class="col-3 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                        <span class="font_design font_uppercase">Driver:</span>
                      </div>
                      <div class="col-9 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                        <span class="font_design">

                          <?= $sale->driver_name ?>

                        </span>
                      </div>
                    </div>
                </div>

              </div>

              </div>

              <div style="width:60%;float:right">

                <div class="row mt-1">
                <div class="col-sm-12">

                  <h6 class="text-primary font_uppercase" style="font-size: 1rem;color: #3a57e9!important;">Invoice To</h6>

                    <span class="font_design font_uppercase"><?= $sale->shop_name ?></span>

                    <p id="customer_address">
                      <?= $sale->customer_address ?>
                    </p>

                </div>
              </div>

              </div>

            </div>

          </div>
          <!-- invoice info row end -->

          <!-- table row start -->
          <br><br>
          <div class="row">

            <div class="col-sm-12">
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th width="45%">Products</th>
                      <th width="10%">Sale Qty</th>
                      <th width="12%">Exchange Qty</th>
                      <th width="12%">Foc Qty</th>
                      <th width="10%">Price</th>
                      <th width="16%" style="text-align:right">Total</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php  $total_sale_qty = 0;
                            $total_exchange_qty = 0;
                            $total_foc_qty = 0;
                            foreach ($sales_details as $key => $v):
                              $total_sale_qty += $v->sale_qty;
                              $total_exchange_qty += $v->exchange_qty;
                              $total_foc_qty += $v->foc_qty;
                 ?>

                    <tr>
                      <td><?= $v->product_name ?></td>
                      <td><?= $v->sale_qty ?></td>
                      <td><?= $v->exchange_qty ?></td>
                      <td><?= $v->foc_qty ?></td>
                      <td><?= number_format(floatval($v->price),2); ?></td>
                      <td style="text-align:right"><?= number_format(floatval($v->amount),2); ?></td>
                    </tr>

                    <?php endforeach; ?>

                  </tbody>
                  <tfoot>
                          <tr style="background-color: #f5f6fa;text-transform: uppercase;letter-spacing: .2px;border-top: 2px solid transparent;">
                            <th style="text-align:right">Total Qty</th>
                            <td><?= $total_sale_qty ?></td>
                            <td><?= $total_exchange_qty ?></td>
                            <td><?= $total_foc_qty  ?></td>
                            <td>SubTotal</td>
                            <td id="totals_color"><?= number_format(floatval($sale->total_amount),2,'.','') ?></td>
                          </tr>
                        </tfoot>
                  <!--<tfoot>-->
                      
                  <!--  <tr>-->
                  <!--    <th colspan="5" style="text-align:right;">SubTotal</th>-->
                  <!--    <td id="totals_color"><= number_format(floatval($sale->total_amount),2); ?></td>-->
                  <!--  </tr>-->
                  <!--</tfoot>-->
                </table>
              </div>
            </div>
<!--
            <div class="col-sm-12">
              <table class="table">
                <thead>
                  <tr>
                    <th width="74%"></th>
                    <td width="10%">SubTotal</td>
                    <td width="16%" id="totals_color"><= $sale->total_amount ?></td>
                  </tr>
                  <tr>
                          <th width="78%"></th>
                          <td>Taxes</td>
                          <td id="totals_color">1000</td>
                        </tr> -->
                  <!-- <tr>
                          <th width="78%"></th>
                          <td>Discount</td>
                          <td id="totals_color">100</td>
                        </tr> -->
                  <!-- <tr>
                          <th width="78%"></th>
                          <td>Net Amount</td>
                          <td id="totals_color">2900</td>
                        </tr>
                </thead>
              </table>
            </div> -->

          </div>
          <!-- table row end -->

          <!-- terms & condition row start -->

          <div class="row mt-3">
            <div class="col-sm-12 mt-1">
              <span class="font_design font_uppercase">Terms & Condition</span>
            </div>
            <div class="col-10 col-sm-10 col-md-8 col-lg-7">
              <label id="customer_address">
                <?= companySetting('terms_and_condition') ?>
              </label>
            </div>
          </div>
          <!-- terms & condition row end -->

        </div>
      </div>
    </div>
  </div>

</body>

</html>
