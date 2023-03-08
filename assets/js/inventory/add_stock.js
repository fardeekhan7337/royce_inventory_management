// add stock popup
$('#add_stock_').click(function () {

    let redirect_url = $(this).attr('data-redirect')

    $('.add_stock_redirect_to_').val(redirect_url)

    $('#AddStockModal').modal('show');

    $('.add_stock_select_').select2({

      dropdownParent: $('.add_stock_modal_select_')

    });

})
