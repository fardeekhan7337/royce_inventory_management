<!-- Footer Section Start -->
  <footer class="footer">
    <div class="footer-body">
      <ul class="left-panel list-inline mb-0 p-0">

      </ul>
      <div class="right-panel">
        ©<script>
          document.write(new Date().getFullYear())

          </script>
          <a href="http://www.alphinex.com">Alphinex Solutions</a>
      </div>
    </div>
  </footer>
  <!-- Footer Section End -->
</main>

<!-- Wrapper End-->

  <!-- Library Bundle Script -->
  <script src="<?= base_url('assets/js/core/libs.min.js') ?>"></script>

  <!-- External Library Bundle Script -->
  <script src="<?= base_url('assets/js/core/external.min.js') ?>"></script>

  <?php

    if(isset($scripts) && !empty($scripts))
    {

      foreach ($scripts as $key => $v) {

          if($v == 'dataTable_buttons')
          {
  ?>
          <!-- datatable button js -->
          <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
          <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>


  <?php
        break;

        }

      }

    }
   ?>


  <!-- AOS Animation Plugin-->
  <script src="<?= base_url('assets/vendor/aos/dist/aos.js') ?>"></script>

  <!-- App Script -->
  <script src="<?= base_url('assets/js/hope-ui.js') ?>" defer></script>

  <!--select2 js-->
  <script src="<?= base_url('assets/js/select2/select2.min.js') ?>"></script>

  <!-- toastr  js -->
  <script src="<?= base_url('assets/js/toastr/toastr.min.js') ?>"></script>

  <!-- parsely  js -->
  <script src="<?= base_url('assets/js/parsley/parsley.js') ?>"></script>

  <script type="text/javascript">

    $('#myForm').parsley()

    $('.select2').select2();

    $('.modal_select_').select2({

       dropdownParent: $('.select2_modal_')

    });

    $('.modal_select_assign_').select2({

      dropdownParent: $('.assign_modal_select_')

    });

    $('.change_language_').change(function () {
        
      let val = $(this).val()

      $.ajax({
        
        type: 'post',
        url : '<?= site_url('Dashboard/update_language/') ?>'+val,
        dataType : 'json',
        success : function (data) {

          location.reload(true)

        }


      })

    })

  </script>
  <?php

    if(isset($scripts) && !empty($scripts))
    {

      foreach ($scripts as $key => $v) {

          if($v != 'dataTable_buttons')
          {

  ?>

      <script src="<?= base_url('assets/js/'.$v) ?>"></script>

  <?php
        }

      }

    }
   ?>

   <?php if ($this->session->flashdata('_success')): ?>

     <script type="text/javascript">

      var _succes_msg = `<?= $this->session->flashdata('_success') ?>`

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

     </script>
    <?php endif; ?>

    <?php if ($this->session->flashdata('_error')): ?>

      <script type="text/javascript">

       var _error_msg = `<?= $this->session->flashdata('_error') ?>`;

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

      </script>
     <?php endif; ?>

</body>

</html>
