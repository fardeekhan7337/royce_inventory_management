<?php
 /**
  *
  */
 class Invoice_model extends CI_Model
 {

   function getAllInvoices($rowno,$rowperpage,$filter)
 	 {

     $only_his = false;
     if(isUserAllow(56))
     {

       $only_his = true;

     }

       $this->db->select('sales.*,customers.img as customer_img,customers.name customer_name,customers.shop_name,customers.shop_acronym,users.img as driver_img,users.name as driver_name,count(sales_details.product_id) as total_products');
       $this->db->from('sales');
       $this->db->join('sales_details','sales_details.sale_id = sales.id');
       $this->db->join('products','products.id = sales_details.product_id');
       $this->db->join('customers','customers.id = sales.customer_id');
       $this->db->join('users','users.id = sales.added_by');

       $this->db->where('sales.is_deleted',0);

       if ($only_his) {

         $this->db->where('sales.added_by',$this->session->userdata('UID'));

       }

       if (!empty($filter['invoice_no']))
       {

         $this->db->where('sales.invoice_no',$filter['invoice_no']);

       }

       if (!empty($filter['customer_id']))
       {

         $this->db->where('sales.customer_id',$filter['customer_id']);

       }

       if (!empty($filter['driver_id']))
       {

         $this->db->where('sales.added_by',$filter['driver_id']);

       }

       if (!empty($filter['status']))
       {

         $this->db->where('sales.status',strtolower($filter['status']));

       }

       if (!empty($filter['from']))
       {

         $this->db->where('DATE_FORMAT(sales.added_at, "%Y-%m-%d") >=',$filter['from']);

       }

       if (!empty($filter['to']))
       {

         $this->db->where('DATE_FORMAT(sales.added_at, "%Y-%m-%d") <=',$filter['to']);

       }

       if (!empty($filter['type']))
       {

         $this->db->like('sales.invoice_no',$filter['type']);

       }


       $this->db->group_by('sales_details.sale_id');

	     $this->db->order_by('sales.id','desc');

	     $this->db->limit($rowperpage, $rowno);

	     return $this->db->get()->result();

   }

   function getCountInvoices($filter)
	 {

     $only_his = false;
     if(isUserAllow(56))
     {

       $only_his = true;

     }

       $this->db->select('sales.id');
       $this->db->from('sales');
       $this->db->join('sales_details','sales_details.sale_id = sales.id');
       $this->db->join('products','products.id = sales_details.product_id');
       $this->db->join('customers','customers.id = sales.customer_id');
       $this->db->join('users','users.id = sales.added_by');

       $this->db->where('sales.is_deleted',0);

       if ($only_his) {

         $this->db->where('sales.added_by',$this->session->userdata('UID'));

       }

        if (!empty($filter['invoice_no']))
        {

          $this->db->where('sales.invoice_no',$filter['invoice_no']);

        }

        if (!empty($filter['customer_id']))
        {

          $this->db->where('sales.customer_id',$filter['customer_id']);

        }

        if (!empty($filter['driver_id']))
        {

          $this->db->where('sales.added_by',$filter['driver_id']);

        }

        if (!empty($filter['status']))
        {

          $this->db->where('sales.status',strtolower($filter['status']));

        }

        if (!empty($filter['from']))
        {

          $this->db->where('DATE_FORMAT(sales.added_at, "%Y-%m-%d") >=',$filter['from']);

        }

        if (!empty($filter['to']))
        {

          $this->db->where('DATE_FORMAT(sales.added_at, "%Y-%m-%d") <=',$filter['to']);

        }

       $this->db->group_by('sales_details.sale_id');

       $res = $this->db->count_all_results();

	     $result= [['allcount'=>$res]];

       return $result[0]['allcount'];

	 }


 }
