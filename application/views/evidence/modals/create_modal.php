
<div class="modal fade create_evidence_modal" id="CreateModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-body">

          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="float:right!important"></button>

          <div class="container" id="create_modal_">


              <h3>Add Evidence</h3>

              <div class="row mt-3">
                  <div class="col-sm-12 col-lg-12">
                          <form class="row g-3" action="javascript:void(0)" method="post" id="CreateEvidence" data-parsley-validate enctype="multipart/form-data">
                            <div class="row mt-4">

                                <div class="col-sm-6">

                                     <div class="row">
                                       <div class="col-sm-12">
                                         <div class="details-circular-img" style="margin:inherit!important;">
                                           <img src="<?= base_url('assets/images/evidence_demo.png') ?>" class="user-form-img" alt="...">
                                         </div>
                                         <input type="file" class="choose_img" name="img" accept="image/*" capture style="display:none;">
                                       </div>
                                       <div class="col-sm-12 mt-4" style="margin-left:5px;">
                                         <button type="button" class="btn btn-sm btn-outline-primary select_img_">Upload Photo</button>
                                       </div>
                                     </div>


                                </div>
                            </div>
                                  <div class="row mt-3">

                                    <?php

                                      echo getSelectField([
                                        'label' => 'Shop',
                                        'name' => 'shop_id',
                                        'classes' => 'modal_select_customer_',
                                        'column' => 'sm-10',
                                        'data' => $customers
                                      ]);
                                      ?>

                                  </div>
                                  <div class="row mt-1">

                                      <?php
                                        echo getTextareaField([
                                          'label' => 'Comment',
                                          'name' => 'comment',
                                          'column' => 'sm-10',
                                          'required' => false
                                        ]);

                                        echo getSubmitBtn('Add Evidence');

                                      ?>
                                  </div>
                           </form>
                  </div>
               </div>


          </div>
        </div>
    </div>
</div>
</div>
