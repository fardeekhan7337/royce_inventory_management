<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
          <?=
          showBreadCumbs([
            ['label'=>'Home','url' => 'dashboard'],
            ['label'=>'Users','url' => 'other_users'],
            ['label'=>'Other Users','url' => 'other_users'],
            ['label'=>'Add Other User']
          ])
          ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form class="row g-3" action="<?= site_url('save_other_user') ?>" method="post" id="myForm" data-parsley-validate enctype="multipart/form-data">
                <div class="row mt-4">

                    <div class="col-sm-2">


                      <?php

                        echo getImgField();

                       ?>


                    </div>
                    <div class="col-sm-10 form-col-padding">
                      <div class="row">

                        <?php

                        echo getInputField([
                          'label' => 'Name',
                          'name' => 'name'
                        ]);
                        echo getInputField([
                          'label' => 'Email',
                          'name' => 'email',
                          'type' => 'email',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Username',
                          'name' => 'username'
                        ]);
                        echo getInputField([
                          'label' => 'Password',
                          'name' => 'password',
                          'type' => 'password'
                        ]);
                        echo getInputField([
                          'label' => 'Contact #',
                          'name' => 'contact_no',
                          'type' => 'number'
                        ]);
                        echo getInputField([
                          'label' => 'License #',
                          'name' => 'license_no',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'FIN #',
                          'name' => 'fin_no',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Car Plate',
                          'name' => 'car_plate',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Date Of Birth',
                          'name' => 'dob',
                          'type' => 'date',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Country',
                          'name' => 'country',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'City',
                          'name' => 'city',
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Zip Code',
                          'name' => 'zip_code',
                          'required' => false
                        ]);

                        echo getTextareaField([
                          'label' => 'Residential Address',
                          'name' => 'address',
                          'required' => false
                        ]);

                          echo getSubmitBtn('Add Other User');

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
