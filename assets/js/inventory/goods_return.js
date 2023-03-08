// driver request products
var sno = 0;
$(".add_return_products_to_driver").click(function () {
  sno++;

  let product_options = $(".getProductOptionsToReturn").html();

  let pro_row =
    `<div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="product_" class="form-label">Product  <a href="javascript:void(0)" class="remove_return_products_to_driver">
                        <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
                      </a></label>
                    <select class="form-select form-select-sm product_id_" data-width="100%" name="product_id[]" id="select2_` +
    sno +
    `" required>
                      ` +
    product_options +
    `
                    </select>
                  </div>
                  <div class="col-sm-2 mb-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="number" class="form-control form-control-sm qty_" min="1" name="qty[]" required>
                  </div>
                </div>`;

  $("#return_products_to_driver").append(pro_row);

  $("#select2_" + sno).select2();
});

// remove_return_products_to_driver
$(document).on("click", ".remove_return_products_to_driver", function () {
  $(this).closest(".row").remove();
});

// $(document).on("click", ".mygood_return .select2-container", function () {
//   // console.log($(this)[0]);
//   // return;
//   alert("hello");
//   let lis = $(".select2-results__options li");
//   let options = $("#product_id option");

//   lis.map((index, li) => {
//     let myopt = $(options[index])[0];

//     let clrname = $(myopt).attr("datapcolor");
//     // console.log(index);
//     let myli = $(li)[0];
//     $(myli).css("color", clrname);
//   });
// });
