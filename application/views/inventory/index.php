
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'view_inventory'],
          ['label'=>'View Inventory']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">

               <div class="header-title">

                 <?php

                   echo getHiddenField('available_inv',$ajax_url.'/available');
                   echo getHiddenField('missing_inv',$ajax_url.'/missing');
                   echo getHiddenField('return_inv',$ajax_url.'/return');
                   echo getHiddenField('exchange_inv',$ajax_url.'/exchange');
                   echo getHiddenField('print_inv',site_url('AjaxController/printInventoryDetails'));

                 ?>

                 <h4 class="card-title"><?= $page_head ?></h4>

               </div>

               <div class="row">

                 <div class="col-sm-12">

                   <span>
                     <?php if (isUserAllow(37)): ?>

                     <a href="javascript:void(0)" class="btn btn-sm btn-primary" id="add_stock_" data-redirect="view_inventory">Add Stock</a>
                   <?php endif; ?>

                    <?php if (isUserAllow(41)): ?>

                     <a href="javascript:void(0)" class="btn btn-sm btn-warning" id="return_stock_">Return Stock</a>
                   <?php endif; ?>

                   <?php if (isUserAllow(40)): ?>

                     <a href="javascript:void(0)" class="btn btn-sm btn-success" id="assign_stock_to_driver_">Assign Stock To Driver</a>
                   <?php endif; ?>
                        <a href="javascript:void(0)" class="btn btn-sm btn-info" id="print_inventory_details">Print Inventory</a>
                   </span>

                 </div>
               </div>

            </div>
            <div class="card-body">
              <div class="row">

                <div class="col-sm-12">
                  <div class="btn-group" role="group" aria-label="Basic example" style="margin-bottom:32px!important">
                    <button type="button" class="btn btn-sm btn-outline-primary active inv_tabs_" data-type="available">Available</button>
                    <button type="button" class="btn btn-sm btn-outline-primary inv_tabs_" data-type="missing">Missing</button>
                    <button type="button" class="btn btn-sm btn-outline-primary inv_tabs_" data-type="return">Return</button>
                    <button type="button" class="btn btn-sm btn-outline-primary inv_tabs_" data-type="exchange">Exchange</button>
                  </div>
                </div>
              </div>
              <div class="table-responsive tabs_table available_table_">
                 <table id="invAvailableDataTable" class="table">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th class="dnr">Action</th>
                          <th style="width:60%">Product Name</th>
                          <th>Available Qty</th>
                       </tr>
                    </thead>
                    <tbody></tbody>
                 </table>
              </div>
              <div class="table-responsive tabs_table missing_table_" style="display:none">
                 <table id="invMissingDataTable" class="table">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th class="dnr">Action</th>
                          <th style="width:60%">Product Name</th>
                          <th>Missing Qty</th>
                       </tr>
                    </thead>
                    <tbody></tbody>
                 </table>
              </div>
              <div class="table-responsive tabs_table return_table_" style="display:none">
                 <table id="invReturnDataTable" class="table">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th class="dnr">Action</th>
                          <th style="width:60%">Product Name</th>
                          <th>Return Qty</th>
                       </tr>
                    </thead>
                    <tbody></tbody>
                 </table>
              </div>
              <div class="table-responsive tabs_table exchange_table_" style="display:none">
                 <table id="invExchangeDataTable" class="table">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th class="dnr">Action</th>
                          <th style="width:60%">Product Name</th>
                          <th>Exchange Qty</th>
                       </tr>
                    </thead>
                    <tbody></tbody>
                 </table>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
include(APPPATH.'views/inventory/modals/add_stock.php');
include(APPPATH.'views/inventory/modals/return_stock.php');
include(APPPATH.'views/inventory/modals/assign_stock_to_driver.php');
include(APPPATH.'views/inventory/modals/view_details_modal.php');
 ?>
