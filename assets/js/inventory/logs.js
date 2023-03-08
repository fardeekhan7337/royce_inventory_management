$(".logs_form").submit(function (e) {
  e.preventDefault();

  let product_id = $("#product_id").val();

  let customer_id = $("select[name=customer_id]").val();
  let driver_id = $("#driver_id").val();
  let type = $("#type_").val();
  let export_type = $("#export_type").val();
  let from = $("input[name=from]").val();
  let to = $("input[name=to]").val();

  let url = $('input[name="logs_filter_url"]').val();

  window.open(
    url +
      "?product_id=" +
      product_id +
      "&customer_id=" +
      customer_id +
      "&driver_id=" +
      driver_id +
      "&type=" +
      type +
      "&export_type=" +
      export_type +
      "&from=" +
      from +
      "&to=" +
      to,
    "Logs",
    "height=800,width=800"
  );
});
