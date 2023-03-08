<div class="row mt-2">
    <div class="col-sm-12">

      <h3>Live Stock Driver Details</h3>

      <div class="row mt-3">
        <div class="col-sm-12">
        <table class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Assign Qty</th>
            <th>Sold</th>
            <th>Remaining</th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($assign_stock_details as $key => $v): ?>

          <tr>
            <td><?= $key + 1 ?></td>
            <td><?= $v->product_name ?></td>
            <td><?= $v->qty ?></td>
            <td><?= $v->qty - $v->available_qty ?></td>
            <td><?= $v->available_qty ?></td>
          </tr>

          <?php endforeach; ?>

        </tbody>
      </table>
        </div>
      </div>

    </div>
</div>
