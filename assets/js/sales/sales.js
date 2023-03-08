
var ajax_url = $('input[name=ajax_url]').val();

function load_sale_dataTable(start , length)
{

  var sale_datatable = $('#myDataTable').DataTable({
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
        { "orderable": false, "targets": [0,1,7,10,11] }
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

        let page_info = sale_datatable.page.info();

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

load_sale_dataTable()

function reDrawDataTable()
{

  let page_number = parseInt($('#pageList').val());

  let sale_dataTable = $('#myDataTable').dataTable();

  sale_dataTable.fnPageChange(page_number);

}

$('#pageList').change(function () {

  let start = $('#pageList').find(':selected').data('start');

  let length = $('#pageList').find(':selected').data('length');

  load_sale_dataTable(start, length);

  reDrawDataTable();

})

//delete sale record
$(document).on('click','.delete_record_',function () {

  let msg = $(this).attr('data-msg')
  let url = $(this).attr('data-url')

  $('#delete-msg').text(msg)

  $('#delete-action-btn-txt').text('Delete')
  $('#delete-action-btn-txt').prop('href',url)

  $('#deleteRecordModal').modal('show')

})

$(document).on('click','.view_sale_details_',function () {

  let url = $(this).attr('data-url')

    window.open(url,'View Sale Information','height=800,width=800');

})

$(document).on('click','.changeSalesStatus',function () {

  let url = $(this).attr('data-url')
  let msg = $(this).attr('data-msg')
  let btn = $(this).attr('data-btn')
  let id = $(this).attr('data-ID')


  $('#sale-status-msg').text(msg)
  $('#sale-status-action-btn-txt').text(btn)
  $('input[name=sale_status_id]').val(id)

  $('#update_sale_status').val('')
  $('#SaleStatusModal').modal('show')

})


$(document).on('click','#sale-status-action-btn-txt',function () {

  let status = $('#update_sale_status').val()
  let update_satatu_url = $('input[name=update_satatu_url]').val()

  if(status != '')
  {

      let id = $('input[name=sale_status_id]').val()
      $.ajax({
        url : update_satatu_url,
        type : 'get',
        data : {status : status , id : id},
        dataType : 'json',
        success : function (response) {
          console.log(response)

          window.location.href = response.redirect;
        }
      })

  }
  else
  {

    alert('Kindly select status')
  }



})


$(document).on('click','.view_sale_history_',function () {


  let url = $(this).attr('data-url')


      $.ajax({
        url : url,
        dataType : 'json',
        success : function (response) {
          console.log(response)

          $('#sales_status_history_data').html(response.html)
          $('#SalesStatusHistoryModal').modal('show')


        }
      })

})
