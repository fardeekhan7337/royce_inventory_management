// driver request products
var sno = 0;
$(".add_assign_products_to_driver").click(function () {
  sno++;

  let product_options = $(".getProductOptionsToAssign").html();

  let pro_row =
    `<div class="row">
                  <div class="col-sm-5 mb-3">
                    <label for="product_" class="form-label">Product  <a href="javascript:void(0)" class="remove_assign_products_to_driver">
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

  $("#assign_products_to_driver").append(pro_row);

  $("#select2_" + sno).select2();
});

// remove_assign_products_to_driver
$(document).on("click", ".remove_assign_products_to_driver", function () {
  $(this).closest(".row").remove();
});

// get product available qty
$(document).on("change", ".product_id_", function () {
  let id = $(this).val();

  var $t = $(this);

  $.ajax({
    url: "AjaxController/getProductAvailableQty/" + id,
    dataType: "json",
    success: function (response) {
      let res = response.data;

      $t.closest(".row").find(".qty_").prop("max", res.available_qty);
      $t.closest(".row").find(".request_pro_stock_").text(res.available_qty);
    },
  });
});

//assigned to driver
$("#driver_id").change(function () {
  let driver_id = $(this).val();

  $.ajax({
    url: "AjaxController/getDriverRequestedProducts/" + driver_id,
    dataType: "json",
    success: function (data) {
      var products = data.products;
      var driver_request = data.driver_request;

      var html = "";
      for (var i = 0; i < driver_request.length; i++) {
        html += `<div class="row">
                          <div class="col-sm-5 mb-3">
                            <label for="product_" class="form-label">Product <a href="javascript:void(0)" class="remove_assign_products_to_driver">
                              <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
                            </a></label>
                            <select class="form-select form-select-sm product_id_ select2_assign_products" data-width="100%" name="product_id[]" required>
                              <option value="">select</option>`;

        for (var p = 0; p < products.length; p++) {
          var selected = "";
          if (products[p].id == driver_request[i].product_id) {
            selected = "selected";
          }

          html +=
            `<option value="` +
            products[p].id +
            `" ` +
            selected +
            `>` +
            products[p].name +
            `</option>`;
        }

        html +=
          `</select>
                          </div>
                          <div class="col-sm-2 mb-3">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="number" class="form-control form-control-sm qty_" min="1" name="qty[]" value="` +
          driver_request[i].qty +
          `" required>
                          </div>
                        </div>`;
      }

      $("#assign_products_to_driver").html(html);

      $(".select2_assign_products").select2();

      $(".product_id_").trigger("change");
    },
  });
});

//assigned to driver from modal
$("#modal_driver_id").change(function () {
  let driver_id = $(this).val();

  $.ajax({
    url: "AjaxController/getDriverRequestedProducts/" + driver_id,
    dataType: "json",
    success: function (data) {
      var products = data.products;
      var driver_request = data.driver_request;

      var html = "";
      for (var i = 0; i < driver_request.length; i++) {
        html += `<div class="row">
                          <div class="col-sm-8 mb-3">
                            <label for="product_" class="form-label">Product <a href="javascript:void(0)" class="remove_assign_products_to_driver">
                              <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
                            </a></label>
                            <select class="form-select form-select-sm product_id_ modal_select_assign_product_" data-width="100%" name="product_id[]" required>
                              <option value="">select</option>`;

        for (var p = 0; p < products.length; p++) {
          var selected = "";
          if (products[p].id == driver_request[i].product_id) {
            selected = "selected";
          }

          html +=
            `<option value="` +
            products[p].id +
            `" ` +
            selected +
            `>` +
            products[p].name +
            `</option>`;
        }

        html +=
          `</select>
                          </div>
                          <div class="col-sm-3 mb-3">
                            <label for="qty" class="form-label">Qty</label>
                            <input type="number" class="form-control form-control-sm qty_" min="1" name="qty[]" value="` +
          driver_request[i].qty +
          `" required>
                          </div>
                        </div>`;
      }

      $("#assign_products_to_driver_modal").html(html);

      $(".modal_select_assign_product_").select2({
        dropdownParent: $(".assign_modal_select_"),
      });

      $(".product_id_").trigger("change");
    },
  });
});

var sno_modal = 0;
$(".add_assign_products_to_driver_from_modal").click(function () {
  sno_modal++;

  let product_options = $(".getProductOptionsToAssign").html();

  let pro_row =
    `<div class="row">
                  <div class="col-sm-8 mb-3">
                    <label for="product_" class="form-label">Product   <a href="javascript:void(0)" class="remove_assign_products_to_driver">
                        <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
                      </a></label>
                    <select class="form-select form-select-sm product_id_" data-width="100%" name="product_id[]" id="select2_` +
    sno_modal +
    `" required>
                      ` +
    product_options +
    `
                    </select>
                  </div>
                  <div class="col-sm-3 mb-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="number" class="form-control form-control-sm qty_" min="1" name="qty[]" required>
                  </div>
                </div>`;

  $("#assign_products_to_driver_modal").append(pro_row);

  $("#select2_" + sno_modal).select2({
    dropdownParent: $(".assign_modal_select_"),
  });
});

// add_assign_products_to_driver

var sno1 = 0;
$(".add_call_order_products_").click(function () {
  sno1++;

  let product_options = $(".getProductOptionsToAssign").html();

  let pro_row =
    `<div class="row">
                  <div class="col-sm-6 mb-3">
                    <label for="product_" class="form-label">Product   <a href="javascript:void(0)" class="remove_assign_products_to_driver">
                        <i class="fa-solid fa-x" style="font-size: 15px;color:#fd6262!important;"></i>
                      </a></label>
                    <select class="form-select form-select-sm product_id_" data-width="100%" name="product_id[]" id="select2_` +
    sno1 +
    `" required>
                      ` +
    product_options +
    `
                    </select>
                  </div>
                  <div class="col-sm-5 mb-3">
                    <label for="qty" class="form-label">Qty</label>
                    <input type="number" class="form-control form-control-sm qty_" min="1" name="qty[]" required>
                  </div>
                </div>`;

  $("#call_order_products_").append(pro_row);

  $("#select2_" + sno1).select2();
});
