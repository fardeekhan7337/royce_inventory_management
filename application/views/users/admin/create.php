<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">

        <div class="row">

            <div class="col-sm-12">

              <?=
              showBreadCumbs([
                ['label'=>'Home','url' => 'dashboard'],
                ['label'=>'Users','url' => 'admins'],
                ['label'=>'Admins','url' => 'admins'],
                ['label'=>'Add Admin']
              ])
              ?>

            </div>

        </div>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
              <form class="row g-3" action="<?= site_url('save_admin') ?>" method="post" id="myForm" data-parsley-validate enctype="multipart/form-data">
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
                          'type' => 'email'
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
                        ?>
                    </div>
                    <div class="row">
                    <?php
                        echo getTextareaField([
                          'label' => 'Residential Address',
                          'name' => 'address',
                          'required' => false
                        ]);

                          echo getSubmitBtn('Add Admin');

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
