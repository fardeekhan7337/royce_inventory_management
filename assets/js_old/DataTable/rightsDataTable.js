
var ajax_url = $('input[name=ajax_url]').val();

$('#myDataTable').DataTable({
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
      "aaSorting": []

})
