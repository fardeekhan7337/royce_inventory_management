<div class="row mt-5">
  <div class="col-sm-12 text-center">

        <div class="details-circular-img">

          <?php

            echo getHiddenField('getEvidenceDetails',site_url('AjaxController/printEvidenceDetails/'.$evidence->id));

            $folder = strtolower($type);

            echo getHiddenField('evidence_img_path',base_url('uploads/'.$folder.'/'.$evidence->img));

            if (!empty($evidence->img))
            {
                echo '<img src="'. base_url('uploads/'.$folder.'/'.$evidence->img) .'" class="preview_evidence_img" style="cursor:pointer;" alt="...">';
            }
            else
            {
                echo '<img src="'. base_url('assets/images/evidence_demo.png') .'" class="preview_evidence_img" style="cursor:pointer;" alt="...">';
            }

         ?>

        </div>

  </div>
  <div class="col-sm-12">

    <h5>Evidence Details</h5>

    <div class="row mt-3 mb-3">

      <?php

        echo viewDetailsCol('Shop Name',$evidence->shop_name);
        echo viewDetailsCol('Added By',$evidence->added_by_name);
        echo viewDetailsCol('Added At',date('d-m-Y,H:i a',strtotime($evidence->added_at)));

        echo viewDetailsCol('Comment',$evidence->comment,12);

      ?>

    </div>

  </div>
  <div class="col-sm-12">
    <button type="button" class="btn btn-sm btn-primary print_evidence_details" style="float:right;">Print</button>
  </div>
</div>
