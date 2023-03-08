$("#save_sale").parsley();

function show_error_(_error_msg) {
  toastr.error(_error_msg, "", {
    positionClass: "toast-top-right",
    timeOut: 5e3,
    closeButton: !0,
    debug: !1,
    newestOnTop: !0,
    progressBar: !0,
    preventDuplicates: !0,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    tapToDismiss: !1,
  });
}

function show_success_(_succes_msg) {
  toastr.success(_succes_msg, "", {
    positionClass: "toast-top-right",
    timeOut: 5e3,
    closeButton: !0,
    debug: !1,
    newestOnTop: !0,
    progressBar: !0,
    preventDuplicates: !0,
    onclick: null,
    showDuration: "300",
    hideDuration: "1000",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut",
    tapToDismiss: !1,
  });
}

//get customer sale prooducts,remarks,unpaid invoices
$("#sale_customer_id").change(function () {
  let customer_id = $(this).val();

  $("#total_unpaid_inv").empty();
  $(".customer_remarks_col").css("display", "none");
  $("#customer_remarks").empty();
  $("#showCustomerSaleProducts_").empty();

  if (customer_id != "") {
    $.ajax({
      url: "AjaxController/getCustomerSaleInfo/" + customer_id,
      dataType: "json",
      success: function (data) {
        if (data.payment_type != "Cash") {
          $("#is_customer_pay")
            .val("No")
            .trigger("change")
            .prop("readonly", true);
        }

        $("input[name=customer_category]").val(data.payment_type);
        $("input[name=total_products]").val(data.total_products);
        $("#total_unpaid_inv").html(data.total_unpaid_inv);
        $(".customer_remarks_col").css("display", "block");
        $(".customer_payment_type_col").css("display", "block");
        $("#customer_category").text(data.payment_type);
        $("#customer_remarks").html(data.remarks);
        $("#showCustomerSaleProducts_").html(data.html);

        $(".remove_sale_products_select2_").select2();
      },
    });
  }
});

// remove empty products
$(document).on("click", ".remove_empty_products", function () {
  $(".total_qty_").each(function () {
    let tot_qty = $(this).val();

    if (tot_qty < 1) {
      $(this)
        .closest(".row")
        .find(".remove_customer_sale_product")
        .trigger("click");
    }
  });
});
// remove sale product row
$(document).on("click", ".remove_customer_sale_product", function () {
  let pid = $(this).attr("data-PID");
  let pname = $(this).attr("data-PNAME");
  let qty = $(this).attr("data-Qty");
  let price = $(this).attr("data-price");
  let removed_sale_pro = $(".remove_sale_products_").html();
  removed_sale_pro +=
    '<option data-PID="' +
    pid +
    '" data-PNAME="' +
    pname +
    '" data-Qty="' +
    qty +
    '" data-price="' +
    price +
    '">' +
    pname +
    "</option>";
  $(".remove_sale_products_").html(removed_sale_pro);
  $(this).closest(".row").remove();
});

// add (removed sale products) in a row
$(document).on("change", ".remove_sale_products_", function () {
  let rsp = $("option:selected", this);
  let pid = rsp.attr("data-PID");
  let pname = rsp.attr("data-PNAME");
  let qty = rsp.attr("data-Qty");
  let price = rsp.attr("data-price");

  let url = $("input[name=remove_sale_products_url]").val();

  $.ajax({
    url: url,
    type: "get",
    data: {
      product_id: pid,
      product_name: pname,
      available_qty: qty,
      product_price: price,
    },
    dataType: "json",
    success: function (result) {
      $("#showCustomerSaleProducts_").append(result.html);

      rsp.remove();
    },
  });
});

// check customer is pay or not
$("#is_customer_pay").change(function () {
  let is_pay = $(this).val();

  $(".payment_type_col,.reason_col").css("display", "none");

  $(".bank_name_col,.acc_no_col,.cheque_no_col").css("display", "none");
  $("#bank_name,#acc_no,#cheque_no").prop("required", false);
  $("#bank_name,#acc_no,#cheque_no").val("");

  if (is_pay == "Yes") {
    $(".payment_type_col").css("display", "block");
    $(".payment_type").prop("required", true);
  } else if (is_pay == "No") {
    $(".payment_type").prop("required", false);
    $(".reason_col").css("display", "block");
  }
});

//check payment type
$(".payment_type").change(function () {
  let pay_type = $(this).val();

  // $('.bank_name_col,.acc_no_col,.cheque_no_col').css('display','none')
  // $('#bank_name,#acc_no,#cheque_no').prop('required',false)
  // $('#bank_name,#acc_no,#cheque_no').val('')
  //
  // if(pay_type == 'Cheque')
  // {
  //
  //   $('.bank_name_col,.acc_no_col,.cheque_no_col').css('display','block')
  //   $('#bank_name,#acc_no,#cheque_no').prop('required',true)
  //
  // }
  // else if(pay_type == 'Bank')
  // {
  //
  //   $('.bank_name_col,.acc_no_col').css('display','block')
  //   $('#bank_name,#acc_no').prop('required',true)
  //
  // }
});

//add sale
$("#save_sale").submit(function (e) {
  e.preventDefault();

  var sale_action = $("input[name=sale_action]").val();
  let url = $("input[name=save_sale]").val();
  let show_details_url = $("input[name=show_details]").val();

  let data = $("#save_sale").serialize();

  let total_products = $("input[name=total_products]").val();

  if (total_products != 0) {
    $.ajax({
      url: url,
      type: "post",
      data: data,
      dataType: "json",
      success: function (response) {
        if (response.status == true) {
          show_success_(response.msg);

          window.open(
            show_details_url + "/" + response.sale_id + "/save_sale",
            "Sale Information",
            "height=800,width=800"
          );

          if (sale_action == "create") {
            location.reload();
          }
        } else {
          show_error_(response.msg);
        }
      },
    });
  } else {
    show_error_("Kindly select anyone product");
  }
});

// calculate qty
$(document).on("keyup", ".sale_qty_,.exchange_qty_,.foc_qty_", function () {
  let $t = $(this).closest(".row");

  let sale_qty = Number($t.find(".sale_qty_").val());
  let exchange_qty = Number($t.find(".exchange_qty_").val());
  let foc_qty = Number($t.find(".foc_qty_").val());

  let total = sale_qty + exchange_qty + foc_qty;

  $t.find(".total_qty_").val(total);
});

function total_amount_() {
  var sum = 0;
  $(".amount_").each(function () {
    sum += Number($(this).val());
  });

  $("input[name=total_amount]").val(sum.toFixed(2));
}

// calculate qty
$(document).on("keyup", ".sale_qty_", function () {
  let $t = $(this).closest(".row");

  let sale_qty = Number($t.find(".sale_qty_").val());

  let price = Number($t.find(".price_").val());

  let amount = sale_qty * price;

  $t.find(".amount_").val(amount.toFixed(2));

  total_amount_();
});
