<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Setting','url' => 'company_setting'],
          ['label'=>'Company Setting']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form class="row g-3" action="<?= site_url('save_company_setting') ?>" method="post" id="myForm" data-parsley-validate enctype="multipart/form-data">
                <div class="row mt-4">

                  <div class="col-sm-3">

                       <div class="row">
                         <div class="col-sm-12">
                           <?php
                             //check image is exist in folder or not
                             if (@getimagesize(base_url('uploads/company_logo/'.$company_setting->logo)) && !empty($company_setting->logo))
                             {
                                  $logo_url = base_url('uploads/company_logo/'.$company_setting->logo);
                             }
                             else
                             {
                                 $logo_url = base_url('assets/images/evidence_demo.png');
                             }

                            ?>
                           <img src="<?= $logo_url ?>" class="img-thumbnail user-form-img" alt="..." style="border-radius:0px!important;">
                           <input type="file" class="choose_img" name="img" accept="image/*" capture style="display:none;">
                           <input type="hidden" name="old_img" value="<?= isset($company_setting->logo)?$company_setting->logo:'' ?>">
                         </div>
                         <div class="col-sm-12 mt-4" style="margin-left:5px;">
                           <button type="button" class="btn btn-sm btn-outline-primary select_img_">Upload Logo</button>
                         </div>
                       </div>


                  </div>
                </div>
                      <div class="row mt-3">

                        <?php

                          echo getInputField([
                            'label' => 'Title',
                            'name' => 'title',
                            'value' => isset($company_setting->name)?$company_setting->name:''
                          ]);

                          ?>

                      </div>
                      <div class="row">

                        <?php

                          echo getTextareaField([
                            'label' => 'Address',
                            'name' => 'address',
                            'value' => isset($company_setting->address)?$company_setting->address:''
                          ]);

                          ?>

                      </div>
                      <div class="row">
                        <?php

                          echo getTextareaField([
                            'label' => 'Terms & Condition',
                            'name' => 'terms_and_condition',
                            'value' => isset($company_setting->terms_and_condition)?$company_setting->terms_and_condition:''
                          ]);

                        ?>
                      </div>
                      <div class="row mt-1">

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
