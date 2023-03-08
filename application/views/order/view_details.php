<div class="row mt-2">
    <div class="col-sm-12">

      <h3>Call Order Details</h3>

      <div class="row mt-3">

          <div class="col-sm-12">
            <div class="row">

              <div class="col-sm-12 mb-2">
                <h6>Customer details</h6>
              </div>

          <?php

            $order_row = $call_order[0];

            echo viewDetailsCol('Name',$order_row->customer_name);
            echo viewDetailsCol('Shop Acronym',$order_row->shop_acronym);
            echo viewDetailsCol('Email',$order_row->customer_email);
            echo viewDetailsCol('Contact #',$order_row->customer_number);
            echo viewDetailsCol('Address',$order_row->customer_address,8);

          ?>

            </div>
            <div class="row">

              <div class="col-sm-12 mb-2">
                <h6>Driver details</h6>
              </div>

          <?php

            echo viewDetailsCol('Name',$order_row->driver_name);
            echo viewDetailsCol('Day',$order_row->delivery_day);
          ?>

            </div>
          <div class="row">

            <div class="col-sm-12 mb-2">
              <h6>Call Order details</h6>
            </div>
            <?php

            echo viewDetailsCol('Added By',$order_row->added_by_name);
            echo viewDetailsCol('Added At ',getDateTimeFormat($order_row->added_at));
            echo viewDetailsCol('Comment ',$order_row->order_comment);

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
          <?php foreach ($call_order as $key => $v): ?>

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
