


<!doctype html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <title><?= $title ?></title>

      <!-- Favicon -->
      <link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>" />

      <!-- Hope Ui Design System Css -->
      <link rel="stylesheet" href="<?= base_url('assets/css/hope-ui.min.css?v=1.2.0') ?>" />

      <!-- Aos Animation Css -->
      <link rel="stylesheet" href="<?= base_url('assets/vendor/aos/dist/aos.css') ?>" />

      <!-- toastr  css -->
      <link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css') ?>" />

      <style type="text/css">
      .form-control,.form-select
      {
        border: 1px solid #c7c7c7!important;
      }
      </style>
  </head>
  <body class=" " data-bs-spy="scroll" data-bs-target="#elements-section" data-bs-offset="0" tabindex="0">
    <!-- loader Start -->
    <div id="loading">
      <div class="loader simple-loader">
          <div class="loader-body"></div>
      </div>    </div>
    <!-- loader END -->

      <div class="wrapper">
      <section class="login-content">
         <div class="row m-0 align-items-center bg-white vh-100">
           <div class="col-md-6 p-0">
               <div class="card card-transparent auth-card shadow-none d-flex justify-content-center mb-0">
                  <div class="card-body">
                      <a href="<?= site_url('login') ?>" class="navbar-brand d-flex align-items-center mb-3">

                        <!--Logo start-->
                        <div style="max-width: 88px;">

                          <img src="<?= companySetting('logo') ?>" alt="" style="width:100%;height:80px;margin-left:11px">

                        </div>
                        <!--logo End-->
                        <h4 class="logo-title"></h4>

                      </a>
                     <h2 class="mb-2">Reset Password</h2>
                     <p>Enter your email address and we'll send you an email with instructions to reset your password.</p>
                     <form action="<?= site_url('send_forgetpassword_link') ?>" method="post">
                        <div class="row">
                           <div class="col-lg-12">
                              <div class="floating-label form-group">
                                 <label for="email" class="form-label">Email</label>
                                 <input type="email" class="form-control" id="email" aria-describedby="email" name="email">
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Reset</button>
                     </form>
                  </div>
               </div>
               <div class="sign-bg sign-bg-right">
               </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="<?= site_url('assets/images/auth/02.png') ?>" class="img-fluid gradient-main animated-scaleX" alt="images">
            </div>
         </div>
      </section>
      </div>


      <!-- Library Bundle Script -->
      <script src="<?= base_url('assets/js/core/libs.min.js') ?>"></script>

      <!-- AOS Animation Plugin-->
      <script src="<?= base_url('assets/vendor/aos/dist/aos.js') ?>"></script>

      <!-- App Script -->
      <script src="<?= base_url('assets/js/hope-ui.js') ?>" defer></script>

      <!-- toastr  js -->
      <script src="<?= base_url('assets/js/toastr/toastr.min.js') ?>"></script>

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
