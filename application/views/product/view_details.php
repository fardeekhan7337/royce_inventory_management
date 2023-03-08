<div class="row mt-5">
    <div class="col-sm-12">

        <div class="details-circular-img">

            <?php

      $folder = strtolower($type);

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
    <div class="col-sm-12">

        <h5>Product Details</h5>

        <div class="row mt-3 mb-3">

            <?php
            $product_color = '<div style="width:28px;height:28px;margin-top:-10px;border-radius:50%;background-color:'. $product->color .'"></div>';
      echo viewDetailsCol('Product Name',$product->name,4);
      echo viewDetailsCol('Product Code',$product->code,4);
      echo viewDetailsCol('sku',$product->sku,4);
      echo viewDetailsCol('Color',$product_color,4);
      echo viewDetailsCol('Product Category',$category->name,4);
      echo viewDetailsCol('Price',$product->price,4);
      echo viewDetailsCol('Description',$product->description, 12);

      ?>
        </div>

    </div>
</div>