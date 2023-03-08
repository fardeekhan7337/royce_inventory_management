

var ajax_url = $('input[name=ajax_url]').val();

function load_evidence_dataTable(start , length)
{

  var evidence_table = $('#myDataTable').DataTable({
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
        { "orderable": false, "targets": [0,1,3] }
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

        let page_info = evidence_table.page.info();

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

load_evidence_dataTable()

function reDrawDataTable()
{

  let page_number = parseInt($('#pageList').val());

  let evidence_dataTable = $('#myDataTable').dataTable();

  evidence_dataTable.fnPageChange(page_number);

}

$('#pageList').change(function () {

  let start = $('#pageList').find(':selected').data('start');

  let length = $('#pageList').find(':selected').data('length');

  load_evidence_dataTable(start, length);

  reDrawDataTable();


})


$(document).on('click','.preview_evidence_img',function(){

  let evidence_img_path = $('input[name=evidence_img_path]').val()

  window.open(evidence_img_path, '', 'width=640,height=480')

})

$(document).on('click','.print_evidence_details',function(){

  let getEvidenceDetails = $('input[name=getEvidenceDetails]').val()

    window.open(getEvidenceDetails,'Print Evidence Details','height=800,width=800');

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

// create evidence
$('#create_evidence').click(function () {

    $('#CreateModal').modal('show')

    $('#CreateEvidence').parsley()

    $('.modal_select_customer_').select2({

      dropdownParent: $('.create_evidence_modal')

    });


})

// editEvidence

function editEvidence(id)
{

    let url = $('input[name=edit_evidence]').val()

    $.ajax({
      url : url,
      type : 'get',
      data : {id : id},
      dataType : 'json',
      success :function (response) {

        $('#edit_modal_').html(response.html)
        $('#EditModal').modal('show')
        $('#updateEvidence').parsley()

        $('.modal_edit_select_customer_').select2({

          dropdownParent: $('.edit_evidence_modal')

        });

      }

    })
}


// saveEvidence
$(document).on('submit','#CreateEvidence',function (e) {

    e.preventDefault()

    let url = $('input[name=saveEvidence]').val()
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

          $('#CreateEvidence')[0].reset();

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


// updateEvidence
$(document).on('submit','#updateEvidence',function (e) {

    e.preventDefault()

    let url = $('input[name=saveEvidence]').val()
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

          $('#updateEvidence')[0].reset();

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


// delete evidence
$(document).on('click','.delete_evidence_',function () {

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
