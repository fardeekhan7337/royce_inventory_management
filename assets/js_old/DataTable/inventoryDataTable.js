
var available_inv = $('input[name=available_inv]').val();
var missing_inv = $('input[name=missing_inv]').val();
var return_inv = $('input[name=return_inv]').val();
var exchange_inv = $('input[name=exchange_inv]').val();

$('#invAvailableDataTable').DataTable({
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
    "ajax": {
      url: available_inv, // json datasource
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


$('#invMissingDataTable').DataTable({
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
      "ajax": {
        url: missing_inv, // json datasource
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


$('#invReturnDataTable').DataTable({
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
      "ajax": {
        url: return_inv, // json datasource
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


$('#invExchangeDataTable').DataTable({
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
      "ajax": {
        url: exchange_inv, // json datasource
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
