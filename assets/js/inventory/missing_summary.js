$(".missing_summary_form").submit(function (e) {
  e.preventDefault();

  let driver_id = $("select[name=driver_id]").val();
  let from = $("input[name=from]").val();
  let to = $("input[name=to]").val();
  let url = $('input[name="driver_return_filter_url"]').val();

  window.open(
    url + "?driver_id=" + driver_id + "&from=" + from + "&to="+ to,
    "Missing Summary",
    "height=800,width=800"
  );
});
