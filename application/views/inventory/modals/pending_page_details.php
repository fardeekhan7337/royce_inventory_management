<?php
  $row = $data[0];
if ($type == 'delivery_order'): ?>

<div class="row mt-2">
    <div class="col-sm-12">

      <h3>Pending Request Details</h3>

      <div class="row mt-3">

          <div class="col-sm-8">
            <div class="row">

              <div class="col-sm-12 mb-2">
                <h6>Driver details</h6>
              </div>

          <?php

            echo viewDetailsCol('Name',$row->driver_name,6);
            echo viewDetailsCol('Email',$row->driver_email,6);
            echo viewDetailsCol('Contact #',$row->driver_number,6);
            echo viewDetailsCol('Added By',$row->added_by_name,6);
            echo viewDetailsCol('Added At ', getDateTimeFormat($row->added_at),'12');

          ?>

            </div>
          </div>
          <div class="col-sm-4 text-center">

            <div class="details-circular-img">

            <?php
              //check image is exist in folder or not
              $folder = 'driver';

              if (@getimagesize(base_url('uploads/'.$folder.'/'.$row->img)) && !empty($row->img))
              {
                  echo '<img src="'. base_url('uploads/'.$folder.'/'.$row->img) .'" alt="...">';
              }
              else
              {
                  echo '<img src="'. base_url('assets/images/avatars/01.png') .'" alt="...">';
              }
             ?>

            </div>

          </div>

        <div class="col-sm-12">
        <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Quantity</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($data as $key => $v): ?>

          <tr>
            <td><?= $key+1 ?></td>
            <td><?= $v->product_name ?></td>
            <td><?= $v->qty ?></td>
          </tr>

        <?php endforeach; ?>
        </tbody>
      </table>
        </div>
      </div>

    </div>
</div>



<?php else: ?>


  <div class="row mt-2">
      <div class="col-sm-12">

        <h3>Pending Request Details</h3>

        <div class="row mt-3">

            <div class="col-sm-12">
              <div class="row">

                <div class="col-sm-12 mb-2">
                  <h6>Customer details</h6>
                </div>

            <?php

            echo viewDetailsCol('Name',$row->customer_name);
            echo viewDetailsCol('Shop Acronym',$row->shop_acronym);
            echo viewDetailsCol('Email',$row->customer_email);
            echo viewDetailsCol('Contact #',$row->customer_number);
            echo viewDetailsCol('Address',$row->customer_address,12);

            ?>

              </div>
              <div class="row">

                <div class="col-sm-12 mb-2">
                  <h6>Driver details</h6>
                </div>

            <?php

            echo viewDetailsCol('Name',$row->driver_name);
            echo viewDetailsCol('Day',$row->delivery_day);
            ?>

              </div>
            <div class="row">

              <div class="col-sm-12 mb-2">
                <h6>Call Order details</h6>
              </div>
              <?php

              echo viewDetailsCol('Added By',$row->added_by_name);
              echo viewDetailsCol('Added At ',getDateTimeFormat($row->added_at),'6');

              ?>
            </div>


            </div>
          </div>

          <div class="col-sm-12">
          <table class="table">
          <thead>
            <tr>
              <th style="width:3%;">#</th>
              <th>Product</th>
              <th style="width:10%;">Quantity</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($data as $key => $v): ?>

            <tr>
              <td><?= $key+1 ?></td>
              <td><?= $v->product_name ?></td>
              <td><?= $v->qty ?></td>
            </tr>

            <?php endforeach; ?>
          </tbody>
        </table>
          </div>
        </div>

      </div>
  </div>



<?php endif; ?>
