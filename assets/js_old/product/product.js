

var ajax_url = $('input[name=ajax_url]').val();

function load_product_dataTable(start , length)
{

  var product_table = $('#myDataTable').DataTable({
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

          let page_info = product_table.page.info();

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

load_product_dataTable()

function reDrawDataTable()
{

  let page_number = parseInt($('#pageList').val());

  let product_dataTable = $('#myDataTable').dataTable();

  product_dataTable.fnPageChange(page_number);

}

$('#pageList').change(function () {

  let start = $('#pageList').find(':selected').data('start');

  let length = $('#pageList').find(':selected').data('length');

  load_product_dataTable(start, length);

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


$('select[name=cat_id]').change(function () {

    let cat_id = $(this).val()
    let url = $('input[name=getCategoryPrice]').val()

    $.ajax({

      url : url+'/'+cat_id,
      dataType : 'json',
      success : function (data) {

        $('input[name=price]').val(data.price)

      }

    })
})

// creat product
$('#create_product').click(function () {

    $('#CreateModal').modal('show')

    $('#CreateProduct').parsley()

    $('.modal_select_category_').select2({

      dropdownParent: $('.create_product_modal')

    });


})

// editproduct

function editProduct(id)
{

    let url = $('input[name=edit_product]').val()

    $.ajax({
      url : url,
      type : 'get',
      data : {id : id},
      dataType : 'json',
      success :function (response) {

        $('#edit_modal_').html(response.html)
        $('#EditModal').modal('show')
        $('#updateProduct').parsley()

        $('.modal_edit_select_category_').select2({

          dropdownParent: $('.edit_product_modal')

        });

      }

    })
}


// saveProduct
$(document).on('submit','#CreateProduct',function (e) {

    e.preventDefault()

    let url = $('input[name=saveProduct]').val()
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

          $('#CreateProduct')[0].reset();

          show_success_(response.msg)

          reDrawDataTable();

        }
        else
        {

          show_error_(response.msg)

        }

      }

    })

})

// updateProduct
$(document).on('submit','#updateProduct',function (e) {

    e.preventDefault()

    let url = $('input[name=saveProduct]').val()
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

          $('#updateProduct')[0].reset();

          show_success_(response.msg)

          reDrawDataTable();

        }
        else
        {

          show_error_(response.msg)

        }

      }

    })

})


// delete product
$(document).on('click','.delete_product_',function () {

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

          reDrawDataTable();

        }
        else
        {

          show_error_(response.msg)

        }

      }

    })

  })

})
