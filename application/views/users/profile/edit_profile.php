<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Edit Profile']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title"><?= $page_head ?></h4>
               </div>
            </div>
            <div class="card-body">
                <form class="row g-3" action="<?= site_url('update_profile') ?>" method="post" id="myForm" data-parsley-validate enctype="multipart/form-data">
                <div class="row mt-4">

                    <div class="col-sm-2">


                        <?php

                          $type = strtolower($user->type);
                          //check image is exist in folder or not
                          if (@getimagesize(base_url('uploads/'.$type.'/'.$user->img)) && !empty($user->img))
                          {
                              echo getImgField([
                                'img_url' => base_url('uploads/'.$type.'/'.$user->img)
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

                      echo getHiddenField('ID',$user->id);
                      echo getHiddenField('old_img',$user->img);
                      echo getHiddenField('old_email',$user->email);
                      echo getHiddenField('old_username',$user->username);
                      echo getHiddenField('type',$type);

                      echo getInputField([
                        'label' => 'Name',
                        'name' => 'name',
                        'value' => $user->name
                      ]);
                      echo getInputField([
                        'label' => 'Email',
                        'name' => 'email',
                        'type' => 'email',
                        'value' => $user->email,
                        'required' => false
                      ]);
                      echo getInputField([
                        'label' => 'Username',
                        'name' => 'username',
                        'value' => $user->username
                      ]);
                      echo getInputField([
                        'label' => 'Password',
                        'name' => 'password',
                        'type' => 'password',
                        'value' => $this->encryption->decrypt($user->password)
                      ]);
                      echo getInputField([
                        'label' => 'Contact #',
                        'name' => 'contact_no',
                        'type' => 'number',
                        'value' => $user->contact_no
                      ]);

                      if($type == 'driver' || $type == 'other')
                      {

                        echo getInputField([
                          'label' => 'License #',
                          'name' => 'license_no',
                          'required' => false,
                          'value' => $user->license_no
                        ]);

                      }

                      if($type != 'admin')
                      {

                        echo getInputField([
                          'label' => 'FIN #',
                          'name' => 'fin_no',
                          'value' => $user->fin_no
                        ]);

                      }

                      if($type == 'driver' || $type == 'other')
                      {

                        echo getInputField([
                          'label' => 'Car Plate',
                          'name' => 'car_plate',
                          'value' => $user->car_plate
                        ]);

                      }

                      echo getInputField([
                        'label' => 'Date Of Birth',
                        'name' => 'dob',
                        'type' => 'date',
                        'required' => false,
                        'value' => $user->dob
                      ]);
                      echo getInputField([
                        'label' => 'Country',
                        'name' => 'country',
                        'required' => false,
                        'value' => $user->country
                      ]);
                      echo getInputField([
                        'label' => 'City',
                        'name' => 'city',
                        'required' => false,
                        'value' => $user->city
                      ]);
                      echo getInputField([
                        'label' => 'Zip Code',
                        'name' => 'zip_code',
                        'required' => false,
                        'value' => $user->zip_code == 0?'':$user->zip_code
                      ]);


                      ?>
                    </div>
                    <div class="row">
                    <?php

                        echo getTextareaField([
                          'label' => 'Residential Address',
                          'name' => 'address',
                          'required' => false,
                          'value' => $user->address
                        ]);

                          echo getSubmitBtn('Update Profile');

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
