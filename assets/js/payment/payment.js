
$('#filter_payments').parsley()

$('#filter_payments').submit(function () {

    let url = $('input[name=getCustomerPayments]').val()

    let customer_id = $('select[name=customer_id]').val()

    let from = $('input[name=from]').val()

    let to = $('input[name=to]').val()

    window.open(url+'?customer_id='+customer_id+'&from='+from+'&to='+to,'Customer Payments','height=800,width=800');

})

$('.add_payment_').click(function () {

    $('#AddPaymentModal').modal('show')

})
