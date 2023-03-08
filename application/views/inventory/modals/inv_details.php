<div class="row mt-2">
    <div class="col-sm-12">

      <h3>Product Summary</h3>

      <div class="row mt-3 mb-3">

        <div class="col-sm-8">
          <div class="row">

        <?php

          echo viewDetailsCol('Product Name',$product->name,4);
          echo viewDetailsCol('Product Code',$product->code,4);
          echo viewDetailsCol('SKU',$product->sku,4);
          echo viewDetailsCol('Description',$product->description,12);

        ?>

          </div>
        </div>
        <div class="col-sm-4 text-center">

          <div class="details-circular-img">
            <?php

              $folder = 'product';

              if (@getimagesize(base_url('uploads/'.$folder.'/'.$product->img)) && !empty($product->img))
              {
                  echo '<img src="'. base_url('uploads/'.$folder.'/'.$product->img) .'" alt="...">';
              }
              else
              {
                  echo '<img src="'. base_url('assets/images/avatars/01.png') .'" alt="...">';
              }

             ?>
         </div>

        </div>

      </div>
      <div class="row">
        <div class="col-sm-12" style="font-size: 14px;">
           <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>#</th>

                  <?php if ($type == 'available'): ?>

                    <!-- <th>Product Stock</th> -->
                    <th>Sold Stock</th>
                    <?php else: ?>
                      <th>Driver</th>
                  <?php endif; ?>

                  <?php if ($type == 'available' || $type == 'missing'): ?>
                    <th>Missing Stock</th>
                  <?php endif; ?>

                  <?php if ($type == 'available' || $type == 'return'): ?>
                    <th>Return Stock</th>
                  <?php endif; ?>

                  <?php if ($type == 'available' || $type == 'exchange'): ?>
                    <th>Exchange Stock</th>
                  <?php endif; ?>

                  <th>Date & Time</th>
                </tr>
              </thead>
              <tbody>

                <?php foreach ($stock_details as $key => $v): ?>

                <tr>
                  <td><?= $key+1 ?></td>
                  <?php if ($type == 'available'): ?>
                      <!-- <td>
                        <php

                          $total_add = $v->total_add_stock_qty + $v->total_return;
                          $total_remove = $v->total_remove_stock_qty + $v->total_assign_stock_confirmed + $v->total_pending_call_order_confirmed + $v->total_return_missing;

                          $total_qty = $total_add - $total_remove;

                         ?>
                      </td> -->
                      <td><?= $v->total_sold_qty ?></td>
                    <?php else: ?>
                      <th><?= $v->driver_name ?></th>
                    <?php endif; ?>

                  <?php if ($type == 'available' || $type == 'missing'): ?>
                    <td><?= $v->total_return_missing ?></td>
                  <?php endif; ?>

                  <?php if ($type == 'available' || $type == 'return'): ?>
                    <td><?= $v->total_return ?></td>
                  <?php endif; ?>

                  <?php if ($type == 'available' || $type == 'exchange'): ?>
                    <td><?= $v->total_exchange ?></td>
                  <?php endif; ?>

                  <td><?= getDateTimeFormat($v->added_at) ?></td>
                </tr>

                <?php endforeach; ?>

              </tbody>
            </table>
          </div>
        </div>
      </div>

    </div>
</div>
