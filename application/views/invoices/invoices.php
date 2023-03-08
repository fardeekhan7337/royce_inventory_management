<div class="col-3 col-sm-3 mb-4" style="padding-left: 25px;">

  <label for="Customer" class="form-label">Select Page No#</label>

  <select class="form-select form-select-sm select22 move_to_page" data-width="100%" name="customer_id" id="sale_customer_id" required>

    <?php
    for ($i=1; $i <= $total_pages; $i++) {

        $selected = '';

        if($i == $selected_page && $selected_page != 0)
        {

          $selected = 'selected';

        }
      ?>
          <option value="<?= $i ?>" <?= $selected ?>><?= $i ?></option>

    <?php } ?>

  </select>

</div>
<div class="col-sm-6 col-6 col-md-6 col-lg-6">
  <button type="button" class="btn btn-sm btn-primary" id="print_selected_invoices" style="margin-top: 29px!important;">Print Invoices</button>
  <button type="button" class="btn btn-sm btn-info" id="print_filter_invoices" style="margin-top: 29px!important;">Print Filter Invoices</button>
  <button type="button" class="btn btn-sm btn-primary" id="print_all_invoices" style="margin-top: 29px!important;">Print All Invoices</button>
</div>

</div>
<div class="row">

<?php if (!empty($invoices)): ?>

<?php foreach ($invoices as $key => $v): ?>

  <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">

    <div class="card" style="box-shadow: 0 1px 6px 0 rgb(54 51 51)!important;">
      <div class="card-body">

        <div class="row">
          <div class="col-sm-8">
            <h6 class="text-primary">Invoice # <?= $v->invoice_no ?></h6>

          </div>
          <div class="col-sm-4" style="text-align:right!important">

            <?php if ($v->status == 'paid'){ ?>

              <span class="badge rounded-pill bg-success">Paid</span>

            <?php }elseif ($v->status == 'unpaid' || $v->status == 'credit') { ?>

              <span class="badge rounded-pill bg-warning"><?= ucfirst($v->status) ?></span>

            <?php }elseif ($v->status == 'pending') { ?>

              <span class="badge rounded-pill bg-secondary">Pending</span>

            <?php }
             ?>

          </div>
        </div>
        <div class="row">
          <div class="col-6 col-sm-12 col-md-6 mt-3">
            <label id="invoice_label">Customer</label>

            <div class="row mt-1">
              <div class="col-sm-12">
                <!-- <php

                  if (@getimagesize(base_url('uploads/customer/'.$v->customer_img)) && !empty($v->customer_img))
                  {
                      echo '<img src="'. base_url('uploads/customer/'.$v->customer_img) .'" class="inv-img-design" alt="...">';
                  }
                  else
                  {
                      echo '<img src="'. base_url('assets/images/avatars/01.png') .'" class="inv-img-design" alt="...">';
                  }

                 ?> -->
                <span class="inv-txt-design">
                 <?= $v->shop_name ?> - <?= $v->shop_acronym ?>
                </span>
              </div>
            </div>

          </div>
          <div class="col-6 col-sm-12 col-md-6 mt-3">
            <label id="invoice_label">Driver</label>
            <div class="row mt-1">
              <div class="col-sm-12">
                <!-- <php

                  if (@getimagesize(base_url('uploads/driver/'.$v->driver_img)) && !empty($v->driver_img))
                  {
                      echo '<img src="'. base_url('uploads/driver/'.$v->driver_img) .'" class="inv-img-design" alt="...">';
                  }
                  else
                  {
                      echo '<img src="'. base_url('assets/images/avatars/01.png') .'" class="inv-img-design" alt="...">';
                  }

                 ?> -->
                <span class="inv-txt-design">
                  <?= $v->driver_name ?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6 col-sm-6 mt-3">
            <label id="invoice_label">Date</label>

            <div class="row mt-1">
              <div class="col-sm-12">
                <span class="inv-txt-design">
                  <?= getDateTimeFormat($v->added_at,'date') ?>
                </span>
              </div>
            </div>

          </div>
          <div class="col-6 col-sm-6 mt-3">
            <label id="invoice_label">Category</label>
            <div class="row mt-1">
              <div class="col-sm-12">
                <?php if ($v->customer_category == 'cash'){ ?>
                  <span class="badge rounded-pill bg-success">Cash</span>
                <?php }elseif ($v->customer_category == 'credit') { ?>
                  <span class="badge rounded-pill bg-warning">Credit</span>
                <?php } ?>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-6 col-sm-6 mt-3">
            <label id="invoice_label">Products</label>

            <div class="row mt-1">
              <div class="col-sm-12">
                <span class="inv-txt-design">
                  <?= $v->total_products ?>
                </span>
              </div>
            </div>

          </div>
          <div class="col-6 col-sm-6 mt-3">
            <label id="invoice_label">Total</label>
            <div class="row mt-1">
              <div class="col-sm-12">
                <span class="inv-txt-design">
                  <?= $v->total_amount ?>
                </span>
              </div>
            </div>
          </div>
        </div>

        <div class="row mt-2 inv_btn_row">
          <div class="col-6 col-sm-6 inv_btn_col">

            <button type="button" class="btn btn-sm btn-primary view_inv_details" data-url="<?= site_url('AjaxController/showSalesDetails/'. $v->id .'/invoice')?>"><i class="fa fa-eye"></i> View Details</button>
          </div>
          <div class="col-6 col-sm-6 inv_btn_col">

            <button type="button" class="btn btn-sm btn-primary print_inv_details" data-url="<?= site_url('AjaxController/showSalesDetails/'. $v->id .'/invoice_print')?>" ><i class="fa fa-print"></i> Print Invoice</button>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">

              <input type="checkbox" value="<?= $v->id?>" class="check_invoice_for_print" id="check_for_print<?= $v->id ?>"> <label for="check_for_print<?= $v->id ?>">Check For Print</label>

          </div>
        </div>

      </div>
    </div>

  </div>

<?php endforeach; ?>
<?php else: ?>
  <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-4">
    <p>No Invoices found...</p>
  </div>
<?php endif; ?>
