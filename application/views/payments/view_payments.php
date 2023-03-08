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
  <body>

    <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
             <div class="card-header d-flex justify-content-between" style="background: #f5f6fa!important;">
                <div class="header-title" style="margin-bottom: 25px!important;">
                   <h3 class="card-title"><?= $page_title ?></h3>
                </div>
                <span>

                    <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
                    <input type="hidden" name="from_date" value="<?= $from ?>">
                    <input type="hidden" name="to_date" value="<?= $to ?>">

                    <?php if (isUserAllow(79)): ?>

                    <a href="javascript:void(0)" class="btn btn-sm btn-success hide_content" id="send_sheet_to_whtaspp"><i class="fa-brands fa-whatsapp" data-type="whatsapp"></i> Send Pdf To WhatsApp</a>

                    <?php endif; ?>

                    <?php if (isUserAllow(78)): ?>


                    <a href="javascript:void(0)" class="btn btn-sm btn-success hide_content" id="send_mail_to_customer" data-type="email">Send Mail To Customer</a>

                    <?php endif; ?>

                    <a href="javascript:void(0)" class="btn btn-sm btn-primary hide_content" id="print_customer_payments">Print</a>

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

                        <h6 class="text-primary font_uppercase">Payment Information</h6>

                      </div>
                      <div class="col-12 col-sm-12 mt-1">
                          <div class="row">

                            <div class="col-12 col-sm-4 col-md-5 col-lg-4">
                              <span class="font_design font_uppercase">Date From:</span>
                            </div>
                            <div class="col-12 col-sm-8 col-md-7 col-lg-8">
                              <span class="font_design font_uppercase"><?= $from != ''?getDateTimeFormat($from,'date'):'All' ?></span>
                            </div>
                          </div>
                      </div>
                      <div class="col-12 col-sm-12">
                          <div class="row">

                            <div class="col-12 col-sm-4 col-md-5 col-lg-4">
                              <span class="font_design font_uppercase">Date To:</span>
                            </div>
                            <div class="col-12 col-sm-7 col-md-6 col-lg-6 col-xl-7">
                              <span class="font_design font_uppercase"><?= $to != ''?getDateTimeFormat($to,'date'):'All' ?></span>
                            </div>
                          </div>
                      </div>

                    </div>

                  </div>
                  <div class="col-12 col-sm-6 col-md-4 col-lg-3">

                    <div class="row mt-1">
                      <div class="col-sm-12">

                        <h6 class="text-primary font_uppercase">Payments To</h6>
                        <div class="col-sm-12 mt-1">
                          <span class="font_design font_uppercase">

                            <?php if (!empty($customer_id)): ?>

                             <?= isset($customer->shop_name)?$customer->shop_name:'' ?>

                             <?php else: ?>

                               All

                            <?php endif; ?>
                          </span>
                        </div>
                        <div class="col-sm-12">
                          <label id="customer_address">

                            <?php if (!empty($customer_id)): ?>

                             <?= isset($customer->address)?$customer->address:'' ?>

                            <?php endif; ?>

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


    <!-- confirmation modal -->
    <div class="modal fade" id="ConfirmationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-body">
                  <p>Are you sure you want to send?</p>
              </div>
              <div class="modal-footer">
                  <button type="button" class="btn btn-sm btn-primary" id="sendPdfToCustomer" data-type="">Yes</button>
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

      $('#send_sheet_to_whtaspp,#send_mail_to_customer').click(function () {

        let type = $(this).attr('data-type')

        $('#sendPdfToCustomer').attr('data-type',type)

        $('#ConfirmationModal').modal('show')

      })

      $('#print_customer_payments').click(function () {

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

        $('#ConfirmationModal').modal('hide')

        let type = $(this).attr('data-type')
        let customer_id = $('input[name=customer_id]').val()
        let from_date = $('input[name=from_date]').val()
        let to_date = $('input[name=to_date]').val()

        // send mail / whtsapp
        $.ajax({
          url : "<?= site_url('AjaxController/sendPaymentsInPdfToCustomer')?>",
          type : 'post',
          data : {customer_id : customer_id,from_date : from_date,to_date : to_date,type : type},
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
