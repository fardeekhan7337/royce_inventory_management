//delete record
$(document).on('click','.delete_record_',function () {

  let msg = $(this).attr('data-msg')
  let url = $(this).attr('data-url')

  $('#delete-msg').text(msg)

  $('#delete-action-btn-txt').text('Delete')
  $('#delete-action-btn-txt').prop('href',url)

  $('#deleteRecordModal').modal('show')

})

//view details
$(document).on('click','.view_details_',function () {

  let url = $(this).attr('data-url')

  $.ajax({

    url : url,
    dataType : 'json',
    success :function (data) {

      $('#view_details_').html(data.html)
      $('#ViewDetailsModal').modal('show')

    }

  })


})
