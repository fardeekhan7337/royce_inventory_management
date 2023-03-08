$(document).on('click','.view_inv_details,.print_inv_details',function () {

  let url = $(this).attr('data-url')

    window.open(url,'Invoice Details','height=800,width=800');

})

$(function(){

  getAllInvoices(1);

  $(document).on('change','.move_to_page',function () {

      let page_no = $(this).val()

      getAllInvoices(page_no);

  })

  // Detect pagination click
  $('#pagination_').on('click','a',function(e){

     e.preventDefault();
     var pageno = $(this).attr('data-ci-pagination-page');
     getAllInvoices(pageno);

  });

  $('#filter_invoice_').submit(function (e) {

      e.preventDefault()

      getAllInvoices(1)

  })

  //get all invoices
  function getAllInvoices(pageno)
  {

      let invoice_url = $('input[name=invoice_url]').val()

      let data = $('#filter_invoice_').serialize()

      $.ajax({
          url:invoice_url+'/'+pageno,
          method: 'post',
          dataType: 'json',
          data : data,
          success: function(response)
          {

            $('#invoices_').html(response.result);
            $('#pagination_').html(response.pagination);
            console.log(response);

            $('.select22').select2()
          }

      })

  }

});
