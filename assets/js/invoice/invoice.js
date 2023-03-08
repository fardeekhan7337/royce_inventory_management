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

            $('.select22').select2()
          }

      })

  }

  var saleIdArr = [];
  $(document).on('click','.check_invoice_for_print',function () {

    let sale_id = $(this).val()

    saleIdArr.push(sale_id)

  })

  $(document).on('click','#print_selected_invoices',function () {

      let url = $('input[name=print_invoices_url]').val()
      if(saleIdArr != '')
      {

        window.open(
          url +
            "?sale_id=" +
            saleIdArr,
          "Print Invoices",
          "height=800,width=800"
        );
      }
      else
      {
        alert('Kindly select atleast one invoice')
      }
  })

  $(document).on('click','#print_all_invoices',function () {

      let url = $('input[name=print_invoices_url]').val()
      let invoices = 'all'

        window.open(
          url +
            "?sale_id=" +
            invoices,
          "Print Invoices",
          "height=800,width=800"
        );

  })

  $(document).on('click','#print_filter_invoices',function () {

      let url = $('input[name=print_filter_invoices]').val()
      let invoice_no = $('input[name=invoice_no]').val()
      let customer_id = $('select[name=customer_id]').val()
      let driver_id = $('select[name=driver_id]').val()
      let status = $('select[name=status]').val()
      let type = $('select[name=type]').val()
      let from = $('input[name=from]').val()
      let to = $('input[name=to]').val()

        window.open(
          url +
            "?invoice_no=" + invoice_no +
            "&customer_id=" + customer_id+
            "&driver_id=" + driver_id+
            "&status=" + status+
            "&type=" + type+
            "&from=" + from+
            "&to=" + to ,
          "Print Filter Invoices",
          "height=800,width=800"
        );

  })

});
