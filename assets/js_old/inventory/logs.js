$('.logs_form').submit(function (e) {

  e.preventDefault()

  let product_id = $('select[name=product_id]').val()
  let customer_id = $('select[name=customer_id]').val()
  let driver_id = $('select[name=driver_id]').val()
  let type = $('select[name=type]').val()
  let type_name = $('input[name=type_name]').val()
  let from = $('input[name=from]').val()
  let to = $('input[name=to]').val()

  let url = $('input[name="logs_filter_url"]').val()

  window.open(url+'?product_id='+product_id+'&customer_id='+customer_id+'&driver_id='+driver_id+'&type='+type+'&type_name='+type_name+'&from='+from+'&to='+to,'Logs','height=800,width=800');

})

$('select[name=type]').change(function () {

  let type_name = $('option:selected',this).text()

  $('input[name=type_name]').val(type_name)

})
