<?php

/**
* Community Types Macro
*/
Form::macro('community_types', function ($name = "group_type", $selected = null) {

    $types = array(
    '' => trans('general.community.type'),
    'O'=> trans('general.community.open.type'),
    'C'=> trans('general.community.closed.type'),
    'S'=> trans('general.community.secret.type')
    );

    $select = '<select name="'.$name.'" class="select2" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
