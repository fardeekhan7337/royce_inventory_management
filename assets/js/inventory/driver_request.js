$(".driver_request_form").submit(function (e) {
  e.preventDefault();

  let driver_id = $("select[name=driver_id]").val();
  let url = $('input[name="driver_request_filter_url"]').val();

  window.open(
    url + "?driver_id=" + driver_id,
    "Driver Request",
    "height=800,width=800"
  );
});
