
var ajax_url = $('input[name=ajax_url]').val();
var ajax_url1 = $('input[name=ajax_url1]').val();

$('#driverRequests').DataTable({
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
      { "orderable": false, "targets": [0,1,3,4] }
    ],
    "aaSorting": [],
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: ajax_url, // json datasource
      type: "post", // method , by default get
      // error: function() { // error handling
      //   $(".employee-grid-error").html("");
      //   $("#employee-grid").append('<tbody class="orders-error"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
      //   $("#employee-grid_processing").css("display", "none");
      //   $('#employee-grid_length').css({
      //     "margin-left": "10px"
      //   });
      // }
    }


})


$('#callOrderRequests').DataTable({
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
        { "orderable": false, "targets": [0,1,5,6] }
      ],
      "aaSorting": [],
      "processing": true,
      "serverSide": true,
      "ajax": {
        url: ajax_url1, // json datasource
        type: "post", // method , by default get
        // error: function() { // error handling
        //   $(".employee-grid-error").html("");
        //   $("#employee-grid").append('<tbody class="orders-error"><tr><th colspan="10">No data found in the server</th></tr></tbody>');
        //   $("#employee-grid_processing").css("display", "none");
        //   $('#employee-grid_length').css({
        //     "margin-left": "10px"
        //   });
        // }
      }

})
