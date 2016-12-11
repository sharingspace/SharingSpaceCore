<?php

/**
* Community Types Macro
*/
Form::macro('theme_color', function ($name = "theme_color", $selected = null) {

    $types = array(
    'blue' => trans('general.color.blue'),
    'brown' => trans('general.color.brown'),
    'darkblue' => trans('general.color.darkblue'),
    'darkgreen' => trans('general.color.darkgreen'),
    'green' => trans('general.color.green'),
    'lightgrey' => trans('general.color.lightgrey'),
    'orange' => trans('general.color.orange'),
    'pink' => trans('general.color.pink'),
    'red' => trans('general.color.red'),
    'gold' => trans('general.color.gold')
    );

    $select = '<select required name="'.$name.'" class="select" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
