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

                  <h6 class="text-primary font_uppercase" style="font-size: 1rem;color: #3a57e9!important;">Payment Information</h6>

                </div>
                <div class="col-sm-12 mt-1">
                  <div class="row">

                    <div class="col-sm-12" style="lfloat:left">
                      <span class="font_design font_uppercase">Date From: <?= $from != ''?getDateTimeFormat($from,'date'):'All' ?></span>
                    </div>
                  </div>
                </div>
                <div class="col-sm-12">
                  <div class="row">

                    <div class="col-sm-12" style="float:left">
                      <span class="font_design font_uppercase">Date To: <?= $to != ''?getDateTimeFormat($to,'date'):'All' ?></span>
                    </div>
                  </div>
                </div>
                <br>

              </div>

              </div>

              <div style="width:60%;float:right">

                <div class="row mt-1">
                <div class="col-sm-12">

                  <h6 class="text-primary font_uppercase" style="font-size: 1rem;color: #3a57e9!important;">Payments To</h6>

                    <span class="font_design font_uppercase">
                      <?php if (!empty($customer_id)): ?>

                       <?= isset($customer->shop_name)?$customer->shop_name:'' ?>

                       <?php else: ?>

                         All

                      <?php endif; ?>
                    </span>

                    <p id="customer_address">

                      <?php if (!empty($customer_id)): ?>

                       <?= isset($customer->address)?$customer->address:'' ?>

                      <?php endif; ?>

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
                      <th>#</th>
                      <th>Invoice No#</th>
                      <th>Date</th>
                      <th>Time</th>
                      <th style="text-align:right">Debit</th>
                      <th style="text-align:right">Credit</th>
                    </tr>
                  </thead>
                  <tbody>

                    <?php if (!empty($payments)): ?>

                    <?php foreach ($payments as $key => $v): ?>

                    <tr>
                       <td><?= $key+1 ?></td>
                       <td><?= $v->invoice_no ?></td>
                       <td><?= getDateTimeFormat($v->added_at,'date') ?></td>
                       <td><?= getDateTimeFormat($v->added_at,'only_time') ?></td>
                       <?php if ($v->type != 'credit'): ?>

                         <td style="text-align:right"><?= $v->amount ?></td>
                         <td style="text-align:right">0</td>

                         <?php else: ?>

                         <td style="text-align:right">0</td>
                         <td style="text-align:right"><?= $v->amount ?></td>

                        <?php endif; ?>
                    </tr>

                    <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <th colspan="6">No payments found...</th>
                      </tr>
                    <?php endif; ?>

                  </tbody>
                </table>
              </div>
            </div>

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
