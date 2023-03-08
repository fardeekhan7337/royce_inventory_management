// return stock popup
$('#return_stock_').click(function () {

    $('#ReturnStockModal').modal('show');

})

// Assign stock to driver popup
$('#assign_stock_to_driver_').click(function () {

    $('#AssignStockToDriverModal').modal('show');

})

// inventory tabs show and hide table
$('.inv_tabs_').click(function () {

    $(this).siblings().removeClass('active')
    $(this).addClass('active')

    let tab_type = $(this).attr('data-type')

    $('.tabs_table').css('display','none')
    $('.'+tab_type+'_table_').css('display','')
})


// view details
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
