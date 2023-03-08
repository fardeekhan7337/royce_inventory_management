<!-- Nav Header Component Start -->
<?= getHiddenField('sale_filter',site_url('AjaxController/getAllSalesandCreditAmounts')); ?>
<?= getHiddenField('daily_sale_filter',site_url('AjaxController/getDailySalesandCreditAmounts')); ?>
<div class="iq-navbar-header" style="height: 215px;">
  <div class="container-fluid iq-container">
    <div class="row">
      <div class="col-md-12" style="z-index:1!important;">
        <div class="flex-wrap d-flex justify-content-between align-items-center">
          <div>

            <h1>Hello <?= $user->name; ?>!</h1>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="iq-header-img" style="z-index:0!important;">
    <img src="<?= base_url('assets/images/dashboard/top-header.png') ?>" alt="header"
      class="theme-color-default-img img-fluid w-100 h-100 animated-scaleX">
  </div>
</div> <!-- Nav Header Component End -->
<!--Nav End-->
</div>
<div class="conatiner-fluid content-inner mt-n5 py-0" style=" padding-top: 0px!important;background: #e9ecef !important;">
<div class="row">
  <div class="col-md-12 col-lg-12">
    <div class="row row-cols-1">
      <div class="overflow-hidden d-slider1 ">
        <ul class="p-0 m-0 mb-2 swiper-wrapper list-inline">
          <?php if ($user->type == 'admin'): ?>

          <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
            <div class="card-body">
              <div class="progress-widget">
                <div id="circle-progress-01"
                  class="text-center circle-progress-01 circle-progress circle-progress-primary"
                  data-min-value="0" data-max-value="100" data-value="90"
                  data-type="percent">
                  <i class="fa-solid fa-sack-dollar dashboard-icons"></i>
                </div>
                <div class="progress-detail">
                  <p class="mb-2">Total Sales</p>
                  <h4 class="counter">
                    <?= isset($sale->total_amount)?change_number_format($sale->total_amount):'0'; ?>
                  </h4>
                </div>
              </div>
            </div>
          </li>
          <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
            <div class="card-body">
              <div class="progress-widget">
                <div id="circle-progress-02"
                  class="text-center circle-progress-01 circle-progress circle-progress-info"
                  data-min-value="0" data-max-value="100" data-value="80"
                  data-type="percent">
                  <i class="fa-solid fa-coins dashboard-icons"></i>
                </div>
                <div class="progress-detail">
                  <p class="mb-2">Total Credit</p>
                  <h4 class="counter">
                    <?php

                      $total_ = checkIsset($payment->total_credit) - checkIsset($payment->total_debit);

                      echo change_number_format($total_);

                     ?>
                  </h4>
                </div>
              </div>
            </div>
          </li>
          <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
            <div class="card-body">
              <div class="progress-widget">
                <div id="circle-progress-03"
                  class="text-center circle-progress-01 circle-progress circle-progress-primary"
                  data-min-value="0" data-max-value="100" data-value="70"
                  data-type="percent">
                  <i class="fa-solid fa-user-group dashboard-icons"></i>
                </div>
                <div class="progress-detail">
                  <p class="mb-2">Total Customers</p>
                  <h4 class="counter"><?= $customers ?></h4>
                </div>
              </div>
            </div>
          </li>
          <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
            <div class="card-body">
              <div class="progress-widget">
                <div id="circle-progress-04"
                  class="text-center circle-progress-01 circle-progress circle-progress-info"
                  data-min-value="0" data-max-value="100" data-value="60"
                  data-type="percent">

                  <i class="fa-solid fa-car-rear dashboard-icons"></i>

                </div>
                <div class="progress-detail">
                  <p class="mb-2">Total Drivers</p>
                  <h4 class="counter"><?= $drivers ?></h4>
                </div>
              </div>
            </div>
          </li>
          <?php endif; ?>
          <?php if ($user->type == 'driver'): ?>

            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
              <div class="card-body">
                <div class="progress-widget">
                  <div id="circle-progress-01"
                    class="text-center circle-progress-01 circle-progress circle-progress-primary"
                    data-min-value="0" data-max-value="100" data-value="90"
                    data-type="percent">
                    <svg class="card-slie-arrow " width="24" height="24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z"></path>
                    </svg>

                  </div>
                  <div class="progress-detail">
                    <p class="mb-2">Stock Taken</p>
                    <h4 class="counter"><?= $stock->total_assign_qty != ''?$stock->total_assign_qty:0 ?></h4>
                  </div>
                </div>
              </div>
            </li>
            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="800">
              <div class="card-body">
                <div class="progress-widget">
                  <div id="circle-progress-02"
                    class="text-center circle-progress-01 circle-progress circle-progress-info"
                    data-min-value="0" data-max-value="100" data-value="80"
                    data-type="percent">
                    <svg class="card-slie-arrow " width="24" height="24px" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M5,17.59L15.59,7H9V5H19V15H17V8.41L6.41,19L5,17.59Z"></path>
                     </svg>

                  </div>
                  <div class="progress-detail">
                    <p class="mb-2">Stock Given</p>
                    <h4 class="counter"><?= checkIsset($stock->total_assign_qty) - checkIsset($stock->total_available_qty)  ?></h4>
                  </div>
                </div>
              </div>
            </li>
            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="900">
              <div class="card-body">
                <div class="progress-widget">
                  <div id="circle-progress-03"
                    class="text-center circle-progress-01 circle-progress circle-progress-primary"
                    data-min-value="0" data-max-value="100" data-value="70"
                    data-type="percent">
                    <svg class="card-slie-arrow " width="24" viewBox="0 0 24 24">
                       <path fill="currentColor" d="M19,6.41L17.59,5L7,15.59V9H5V19H15V17H8.41L19,6.41Z"></path>
                    </svg>

                 </div>
                 <div class="progress-detail">
                   <p class="mb-2">Stock Inhand</p>
                   <h4 class="counter"><?= $stock->total_available_qty != '' || $stock->total_exchange_qty != ''?$stock->total_available_qty + $stock->total_exchange_qty:0 ?></h4>
                 </div>
                </div>
              </div>
            </li>

          <?php endif; ?>
          <?php if ($user->type == 'production'): ?>

            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="700">
              <div class="card-body">
                <div class="progress-widget">
                  <div id="circle-progress-01"
                    class="text-center circle-progress-01 circle-progress circle-progress-primary"
                    data-min-value="0" data-max-value="100" data-value="90"
                    data-type="percent">
      								<i class="fa-brands fa-product-hunt dashboard-icons"></i>
                  </div>
                  <div class="progress-detail">
                    <p class="mb-2">Total Products</p>
                    <h4 class="counter"><?= $products ?></h4>
                  </div>
                </div>
              </div>
            </li>
            <li class="swiper-slide card card-slide" data-aos="fade-up" data-aos-delay="1000">
              <div class="card-body">
                <div class="progress-widget">
                  <div id="circle-progress-04"
                    class="text-center circle-progress-01 circle-progress circle-progress-info"
                    data-min-value="0" data-max-value="100" data-value="60"
                    data-type="percent">

                    <i class="fa-solid fa-car-rear dashboard-icons"></i>

                  </div>
                  <div class="progress-detail">
                    <p class="mb-2">Total Drivers</p>
                    <h4 class="counter"><?= $drivers ?></h4>
                  </div>
                </div>
              </div>
            </li>
          <?php endif; ?>
        </ul>
        <div class="swiper-button swiper-button-next"></div>
        <div class="swiper-button swiper-button-prev"></div>
      </div>
    </div>
  </div>
  <div class="col-md-12 col-lg-12">
    <div class="row">
      <?php if ($user->type == 'admin'): ?>
      <div class="col-md-12">
        <div class="card" data-aos="fade-up" data-aos-delay="800">
          <div class="flex-wrap card-header d-flex justify-content-between align-items-center">
            <!-- <div class="header-title">
              <h4 class="card-title">855.8</h4>
              <p class="mb-0">Total Sales</p>
            </div> -->
            <div class="d-flex align-items-center align-self-center">
              <div class="d-flex align-items-center text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24"
                  fill="currentColor">
                  <g>
                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                  </g>
                </svg>
                <div class="ms-2">
                  <span class="text-secondary">Sales</span>
                </div>
              </div>
              <div class="d-flex align-items-center ms-3 text-info">
                <svg xmlns="http://www.w3.org/2000/svg" width="12" viewBox="0 0 24 24"
                  fill="currentColor">
                  <g>
                    <circle cx="12" cy="12" r="8" fill="currentColor"></circle>
                  </g>
                </svg>
                <div class="ms-2">
                  <span class="text-secondary">Credit</span>
                </div>
              </div>
            </div>
            <div class="dropdown">
              <a href="#" class="text-secondary dropdown-toggle selected_sale_filter_" id="dropdownMenuButton22"
                data-bs-toggle="dropdown" aria-expanded="false">
                This Week
              </a>
              <ul class="dropdown-menu dropdown-menu-end"
                aria-labelledby="dropdownMenuButton22">
                <li><a class="dropdown-item sale_filter_" data-type="weekly" href="javascript:void(0)">This Week</a></li>
                <li><a class="dropdown-item sale_filter_" data-type="monthly" href="javascript:void(0)">This Month</a></li>
                <li><a class="dropdown-item sale_filter_" data-type="yearly" href="javascript:void(0)">This Year</a></li>
              </ul>
            </div>
          </div>
          <div class="card-body">
            <div id="d-main-my" class="d-main-my"></div>
          </div>
        </div>
      </div>
           <div class="col-md-12 col-xl-12">
            <div class="card" data-aos="fade-up" data-aos-delay="900">
               <div class="flex-wrap card-header d-flex justify-content-between">
                  <div class="header-title">
                     <h4 class="card-title">Daily Sales</h4>
                  </div>
                  <!-- <div class="dropdown">
                     <a href="#" class="text-secondary dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                        This Week
                     </a>
                     <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton1">
                        <li><a class="dropdown-item" href="#">This Week</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                     </ul>
                  </div> -->
               </div>
               <div class="card-body">
                  <div class="flex-wrap d-flex align-items-center justify-content-between">
                     <div id="myChart" class="col-md-8 col-lg-8 myChart"></div>
                     <div class="d-grid gap col-md-4 col-lg-4">
                        <div class="d-flex align-items-start">
                           <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#3a57e8">
                              <g>
                                 <circle cx="12" cy="12" r="8" fill="#3a57e8"></circle>
                              </g>
                           </svg>
                           <div class="ms-3">
                              <span class="text-secondary">Sales</span>
                              <h6><?= $total_daily_sale_amount ?></h6>
                           </div>
                        </div>
                        <div class="d-flex align-items-start">
                           <svg class="mt-2" xmlns="http://www.w3.org/2000/svg" width="14" viewBox="0 0 24 24" fill="#4bc7d2">
                              <g>
                                 <circle cx="12" cy="12" r="8" fill="#4bc7d2"></circle>
                              </g>
                           </svg>
                           <div class="ms-3">
                              <span class="text-secondary">Credit</span>
                              <h6><?= $total_daily_credit_amount ?></h6>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <div class="col-md-12 col-lg-12">
        <div class="overflow-hidden card" data-aos="fade-up" data-aos-delay="600">
          <div class="p-0 card-body">
            <div class="mt-4 table-responsive">
              <table id="basic-table" class="table mb-0" role="grid">
                <thead>
                  <tr>
                    <th>#</th>

                    <th>Shop Name</th>
                    <th>Shop Acronym</th>
                    <th>Email</th>
                    <th>Contact #</th>
                    <th>Shop ID </th>
                    <th>Total Credit</th>
                  </tr>
                </thead>
                <tbody>

                  <?php if (!empty($customer_credits)): ?>

                  <?php foreach ($customer_credits as $key => $v): ?>

                  <tr>
                    <td><?= $key+1 ?></td>

                    <td><?= $v->shop_name ?></td>
                    <td><?= $v->shop_acronym ?></td>
                    <td><?= $v->e_receipt_email ?></td>
                    <td><?= $v->primary_contact ?></td>
                    <td><?= $v->shop_id ?></td>
                    <td><?php  $a = $v->total_credit - $v->total_debit;
                        echo change_number_format($a);?></td>
                  </tr>

                  <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <th colspan="7">No record found...</th>
                    </tr>
                <?php endif; ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <?php endif; ?>

      <?php if ($user->type == 'driver'): ?>
      <div class="col-md-12 col-lg-12">
        <div class="overflow-hidden card" data-aos="fade-up" data-aos-delay="600">
          <div class="p-0 card-body mb-2">
            <h4 class="mt-2" style="margin-left:8px;">
              Call Orders
            </h4>
            <div class="mt-2 table-responsive">
              <table id="basic-table" class="table mb-0" role="grid">
                <thead>
                  <tr>
                    <th style="width:2%;">#</th>
                    <!-- <th>Customer</th> -->
                    <th>Shop Name</th>
                    <th>Shop Acronym</th>
                    <th>Total Products</th>
                    <th>Total Qty</th>
                    <th>Action </th>
                  </tr>
                </thead>
                <tbody>

                  <?php if (!empty($call_orders)): ?>
                  <?php foreach ($call_orders as $key => $v): ?>

                  <tr>
                    <td><?= $key+1 ?></td>
                    <!-- <td><= $v->customer_name ?></td> -->
                    <td><?= $v->shop_name ?></td>
                    <td><?= $v->shop_acronym ?></td>
                    <td><?= $v->total_products ?></td>
                    <td><?= $v->total_qty ?></td>
                    <td>
                      <button class="btn btn-primary accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne<?= $v->id ?>" aria-expanded="true" aria-controls="collapseOne<?= $v->id ?>">
                          <i class="fa-solid fa-circle-down"></i>
                      </button>
                    </td>
                  </tr>
                  <tr id="collapseOne<?= $v->id ?>" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                    <td colspan="6">
                      <div class="row">
                        <div class="col-sm-8 m-auto">
                          <h3 class="mb-2">Details</h3>
                          <table class="table">
                            <tr style="background-color: #f5f6fa;">
                                <th style="width:2%;">#</th>
                                <th>Product</th>
                                <th>Qty</th>
                            </tr>
                            <?php if (isset($call_orders_details[$key]) && !empty($call_orders_details[$key])): ?>

                            <?php foreach ($call_orders_details[$key] as $key1 => $v1): ?>

                              <tr>
                                  <td><?= $key1+1 ?></td>
                                  <td><?= $v1->product_name ?></td>
                                  <td><?= $v1->qty ?></td>
                              </tr>

                            <?php endforeach; ?>

                            <?php endif; ?>
                          </table>
                        </div>
                      </div>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                  <?php else: ?>
                    <tr>
                      <th colspan="6">No record found...</th>
                    </tr>

                  <?php endif; ?>

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <?php endif; ?>

    </div>
  </div>

</div>
</div>
