//change user status
$(document).on('click','.changeUser_status_',function () {

  let type = $(this).attr('data-msg')
  let status = $(this).attr('data-type-status')
  let url = $(this).attr('data-url')

  let msg = 'Are you sure you want to '+status+' this '+type+'?'

  // let btn_txt = status +' '+type
  let btn_txt = status

  $('#user-status-msg').text(msg)

  $('#user-status-action-btn-txt').text(btn_txt)
  $('#user-status-action-btn-txt').prop('href',url)

  $('#UserStatusModal').modal('show')

})
