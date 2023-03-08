<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'Auth/login';
$route['404_override'] = 'CustomError404';
$route['translate_uri_dashes'] = FALSE;

// auth
$route['login'] = 'Auth/login';
$route['login_user'] = 'Auth/checkLoginDetails';
$route['forget_password'] = 'Auth/forget_password';
$route['send_forgetpassword_link'] = 'Auth/send_forgetpassword_link';
$route['change_password/(:any)'] = 'Auth/change_password/$1';
$route['update_password'] = 'Auth/update_password';
$route['logout'] = 'Auth/logout';

//dashbaord
$route['dashboard'] = 'Dashboard';

//Manage
//admin
$route['admins'] = 'Admin';
$route['add_admin'] = 'Admin/create';
$route['save_admin'] = 'Admin/save_admin';
$route['edit_admin/(:num)'] = 'Admin/edit/$1';
$route['update_admin_status/(:any)/(:num)'] = 'Admin/update_status/$1/$2';
$route['delete_admin/(:num)'] = 'Admin/delete/$1';

//driver
$route['drivers'] = 'Driver';
$route['add_driver'] = 'Driver/create';
$route['save_driver'] = 'Driver/save_driver';
$route['edit_driver/(:num)'] = 'Driver/edit/$1';
$route['update_driver_status/(:any)/(:num)'] = 'Driver/update_status/$1/$2';
$route['delete_driver/(:num)'] = 'Driver/delete/$1';


//production
$route['productions'] = 'Production';
$route['add_production'] = 'Production/create';
$route['save_production'] = 'Production/save_production';
$route['edit_production/(:num)'] = 'Production/edit/$1';
$route['update_production_status/(:any)/(:num)'] = 'Production/update_status/$1/$2';
$route['delete_production/(:num)'] = 'Production/delete/$1';

//other users
$route['other_users'] = 'OtherUsers';
$route['add_other_user'] = 'OtherUsers/create';
$route['save_other_user'] = 'OtherUsers/save_other_user';
$route['edit_other_user/(:num)'] = 'OtherUsers/edit/$1';
$route['update_other_user_status/(:any)/(:num)'] = 'OtherUsers/update_status/$1/$2';
$route['delete_other_user/(:num)'] = 'OtherUsers/delete/$1';

//rights
$route['rights'] = 'Rights';
$route['edit_rights/(:any)'] = 'Rights/edit/$1';
$route['save_rights'] = 'Rights/save';


//categories
$route['categories'] = 'Category';
$route['add_category'] = 'Category/create';
$route['save_category'] = 'Category/save_category';
$route['edit_category/(:num)'] = 'Category/edit/$1';
$route['delete_category/(:num)'] = 'Category/delete/$1';


//products
$route['products'] = 'Product';
$route['add_product'] = 'Product/create';
$route['save_product'] = 'Product/save_product';
$route['edit_product/(:num)'] = 'Product/edit/$1';
$route['delete_product/(:num)'] = 'Product/delete/$1';


//customers
$route['customers'] = 'Customer';
$route['add_customer'] = 'Customer/create';
$route['save_customer'] = 'Customer/save_customer';
$route['edit_customer/(:num)'] = 'Customer/edit/$1';
$route['delete_customer/(:num)'] = 'Customer/delete/$1';
$route['update_customer_products_price'] = 'Customer/update_products_price';


//profile
$route['edit_profile'] = 'Profile/edit_profile';
$route['update_profile'] = 'Profile/update_profile';
$route['view_profile'] = 'Profile/view_profile';


//inventory //view inventory
$route['view_inventory'] = 'Inventory';

//inventory //stock
$route['add_stock'] = 'Inventory/add_stock';
$route['save_stock'] = 'Inventory/save_stock';
$route['view_stock'] = 'Inventory/view_stock';
$route['delete_stock/(:num)'] = 'Inventory/delete_stock/$1';
$route['stock_history'] = 'Inventory/stock_history';


// inventory // live_stock
$route['live_stock'] = 'Inventory/live_stock';

// inventory //return_stock
$route['return_stock'] = 'Inventory/return_stock';
$route['save_return_stock'] = 'Inventory/save_return_stock';

// inventory //request_stock
$route['request_stock'] = 'Inventory/request_stock';
$route['save_driver_request'] = 'Inventory/save_driver_stock_request';

// inventory //goods return
$route['goods_return'] = 'Inventory/goods_return';
$route['save_goods_return'] = 'Inventory/save_goods_return';
$route['return_summary'] = 'Inventory/return_summary';
$route['missing_summary'] = 'Inventory/missing_summary';

// inventory //assign_stock
$route['assign_to_driver'] = 'Inventory/assign_to_driver';
$route['save_assign_to_driver'] = 'Inventory/save_assign_to_driver';

// inventory //pending_request
$route['pending_request'] = 'Inventory/pending_request';
$route['update_delivery_order_status/(:num)'] = 'Inventory/update_delivery_order_status/$1';
$route['delete_delivery_order/(:num)'] = 'Inventory/delete_delivery_order/$1';
$route['update_pending_call_order_status/(:num)'] = 'Inventory/update_pending_call_order_status/$1';
$route['delete_pending_call_order/(:num)'] = 'Inventory/delete_pending_call_order/$1';


// inventory //logs
$route['logs'] = 'Inventory/logs';
$route['view_logs'] = 'Inventory/view_logs';

// inventory //driver requests
$route['driver_requests'] = 'Inventory/view_driver_requests';
// $route['print_driver_requests'] = 'Inventory/print_driver_requests';

//sales
$route['sales'] = 'Sales';
$route['add_sale'] = 'Sales/create';
$route['sale_call_order'] = 'Sales/sale_call_order';
$route['edit_sale/(:num)'] = 'Sales/edit/$1';
$route['delete_sale/(:num)'] = 'Sales/delete/$1';
$route['view_sale'] = 'Sales/view_sale';
$route['update_sales_status/(:any)/(:num)'] = 'Sales/update_sales_status/$1/$2';
$route['sales_status_update'] = 'Sales/sales_status_update';

//call order
$route['call_order'] = 'Order';
$route['add_call_order'] = 'Order/create';
$route['save_call_order'] = 'Order/save';
$route['update_call_order_status/(:num)'] = 'Order/update_status/$1';
$route['delete_call_order/(:num)'] = 'Order/delete/$1';


// invoices
$route['invoices'] = 'Invoice';


//evidence
$route['evidence'] = 'Evidence';
$route['add_evidence'] = 'Evidence/create';
$route['save_evidence'] = 'Evidence/save_evidence';
$route['edit_evidence/(:num)'] = 'Evidence/edit/$1';
$route['delete_evidence/(:num)'] = 'Evidence/delete/$1';



//salesperson
$route['salesperson'] = 'Salesperson';
$route['add_salesperson'] = 'Salesperson/create';
$route['save_salesperson'] = 'Salesperson/save_salesperson';
$route['edit_salesperson/(:num)'] = 'Salesperson/edit/$1';
$route['delete_salesperson/(:num)'] = 'Salesperson/delete/$1';


//payments
$route['payments'] = 'Payments';
$route['save_payment'] = 'Payments/save_payment';

//db_export
$route['db_export'] = 'DB_export';


//settings
$route['company_setting'] = 'Settings/company';
$route['save_company_setting'] = 'Settings/save_company_setting';
$route['email_setting'] = 'Settings/email';
$route['save_general_setting'] = 'Settings/save_general_setting';
$route['save_email_template'] = 'Settings/save_template';
$route['delete_template/(:num)'] = 'Settings/delete_template/$1';
