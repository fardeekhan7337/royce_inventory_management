<?php

/**
 *
 */
class Payment_model extends CI_Model
{

  public function getPayments($customer_id,$from = '',$to = '')
  {

    $this->db->select('payments.*,sales.invoice_no,customers.name as customer_name');
    $this->db->from('payments');
    $this->db->join('sales','sales.id = payments.sale_id','left');
    $this->db->join('customers','customers.id = payments.customer_id');

    if (!empty($customer_id))
    {

      $this->db->where('payments.customer_id',$customer_id);

    }

    if (!empty($from))
    {

      $this->db->where('DATE_FORMAT(payments.added_at, "%Y-%m-%d") >=',$from);

    }

    if (!empty($to))
    {

      $this->db->where('DATE_FORMAT(payments.added_at, "%Y-%m-%d") <=',$to);

    }

    return $this->db->get()->result();

  }

  public function getTotalCreditAmount()
  {

      $this->db->select("sum(if(payments.type='debit',amount,0)) as total_debit,sum(if(payments.type='credit',amount,0)) as total_credit", FALSE);
      $this->db->from('payments');
      $this->db->join('sales','sales.id = payments.sale_id','left');
      $this->db->join('customers','customers.id = payments.customer_id');

      return $this->db->get()->row();

  }

  public function getCustomerCreditsAmount($value='')
  {

    $this->db->select("customers.*,sum(if(payments.type='debit',amount,0)) as total_debit,sum(if(payments.type='credit',amount,0)) as total_credit", FALSE);
    $this->db->from('payments');
    $this->db->join('sales','sales.id = payments.sale_id','left');
    $this->db->join('customers','customers.id = payments.customer_id');

    $this->db->group_by('payments.customer_id');

    return $this->db->get()->result();

  }
  
  public function getAllDailyPayments()
  {
      
    $this->db->select("sum(if(payments.type='debit',amount,0)) as total_debit,sum(if(payments.type='credit',amount,0)) as total_credit", FALSE);
    $this->db->from('payments');
    $this->db->join('sales','sales.id = payments.sale_id','left');
    $this->db->join('customers','customers.id = payments.customer_id');

    // $this->db->group_by('payments.customer_id');
    
    $this->db->where('DATE_FORMAT(payments.added_at, "%Y-%m-%d") =',date('Y-m-d'));

    return $this->db->get()->row();

  }

  public function getDailyCreditAmount()
  {

      $this->db->select("sum(if(payments.type='debit',amount,0)) as total_debit,sum(if(payments.type='credit',amount,0)) as total_credit", FALSE);
      $this->db->from('payments');
      $this->db->join('sales','sales.id = payments.sale_id','left');
      $this->db->join('customers','customers.id = payments.customer_id');

      $this->db->where('DATE_FORMAT(payments.added_at, "%Y-%m-%d") =',date('Y-m-d'));

      return $this->db->get()->row();

  }


}
