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
                ['label'=>'Edit Admin']
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

                        //check image is exist in folder or not
                        if (@getimagesize(base_url('uploads/admin/'.$admin->img)) && !empty($admin->img))
                        {
                            echo getImgField([
                              'img_url' => base_url('uploads/admin/'.$admin->img)
                            ]);
                        }
                        else
                        {
                            echo getImgField();
                        }

                       ?>

                    </div>
                    <div class="col-sm-10 form-col-padding">
                      <div class="row">

                        <?php

                        echo getHiddenField('ID',$admin->id);
                        echo getHiddenField('old_img',$admin->img);
                        echo getHiddenField('old_email',$admin->email);
                        echo getHiddenField('old_username',$admin->username);

                        echo getInputField([
                          'label' => 'Name',
                          'name' => 'name',
                          'value' => $admin->name
                        ]);
                        echo getInputField([
                          'label' => 'Email',
                          'name' => 'email',
                          'type' => 'email',
                          'value' => $admin->email
                        ]);
                        echo getInputField([
                          'label' => 'Username',
                          'name' => 'username',
                          'value' => $admin->username
                        ]);
                        echo getInputField([
                          'label' => 'Password',
                          'name' => 'password',
                          'type' => 'password',
                          'value' => $this->encryption->decrypt($admin->password)
                        ]);
                        echo getInputField([
                          'label' => 'Contact #',
                          'name' => 'contact_no',
                          'type' => 'number',
                          'value' => $admin->contact_no
                        ]);
                        echo getInputField([
                          'label' => 'Date Of Birth',
                          'name' => 'dob',
                          'type' => 'date',
                          'required' => false,
                          'value' => $admin->dob
                        ]);
                        echo getInputField([
                          'label' => 'Country',
                          'name' => 'country',
                          'required' => false,
                          'value' => $admin->country
                        ]);
                        echo getInputField([
                          'label' => 'City',
                          'name' => 'city',
                          'required' => false,
                          'value' => $admin->city
                        ]);
                        echo getInputField([
                          'label' => 'Zip Code',
                          'name' => 'zip_code',
                          'required' => false,
                          'value' => $admin->zip_code == 0?'':$admin->zip_code
                        ]);
                        ?>
                    </div>
                    <div class="row">
                    <?php
                        echo getTextareaField([
                          'label' => 'Residential Address',
                          'name' => 'address',
                          'required' => false,
                          'value' => $admin->address
                        ]);

                          echo getSubmitBtn('Update Admin');

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
