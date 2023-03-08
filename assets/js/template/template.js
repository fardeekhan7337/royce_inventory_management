$('#add_template_').click(function () {

  let head = $(this).attr('data-head')

  $('#template_action_head').text(head)

  $('#AddTemplateModal').modal('show')

})

$(document).on('click','.edit_template_',function () {

  let url = $(this).attr('data-url')

  $('#template_action_head').text('Edit Template')

  $.ajax({

    url : url,
    dataType : 'json',
    success : function (response) {

      let template = response.data

      $('input[name=ID]').val(template.id)
      $('input[name=title]').val(template.title)
      $('input[name=subject]').val(template.subject)
      $('textarea[name=template]').val(template.template)

      $('#AddTemplateModal').modal('show')

    }

  })


})

$('.template_commands_').click(function () {

  let command = $(this).attr('data');
  navigator.clipboard.writeText(command)

})

//check or uncheck all customers
$('.check_all_customers').change(function () {

  if($(this).is(':checked'))
  {

    $('.customer_check').prop('checked',true)

  }
  else
  {

    $('.customer_check').prop('checked',false)

  }
})

$('.sending_type').change(function () {

  let sending_type = $(this).val()

  $('.sending_day,.sending_day_date').css('display','none')

  if(sending_type == 'Weekly')
  {

    $('.sending_day').css('display','block')

  }
  else if(sending_type == 'Monthly')
  {

    $('.sending_day_date').css('display','block')

  }

})
