<!-- sidebar start-->
<aside class="sidebar sidebar-default navs-rounded-all ">
    <div class="sidebar-header d-flex align-items-center justify-content-start company_logo_div">
        <a href="<?= site_url('dashboard') ?>" class="navbar-brand">
            <!--Logo start-->
            <img src="<?= companySetting('logo') ?>" alt="" style="width:100%;height:80px;">
            <!--logo End-->
            <h4 class="logo-title"></h4>
        </a>
        <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
            <i class="icon">
                <i class="fa-solid fa-arrow-left-long"></i>
            </i>
        </div>
    </div>
    <div class="sidebar-body pt-0 data-scrollbar">
        <div class="sidebar-list">
            <!-- Sidebar Menu Start -->
            <ul class="navbar-nav iq-main-menu" id="sidebar-menu">

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'dashboard'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('dashboard') ?>">
                        <i class="icon">
                            <i class="fa fa-home"></i>
                        </i>
                        <span class="item-name"><?= __('dashboard') ?></span>
                    </a>
                </li>

                <?php if (isUserAllow(1) || isUserAllow(5) || isUserAllow(11) || isUserAllow(16) || UTYPE() == 'admin'): ?>

                <li>
                    <hr class="hr-horizontal">
                </li>
                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon"><?= __('manage') ?></span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'users'?'active':'' ?>" data-bs-toggle="collapse"
                        href="#users-auth" role="button" aria-expanded="false" aria-controls="users-user">
                        <i class="icon">
                            <i class="fa fa-users"></i>
                        </i>
                        <span class="item-name"><?= __('users') ?></span>
                        <i class="right-icon">
                            <i class="fa-solid fa-angle-right"></i>
                        </i>
                    </a>
                    <ul class="sub-nav collapse <?= $active_menu == 'users'?'show':'' ?>" id="users-auth"
                        data-bs-parent="#users-menu">

                        <?php if (isUserAllow(1)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'admins'?'active':'' ?>"
                                href="<?= site_url('admins') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> A </i>
                                <span class="item-name"><?= __('admins') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(5)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'drivers'?'active':'' ?>"
                                href="<?= site_url('drivers') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> D </i>
                                <span class="item-name"><?= __('drivers') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(11)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'productions'?'active':'' ?>"
                                href="<?= site_url('productions') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> P </i>
                                <span class="item-name"><?= __('production') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(16)): ?>


                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'others_users'?'active':'' ?>"
                                href="<?= site_url('other_users') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> O </i>
                                <span class="item-name"><?= __('other') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (UTYPE() == 'admin'): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'rights'?'active':'' ?>"
                                href="<?= site_url('rights') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> R </i>
                                <span class="item-name"><?= __('rights') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                    </ul>
                </li>

                <?php endif; ?>

                <?php if (isUserAllow(21)): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'categories'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('categories') ?>">
                        <i class="icon">
                            <i class="fa-solid fa-soap"></i>
                        </i>
                        <span class="item-name"><?= __('product_categories') ?></span>
                    </a>
                </li>

                <?php endif; ?>

                <?php if (isUserAllow(25)): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'products'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('products') ?>">
                        <i class="icon">
                            <i class="fa-brands fa-product-hunt"></i>
                        </i>
                        <span class="item-name"><?= __('products') ?></span>
                    </a>
                </li>

                <?php endif; ?>

                <?php if (isUserAllow(30)): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'customers'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('customers') ?>">
                        <i class="icon">
                            <i class="fa fa-users"></i>
                        </i>
                        <span class="item-name"><?= __('customers') ?></span>
                    </a>
                </li>

                <?php endif; ?>


                <?php if (isUserAllow(35) || isUserAllow(37) || isUserAllow(38) || isUserAllow(39) || isUserAllow(40) || isUserAllow(41) || isUserAllow(42) ||
					isUserAllow(43) || isUserAllow(44) || isUserAllow(45)): ?>

                <li>
                    <hr class="hr-horizontal">
                </li>

                <li class="nav-item static-item">
                    <a class="nav-link static-item disabled" href="#" tabindex="-1">
                        <span class="default-icon"><?= __('pages') ?></span>
                        <span class="mini-icon">-</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'inventory'?'active':'' ?>" data-bs-toggle="collapse"
                        href="#inventory-auth" role="button" aria-expanded="false" aria-controls="inventory-user">
                        <i class="icon">
                            <i class="fa-solid fa-warehouse"></i>
                        </i>
                        <span class="item-name">
                            <?= __('inventory') ?>

                            <?php if (isUserAllow(44)): ?>

                            <span class="badge rounded-pill bg-success"
                                style="margin-left:6px">
                                <?php

                                  $login_user = loginUserDetails($this->session->userdata('UID'));

                                  if($login_user->type == 'driver')
                                  {
                                    echo showPendingRequestCount();
                                  }
                                  else
                                  {
                                    echo showPendingRequestCount() + showDriverRequestCount();
                                  }

                                ?></span>

                            <?php endif; ?>
                        </span>
                        <i class="right-icon">
                            <i class="fa-solid fa-angle-right"></i>
                        </i>
                    </a>
                    <ul class="sub-nav collapse" id="inventory-auth" data-bs-parent="#inventory-menu">

                        <?php if (isUserAllow(35)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'view_inventory'?'active':'' ?>"
                                href="<?= base_url('view_inventory') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> VI </i>
                                <span class="item-name"><?= __('view_inventory') ?></span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (isUserAllow(37)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'add_stock'?'active':'' ?>"
                                href="<?= base_url('add_stock') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> AS </i>
                                <span class="item-name"><?= __('add_stock') ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (isUserAllow(38)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'view_stock'?'active':'' ?>"
                                href="<?= base_url('view_stock') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> VS </i>
                                <span class="item-name"><?= __('view_stock') ?></span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if (isUserAllow(39)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'stock_history'?'active':'' ?>"
                                href="<?= base_url('stock_history') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> SH </i>
                                <span class="item-name"><?= __('stock_history') ?></span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (isUserAllow(40)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'assign_to_driver'?'active':'' ?>"
                                href="<?= base_url('assign_to_driver') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> ATD </i>
                                <span class="item-name"><?= __('assign_to_driver') ?>
                                  <span class="badge rounded-pill bg-success"
                                      style="margin-left:6px"><?= showDriverRequestCount() ?></span></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(41)): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'return_stock'?'active':'' ?>"
                                href="<?= base_url('return_stock') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> RS </i>
                                <span class="item-name"><?= __('return_stock') ?></span>
                            </a>
                        </li>
                        <?php endif; ?>

                        <?php if (isUserAllow(42)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'live_stock'?'active':'' ?>"
                                href="<?= base_url('live_stock') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> LS </i>
                                <span class="item-name"><?= __('live_stock') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(43)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'request_stock'?'active':'' ?>"
                                href="<?= base_url('request_stock') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> Rs </i>
                                <span class="item-name"><?= __('request_stock') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(44)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'pending_request'?'active':'' ?>"
                                href="<?= base_url('pending_request') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> PR </i>
                                <span class="item-name"><?= __('pending_requests') ?>
                                    <span class="badge rounded-pill bg-success"
                                        style="margin-left:6px"><?= showPendingRequestCount() ?></span>
                                </span>
                            </a>
                        </li>

                        <?php endif; ?>
                        <?php if (isUserAllow(82)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'goods_return'?'active':'' ?>"
                                href="<?= base_url('goods_return') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> GR </i>
                                <span class="item-name"><?= __('goods_return') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>

                        <?php if (isUserAllow(81)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'driver_requests'?'active':'' ?>"
                                href="<?= base_url('driver_requests') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> RS </i>
                                <span class="item-name"><?= __('driver_requests') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>



                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'return_summary'?'active':'' ?>"
                                href="<?= base_url('return_summary') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> RS </i>
                                <span class="item-name"><?= __('return_summary') ?></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'missing_stock'?'active':'' ?>"
                                href="<?= base_url('missing_summary') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> MS </i>
                                <span class="item-name"><?= __('missing_summary') ?></span>
                            </a>
                        </li>



                        <?php if (isUserAllow(45)): ?>

                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'logs'?'active':'' ?>"
                                href="<?= base_url('logs') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> L </i>
                                <span class="item-name"><?= __('logs') ?></span>
                            </a>
                        </li>

                        <?php endif; ?>


                    </ul>
                </li>

                <?php endif; ?>

                <?php if (isUserAllow(46) || isUserAllow(47)): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'sales'?'active':'' ?>" aria-current="page"
                        href="<?= base_url('sales') ?>">
                        <i class="icon">
                            <i class="fa-solid fa-circle-dollar-to-slot"></i>
                        </i>
                        <span class="item-name"><?= __('sales') ?></span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (isUserAllow(51)): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'call_order'?'active':'' ?>" aria-current="page"
                        href="<?= base_url('call_order') ?>">
                        <i class="icon">
                            <i class="fa-solid fa-cart-flatbed"></i>
                        </i>
                        <span class="item-name"><?= __('call_orders') ?></span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (isUserAllow(55) || isUserAllow(56)): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'invoices'?'active':'' ?>" aria-current="page"
                        href="<?= base_url('invoices') ?>">
                        <i class="icon">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </i>
                        <span class="item-name"><?= __('invoices') ?></span>
                    </a>
                </li>

                <?php endif; ?>


                <?php if (isUserAllow(59)): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'payments'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('payments') ?>">
                        <i class="icon">
                            <i class="fa fa-money"></i>
                        </i>
                        <span class="item-name"><?= __('payments') ?></span>
                    </a>
                </li>

                <?php endif; ?>

                <?php if (isUserAllow(61)): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'evidence'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('evidence') ?>">
                        <i class="icon">
                            <i class="fa-solid fa-file-shield"></i>
                        </i>
                        <span class="item-name"><?= __('evidence') ?></span>
                    </a>
                </li>
                <?php endif; ?>

                <?php if (isUserAllow(66)): ?>
                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'salesperson'?'active':'' ?>" aria-current="page"
                        href="<?= site_url('salesperson') ?>">
                        <i class="icon">
                            <i class="fa-solid fa-person-dots-from-line"></i>
                        </i>
                        <span class="item-name"><?= __('salesperson') ?></span>
                    </a>
                </li>
                <?php endif; ?>


                <?php if (UTYPE() == 'admin'): ?>

                <li class="nav-item">
                    <a class="nav-link <?= $active_menu == 'setting'?'active':'' ?>" data-bs-toggle="collapse"
                        href="#setting-auth" role="button" aria-expanded="false" aria-controls="setting-user">
                        <i class="icon">
                            <i class="fa-solid fa-gear"></i>
                        </i>
                        <span class="item-name"><?= __('setting') ?></span>
                        <i class="right-icon">
                            <i class="fa-solid fa-angle-right"></i>
                        </i>
                    </a>
                    <ul class="sub-nav collapse" id="setting-auth" data-bs-parent="#setting-menu">
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'company_setting'?'active':'' ?>"
                                href="<?= base_url('company_setting') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> C </i>
                                <span class="item-name"><?= __('company') ?></span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= $active_submenu == 'email_setting'?'active':'' ?>"
                                href="<?= base_url('email_setting') ?>">
                                <i class="icon">
                                    <i class="fa-solid fa-caret-right"></i>
                                </i>
                                <i class="sidenav-mini-icon"> E </i>
                                <span class="item-name"><?= __('email') ?></span>
                            </a>
                        </li>

                    </ul>
                </li>

                <!-- <li class="nav-item mb-5">
						<a class="nav-link <= $active_menu == 'db_export'?'active':'' ?>" aria-current="page" href="<?= site_url('db_export') ?>">
							<i class="icon">
								<i class="fa fa-download"></i>
							</i>
							<span class="item-name">DB Export</span>
						</a>
					</li> -->

                <?php endif; ?>

            </ul>
            <br><br><br><br><br>
            <!-- Sidebar Menu End -->
        </div>
    </div>
    <div class="sidebar-footer"></div>
</aside>

<!-- sidebar end-->


<main class="main-content">
    <div class="position-relative iq-banner">
        <!--Nav Start-->
        <nav class="nav navbar navbar-expand-lg navbar-light iq-navbar">
            <div class="container-fluid navbar-inner">
                <a href="<?= site_url('dashboard') ?>" class="navbar-brand">
                    <!--Logo start-->
                    <!-- <i class="fa-solid fa-hashtag"></i> -->
                    <img src="<?= base_url('assets/images/company_logo.jpg')?>" alt="" style="width:100%;height:45px;">
                    <!--logo End-->
                    <h4 class="logo-title"></h4>
                </a>
                <div class="sidebar-toggle" data-toggle="sidebar" data-active="true">
                    <i class="icon">
                        <i class="fa-solid fa-arrow-right-long"></i>
                    </i>
                </div>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <span class="mt-2 navbar-toggler-bar bar1"></span>
                        <span class="navbar-toggler-bar bar2"></span>
                        <span class="navbar-toggler-bar bar3"></span>
                    </span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="mb-2 navbar-nav ms-auto align-items-center navbar-list mb-lg-0">
                        <li class="nav-item dropdown">

                            <div class="row">
                                <div class="col-sm-1" style="margin-top: 3px;font-size: 24px;">

                                    <label><i class="fa-solid fa-globe"></i></label>

                                </div>
                                <div class="col-sm-9">

                                    <select class="form-control change_language_">

                                        <option value="Eng"
                                            <?= $this->session->userdata('user_language') != 'CHN'?'selected':'' ?>>
                                            English</option>
                                        <option value="CHN"
                                            <?= $this->session->userdata('user_language') == 'CHN'?'selected':'' ?>>
                                            Chinese</option>

                                    </select>

                                </div>
                            </div>

                        </li>
                        <?php

								$login_user = loginUserDetails($this->session->userdata('UID'));

							?>
                        <li class="nav-item dropdown">
                            <a class="py-0 nav-link d-flex align-items-center" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                <?php
									if (@getimagesize(base_url('uploads/'.$login_user->type.'/'.$login_user->img)) && !empty($login_user->img))
									{
										 	$user_img_url = base_url('uploads/'.$login_user->type.'/'.$login_user->img);
									}
									else
									{
											$user_img_url = base_url('assets/images/avatars/01.png');
									}
									 ?>
                                <img src="<?= $user_img_url ?>" alt="User-Profile"
                                    class="theme-color-default-img img-fluid avatar avatar-50 avatar-rounded">
                                <div class="caption ms-3 d-none d-md-block ">
                                    <h6 class="mb-0 caption-title"><?= $login_user->name?></h6>
                                    <p class="mb-0 caption-sub-title"><?= ucfirst($login_user->type )?></p>
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('edit_profile') ?>">
                                        <i class="fa-solid fa-user-pen"></i> Edit Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('view_profile') ?>">
                                        <i class="fa-solid fa-id-card-clip"></i> View Profile
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url('logout') ?>">
                                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
