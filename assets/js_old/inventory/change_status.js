//change user status
$(document).on('click','.changeInv_status_',function () {

  let msg = $(this).attr('data-msg')
  let btn_txt = $(this).attr('data-btn-txt')
  let url = $(this).attr('data-url')

  $('#inv-status-msg').text(msg)

  $('#inv-status-action-btn-txt').text(btn_txt)
  $('#inv-status-action-btn-txt').prop('href',url)

  $('#InventoryStatus_').modal('show')

})
