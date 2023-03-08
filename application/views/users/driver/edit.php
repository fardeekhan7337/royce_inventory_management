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
                ['label'=>'Users','url' => 'drivers'],
                ['label'=>'Drivers','url' => 'drivers'],
                ['label'=>'Edit Driver']
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
              <form class="row g-3" action="<?= site_url('save_driver') ?>" method="post" id="myForm" data-parsley-validate enctype="multipart/form-data">
                <div class="row mt-4">

                    <div class="col-sm-2">


                      <?php

                      //check image is exist in folder or not
                      if (@getimagesize(base_url('uploads/driver/'.$driver->img)) && !empty($driver->img))
                      {
                          echo getImgField([
                            'img_url' => base_url('uploads/driver/'.$driver->img)
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

                        echo getHiddenField('ID',$driver->id);
                        echo getHiddenField('old_img',$driver->img);
                        echo getHiddenField('old_email',$driver->email);
                        echo getHiddenField('old_username',$driver->username);

                        echo getInputField([
                          'label' => 'Name',
                          'name' => 'name',
                          'value' => $driver->name
                        ]);
                        echo getInputField([
                          'label' => 'Email',
                          'name' => 'email',
                          'type' => 'email',
                          'value' => $driver->email,
                          'required' => false
                        ]);
                        echo getInputField([
                          'label' => 'Username',
                          'name' => 'username',
                          'value' => $driver->username
                        ]);
                        echo getInputField([
                          'label' => 'Password',
                          'name' => 'password',
                          'type' => 'password',
                          'value' => $this->encryption->decrypt($driver->password)
                        ]);
                        echo getInputField([
                          'label' => 'Contact #',
                          'name' => 'contact_no',
                          'type' => 'number',
                          'value' => $driver->contact_no
                        ]);
                        echo getInputField([
                          'label' => 'License #',
                          'name' => 'license_no',
                          'required' => false,
                          'value' => $driver->license_no
                        ]);
                        echo getInputField([
                          'label' => 'FIN #',
                          'name' => 'fin_no',
                          'value' => $driver->fin_no
                        ]);
                        echo getInputField([
                          'label' => 'Car Plate',
                          'name' => 'car_plate',
                          'value' => $driver->car_plate
                        ]);
                        echo getInputField([
                          'label' => 'Date Of Birth',
                          'name' => 'dob',
                          'type' => 'date',
                          'required' => false,
                          'value' => $driver->dob
                        ]);
                        echo getInputField([
                          'label' => 'Country',
                          'name' => 'country',
                          'required' => false,
                          'value' => $driver->country
                        ]);
                        echo getInputField([
                          'label' => 'City',
                          'name' => 'city',
                          'required' => false,
                          'value' => $driver->city
                        ]);
                        echo getInputField([
                          'label' => 'Zip Code',
                          'name' => 'zip_code',
                          'required' => false,
                          'value' => $driver->zip_code == 0?'':$driver->zip_code
                        ]);

                        echo getTextareaField([
                          'label' => 'Residential Address',
                          'name' => 'address',
                          'required' => false,
                          'value' => $driver->address
                        ]);

                        echo getSubmitBtn('Update Driver');

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
