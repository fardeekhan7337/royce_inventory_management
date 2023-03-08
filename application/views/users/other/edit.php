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
            ['label'=>'Edit Other User']
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

                        //check image is exist in folder or not
                        if (@getimagesize(base_url('uploads/other_user/'.$otherUser->img)) && !empty($otherUser->img))
                        {
                            echo getImgField([
                              'img_url' => base_url('uploads/other_user/'.$otherUser->img)
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

                        echo getHiddenField('ID',$otherUser->id);
                        echo getHiddenField('old_img',$otherUser->img);
                        echo getHiddenField('old_email',$otherUser->email);
                        echo getHiddenField('old_username',$otherUser->username);

                        echo getInputField([
                          'label' => 'Name',
                          'name' => 'name',
                          'value' => $otherUser->name
                        ]);
                        echo getInputField([
                          'label' => 'Email',
                          'name' => 'email',
                          'type' => 'email',
                          'value' => $otherUser->email,
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Username',
                          'name' => 'username',
                          'value' => $otherUser->username
                        ]);
                        echo getInputField([
                          'label' => 'Password',
                          'name' => 'password',
                          'type' => 'password',
                          'value' => $this->encryption->decrypt($otherUser->password)
                        ]);
                        echo getInputField([
                          'label' => 'Contact #',
                          'name' => 'contact_no',
                          'type' => 'number',
                          'value' => $otherUser->contact_no
                        ]);
                        echo getInputField([
                          'label' => 'License #',
                          'name' => 'license_no',
                          'required' => false,
                          'value' => $otherUser->license_no
                        ]);
                        echo getInputField([
                          'label' => 'FIN #',
                          'name' => 'fin_no',
                          'required' => false,
                          'value' => $otherUser->fin_no
                        ]);
                        echo getInputField([
                          'label' => 'Car Plate',
                          'name' => 'car_plate',
                          'required' => false,
                          'value' => $otherUser->car_plate
                        ]);
                        echo getInputField([
                          'label' => 'Date Of Birth',
                          'name' => 'dob',
                          'type' => 'date',
                          'required' => false,
                          'value' => $otherUser->dob
                        ]);
                        echo getInputField([
                          'label' => 'Country',
                          'name' => 'country',
                          'required' => false,
                          'value' => $otherUser->country
                        ]);
                        echo getInputField([
                          'label' => 'City',
                          'name' => 'city',
                          'required' => false,
                          'value' => $otherUser->city
                        ]);
                        echo getInputField([
                          'label' => 'Zip Code',
                          'name' => 'zip_code',
                          'required' => false,
                          'value' => $otherUser->zip_code == 0?'':$otherUser->zip_code
                        ]);

                        echo getTextareaField([
                          'label' => 'Residential Address',
                          'name' => 'address',
                          'required' => false,
                          'value' => $otherUser->address
                        ]);

                          echo getSubmitBtn('Update Other User');

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
