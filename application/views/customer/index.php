
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Customers']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">

                 <h4 class="card-title"><?= $page_head ?></h4>
               </div>
               <?php
               echo getHiddenField('ajax_url',$ajax_url);
               echo getHiddenField('update_product_price_url',site_url('Customer/update_products_price'));
               echo getHiddenField('saveCustomer',site_url('Customer/saveCustomer'));
               echo getHiddenField('edit_customer',site_url('Customer/editCustomer'));
               ?>

               <?php if (isUserAllow(31)): ?>

                 <a href="javascript:void(0)" id="create_customer" class="btn btn-sm btn-primary">Add Customer</a>

                <?php endif; ?>

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
                           <th class="dnr">Actions</th>
                           <th>Name</th>
                           <th>Day</th>
                           <th>Driver</th>
                           <th>Shop Name</th>
                           <th>Shop Acronym</th>
                           <th>Shop ID</th>
                           <th>Primary Contact </th>
                           <th>Secondary Contact </th>
                           <th>Email For E-receipt </th>
                           <th>Payment Type</th>
                           <th>Address</th>
                           <th>Salesperson </th>
                           <th>Added At</th>
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
 include(APPPATH.'views/customer/modals/create_modal.php');
 include(APPPATH.'views/customer/modals/edit_modal.php');
 include(APPPATH.'views/modals/delete_ajax_modal.php');
 include(APPPATH.'views/modals/view-details-modal.php');
 include(APPPATH.'views/customer/customer_products.php');
  ?>
