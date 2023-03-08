<div class="row mt-5">
  <?php if ($type != 'Rights'): ?>
    <div class="col-sm-12">

      <div class="details-circular-img">

      <?php
        //check image is exist in folder or not
        $folder = strtolower($type);

        if (@getimagesize(base_url('uploads/'.$folder.'/'.$user->img)) && !empty($user->img))
        {
            echo '<img src="'. base_url('uploads/'.$folder.'/'.$user->img) .'" alt="...">';
        }
        else
        {
            echo '<img src="'. base_url('assets/images/avatars/01.png') .'" alt="...">';
        }
       ?>

      </div>

    </div>
    <div class="col-sm-12">

      <h5>Basic Information</h5>

      <div class="row mt-3 mb-3">

        <?php

          if($type == 'Admin' || $type == 'Driver' || $type == 'Other_user' || $type == 'Production')
          {

            echo viewDetailsCol('Name',$user->name);
            echo viewDetailsCol('Email',$user->email);
            echo viewDetailsCol('Username',$user->username);

            if($type != 'Admin')
            {
              echo viewDetailsCol('Password',$this->encryption->decrypt($user->password));
            }

            echo viewDetailsCol('Contact #',$user->contact_no);

            if($type == 'Driver' || $type == 'Other_user')
            {

              echo viewDetailsCol('License #',$user->license_no);

            }

            if($type != 'Admin')
            {

              echo viewDetailsCol('FIN #',$user->fin_no);

            }

            if($type == 'Driver' || $type == 'Other_user')
            {

              echo viewDetailsCol('Car Plate',$user->car_plate);

            }

            $badge_clr = $user->status == 1?'bg-secondary':'bg-success';
            $status = $user->status == 1?'Deactivated':'Active';

            $status_row = '<span class="badge rounded-pill '. $badge_clr .'">'. $status .'</span>';

            echo viewDetailsCol('Status',$status_row);

          }
          else if($type == 'Driver' || $type == 'Other_user' || $type == 'Production')
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

          if($type == 'Admin' || $type == 'Driver' || $type == 'Other_user' || $type == 'Production')
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
  <?php else: ?>
    <div class="col-sm-12">

      <div class="row mb-4">
        <div class="col-sm-12">
          <h5>Rights Details</h5>
        </div>
      </div>
      <div class="accordion" id="accordionExample">
          <div class="accordion-item">

            <?php foreach ($modules as $key => $v): ?>

            <div class="accordion-item">
                <h4 class="accordion-header" id="headingOne<?= $v->id ?>">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $v->id ?>" aria-expanded="true" aria-controls="collapseOne<?= $v->id ?>">
                        <?= $v->name ?>
                    </button>
                </h4>
                <div id="collapseOne<?= $v->id ?>" class="accordion-collapse collapse" aria-labelledby="headingOne<?= $v->id ?>" data-bs-parent="#accordionExample">
                    <div class="accordion-body">

                    <?php foreach ($roles[$key] as $k => $val): ?>

                      <div class="row">

                        <div class="col-sm-11">

                          <p><i class="fa-solid fa-star"></i>  <?= $val->name ?></p>

                        </div>

                        <div class="col-sm-1 text-center">

                          <?php if (isset($val->is_allow) && $val->is_allow == 1): ?>

                            <i class="fa-regular fa-circle-check" style="color:green!important;"></i>

                          <?php else: ?>

                            <i class="fa-regular fa-circle-xmark" style="color:red!important;"></i>

                          <?php endif; ?>
                        </div>

                      </div>

                    <?php endforeach; ?>

                  </div>
              </div>
          </div>

          <?php endforeach; ?>

      </div>

    </div>
  <?php endif; ?>
</div>
