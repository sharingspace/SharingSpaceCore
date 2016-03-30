<?php

/**
* Community Types Macro
*/
Form::macro('community_types', function ($name = "group_type", $selected = null) {

    $types = array(
    '' => trans('general.community.privacy_type'),
    'O'=> trans('general.community.open.type').' ('.trans('general.community.open.text').')',
    'C'=> trans('general.community.closed.type').' ('.trans('general.community.closed.text').')',
    'S'=> trans('general.community.secret.type').' ('.trans('general.community.secret.text').')'
    );

    $select = '<select name="'.$name.'" class="select2" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
