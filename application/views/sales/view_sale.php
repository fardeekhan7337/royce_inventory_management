<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title><?= $page_title ?></title>

    <!-- Hope Ui Design System Css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/hope-ui.min.css?v=1.2.0') ?>"  media="all" />

    <!-- Custom Css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/custom.min.css?v=1.2.0') ?>"  media="all" />

    <!-- to set deisgn in print -->
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap-print.min.css') ?>" media="print">

    <!-- toastr  css -->
    <link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css') ?>" />

    <!-- Font Awesome script -->
    <script src="https://kit.fontawesome.com/b04cb78fd5.js" crossorigin="anonymous"></script>

    <style type="text/css">

        .row
        {
          --bs-gutter-x: 0px!important;
        }

        .company_logo
        {
          min-width: 100px;
          height: 100px;
        }

        #company_head
        {
          text-align: right;
          text-transform: uppercase;
          margin-top: 10px;
        }
        #company_address
        {
          text-align: right;
          font-size: 13px;
          float:right;
        }
        .font_uppercase
        {
          text-transform: uppercase!important;
        }
        .font_design
        {
          color: black;
          font-size : 14px;
        }
        #customer_address
        {
          font-size: 13px;
        }
        #totals_color
        {
          color:black;
          text-align: right;
        }

        @media print
        {
            .hide_content
            {
                display: none !important;
            }
        }

    </style>
  </head>
  <?php if ($type == 'invoice_print'): ?>

  <body onload="window.print()">
    <?php else: ?>
  <body>
  <?php endif; ?>

    <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
             <div class="card-header d-flex justify-content-between" style="background: #f5f6fa!important;">
                <div class="header-title" style="margin-bottom: 25px!important;">
                   <h3 class="card-title"><?= $page_title ?></h3>
                </div>
                <span>

                  <?php if (($type == 'details' || $type == 'save_sale') && $sale->status == 'pending'): ?>

                        <a href="javascript:void(0)" class="btn btn-sm btn-success" id="mark_as_done">Mark As Done</a>

                  <?php endif; ?>

                  <?php if ($type == 'save_sale'): ?>

                        <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="return_to_sale" data-url="<?= site_url('edit_sale/'.$sale->id) ?>">Return To Sale</a>

                  <?php endif; ?>

                  <?php if ($type == 'invoice' || $type == 'invoice_print'): ?>

                    <?php if (isUserAllow(58)): ?>

                    <a href="javascript:void(0)" class="btn btn-sm btn-success hide_content" id="send_pdf_to_whtaspp" data-type="whatsapp" data-id="<?= $sale->id ?>"><i class="fa-brands fa-whatsapp"></i> Send Pdf To WhatsApp</a>

                    <?php endif; ?>

                    <?php if (isUserAllow(57)): ?>

                    <a href="javascript:void(0)" class="btn btn-sm btn-success hide_content" id="send_invoice_email" data-type="mail" data-id="<?= $sale->id ?>">Send Email</a>

                    <?php endif; ?>

                    <a href="javascript:void(0)" class="btn btn-sm btn-primary hide_content" id="print_details">Print</a>

                  <?php endif; ?>

                </span>
             </div>
             <div class="card-body">

               <!-- company info row start -->
                <div class="row">

                  <div class="col-12 col-sm-6 col-md-8">
                    <img src="<?= companySetting('logo') ?>" alt="company_logo" class="company_logo">
                  </div>
                  <div class="col-12 col-sm-6 col-md-4">
                    <h5 id="company_head"><?= companySetting('name') ?></h5>
                    <label id="company_address">
                      <?= companySetting('address') ?>
                    </label>
                  </div>

                </div>
                <!-- company info row end -->

                <!-- invoice info row start -->
                <div class="row mt-5">

                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <div class="row mt-1">
                      <div class="col-sm-12">

                        <h6 class="text-primary font_uppercase">Invoice Information</h6>

                      </div>
                      <div class="col-12 col-sm-12 mt-1">
                          <div class="row">

                            <div class="col-12 col-sm-4 col-md-5 col-lg-4">
                              <span class="font_design font_uppercase">Invoice #:</span>
                            </div>
                            <div class="col-12 col-sm-8 col-md-7 col-lg-8">
                              <span class="font_design font_uppercase"><?= $sale->invoice_no ?></span>
                            </div>
                          </div>
                      </div>
                      <div class="col-12 col-sm-12">
                          <div class="row">

                            <div class="col-12 col-sm-5 col-md-6 col-lg-6 col-xl-5">
                              <span class="font_design font_uppercase">Invoice Date:</span>
                            </div>
                            <div class="col-12 col-sm-7 col-md-6 col-lg-6 col-xl-7">
                              <span class="font_design font_uppercase"><?= getDateTimeFormat($sale->added_at,'date') ?></span>
                            </div>
                          </div>
                      </div>
                      <div class="col-12 col-sm-12">
                          <div class="row">

                            <div class="col-3 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                              <span class="font_design font_uppercase">Category:</span>
                            </div>
                            <div class="col-9 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                              <span class="font_design font_uppercase">
                                <?php if ($sale->customer_category == 'cash'){ ?>
                                  <span class="badge rounded-pill bg-success">Cash</span>
                                <?php }elseif ($sale->customer_category == 'credit') { ?>
                                  <span class="badge rounded-pill bg-warning">Credit</span>
                                <?php } ?>
                              </span>
                            </div>
                          </div>
                      </div>
                      <div class="col-12 col-sm-12">
                          <div class="row">

                            <div class="col-3 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                              <span class="font_design font_uppercase">Status:</span>
                            </div>
                            <div class="col-9 col-sm-8 col-md-8 col-lg-8 col-xl-8">
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
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <div class="row mt-1">
                      <div class="col-sm-12">

                        <h6 class="text-primary font_uppercase">Invoice To</h6>
                        <div class="col-sm-12 mt-1">
                          <span class="font_design font_uppercase"><?= $sale->shop_name ?></span>
                        </div>
                        <div class="col-sm-12">
                          <label id="customer_address">
                            <?= $sale->customer_address ?>
                          </label>
                        </div>
                      </div>
                    </div>

                  </div>

                </div>
                <!-- invoice info row end -->

                <!-- table row start -->
                <div class="row mt-4">

                  <div class="col-12">
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th width="55%">Products</th>
                            <th width="10%">Sale Qty</th>
                            <th width="13%">Exchange Qty</th>
                            <th width="13%">Foc Qty</th>
                            <th width="10%">Price</th>
                            <th style="text-align:right">Total</th>
                          </tr>
                        </thead>
                        <tbody>

                          <?php

                            $total_sale_qty = 0;
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
                            <td><?= $v->price ?></td>
                            <td style="text-align:right"><?= $v->amount?></td>
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
                      </table>
                    </div>
                  </div>

                  <!-- <div class="col-sm-12">
                    <table class="table">
                      <thead>
                        <tr>
                          <th width="48%" style="text-align:right">Total Qty</th>
                          <td width="10%"><= $total_sale_qty ?></td>
                          <td width="13.5%"><= $total_exchange_qty ?></td>
                          <td width="11%"><= $total_foc_qty  ?></td>
                          <td width="10%">SubTotal</td>
                          <td id="totals_color"><= number_format(floatval($sale->total_amount),2,'.','') ?></td>
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
                  </div>

                </div>-->
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


    <!-- confirmation modal -->
    <div class="modal fade" id="markAsDoneModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body">
                  <p>Are you sure you want to submit this sale?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-primary" id="confirm_sale" data-url="<?= site_url('Sales/mark_as_done')?>" data-id="<?= $sale->id ?>" data-redirect="<?= site_url('sales')?>">Submit</button>
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
    </div>


    <!-- confirmation pdf modal -->
    <div class="modal fade" id="ConfirmationPdfModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body">
                  <p>Are you sure you want to send?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-primary" id="sendPdfToCustomer" data-type="" data-id="">Yes</button>
                  <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
              </div>
          </div>
      </div>
    </div>


  </body>

  <!-- Library Bundle Script -->
  <script src="<?= base_url('assets/js/core/libs.min.js') ?>"></script>

  <!-- toastr  js -->
  <script src="<?= base_url('assets/js/toastr/toastr.min.js') ?>"></script>

  <script type="text/javascript">

    $('#mark_as_done').click(function functionName() {

      $('#markAsDoneModal').modal('show')

    })


    $('#send_invoice_email,#send_pdf_to_whtaspp').click(function () {

      let type = $(this).attr('data-type')
      let sale_id = $(this).attr('data-id')

      $('#sendPdfToCustomer').attr('data-type',type)
      $('#sendPdfToCustomer').attr('data-id',sale_id)

      $('#ConfirmationPdfModal').modal('show')

    })

    //yes mark as done
    $('#confirm_sale').click(function () {

      let url = $(this).attr('data-url')

      let sale_id = $(this).attr('data-id')

      var redirect = $(this).attr('data-redirect')

      // update status of sale
      $.ajax({
        url : url,
        type : 'post',
        data : {sale_id : sale_id},
        dataType : 'json',
        success : function (data) {

            self.opener.location.href = redirect

            window.close()

        }
      })

    })

    $('#return_to_sale').click(function () {

      let url = $(this).attr('data-url')

      self.opener.location.href = url

      window.close()

    })

    $('#print_details').click(function () {

        window.print()

    })


    function show_error_(_error_msg) {

       toastr.error(_error_msg, "", {
        positionClass: "toast-top-right",
        timeOut: 5e3,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1
      })

    }

    function show_success_(_succes_msg) {

      toastr.success(_succes_msg, "", {
        positionClass: "toast-top-right",
        timeOut: 5e3,
        closeButton: !0,
        debug: !1,
        newestOnTop: !0,
        progressBar: !0,
        preventDuplicates: !0,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
        tapToDismiss: !1
      })

    }

    $('#sendPdfToCustomer').click(function () {

      $('#ConfirmationPdfModal').modal('hide')

      let type = $(this).attr('data-type')
      let sale_id = $(this).attr('data-id')

      // send mail / whtsapp
      $.ajax({
        url : "<?= site_url('AjaxController/sendPdfToCustomer') ?>",
        type : 'post',
        data : {sale_id : sale_id,type : type},
        dataType : 'json',
        success : function (data) {

          if(data.status == true)
          {

            show_success_(data.msg)

          }
          else
          {

            show_error_(data.msg)

          }


        }
      })


    })

  </script>
</html>
