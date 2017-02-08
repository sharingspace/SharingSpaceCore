<?php

/**
* Community Types Macro
*/
Form::macro('theme_color', function ($name = "theme_color", $selected = null) {

    $types = array(
        'amber' => 'Amber / Teal',
        'black' => 'Black / Ocean Grey',
        'black_white' => 'Black & White / Grey',
        'blue' => 'Blue / Lilac',
        'brown' => 'Brown / Green',
        'cyan' => 'Cyan / Orange',
        'darkBlue' => 'Dark Blue / Pink',
        'darkGray' => 'Dark Gray / Olive',
        'gray' => 'Gray / Brown',
        'green' => 'Green / Olive',
        'lightBlue' => 'Light Blue / Teal',
        'lime' => 'Lime / Brown',
        'oceanBlue' => 'Ocean Blue / Teal',
        'orange' => 'Orange / Red',
        'purple' => 'Purple / Sky Blue',
        'purple_pink' => 'Purple / Pink',
        'white_blue' => 'White / Blue',
        'white_gray' => 'White / Gray',
        'white_green' => 'White / Green',
        'white_orange' => 'White / Orange',
        'white_pink' => 'White / Pink'
    );

    $select = '<select required name="'.$name.'" class="select" style="width: 100%;">';
    foreach ($types as $key => $value) {
        $select .= '<option value="'.$key.'"'.($selected == $key ? ' selected="selected"' : '').'>'.$value.'</option> ';
    }

    $select .= '</select>';

    return $select;

});
