//return_stock_driver
$('#return_stock_driver').change(function () {

  let driver_id = $(this).val()

  let url = $('input[name=return_stock_url]').val()

  $.ajax({
    url : url+'/'+driver_id,
    dataType : 'json',
    success : function (data) {

      $('#show_driver_products_').html(data.html)

    }
  })

})


// calculate qty
$(document).on('keyup','.missing_qty_,.return_qty_',function () {

  let $t = $(this).closest('.row')

  let sale_qty = Number($t.find('.sale_qty_').val())
  let exchange_qty = Number($t.find('.exchange_qty_').val())
  let foc_qty = Number($t.find('.foc_qty_').val())
  let missing_qty = Number($t.find('.missing_qty_').val())
  let return_qty = Number($t.find('.return_qty_').val())

  let total = sale_qty + exchange_qty + foc_qty + missing_qty + return_qty

  $t.find('.total_qty_').val(total)

})
