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

        /* details circular img */
				.details-circular-img {
				  width: 235px;
				  height: 235px;
				  border-radius: 50%;
				  position: relative;
				  overflow: hidden;
					margin:auto;
				}
				.details-circular-img img {
				  min-width: 235px;
				  min-height: 235px;
				  width: auto;
				  height: 100%;
				  position: absolute;
				  background-size: 100%;
				  left: 50%;
				  top: 50%;
				  -webkit-transform: translate(-50%, -50%);
				  -moz-transform: translate(-50%, -50%);
				  -ms-transform: translate(-50%, -50%);
				  transform: translate(-50%, -50%);
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
  <body onload="window.print()">

    <div class="row">
        <div class="col-sm-12 col-lg-12">
          <div class="card">
             <div class="card-header d-flex justify-content-between" style="background: #f5f6fa!important;">
                <div class="header-title" style="margin-bottom: 25px!important;">
                   <h3 class="card-title"><?= $page_title ?></h3>
                 </div>
                   <span>

                       <a href="javascript:void(0)" class="btn btn-sm btn-primary hide_content" id="print_customer_payments" onClick="window.print()">Print</a>

                   </span>
             </div>
             <div class="card-body">
               <div class="row mt-5">
                 <div class="col-sm-12 text-center">

                       <div class="details-circular-img">

                         <?php

                           $folder = strtolower($type);

                           echo getHiddenField('evidence_img_path',base_url('uploads/'.$folder.'/'.$evidence->img));

                           if (!empty($evidence->img))
                           {
                               echo '<img src="'. base_url('uploads/'.$folder.'/'.$evidence->img) .'" alt="...">';
                           }
                           else
                           {
                               echo '<img src="'. base_url('assets/images/evidence_demo.png') .'" alt="...">';
                           }

                        ?>

                       </div>

                 </div>
                 <div class="col-sm-12 mb-4">
                   <table width="30%">
                     <tr>
                       <td>Shop Name:</td>

                        <th><?= $evidence->shop_name ?></th>

                     </tr>
                     <tr>
                       <td>Added By:</td>

                        <th><?= $evidence->added_by_name ?></th>

                     </tr>
                     <tr>
                       <td>Added At:</td>

                        <th><?= date('d-m-Y,H:i a',strtotime($evidence->added_at)); ?></th>

                     </tr>
                     <tr>
                       <td>Comment:</td>

                        <th><?= $evidence->comment ?></th>

                     </tr>
                   </table>
                 </div>
               </div>
             </div>
          </div>
        </div>
    </div>

  </body>
</html>
