<?php

return [
    'number' => [
        'integer' => ['alias' => 'numeric', 'digits' => 0, 'groupSeparator' => '.', 'radixPoint' => ',', 'autoGroup' => true],
        'decimal' => ['alias' => 'numeric', 'digits' => 2, 'groupSeparator' => '.', 'radixPoint' => ',', 'autoGroup' => true],
        'currency' => ['alias' => 'currency','digits' => 2,'digitsOptional' => false, 'prefix' => 'Rp.', 'groupSeparator' => '.', 'radixPoint' => ','],
    ],
    'textmask' => [
        'nopol' => ['mask' => 'a{1,2}9{1,4}a{1,3}'],
        'phone' => ['mask' => '9{3,4}-9{4,8}'],
        'mobile' => ['mask' => '62999-9999-9999'],
        'email' => ['alias' => 'email'],
        // 23.232.323.4-444.444 -- nomer NPWP
        'tax' => ['mask' => '9{2}.9{3}.9{3}.9{1}-.9{3}.9{3}']
    ],
    'select2' => [
        'ajax' => ['data-ajax' => 1],
        'tag' => ['tags' => true, 'multiple' => true, 'tokenSeparators' => [',']],
    ],    
    'daterange' => ['singleDatePicker' => false, 'locale' => ['format' => 'DD MMM YYYY']],
    'time' => ['locale' => ['format' => 'HH:mm']],
    'date_format' => 'd M Y',
    'datetime_format' => 'd M Y H:i:s',
    'date_format_javascript' => 'DD MMM YYYY',
    'datetime_format_javascript' => 'DD MMM YYYY HH:mm:ss',
    'thousand_separator' => '.',
    'decimal_separator' => ',',
    'digit_decimal' => 2
];
