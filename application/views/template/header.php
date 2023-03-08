<!doctype html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>
		<?php
		if(isset($title) && !empty($title))
		{
			echo $title;
		}else
		{
			echo 'Royce';
		}  ?>
	</title>

	<!-- Favicon -->
	<link rel="shortcut icon" href="<?= base_url('assets/images/favicon.ico') ?>" />

	<!-- Library / Plugin Css Build -->
	<link rel="stylesheet" href="<?= base_url('assets/css/core/libs.min.css') ?>" />

	<!-- Aos Animation Css -->
	<link rel="stylesheet" href="<?= base_url('assets/vendor/aos/dist/aos.css') ?>" />

	<!-- Hope Ui Design System Css -->
	<link rel="stylesheet" href="<?= base_url('assets/css/hope-ui.min.css?v=1.2.0') ?>" />

	<!-- Custom Css -->
	<link rel="stylesheet" href="<?= base_url('assets/css/custom.min.css?v=1.2.0') ?>" />

	<!-- datatable button Css -->
	<link rel="stylesheet" href="<?= base_url('assets/css/dataTable/buttons.dataTables.min.css') ?>" />

	<!-- toastr  css -->
	<link rel="stylesheet" href="<?= base_url('assets/css/toastr.min.css') ?>" />

	<!-- select 2 css-->
	<link href="<?= base_url('assets/css/select2/select2.min.css') ?>" rel="stylesheet" />

	<!-- parsely  css-->
	<link href="<?= base_url('assets/css/parsley/parsley.css') ?>" rel="stylesheet" />

	<!-- Font Awesome script -->
	<script src="https://kit.fontawesome.com/b04cb78fd5.js" crossorigin="anonymous"></script>

    <?php

      if(isset($styles) && !empty($styles))
      {

        foreach ($styles as $key => $v) {

    ?>

        <link rel="stylesheet" href="<?= base_url('assets/css/'.$v) ?>" />

    <?php

        }

      }
     ?>

		 <style type="text/css">

				.form-control,.form-select
				{
					border: 1px solid #c7c7c7!important;
				}

				.action-icons,.action-icons:hover
				{
					color : grey;
				}

				.view-details-txt
				{
					color : black!important;
					font-size: 15px;
				}

				.accordion-item {
				    background-color: white;
				}

				.form-switch .form-check-input {
    			background-color: #ff3b3b;
				}

				.btn-lign-right
				{
					text-align: right!important;
				}
				.btn-group button
				{
					height: 35px;
				}
				.return_stock_inp_cols
				{
					-webkit-box-flex: 0!important;
					-webkit-flex: 0 0 auto!important;
					-ms-flex: 0 0 auto!important;
					flex: 0 0 auto!important;
					width: 11%!important;

				}
				.return_stock_inp_cols label
				{

					font-size: 11px!important;

				}
				#log-details-filter tr th,#log-details-filter tr td
				{
					padding-bottom: 10px!important;
				}
				#log-details-filter tr td
				{
					color: black!important
				}
				#log-details-filter
				{
					margin-left: 18px!important;
				}
				#email_general_setting_save_btn > .col-12
				{
					margin: 0px!important;
					padding: 0px!important;
				}
				#email_general_setting_save_btn > .col-12 > button
				{
					margin-left: 12px;
				}
				.conatiner-fluid.content-inner.mt-n5.py-0 {
					 padding-top: 80px !important;
					 background: #e9ecef !important;
				}

				.form-col-padding
				{
					padding-left: 44px;
				}

				aside.sidebar.sidebar-default.navs-rounded-all.sidebar-mini > .company_logo_div > a > img
				{
					height: 30px!important;
				}

				@media only screen and (max-width: 767px) {
				  /* For mobile phones: */
					.card-header.d-flex.justify-content-between
					{
						   flex-flow: wrap;
					}
					.card-header.d-flex.justify-content-between > .row > .col-sm-12 > span > a
					{
						   margin-top: 10px;
					}
					.btn-group
					{
						flex-flow: column;
					}
					.dt-buttons
					{
						display: inline-table;
						padding-top: 10px;
						padding-bottom: 10px;
					}
					.dt-buttons > .buttons-html5
					{
						margin-right: 7px;
					}
				}

				/* details circular img */
				.details-circular-img {
				  width: 135px;
				  height: 135px;
				  border-radius: 50%;
				  position: relative;
				  overflow: hidden;
					margin:auto;
				}
				.details-circular-img img {
				  min-width: 135px;
				  min-height: 135px;
				  width: auto;
				  height: 100%;
				  position: absolute;
				  background-size: 100%;
				  left: 50%;
				  top: 50%;
				  -webkit-transform: translate(-50%, -50%);
				  -moz-transform: translate(-50%, -50%);
				  -ms-transform: translate(-50%, -50%);
				  transform: translate(-50%, -50%);
				}
				
				@media screen and (max-width: 480px) {
                  .iq-navbar .navbar-brand img{
                        width: 60px!important;
                        height : 60px!important;
                    }
                    .sidebar .navbar-brand img{
                         width: 60px!important;
                        height : 60px!important;
                    }
                }

		 </style>

</head>

<body class="">
	<!-- loader Start -->
	<div id="loading">
		<div class="loader simple-loader">
			<div class="loader-body"></div>
		</div>
	</div>
	<!-- loader END -->
