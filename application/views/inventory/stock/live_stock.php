
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'live_stock'],
          ['label'=>'Live Stock']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">

                 <?=
                  getHiddenField('ajax_url',$ajax_url);
                 ?>
                 <h4 class="card-title"><?= $page_head ?></h4>
               </div>

            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="myDataTable" class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th class="dnr">Action</th>
                           <th>Driver</th>
                           <th>Total Products</th>
                           <th>Total Assign Qty</th>
                           <th>Total Sold Qty</th>
                           <th>Total Remaining Qty</th>
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
include(APPPATH.'views/modals/view-details-modal.php');
 ?>
