
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Sales']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">

                 <h4 class="card-title"><?= $page_head ?></h4>
               </div>
               <?php
               echo getHiddenField('ajax_url',$ajax_url);
               echo getHiddenField('update_satatu_url',site_url('sales_status_update'));
               ?>

               <div class="row">

                 <div class="col-sm-12">

                   <span>
                     <?php if (isUserAllow(48)): ?>

                       <a href="<?= site_url('add_sale') ?>" class="btn btn-sm btn-primary">Add Sale</a>

                       <a href="<?= site_url('sale_call_order') ?>" class="btn btn-sm btn-warning">Add Call Order Sale</a>

                   <?php endif; ?>


                 </div>
               </div>

            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-sm-2 mb-3">

                  <label for="pageList" class="form-label">Page No#</label>

                  <select class="form-select form-select-sm select2" data-width="100%" name="pageList" id="pageList">
                  </select>

                </div>
              </div>
               <div class="table-responsive">
                  <table id="myDataTable" class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th class="dnr">Action</th>
                           <th>Salesperson</th>
                           <th>Shop Acronym</th>
                           <th>Created At</th>
                           <th>Category</th>
                           <th>Invoice #</th>
                           <th>Total Price</th>
                           <th>Sale Type</th>
                           <th>Driver</th>
                           <th>Total Product</th>
                           <th>Total Qty</th>
                           <th>Shop Name</th>
                           <th>Status</th>
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
include(APPPATH.'views/sales/status_modal.php');
include(APPPATH.'views/sales/history_modal.php');
include(APPPATH.'views/modals/delete-modal.php');
?>
