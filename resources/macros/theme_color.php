<?php

/**
* Community Types Macro
*/
Form::macro('theme_color', function ($name = "theme_color", $selected = null) {

    $types = array(
    'oceanBlue' => 'Ocean blue',
    'darkBlue' => 'Dark blue',
    'lightBlue' => 'Light blue',
    'orange' => 'Orange',
    'blue' => 'Blue',
    'purple' => 'Purple',
    'green' => 'Green',
    'brown' => 'Brown',
    'cyan' => 'Cyan',
    'amber' => 'Amber',
    'gray' => 'Gray',
    'lime' => 'Lime',
    'darkGray' => 'Dark gray',
    'black' => 'Black',
    'white' => 'White',
    'black_white' => 'Black and white'
    );

    $select = '<select required name="'.$name.'" class="select" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
