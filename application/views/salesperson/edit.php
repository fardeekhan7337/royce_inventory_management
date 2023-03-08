<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Salesperson','url' => 'salesperson'],
          ['label'=>'Edit Salesperson ']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
            <form class="row g-3" action="<?= site_url('save_salesperson') ?>" id="myForm" data-parsley-validate method="post">
                <div class="row mt-4">

                    <div class="col-sm-12">
                      <div class="row">

                        <?php

                          echo getHiddenField('ID',$salesperson->id);

                          echo getInputField([
                              'label' => 'Name',
                              'name' => 'name',
                              'value' => $salesperson->name
                            ]);
                          echo getInputField([
                              'label' => 'Contact #',
                              'name' => 'contact_no',
                              'type' => 'number',
                              'value' => $salesperson->contact_no
                            ]);
                          echo getInputField([
                              'label' => 'Email Address',
                              'name' => 'email',
                              'type' => 'email',
                              'value' => $salesperson->email
                            ]);

                            echo getTextareaField([
                              'label' => 'Address',
                              'name' => 'address',
                              'required' => false,
                              'value' => $salesperson->address
                            ]);

                            echo getSubmitBtn('Update Salesperson');

                          ?>
                      </div>
                    </div>

                </div>

               </form>
            </div>
         </div>
      </div>
   </div>
</div>
