
// requests tabs show and hide table
$('.request_tab_').click(function () {

    $(this).siblings().removeClass('active')
    $(this).addClass('active')

    let tab_type = $(this).attr('data-type')

    $('.tabs_table').css('display','none')
    $('.'+tab_type+'_requests').css('display','')
})
