<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'generic_form_error'   => 'Prosím, zkontrolujte chyby na tomto formuláři',
    'accepted'             => ':attribute musí být přijato.',
    'active_url'           => ':attribute není platné URL.',
    'after'                => ':attribute musí být datum po :date.',
    'alpha'                => ':attribute smí obsahovat pouze písmena.',
    'alpha_dash'           => ':attribute smí obsahovat pouze písmena, čísla a pomlčky.',
    'alpha_num'            => ':attribute smí obsahovat pouze písmena a čísla.',
    'array'                => ':attribute musí být pole.',
    'before'               => ':attribute musí být datum před :date.',
    'between'              => [
        'numeric' => ':attribute musí být mezi :min a :max.',
        'file'    => ':attribute musí být mezi :min a :max kilobytů.',
        'string'  => ':attribute musí být mezi :min a :max znaků.',
        'array'   => ':attribute musí mít mezi :min a :max položkami.',
    ],
    'boolean'              => ':attribute musí být true nebo false.',
    'confirmed'            => 'Potvrezní :attribute se neshoduje.',
    'date'                 => ':attribute není platné datum.',
    'date_format'          => ':attribute neodpovídá formátu :format.',
    'different'            => ':attribute a :other musejí být různé.',
    'digits'               => ':attribute musí být :digits číslic.',
    'digits_between'       => ':attribute musí mít mezi :min a :max číslic.',
    'email'                => ':attribute musí být platná emailová adresa.',
    'exists'               => 'Vybraný :attribute je neplatný.',
    'filled'               => ':attribute je vyžadován.',
    'image'                => ':attribute musí být obrázek.',
    'in'                   => 'Vybraný :attribute je neplatný.',
    'integer'              => ':attribute musí být celé číslo.',
    'ip'                   => ':attribute musí být platná IP adresa.',
    'json'                 => ':attribute musí být platný JSON string.',
    'max'                  => [
        'numeric' => ':attribute nesmí být větší než :max.',
        'file'    => ':attribute nesmí být větší než :max kilobytů.',
        'string'  => ':attribute nesmí být větší než :max znaků.',
        'array'   => ':attribute nesmí mít více než :max položek.',
    ],
    'mimes'                => ':attribute musí být soubor typu :values.',
    'min'                  => [
        'numeric' => ':attribute musí být nejméně :min.',
        'file'    => ':attribute musí být nejméně :min kilobytů.',
        'string'  => ':attribute musí být nejméně :min znaků.',
        'array'   => ':attribute musí mít nejméně :min položek.',
    ],
    'not_in'               => 'Vybraný :attribute je neplatný.',
    'numeric'              => ':attribute musí být číslo.',
    'regex'                => ':attribute je v neplatném formátu.',
    'required'             => ':attribute je vyžadován.',
    'required_if'          => ':attribute je vyžadován, pokud :other je :value.',
    'required_with'        => ':attribute je vyžadován, pokud existuje :values.',
    'required_with_all'    => ':attribute je vyžadován, pokud existuje :values.',
    'required_without'     => ':attribute je vyžadován, pokud neexistuje :values.',
    'required_without_all' => ':attribute je vyžadován, pokud neexistuje žádná z hodnot :values.',
    'same'                 => ':attribute a :other se musejí shodovat.',
    'size'                 => [
        'numeric' => ':attribute musí být :size.',
        'file'    => ':attribute musí být :size kilobytů.',
        'string'  => ':attribute musí být :size znaků.',
        'array'   => ':attribute musí obsahovat :size položek.',
    ],
    'string'               => ':attribute musí být řetězec.',
    'timezone'             => ':attribute musí být platná zóna.',
    'unique'               => ':attribute už je obsazen.',
    'url'                  => ':attribute je v neplatném formátu.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

];
