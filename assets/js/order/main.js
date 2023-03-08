$('#customer_id').change(function () {

    let customer_id = $(this).val()

    $('#customer_name_,#customer_cno_,#customer_email_,#customer_addr_').val('')

    if(customer_id != '')
    {

      $.ajax({
        url : 'AjaxController/getCustomersData/'+customer_id,
        dataType : 'json',
        success : function (reponse) {

          $('#customer_name_').val(reponse.data.name)
          $('#customer_shop_acronym_').val(reponse.data.shop_acronym)
          $('#customer_cno_').val(reponse.data.primary_contact)
          $('#customer_email_').val(reponse.data.e_receipt_email)
          $('#customer_addr_').val(reponse.data.address)

        }
      })

    }
})
