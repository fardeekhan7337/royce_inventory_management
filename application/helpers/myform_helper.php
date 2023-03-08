<?php

if ( ! function_exists('getSelectField'))
{

  function getSelectField($arr)
	{

      $label = '';
      $name = '';
      $required = 'required';
      $id = '';
      $column = 'sm-6';
      $sel_classes = '';
      $col_classes = '';
      $col_attributes = '';
      $options = '';
      $sel_first_option = 'select';
      $select2_class = 'select2';
      $sel_attributes = '';
      $fo_attr = '';
      //select column width
      if(isset($arr['column']))
      {
        $column = $arr['column'];
      }
      // select label
      if(isset($arr['label']))
      {
        $label = $arr['label'];
      }
      // select name
      if(isset($arr['name']))
      {
        $name = $arr['name'];
      }
      // select required or not
      if(isset($arr['required']))
      {
        $required = $arr['required'] === false ?  '': 'required';
      }
      //to add id in select
      if(isset($arr['id']))
      {
        $id = "id=".$arr['id'];
      }
      //set color option text or not
      if(isset($arr['option_color']))
      {
        $is_option_color = true;
      }
      else
      {
        $is_option_color = false;
      }
      
      //to add select2 class in select
      if(isset($arr['select2_class']))
      {

          if($arr['select2_class'] != false)
          {

            $select2_class = $arr['select2_class'];

          }
          else
          {
            $select2_class = '';
          }

      }
      //to add classes in select
      if(isset($arr['classes']) && !empty($arr['classes']))
      {

          $s_classes = explode(',',$arr['classes']);

          foreach ($s_classes as $k => $v)
          {

            $sel_classes .= $v.' ';

          }

      }
      //to add attributes in column
      if(isset($arr['col_attr']) && !empty($arr['col_attr']))
      {

          $c_attributes = explode(',',$arr['col_attr']);

          foreach ($c_attributes as $k => $v)
          {

            $col_attributes .= $v.' ';

          }

      }
      //to add attributes in select
      if(isset($arr['attr']) && !empty($arr['attr']))
      {

          $s_attributes = explode(',',$arr['attr']);

          foreach ($s_attributes as $k => $v)
          {

            $sel_attributes .= $v.' ';

          }

      }
      //to add classes in column
      if(isset($arr['col_classes']) && !empty($arr['col_classes']))
      {

          $cl_classes = explode(',',$arr['col_classes']);

          foreach ($cl_classes as $k => $v)
          {

            $col_classes .= $v.' ';

          }

      }
      //to add options in select
      if(isset($arr['data']) && !empty($arr['data']))
      {

          foreach ($arr['data'] as $key => $v) {

              if(isset($arr['static']) && $arr['static'] == true)
              {

                if(isset($arr['selected']) && $arr['selected'] == $v)
                {

                  $options .='<option value="'. $v .'" selected>'.$v.'</option>';

                }
                else
                {

                  $options .='<option value="'. $v .'">'.$v.'</option>';

                }

              }
              else
              {
                
                if($is_option_color)
                {

                  $clr = isset($v->color)?$v->color : 'black';
                  
                  $option_clr = 'style="color:'. $clr.'!important"';
                  $option_clr_attr = "datapcolor=".$clr;
                }
                else
                {
                  $option_clr = '';
                  $option_clr_attr = '';
                }
                
                if(isset($arr['selected']) && $arr['selected'] == $v->id)
                {

                  $options .='<option value="'. $v->id .'" selected '. $option_clr.' '. $option_clr_attr .'>'.$v->name.'</option>';

                }
                else
                {

                  $options .='<option value="'. $v->id .'" '. $option_clr.' '. $option_clr_attr .'>'.$v->name.'</option>';

                }

              }
          }
      }
      //select first option
      if(isset($arr['first_option']))
      {
        $sel_first_option = $arr['first_option'];
      }

      //select first option (show / hide)
      if(isset($arr['is_first_option']))
      {
        $is_first_option = false;
      }
      else
      {
        $is_first_option = true;
      }
      
      //to add attr in first option
      if(isset($arr['first_option_attr']) && !empty($arr['first_option_attr']))
      {

          $fo_attr_ = explode(',',$arr['first_option_attr']);

          foreach ($fo_attr_ as $k => $v)
          {

            $fo_attr .= $v.' ';

          }

      }

      $select_col = '<div class="col-'.$column.' mb-3 '.$col_classes.'" '. $col_attributes .'>';

                      if($label != '')
                      {

                        if(isset($arr['custom_label']))
                        {

                            $select_col .= '<label for="'. ucfirst($label) .'" class="form-label">'. ucfirst($label) . $arr['custom_label'].'</label>';

                        }
                        else
                        {

                          $select_col .= '<label for="'. ucfirst($label) .'" class="form-label">'. ucfirst($label) .'</label>';

                        }

                      }

                     $select_col .='<select class="form-select form-select-sm '.$select2_class.' '. $sel_classes .'" data-width="100%" name="'.$name.'" '.$id.' '.$required.' '. $sel_attributes .'>';

                     if($is_first_option)
                     {

                       $select_col .='<option value="" '. $fo_attr .'>'.$sel_first_option.'</option>';

                      }

                      $select_col .= $options.'</select>'.
                  '</div>';


                  // echo $options;

                  // die();
      return $select_col;

	}

}

if ( ! function_exists('getInputField'))
{

  function getInputField($arr)
	{

      $label = '';
      $type = 'text';
      $name = '';
      $required = 'required';
      $value = '';
      $id = '';
      $column = 'sm-6';
      $inp_classes = '';
      $col_classes = '';
      $inp_attributes = '';
      $col_attributes = '';
      //input column width
      if(isset($arr['column']))
      {
        $column = $arr['column'];
      }
      // input label
      if(isset($arr['label']))
      {
        $label = $arr['label'];
      }
      // input type
      if(isset($arr['type']))
      {
        $type = $arr['type'];
      }
      // input name
      if(isset($arr['name']))
      {
        $name = $arr['name'];
      }
      // input required or not
      if(isset($arr['required']))
      {
        $required = $arr['required'] === false ?  '': 'required';
      }
      // input value
      if(isset($arr['value']))
      {

        if(!empty($arr['value']) || $arr['value'] == '0')
        {

          $value = $arr['value'];

        }

      }

      //to add id in input
      if(isset($arr['id']))
      {
        $id = "id=".$arr['id'];
      }
      //to add classes in input
      if(isset($arr['classes']) && !empty($arr['classes']))
      {

          $i_classes = explode(',',$arr['classes']);

          foreach ($i_classes as $k => $v)
          {

            $inp_classes .= $v.' ';

          }

      }
      //to add classes in column
      if(isset($arr['col_classes']) && !empty($arr['col_classes']))
      {

          $cl_classes = explode(',',$arr['col_classes']);

          foreach ($cl_classes as $k => $v)
          {

            $col_classes .= $v.' ';

          }

      }
      //to add attributes in input
      if(isset($arr['attr']) && !empty($arr['attr']))
      {

          $i_attributes = explode(',',$arr['attr']);

          foreach ($i_attributes as $k => $v)
          {

            $inp_attributes .= $v.' ';

          }

      }

      //to add attributes in column
      if(isset($arr['col_attr']) && !empty($arr['col_attr']))
      {

          $i_col_attributes = explode(',',$arr['col_attr']);

          foreach ($i_col_attributes as $k => $v)
          {

            $col_attributes .= $v.' ';

          }

      }

      $input_col = '<div class="col-'.$column.' mb-3 '.$col_classes.'" '. $col_attributes .'>';

                    if($label != '')
                    {

                      if(isset($arr['custom_label']))
                      {

                          $input_col .= '<label for="'. ucfirst($label) .'" class="form-label">'. ucfirst($label) . $arr['custom_label'].'</label>';

                      }
                      else
                      {

                        $input_col .= '<label for="'. ucfirst($label) .'" class="form-label">'. ucfirst($label) .'</label>';

                      }

                    }

                     $input_col .= '<input type="'. $type .'" class="form-control form-control-sm '. $inp_classes .'" name="'.$name.'" '. $id .' '.$required.' '.$inp_attributes.' value="'.$value.'" />'.
                  '</div>';

      return $input_col;

	}

}


if ( ! function_exists('getImgField'))
{
  function getImgField($arr = [])
	{

      $img_url = base_url('assets/images/avatars/01.png');
      $name = 'img';
      $label = 'Upload Photo';
      if(!empty($arr))
      {

        if(isset($arr['img_url']))
        {

          $img_url = $arr['img_url'];

        }
        if(isset($arr['name']))
        {

          $name = $arr['name'];

        }
        if(isset($arr['label']))
        {

          $label = $arr['label'];

        }

      }

      $img_row = '<div class="row">'.
                    '<div class="col-sm-12">'.
                      '<div class="details-circular-img"><img src="'. $img_url .'" class="user-form-img" alt="..."></div>'.
                      '<input type="file" class="choose_img" name="'.$name.'" style="display:none;">'.
                    '</div>'.
                    '<div class="col-sm-12 mt-4 upload_modal_btn" style="margin-left:10px;">'.
                      '<button type="button" class="btn btn-sm btn-outline-primary select_img_">'.$label.'</button>'.
                    '</div>'.
                  '</div>';

      return $img_row;

	}

}

if ( ! function_exists('getTextareaField'))
{

  function getTextareaField($arr)
	{

      $label = '';
      $name = '';
      $required = 'required';
      $value = '';
      $id = '';
      $column = 'sm-6';
      $textarea_classes = '';
      //textarea column width
      if(isset($arr['column']))
      {
        $column = $arr['column'];
      }
      // textarea label
      if(isset($arr['label']))
      {
        $label = $arr['label'];
      }
      // textarea name
      if(isset($arr['name']))
      {
        $name = $arr['name'];
      }
      // textarea required or not
      if(isset($arr['required']))
      {
        $required = $arr['required'] === false ?  '': 'required';
      }
      // textarea value
      if(isset($arr['value']))
      {
        $value = $arr['value'];
      }
      //to add id in textarea
      if(isset($arr['id']))
      {
        $id = "id=".$arr['id'];
      }
      //to add classes in textarea
      if(isset($arr['classes']) && !empty($arr['classes']))
      {

          $txt_classes = explode(',',$arr['classes']);

          foreach ($txt_classes as $k => $v)
          {

            $textarea_classes .= $v.' ';

          }

      }

      $textarea_col = '<div class="col-'.$column.' mb-3">'.
                          '<label for="'. ucfirst($label) .'" class="form-label">'. ucfirst($label) .'</label>'.
                          '<textarea name="'.$name.'" class="form-control '.$textarea_classes.'" aria-label="With textarea" '. $id .' '.$required.'>'.$value.'</textarea>'.
                        '</div>';

      return $textarea_col;

	}

}


if ( ! function_exists('getSubmitBtn'))
{

  function getSubmitBtn($btn_txt = '')
	{

      $form_btn = '<div class="col-12">
                    <button class="btn btn-sm btn-primary" type="submit">'. $btn_txt .'</button>
                  </div>';

      return $form_btn;
	}

}


if ( ! function_exists('getHiddenField'))
{

  function getHiddenField($name = '', $value = '' ,$classnames = '' , $id = '')
	{

    // for extra classes
     $extra_classes = '';
     if (!empty($classnames)) {

       $attr = explode(',',$classnames);

       foreach ($attr as $k => $v)
       {

         $extra_classes .= $v.' ';

       }


     }

     if($id != '')
     {
       $id = "id=".$id;
     }
     else
     {
        $id = '';
     }

      $hidden_input = '<input type="hidden" class="'. $extra_classes .'" name="'.$name.'" '. $id .' value="'.$value.'">';

      return $hidden_input;

	}

}

if ( ! function_exists('viewDetailsCol'))
{

  function viewDetailsCol($label, $val,$column = 4)
	{

      $col = '<div class="col-sm-'.$column.'"><label for="'.ucfirst($label).'">'.ucfirst($label).'</label><p class="view-details-txt">'.$val.'</p></div>';

      return $col;

	}

}


if ( ! function_exists('showBreadCumbs'))
{

  function showBreadCumbs($arr)
	{

      $breadcumb = '<nav aria-label="breadcrumb">
                      <ol class="breadcrumb">';
                          foreach ($arr as $key => $v)
                          {

                            if(isset($v['url']))
                            {
                              $breadcumb .='<li class="breadcrumb-item"><a href="'. site_url($v['url']) .'">'.$v['label'].'</a></li>';
                            }
                            else
                            {
                              $breadcumb .='<li class="breadcrumb-item active" aria-current="page">'. $v['label'].'</li>';
                            }


                          }
                      $breadcumb .='</ol>'.
                    '</nav>';

      return $breadcumb;

	}

}