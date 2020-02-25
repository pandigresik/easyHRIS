/**
 * @title : Kumpulan fungsi-fungsi(baca: method) u/ global proses.
 * @author: mursito&prends <02-04@mitraunggassejati.com>
 *
 */

'use strict';
var Config = {
    decimal: {
        prefix: '',
        centsSeparator: ',',
        centsLimit: 2,
        thousandsSeparator: '.'
    },
    decimal3: {
        prefix: '',
        centsSeparator: ',',
        centsLimit: 3,
        thousandsSeparator: '.'
    },
    angka: {
        prefix: '',
        centsSeparator: '',
        centsLimit: 0,
        clearOnEmpty: true,
        thousandsSeparator: ''
    },
    telpon: {
        prefix: '0',
        centsSeparator: '',
        centsLimit: 0,
        clearOnEmpty: false,
        thousandsSeparator: '',
        insertPlusSign: false,
        allowNegative: false,
    },
    integer: {
        prefix: '',
        centsSeparator: ',',
        centsLimit: 0,
        thousandsSeparator: '.'
    },
    tahun: {
        prefix: '',
        centsSeparator: ',',
        limit: 4,
        centsLimit: 0,
        clearOnEmpty: true,
        thousandsSeparator: ''
    },
};


function getMessage(message, msgRequest) {
    /**
     * @Usage:
     *      toastr.[jenis_alert](getMessage([nama_key_element]));
     *
     * @Notes:
     *      jenis_alert = (success, error, info, warning)
     *
     * @Examples:
     *      toastr.info(getMessage('loginWrong'));
     *      toastr.error(getMessage('error'));
     ***/

    messages = {
        success: 'berhasil.',
        error: 'gagal.',
        required: 'harus diisi.',
        custom: '',
    };
    return message + ' ' + messages[msgRequest];
}

function number_only(e) {
    var pola = "^";
    pola += "[.0-9]*";
    pola += "$";
    rx = new RegExp(pola);

    if (!e.value.match(rx)) {
        if (e.lastMatched) {
            e.value = e.lastMatched;
        } else {
            e.value = "";
        }
    } else {
        e.lastMatched = e.value;
    }
}

function convert_datepicker(e) {
    var date = $(e).val();
    var new_date = convert_month(date);
    $(e).val(new_date);
}

function convert_month(date) {
    var month = $.datepicker.regional['id'].monthNames;
    var short_month = $.datepicker.regional['id'].monthNamesShort;
    var explode = date.split(' ');
    var d = explode[0];
    var tmp_m = explode[1];
    var m = (isNaN(tmp_m)) ? short_month[month.indexOf(tmp_m)] : short_month[parseInt(tmp_m) - 1];
    var y = explode[2];
    return d + " " + m + " " + y;
}

function upper_text(elm) {
    elm.value = elm.value.toUpperCase();
}

function number_format(number, decimals, dec_point, thousands_sep) {
    //  discuss at: http://phpjs.org/functions/number_format/
    // original by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: davook
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Brett Zamir (http://brett-zamir.me)
    // improved by: Theriault
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Michael White (http://getsprink.com)
    // bugfixed by: Benjamin Lupton
    // bugfixed by: Allan Jensen (http://www.winternet.no)
    // bugfixed by: Howard Yeend
    // bugfixed by: Diogo Resende
    // bugfixed by: Rival
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //  revised by: Jonas Raoni Soares Silva (http://www.jsfromhell.com)
    //  revised by: Luke Smith (http://lucassmith.name)
    //    input by: Kheang Hok Chin (http://www.distantia.ca/)
    //    input by: Jay Klehr
    //    input by: Amir Habibi (http://www.residence-mixte.com/)
    //    input by: Amirouche
    //   example 1: number_format(1234.56);
    //   returns 1: '1,235'
    //   example 2: number_format(1234.56, 2, ',', ' ');
    //   returns 2: '1 234,56'
    //   example 3: number_format(1234.5678, 2, '.', '');
    //   returns 3: '1234.57'
    //   example 4: number_format(67, 2, ',', '.');
    //   returns 4: '67,00'
    //   example 5: number_format(1000);
    //   returns 5: '1,000'
    //   example 6: number_format(67.311, 2);
    //   returns 6: '67.31'
    //   example 7: number_format(1000.55, 1);
    //   returns 7: '1,000.6'
    //   example 8: number_format(67000, 5, ',', '.');
    //   returns 8: '67.000,00000'
    //   example 9: number_format(0.9, 0);
    //   returns 9: '1'
    //  example 10: number_format('1.20', 2);
    //  returns 10: '1.20'
    //  example 11: number_format('1.20', 4);
    //  returns 11: '1.2000'
    //  example 12: number_format('1.2000', 3);
    //  returns 12: '1.200'
    //  example 13: number_format('1 000,50', 2, '.', ' ');
    //  returns 13: '100 050.00'
    //  example 14: number_format(1e-8, 8, '.', '');
    //  returns 14: '0.00000001'

    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 :
        Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' :
        thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' :
        dec_point,
        s = '',
        toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k).toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}

function angkaIndonesia(number, decimal) {
    decimal = decimal == undefined ? 0 : decimal;
    return number_format(number, decimal, ',', '.');
}

function parse_number(string_number, thousands_sep, decimal_sep) {
    string_number = string_number.toString();
    thousands_sep = (typeof thousands_sep == 'undefined') ? '.' : thousands_sep;
    decimal_sep = (typeof decimal_sep == 'undefined') ? ',' : decimal_sep;
    var thousand = new RegExp('\\' + thousands_sep + '', 'g');
    var decimal = new RegExp('\\' + decimal_sep + '', 'g');
    var tanpa_ribuan = string_number.replace(thousand, '');
    var replace_decimal = tanpa_ribuan.replace(decimal, '.');
    return parseFloat(replace_decimal);

}

function empty(data) {
    if (typeof(data) == 'number' || typeof(data) == 'boolean') {
        return false;
    }
    if (typeof(data) == 'undefined' || data === null || data == 'null') {
        return true;
    }
    if (typeof(data.length) != 'undefined') {
        return data.length == 0;
    }
    var count = 0;
    for (var i in data) {
        if (data.hasOwnProperty(i)) {
            count++;
        }
    }
    return count == 0;
}


function in_array(item, arr) {
    if (!arr) {
        return false;
    } else {
        for (var p = 0; p < arr.length; p++) {
            if (item == arr[p]) {
                return true;
            }
        }
        return false;
    }
}

function array_sum(array) {
    //  discuss at: http://phpjs.org/functions/array_sum/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Nate
    // bugfixed by: Gilbert
    // improved by: David Pilia (http://www.beteck.it/)
    // improved by: Brett Zamir (http://brett-zamir.me)
    //   example 1: array_sum([4, 9, 182.6]);
    //   returns 1: 195.6
    //   example 2: total = []; index = 0.1; for (y=0; y < 12; y++){total[y] = y + index;}
    //   example 2: array_sum(total);
    //   returns 2: 67.2

    var key, sum = 0;

    if (array && typeof array === 'object' && array.change_key_case) { // Duck-type check for our own array()-created PHPJS_Array
        return array.sum.apply(array, Array.prototype.slice.call(arguments, 0));
    }

    // input sanitation
    if (typeof array !== 'object') {
        return null;
    }

    for (key in array) {
        if (!isNaN(parseFloat(array[key]))) {
            sum += parseFloat(array[key]);
        }
    }

    return sum;
}

function selisihHari(d1, d2) {
    var _t1 = d1.getTime();
    var _t2 = d2.getTime();
    return parseInt((_t2 - _t1) / (24 * 3600 * 1000));
}



function errorMessage(message) {
    return '<span class="error">' + message + '</span>';
}

function successMessage(message) {
    return '<span class="success">' + message + '</span>';
}

function createTree(arr) {
    if (!empty(arr)) {
        var tmp = '<ul>';
        for (var i in arr) {
            var val = arr[i];
            if (typeof(val) === 'string') {
                tmp += '<li><a href="#">' + val + '</a></li>';
            } else {
                var _id = getRandomInt(1001, 2000);
                tmp += '<li><input type="checkbox" id="' + _id + '" /><label for="' + _id + '">' + i + '</label>';
                tmp += createTree(val);
            }
        }
        tmp += '</ul>';
        return tmp;
    }
}

/**
 * Returns a random integer between min (inclusive) and max (inclusive)
 * Using Math.round() will give you a non-uniform distribution!
 */
function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min + 1)) + min;
}

function messageBox(title, message) {
    var box = bootbox.dialog({
        message: message,
        title: title,
        buttons: {
            success: {
                label: "OK",
                className: "btn-success",
                callback: function() {
                    return true;
                }
            }
        }
    });
    /*
        box.bind('hidden.bs.modal', function() {
            $(element).focus().select();
        });
    */
}

function setNumberFormatOnLoadPage() {
    $('[data-tipe=integer],[data-tipe=angka],[data-tipe=decimal],[data-tipe=decimal3]').each(function() {
        $(this).priceFormat(Config[$(this).data('tipe')]);
    });
} // end - setNumberFormatOnLoadPage

var s_loading = null;

function showLoading(pesan = "Please wait . . . ") {
    if (s_loading == null) {
        s_loading = bootbox.dialog({
            message: '<div class="text-center"><i class="fa fa-spin fa-spinner"></i> ' + pesan + '</div>',
            closeButton: false,
        });
    }
}

function hideLoading() {
    if (s_loading != null) {
        s_loading.modal('hide');
        s_loading = null;
    }
}

function filter_content(elm) {
    var _tr = $(elm).closest('tr');
    var _tbody = _tr.closest('table').find('tbody');
    var _content, _target;
    _tbody.find('tr').show();
    _tr.find('input,select').each(function() {
        _content = $(this).val();
        if (!empty(_content)) {
            _target = $(this).data('target');
            _tbody.find('td.' + _target + ':not(:contains(' + _content.toUpperCase() + '))').parent().hide();
        }
    });
}

function showNameFile(elm) {
    var _label = $(elm).closest('label');
    var _spanfile = _label.prev('span');
    var _allowtypes = $(elm).data('allowtypes').split('|');
    var _type = $(elm).get(0).files[0]['name'].split('.').pop();

    if (in_array(_type, _allowtypes)) {
        if (_spanfile.length) {
            _spanfile.html($(elm).val());
        } else {
            $('<span>' + $(elm).val() + '</span>').insertBefore(_label);
        }
    } else {
        $(elm).val('');
        bootbox.alert('Format file tidak sesuai. Mohon attach ulang.');
    }
}

var numeral = {
    unformat: function(string_number) {
        string_number = (empty(string_number)) ? 0 : string_number;
        return parse_number(string_number, '.', ',');
    },

    format: function(string_number, dec = 2) {
        string_number = (empty(string_number)) ? 0 : string_number;
        return number_format(string_number, dec, ',', '.');
    },

    formatInt: function(string_number, dec = 2) {
        string_number = (empty(string_number)) ? 0 : string_number;
        return number_format(string_number, 0, ',', '.');
    },

    formatDec: function(string_number, dec = 2) {
        string_number = (empty(string_number)) ? 0 : string_number;
        return number_format(string_number, dec, ',', '.');
    }
};

function getValueDateSQL(elm) {
    var result = null;
    try {
        var _value = moment($(elm).datepicker("getDate"));
        result = moment(_value).format('YYYY-MM-DD');
    } catch (e) {
        console.error(e);
    }
    return result;
}

function getValueTimeSQL(elm) {
    var result = null;
    try {
        var _value = moment($(elm).data("DateTimePicker").date());
        result = moment(_value).format('HH:mm:ss');
    } catch (e) {
        console.error(e);
    }
    return result;
}

function getValueDateTimeSQL(elm) {
    var result = null;
    try {
        var _value = moment($(elm).data("DateTimePicker").date());
        result = moment(_value).format('YYYY-MM-DD HH:mm:ss');
    } catch (e) {
        console.error(e);
    }
    return result;
}

$.fn.enterKey = function(fnc, mod) {
    return this.each(function() {
        $(this).keypress(function(ev) {
            var keycode = (ev.keyCode ? ev.keyCode : ev.which);
            if ((keycode == '13' || keycode == '10') && (!mod || ev[mod + 'Key'])) {
                fnc.call(this, ev);
            }
        })
    })
}

Number.prototype.round = function(decLength = 2) {
    var num = Math.round(this + 'e' + decLength)
    return Number(num + 'e-' + decLength)
}

function dateSQL(tanggal) {
    return moment(tanggal).format('YYYY-MM-DD');
}

function dateTimeSQL(tanggal) {
    return moment(tanggal).format('YYYY-MM-DD HH:mm:ss');
}

function timeSQL(time) {
    return moment(time).format('HH:mm:ss');
}

function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {
            break;
        }
    }
}

/* fungsi untuk inisialisasi input format angka ketika klik baris baru*/
function reinitiateNumber(elm) {
    $(elm).each(function(i) {
        console.log($(this).data('tipe'));
        if ($(this).data('tipe') != undefined) {
            $(this).priceFormat(Config[$(this).data('tipe')]);
        }
    })
}

function serializeArrayFull(elm) {
    var data_params = [];
    var data = {};
    $(elm).find('input[type!=checkbox]').each(function(i, v) {
        data = {
            'name': $(v).attr('name'),
            'value': ($(v).attr('data-tipe') == 'integer' || $(v).attr('data-tipe') == 'decimal') ? numeral.unformat($(v).val()) : $(v).val(),
            'required': $(v).attr('required') ? true : false,
            'label': $(v).attr('required') ? $(v).attr('label') : '',
            'type': $(v).attr('type')
        };
        data_params.push(data);
    });

    $(elm).find('input[type=checkbox]').each(function(i, v) {
        data = {
            'name': $(v).attr('name'),
            'value': $(v).is(':checked') ? 1 : 0,
            'required': $(v).attr('required') ? true : false,
            'label': $(v).attr('required') ? $(v).attr('label') : '',
            'type': $(v).attr('type')
        };
        data_params.push(data);
    });

    $(elm).find('select').each(function(i, v) {
        data = {
            'name': $(v).attr('name'),
            'value': $(v).find('option:selected').val(),
            'required': $(v).attr('required') ? true : false,
            'label': $(v).attr('required') ? $(v).attr('label') : '',
            'type': $(v).attr('type')
        };
        data_params.push(data);
    });

    // data_params.find(v => v.name == 'status').value = 'tes';
    // console.log(data_params);
    return data_params;
}
File.prototype.convertToBase64 = function(callback) {
    var reader = new FileReader();
    reader.onload = function(e) {
        callback(e.target.result)
    };
    reader.onerror = function(e) {
        callback(null);
    };
    reader.readAsDataURL(this);
};

function validationSave(data_params, confirm_msg, callback) {
    var result = 1;
    var count = 0;
    var jenis_grade = '';

    $.each(data_params, function(i, v) {
        if (v.required == true && v.value == '') {
            result = 0;
        }
    });
    // return false;

    if (result == 1) {
        var message2 = confirm_msg;
        var _options2 = {
            title: 'Konfirmasi Simpan Data',
            className: 'titleCenter',
            message: message2,
            buttons: {
                cancel: {
                    label: 'Tidak',
                    callback: function() {}
                },
                confirm: {
                    label: 'Ya',
                    callback: function() {
                        box2.bind('hidden.bs.modal', function() {
                            callback(result);
                        });
                    }
                },
            },
        };

        var box2 = bootbox.dialog(_options2);
    } else {
        var _options = {
            title: 'Penyimpanan data gagal',
            className: 'titleCenter',
            message: 'Isian data tidak lengkap',
        };
        var box = bootbox.dialog(_options);

        box.bind('shown.bs.modal', function() {
            $('div.bootbox .btn-checkmark').addClass('hide');
        });
    }
};

function executeSave(data_params, url, callback) {
    // console.log(url);
    $.ajax({
        url: url,
        data: data_params,
        type: 'post',
        dataType: 'json',
        beforeSend: function() {
            bootbox.dialog({
                message: "Sedang proses simpan..."
            });
        },
        success: function(data) {
            $('.bootbox').modal('hide');
            callback(data);
        }
    });

};