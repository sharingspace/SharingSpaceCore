<?php

/**
* Community Types Macro
*/
Form::macro('entry_layout', function ($name = "group_type", $selected = null) {

    $types = array(
    '' => trans('general.community.layout'),
    'G'=> trans('general.community.grid'),
    'L'=> trans('general.community.list')
    /* 'M'=> trans('general.community.map') */
    );

    $select = '<select required name="'.$name.'" class="select" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
