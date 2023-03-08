
var ajax_url = $('input[name=ajax_url]').val();

function load_customer_dataTable(start , length)
{

  var customer_table = $('#myDataTable').DataTable({
        dom: 'lBfrtip',
          buttons: [
            {
              text: 'Excel',
              extend: 'excelHtml5',
              className: 'btn btn-sm btn-primary',
              init: function(api, node, config) {
                 $(node).removeClass('dt-button')
              },
              exportOptions: {
                     columns: ":not('.dnr')",
                 }
            },
            {
              text: 'Pdf',
              extend: 'pdfHtml5',
              className: 'btn btn-sm btn-primary',
              init: function(api, node, config) {
                 $(node).removeClass('dt-button')
              },
              exportOptions: {
                     columns: ":not('.dnr')",
                 }
            }
          ],
        language: {
          'paginate': {
            'previous': '«',
            'next': '»'
          }
        },
        "columnDefs": [
          { "orderable": false, "targets": [0,1] }
        ],
        "aaSorting": [],
        "processing": true,
        "serverSide": true,
        "retrieve": true,
        "ajax": {
          url: ajax_url, // json datasource
          type: "post", // method , by default get
          data : {start : start , length : length} // jump to particular page
          // error: function() { // error handling
          //   $(".employee-grid-error").html("");
          //   $("#employee-grid").append('<tbody class="orders-error"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
          //   $("#employee-grid_processing").css("display", "none");
          //   $('#employee-grid_length').css({
          //     "margin-left": "10px"
          //   });
          // }
        },
        "drawCallback" : function (settings) {

          let page_info = customer_table.page.info();

  				let html = '';

  				let start = 0;

  				let length = page_info.length;

  				for(let count = 1; count <= page_info.pages; count++)
  				{

            let page_number = count - 1;

  					html += '<option value="'+page_number+'" data-start="' + start + '" data-length="' + length + '">' + count + '</option>';

  					start = start + page_info.length;

  				}

  				$('#pageList').html(html);

  				$('#pageList').val(page_info.page);


        }

  })

}

load_customer_dataTable()

function reDrawDataTable()
{

  let page_number = parseInt($('#pageList').val());

  let customer_dataTable = $('#myDataTable').dataTable();

  customer_dataTable.fnPageChange(page_number);

}

$('#pageList').change(function () {

  let start = $('#pageList').find(':selected').data('start');

  let length = $('#pageList').find(':selected').data('length');

  load_customer_dataTable(start, length);

  reDrawDataTable();


})


function show_error_(_error_msg) {

  toastr.error(_error_msg, "", {
   positionClass: "toast-top-right",
   timeOut: 5e3,
   closeButton: !0,
   debug: !1,
   newestOnTop: !0,
   progressBar: !0,
   preventDuplicates: !0,
   onclick: null,
   showDuration: "300",
   hideDuration: "1000",
   extendedTimeOut: "1000",
   showEasing: "swing",
   hideEasing: "linear",
   showMethod: "fadeIn",
   hideMethod: "fadeOut",
   tapToDismiss: !1
 })

}

function show_success_(_succes_msg) {

 toastr.success(_succes_msg, "", {
   positionClass: "toast-top-right",
   timeOut: 5e3,
   closeButton: !0,
   debug: !1,
   newestOnTop: !0,
   progressBar: !0,
   preventDuplicates: !0,
   onclick: null,
   showDuration: "300",
   hideDuration: "1000",
   extendedTimeOut: "1000",
   showEasing: "swing",
   hideEasing: "linear",
   showMethod: "fadeIn",
   hideMethod: "fadeOut",
   tapToDismiss: !1
 })

}

$(document).on('click','.adjust_prices_',function () {


    let url = $(this).attr('data-url')

    $.ajax({

      url : url,
      dataType : 'json',
      success :function (data) {

        $('#customer_products_price_').html(data.html)
        $('input[name=customer_id_]').val(data.customer_id)
        $('#CustomerProductsPricesModal').modal('show')

      }

    })

})

$(document).on('keyup','.adjust_product_price',function () {

    let id = $(this).attr('id')
    let price = $(this).val()

    $('.product_price_'+id).val(price)

})


//update customer product prices

$(document).on('submit','.update_customer_products_price_',function (e) {

    e.preventDefault()

    let url = $('input[name=update_product_price_url]').val()
    let data = $(this).serialize()

      $.ajax({

        url : url,
        type : 'post',
        data : data,
        dataType : 'json',
        success : function (response) {

          $('#CustomerProductsPricesModal').modal('hide')

          if(response.status == true)
          {

            show_success_(response.msg)

          }
          else
          {

            show_error_(response.msg)

          }

        }

      })

})

// create customer
$('#create_customer').click(function () {

    $('#CreateModal').modal('show')

    $('#CreateCustomer').parsley()

    $('#CreateModal').on('shown.bs.modal', function (e) {

         var modal_select_cat_type = $('.modal_select_cat_type_')
         modal_select_cat_type.select2({
           dropdownParent:modal_select_cat_type.parent()
         })

         var modal_select_salesperson = $('.modal_select_salesperson_')
         modal_select_salesperson.select2({
           dropdownParent:modal_select_salesperson.parent()
         })

         var modal_select_assign_driver = $('.modal_select_assign_driver_')
         modal_select_assign_driver.select2({
           dropdownParent:modal_select_assign_driver.parent()
         })

         var modal_select_day = $('.modal_select_day_')
         modal_select_day.select2({
           dropdownParent:modal_select_day.parent()
         })

    });

    // $('#modal_select_cat_type_').select2({
    //
    //   dropdownParent: $('#CreateModal')
    //
    // });
    // $('#modal_select_salesperson_').select2({
    //
    //   dropdownParent: $('#CreateModal')
    //
    // });
    // $('#modal_select_assign_driver_').select2({
    //
    //   dropdownParent: $('#CreateModal')
    //
    // });
    // $('#modal_select_day_').select2({
    //
    //   dropdownParent: $('#CreateModal')
    //
    // });

})

// editCustomer

function editCustomer(id)
{

    let url = $('input[name=edit_customer]').val()

    $.ajax({
      url : url,
      type : 'get',
      data : {id : id},
      dataType : 'json',
      success :function (response) {

        $('#edit_modal_').html(response.html)
        $('#EditModal').modal('show')
        $('#updateCustomer').parsley()

        $('#EditModal').on('shown.bs.modal', function (e) {

           var modal_edit_cat_type = $('.modal_edit_cat_type_')
           modal_edit_cat_type.select2({
             dropdownParent:modal_edit_cat_type.parent()
           })

           var modal_edit_salesperson = $('.modal_edit_salesperson_')
           modal_edit_salesperson.select2({
             dropdownParent:modal_edit_salesperson.parent()
           })

           var modal_edit_assign_driver = $('.modal_edit_assign_driver_')
           modal_edit_assign_driver.select2({
             dropdownParent:modal_edit_assign_driver.parent()
           })

           var modal_edit_day = $('.modal_edit_day_')
           modal_edit_day.select2({
             dropdownParent:modal_edit_day.parent()
           })

         });

      }

    })
}


// saveCustomer
$(document).on('submit','#CreateCustomer',function (e) {

      e.preventDefault()

    let url = $('input[name=saveCustomer]').val()
    let data = new FormData(this)

    $.ajax({

      url : url,
      type : 'post',
      data : data,
      processData : false,
      contentType : false,
      cache : false,
      async : false,
      dataType : 'json',
      success : function (response) {

        if(response.status == true)
        {

          $('#CreateModal').modal('hide')

          $('#CreateCustomer')[0].reset();

          show_success_(response.msg)

          reDrawDataTable()

        }
        else
        {

          show_error_(response.msg)

        }

      }

    })

})


// updateCustomer
$(document).on('submit','#updateCustomer',function (e) {

    e.preventDefault()

    let url = $('input[name=saveCustomer]').val()
    let data = new FormData(this)

    $.ajax({

      url : url,
      type : 'post',
      data : data,
      processData : false,
      contentType : false,
      cache : false,
      async : false,
      dataType : 'json',
      success : function (response) {

        if(response.status == true)
        {

          $('#EditModal').modal('hide')

          $('#updateCustomer')[0].reset();

          show_success_(response.msg)

          reDrawDataTable()

        }
        else
        {

          show_error_(response.msg)

        }

      }

    })

})


// delete customer
$(document).on('click','.delete_customer_',function () {

  let msg = $(this).attr('data-msg')
  let url = $(this).attr('data-url')

  $('#delete-msg').text(msg)

  $('#delete-action-btn-txt').text('Delete')

  $('input[name=delete_product_url]').val(url)

  $('#deleteAjaxModal').modal('show')

  $('#delete-action-btn-txt').click(function () {

    $.ajax({
      url : $('input[name=delete_product_url]').val(),
      dataType : 'json',
      success : function (response) {

        if(response.status == true)
        {

          $('#deleteAjaxModal').modal('hide')

          $('input[name=delete_product_url]').val('')

          show_success_(response.msg)

          reDrawDataTable()

        }
        else
        {

          show_error_(response.msg)

        }

      }

    })

  })

})
