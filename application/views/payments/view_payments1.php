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
               <div class="row">
                 <div class="col-sm-12 mb-4">
                   <table width="30%">
                     <tr>
                       <td>Customer:</td>

                       <?php if (!empty($customer_id)): ?>

                         <th><?= isset($customer->name)?$customer->name:'' ?></th>

                         <?php else: ?>

                           <th>All</th>

                        <?php endif; ?>

                     </tr>
                     <tr>
                       <td>Date From:</td>
                       <th><?= $from != ''?getDateTimeFormat($from,'date'):'All' ?></th>
                     </tr>
                     <tr>
                       <td>Date To:</td>
                       <th><?= $to != ''?getDateTimeFormat($to,'date'):'All' ?></th>
                     </tr>
                   </table>
                 </div>
               </div>
                <div class="table-responsive">
                   <table class="table">
                      <thead>
                         <tr>
                            <th>#</th>
                            <th>Invoice No#</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Debit</th>
                            <th>Credit</th>
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

                             <td><?= $v->amount ?></td>
                             <td>0</td>

                             <?php else: ?>

                             <td>0</td>
                             <td><?= $v->amount ?></td>

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
