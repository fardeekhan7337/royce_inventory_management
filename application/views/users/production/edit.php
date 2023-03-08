<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'Users','url' => 'productions'],
          ['label'=>'Production Users','url' => 'productions'],
          ['label'=>'Edit Production User']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h3 class="card-title"><?= $page_head ?></h3>
               </div>
            </div>
            <div class="card-body">
                <form class="row g-3" action="<?= site_url('save_production') ?>" method="post" id="myForm" data-parsley-validate enctype="multipart/form-data">
                <div class="row mt-4">

                    <div class="col-sm-2">


                      <?php

                        //check image is exist in folder or not
                        if (@getimagesize(base_url('uploads/production/'.$production->img)) && !empty($production->img))
                        {
                            echo getImgField([
                              'img_url' => base_url('uploads/production/'.$production->img)
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

                            echo getHiddenField('ID',$production->id);
                            echo getHiddenField('old_img',$production->img);
                            echo getHiddenField('old_email',$production->email);
                            echo getHiddenField('old_username',$production->username);

                            echo getInputField([
                              'label' => 'Name',
                              'name' => 'name',
                              'value' => $production->name
                            ]);
                            echo getInputField([
                              'label' => 'Email',
                              'name' => 'email',
                              'type' => 'email',
                              'value' => $production->email,
                              'required' => false
                            ]);
                            echo getInputField([
                              'label' => 'Username',
                              'name' => 'username',
                              'value' => $production->username
                            ]);
                            echo getInputField([
                              'label' => 'Password',
                              'name' => 'password',
                              'type' => 'password',
                              'value' => $this->encryption->decrypt($production->password)
                            ]);
                            echo getInputField([
                              'label' => 'Contact #',
                              'name' => 'contact_no',
                              'type' => 'number',
                              'value' => $production->contact_no
                            ]);
                            echo getInputField([
                              'label' => 'FIN #',
                              'name' => 'fin_no',
                              'value' => $production->fin_no
                            ]);
                            echo getInputField([
                              'label' => 'Date Of Birth',
                              'name' => 'dob',
                              'type' => 'date',
                              'required' => false,
                              'value' => $production->dob
                            ]);
                            echo getInputField([
                              'label' => 'Country',
                              'name' => 'country',
                              'required' => false,
                              'value' => $production->country
                            ]);
                            echo getInputField([
                              'label' => 'City',
                              'name' => 'city',
                              'required' => false,
                              'value' => $production->city
                            ]);
                            echo getInputField([
                              'label' => 'Zip Code',
                              'name' => 'zip_code',
                              'required' => false,
                              'value' => $production->zip_code == 0?'':$production->zip_code
                            ]);

                            echo getTextareaField([
                              'label' => 'Residential Address',
                              'name' => 'address',
                              'required' => false,
                              'value' => $production->address
                            ]);

                            echo getSubmitBtn('Update Production User');

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
