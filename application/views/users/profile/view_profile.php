<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0">
  <div class="row">
      <div class="col-sm-12 col-lg-12">
        <?=
        showBreadCumbs([
          ['label'=>'Home','url' => 'dashboard'],
          ['label'=>'View Profile']
        ])
        ?>
         <div class="card">
            <div class="card-header d-flex justify-content-between">
               <div class="header-title">
                  <h4 class="card-title"><?= $page_head ?></h4>
               </div>

            </div>
            <div class="card-body">
               <div class="row mt-4 mb-2">

                    <div class="col-sm-2">

                        <div class="row">
                          <div class="col-sm-12">
                            <div class="details-circular-img">
                            <?php

                            //check image is exist in folder or not
                            $type = $user->type;
                            $folder = strtolower($type);

                            if (@getimagesize(base_url('uploads/'.$folder.'/'.$user->img)) && !empty($user->img))
                            {
                                echo '<img src="'. base_url('uploads/'.$folder.'/'.$user->img) .'" class="user-form-img" alt="...">';
                            }
                            else
                            {
                                echo '<img src="'. base_url('assets/images/avatars/01.png') .'" class="img-thumbnail user-form-img" alt="...">';
                            }

                             ?>
                           </div>
                          </div>
                          <div class="col-sm-12" style="text-align: center;margin-top: 10px;">
                            <p class="view-details-txt"><span class="badge rounded-pill bg-secondary"><?= ucfirst($type) ?></span></p>
                          </div>
                        </div>

                    </div>
                </div>
                <div class="row">

                  <div class="col-sm-12">

                    <h5>Basic Information</h5>

                    <div class="row mt-3 mb-3">

                      <?php

                      if($type == 'admin' || $type == 'driver' || $type == 'other' || $type == 'production')
                      {

                        echo viewDetailsCol('Name',$user->name);
                        echo viewDetailsCol('Email',$user->email);
                        echo viewDetailsCol('Username',$user->username);
                        echo viewDetailsCol('Contact #',$user->contact_no);

                        if($type == 'driver' || $type == 'other')
                        {

                          echo viewDetailsCol('License #',$user->license_no);

                        }

                        if($type != 'admin')
                        {

                          echo viewDetailsCol('FIN #',$user->fin_no);

                        }

                        if($type == 'driver' || $type == 'other')
                        {

                          echo viewDetailsCol('Car Plate',$user->car_plate);

                        }

                        $badge_clr = $user->status == 1?'bg-secondary':'bg-success';
                        $status = $user->status == 1?'Deactivated':'Active';

                        $status_row = '<span class="badge rounded-pill '. $badge_clr .'">'. $status .'</span>';

                        echo viewDetailsCol('Status',$status_row);

                      }
                      else if($type == 'driver' || $type == 'other' || $type == 'production')
                      {

                        echo viewDetailsCol('Name',$user->name);
                        echo viewDetailsCol('Email',$user->email);
                        echo viewDetailsCol('Username',$user->username);
                        echo viewDetailsCol('Contact #',$user->contact_no);


                        $badge_clr = $user->status == 1?'bg-secondary':'bg-success';
                        $status = $user->status == 1?'Deactivated':'Active';

                        $status_row = '<span class="badge rounded-pill '. $badge_clr .'">'. $status .'</span>';

                        echo viewDetailsCol('Status',$status_row);

                      }


                      ?>

                    </div>

                    <h5>Additinal Information</h5>

                    <div class="row mt-3">

                      <?php


                        if($type == 'admin' || $type == 'driver' || $type == 'other' || $type == 'production')
                        {

                          echo viewDetailsCol('Date Of Birth',$user->dob == '0000-00-00'?'':$user->dob);
                          echo viewDetailsCol('Country',$user->country);
                          echo viewDetailsCol('City',$user->city);
                          echo viewDetailsCol('Zip code',$user->zip_code == 0?'':$user->zip_code);
                          echo viewDetailsCol('Residential Address',$user->address,12);

                        }


                      ?>

                    </div>

                  </div>

                </div>
            </div>
         </div>
      </div>
   </div>
</div>
