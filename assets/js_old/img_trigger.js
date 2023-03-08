$(document).on('click','.select_img_',function () {

  $(this).closest('.row').find('.choose_img').trigger('click');

})


function readImgURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {


            $(input).closest('.row').find('.details-circular-img').find('.user-form-img').attr('src', e.target.result);

        }

        reader.readAsDataURL(input.files[0]);
    }
}

$(document).on('change','.choose_img',function(){
    readImgURL(this);
});
