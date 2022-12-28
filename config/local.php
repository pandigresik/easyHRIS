<?php

return [
    'number' => [
        'integer' => ['alias' => 'numeric', 'digits' => 0, 'groupSeparator' => '.', 'radixPoint' => ',', 'autoGroup' => true],
        'decimal' => ['alias' => 'numeric', 'digits' => 2, 'groupSeparator' => '.', 'radixPoint' => ',', 'autoGroup' => true],
        'currency' => ['alias' => 'currency','digits' => 2,'digitsOptional' => false, 'prefix' => 'Rp.', 'groupSeparator' => '.', 'radixPoint' => ','],
    ],
    'textmask' => [
        'nopol' => ['mask' => 'a{1,2}9{1,4}a{1,3}'],
        'ritase' => ['alias' => 'numeric', 'mask' => '9{1}'],
        'phone' => ['mask' => '9{3,4}-9{4,8}'],
        'time' => ['mask' => '(09|19|20|21|22|23):(09|19|29|39|49|59):(09|19|29|39|49|59)'],
        'time-minute' => ['mask' => '(09|19|20|21|22|23):(09|19|29|39|49|59)'],
        'mobile' => ['mask' => '62999-9999-9999'],
        'email' => ['alias' => 'email'],
        'upper' => ['casing' => 'upper'],
        // 23.232.323.4-444.444 -- nomer NPWP
        'tax' => ['mask' => '9{2}.9{3}.9{3}.9{1}-.9{3}.9{3}']
    ],
    'select2' => [
        'ajax' => ['data-ajax' => 1],
        'tag' => ['tags' => true, 'multiple' => true, 'tokenSeparators' => [',']],
    ],    
    'daterange' => ['singleDatePicker' => false, 'locale' => ['format' => 'DD MMM YYYY']],
    'datetime' => ['timePicker' => true, 'timePicker24Hour' => true, 'singleDatePicker' => true, 'locale' => ['format' => 'DD MMM YYYY HH:mm:ss']],
    'daterange_search' => ['singleDatePicker' => false, 'locale' => ['format' => 'DD MMM YYYY'], 'autoApply' => false, 'autoUpdateInput' => false ],
    'datesingle_empty' => ['singleDatePicker' => true, 'locale' => ['format' => 'DD MMM YYYY'], 'autoApply' => false, 'autoUpdateInput' => false ],
    'time' => ['timePicker' => true,'locale' => ['format' => 'HH:mm']],
    'date_format' => 'd M Y',
    'datetime_format' => 'd M Y H:i:s',
    'date_format_javascript' => 'DD MMM YYYY',
    'datetime_format_javascript' => 'DD MMM YYYY HH:mm:ss',
    'thousand_separator' => '.',
    'decimal_separator' => ',',
    'digit_decimal' => 2,    
    'bpjs_fee' => [6, 10, 21, 28],
    'reason_code_not_absent' => ['OFF', 'LK', 'DL'],
    // id untuk shiftment yang libur
    'shiftment_off' => [2],
    // untuk perhitungan premi
    'leave_code' => ['PC', 'DT'],
    // untuk tunjangan yang diberikan di akhir bulan saja
    'benefit_end_of_month' => ['TJ', 'PRHD'],
    // job level leader code
    'job_level_leader' => ['MGR','SPV', 'FRM'],
    // annual leave code
    'annual_leave_code' => 'CT',    
];
