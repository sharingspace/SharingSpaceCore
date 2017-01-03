<?php

/**
* Community Types Macro
*/
Form::macro('theme_color', function ($name = "theme_color", $selected = null) {

    $types = array(
    'fresh' => trans('general.color.fresh'),
    'starryNight' => trans('general.color.starry_night'),
    'future' => trans('general.color.future'),
    'muted' => trans('general.color.muted'),
    'spring' => trans('general.color.spring'),
    'organic' => trans('general.color.organic'),
    );

    $select = '<select required name="'.$name.'" class="select" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
