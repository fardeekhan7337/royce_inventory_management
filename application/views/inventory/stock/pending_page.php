
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Inventory','url' => 'pending_request'],
          ['label'=>'Pending Requests']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                 <?php
                  echo getHiddenField('ajax_url',$ajax_url);
                  echo getHiddenField('ajax_url1',$ajax_url1);
                 ?>
                 <h4 class="card-title"><?= $page_head ?></h4>
               </div>

            </div>
            <div class="card-body">
              <div class="row">

                <div class="col-sm-12">
                  <div class="btn-group" role="group" aria-label="Basic example" style="margin-bottom:32px!important">
                    <button type="button" class="btn btn-sm btn-outline-primary active request_tab_" data-type="driver">Delivery Order</button>
                    <button type="button" class="btn btn-sm btn-outline-primary request_tab_" data-type="call_order">Call Order</button>
                  </div>
                </div>
              </div>
              <div class="table-responsive driver_requests tabs_table">
                 <table id="driverRequests" class="table">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th>Actions</th>
                          <th>Driver</th>
                          <th>Total Products</th>
                          <th>Total Quantity</th>
                          <th>Status</th>
                       </tr>
                    </thead>
                    <tbody></tbody>
                 </table>
              </div>
              <div class="table-responsive call_order_requests tabs_table" style="display:none">
                 <table id="callOrderRequests" class="table">
                    <thead>
                       <tr>
                          <th>#</th>
                          <th>Actions</th>
                          <th>Customer</th>
                          <th>Driver</th>
                          <th>Day</th>
                          <th>Total Products</th>
                          <th>Total Quantity</th>
                          <th>Status</th>
                       </tr>
                    </thead>
                    <tbody>
                      <tr>
                         <td>1</td>
                         <td>
                             Customer
                         </td>
                         <td>
                             Driver
                         </td>
                         <td>
                             Monday
                         </td>
                         <td>10</td>
                         <td>50</td>
                         <td>
                           <a href="javascript:void(0)" class="changeUser_status_" data-type-msg="" data-type-status="confirm">

                                 <span class="badge rounded-pill bg-secondary">Pending</span>
                           </a>
                         </td>
                         <td>
                           <span class="actions-icons">
                             <a href="javascript:void(0)" class="action-icons delete_record_" data-type-msg="Pending Request" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Delete">
                               <i class="fa-solid fa-trash"></i>
                             </a>
                             <a href="javascript:void(0)" class="action-icons view_details_" data-url="<?= site_url('AjaxController/getPendingPageStockDetails/1/call_order') ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="View Details">
                               <i class="fa fa-eye"></i>
                             </a>
                           </span>
                         </td>
                      </tr>

                    </tbody>
                 </table>
              </div>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
include(APPPATH.'views/inventory/modals/status_modal.php');
include(APPPATH.'views/modals/delete-modal.php');
include(APPPATH.'views/modals/view-details-modal.php');
?>
