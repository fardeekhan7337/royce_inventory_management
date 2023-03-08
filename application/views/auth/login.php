


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
            <div class="col-md-6">
               <div class="row justify-content-center">
                  <div class="col-md-10">
                     <div class="card card-transparent shadow-none d-flex justify-content-center mb-0 auth-card">
                        <div class="card-body">
                           <a href="<?= site_url('login') ?>" class="navbar-brand d-flex align-items-center mb-3">

                             <!--Logo start-->
                             <div style="max-width: 88px;margin:auto">

                               <img src="<?= companySetting('logo') ?>" alt="" style="width:100%;height:80px;margin-left:11px">

                             </div>
                             <!--logo End-->
                             <h4 class="logo-title"></h4>

                           </a>
                           <h2 class="mb-2 text-center">Sign In</h2>
                           <p class="text-center">Login to stay connected.</p>
                           <form action="<?= site_url('login_user') ?>" method="post">
                              <div class="row">
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="email" class="form-label">Username</label>
                                       <input type="text" class="form-control" id="username" name="username" aria-describedby="username" value="<?= isset($_COOKIE["loginUsername"])?$_COOKIE["loginUsername"]:'' ?>">
                                    </div>
                                 </div>
                                 <div class="col-lg-12">
                                    <div class="form-group">
                                       <label for="password" class="form-label">Password</label>
                                       <input type="password" class="form-control" id="password" name="password" aria-describedby="password" value="<?= isset($_COOKIE["loginPass"])?$_COOKIE["loginPass"]:'' ?>">
                                    </div>
                                 </div>
                                 <div class="col-lg-12 d-flex justify-content-between">
                                    <div class="form-check mb-3">
                                       <input type="checkbox" class="form-check-input" id="customCheck1" name="remember_me" <?= isset($_COOKIE["loginUsername"])?'checked':'' ?> >
                                       <label class="form-check-label" for="customCheck1">Remember Me</label>
                                    </div>
                                    <a href="<?= site_url('forget_password')?>">Forgot Password?</a>
                                 </div>
                              </div>
                              <div class="d-flex justify-content-center">
                                 <button type="submit" class="btn btn-primary">Sign In</button>
                              </div>
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="sign-bg">

               </div>
            </div>
            <div class="col-md-6 d-md-block d-none bg-primary p-0 mt-n1 vh-100 overflow-hidden">
               <img src="<?= base_url('assets/images/auth/01.png') ?>" class="img-fluid gradient-main animated-scaleX" alt="images">
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
