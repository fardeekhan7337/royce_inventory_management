
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Invoices']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">

                 <?php

                  echo getHiddenField('invoice_url',site_url('Invoice/getAllInvoices'));
                  echo getHiddenField('print_invoices_url',site_url('AjaxController/printMultipleInvoices'));
                  echo getHiddenField('print_filter_invoices',site_url('AjaxController/printFilterInvoices'));

                 ?>

                 <h4 class="card-title"><?= $page_head ?></h4>
               </div>

            </div>
            <div class="card-body">

              <form class="row g-3" id="filter_invoice_">
                <div class="row mt-4">

                    <div class="col-sm-12">
                      <h5 class="text-primary">Filters</h5>
                    </div>
                    <div class="col-sm-12 mt-3">
                      <div class="row">

                        <?php

                            echo getInputField([
                              'label' => 'Invoice No#',
                              'name' => 'invoice_no',
                              'id' => 'invoice_no',
                              'column' => 'sm-3',
                              'required' => false
                            ]);

                            echo getSelectField([
                              'label' => 'Customer',
                              'name' => 'customer_id',
                              'id' => 'customer_id',
                              'column' => 'sm-3',
                              'data' => $customers,
                              'required' => false
                            ]);

                            echo getSelectField([
                              'label' => 'Driver',
                              'name' => 'driver_id',
                              'id' => 'driver_id',
                              'column' => 'sm-3',
                              'data' => $drivers,
                              'required' => false
                            ]);

                            echo getSelectField([
                              'label' => 'Status',
                              'name' => 'status',
                              'id' => 'status',
                              'column' => 'sm-3',
                              'static' => true,
                              'data' => ['Paid','Unpaid','Credit','Pending'],
                              'required' => false
                            ]);

                            echo getSelectField([
                              'label' => 'Type',
                              'name' => 'type',
                              'id' => 'type',
                              'column' => 'sm-3',
                              'static' => true,
                              'data' => ['CA','T'],
                              'required' => false
                            ]);

                            echo getInputField([
                              'label' => 'From',
                              'name' => 'from',
                              'type' => 'date',
                              'id' => 'from',
                              'column' => 'sm-3',
                              'required' => false
                            ]);
                            echo getInputField([
                              'label' => 'To',
                              'name' => 'to',
                              'type' => 'date',
                              'id' => 'to',
                              'column' => 'sm-3',
                              'required' => false
                            ]);

                          ?>

                            <div class="col-sm-3">
                              <button type="submit" class="btn btn-sm btn-primary" style="margin-top: 32px!important;">Submit</button>
                            </div>

                        </div>
                      </div>
                </div>
              </form>
              <hr>
              <div class="row mt-3" id="invoices_">

              </div>


               <div class="row">

                 <div class="col-sm-3 mx-auto" id="pagination_">

                 </div>

               </div>

            </div>
         </div>
      </div>
   </div>
</div>

<?php
include(APPPATH.'views/modals/delete-modal.php');
include(APPPATH.'views/modals/view-details-modal.php');
 ?>
