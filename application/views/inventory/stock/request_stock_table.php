
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Evidence']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">

                 <h4 class="card-title"><?= $page_head ?></h4>
               </div>
               <?php
               echo getHiddenField('ajax_url',$ajax_url);
               echo getHiddenField('saveEvidence',base_url('Evidence/saveEvidence'));
               echo getHiddenField('edit_evidence',site_url('Evidence/editEvidence'));
               ?>

               <?php if (isUserAllow(62)): ?>

               <a href="javascript:void(0)" id="create_evidence" class="btn btn-sm btn-primary">Add Evidence</a>

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
                           <th>Shop Name</th>
                           <th>Image</th>
                           <th>Comment</th>
                           <th>Added By </th>
                           <th>Added At </th>
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
 include(APPPATH.'views/evidence/modals/create_modal.php');
 include(APPPATH.'views/evidence/modals/edit_modal.php');
 include(APPPATH.'views/modals/delete_ajax_modal.php');
 include(APPPATH.'views/modals/view-details-modal.php');
  ?>
