<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'DB Export']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>

               <a href="javascript:void(0)" class="btn btn-sm btn-primary ">Export</a>

            </div>
            <div class="card-body">
              <form class="row g-3 needs-validation" novalidate>
                <div class="row mt-2">

                  <div class="col-sm-12">

                      <div class="row">
                        <div class="col-sm-12">
                          <span class="text-danger">Note: </span>
                          <span>The Exported file is the backup of the Database in order to import it please follow these</span>
                          <span class="text-primary">instructions.</span>
                          <input type="file" class="choose_img" name="img" style="display:none;">
                        </div>
                        <div class="col-sm-12">
                          <button type="button" class="btn btn-sm btn-outline-primary select_img_">Choose File</button>
                        </div>
                      </div>

                  </div>

                </div>
                  <div class="row mt-5">

                      <?php

                        echo getSubmitBtn('Submit');

                      ?>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
</div>

<?php
include(APPPATH.'views/payments/add_payment_modal.php');
 ?>
