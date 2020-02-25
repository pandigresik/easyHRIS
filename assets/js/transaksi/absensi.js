var Absensi = {
    hariLibur: [],
    dataKaryawan: {},
    fingerTerakhir: null,
    getHariLibur: function() {
        return this.hariLibur;
    },
    getJmlLibur: function(_startDate, _range) {
        var _r = 0;
        if (_range < 1) {
            return _r;
        }
        var _maxDate = new Date(jQuery.datepicker.formatDate('yy-mm-dd', _startDate));
        _maxDate.setDate(_maxDate.getDate() + _range);

        for (var _refDate = new Date(jQuery.datepicker.formatDate('yy-mm-dd', _startDate)); _refDate <= _maxDate; _refDate.setDate(_refDate.getDate() + 1)) {
            if (Absensi.getHariLibur().indexOf(jQuery.datepicker.formatDate('yy-mm-dd', _refDate)) != -1) {
                _r++;
            }
        }
        return _r;
    },
    setTanggal: function(elm) {
        var _form = $(elm).closest('form');
        var _option = $(elm).find('option:selected');
        var _ref = _option.data('ref');
        var _refDate = {
            'start_date_min': _option.data('start_date_min'),
            'start_date_max': _option.data('start_date_max'),
            'end_date_min': _option.data('end_date_min'),
            'end_date_max': _option.data('end_date_max'),
        };
        switch (_ref) {
            case 'H':
                this.setTanggalH(_form, _refDate);
                break;
            case 'FP':
                this.setTanggalFP(_form, _refDate);
                break;
            case 'CL':
                this.setTanggalCL(_form, _refDate);
                break;
        }
    },
    setTanggalH: function(_form, _refDate) {
        var _startDate = _form.find('#start_date');
        var _endDate = _form.find('#end_date');

        var _minStartDate = new Date();
        var _maxStartDate = new Date();
        var _jumlahLiburStart = 0;
        if (_refDate.start_date_max <= 15) {
            _jumlahLiburStart = this.getJmlLibur(_minStartDate, _refDate.start_date_max);
        }

        _minStartDate.setDate(_minStartDate.getDate() + _refDate.start_date_min);
        _maxStartDate.setDate(_maxStartDate.getDate() + (_refDate.start_date_max + _jumlahLiburStart));

        var _minEndDate = new Date($.datepicker.formatDate('yy-mm-dd', _minStartDate));
        var _maxEndDate = new Date();
        var _jumlahLiburEnd = 0;
        if (_refDate.end_date_max <= 10) {
            _jumlahLiburEnd = this.getJmlLibur(_minEndDate, _refDate.end_date_max);
        }
        _minEndDate.setDate(_minEndDate.getDate() + _refDate.end_date_min);
        _maxEndDate.setDate(_maxEndDate.getDate() + (_refDate.end_date_max + _jumlahLiburEnd));

        _startDate.datepicker('option', 'minDate', _minStartDate);
        _startDate.datepicker('option', 'maxDate', _maxStartDate);

        _endDate.datepicker('option', 'minDate', _minEndDate);
        _endDate.datepicker('option', 'maxDate', _maxEndDate);

        _startDate.val('');
        _endDate.val('');
    },

    setTanggalFP: function(_form, _refDate) {
        var _startDate = _form.find('#start_date');
        var _endDate = _form.find('#end_date');
        var _fingerTerakhir = this.getFingerTerakhir();
        var _minStartDate = new Date(_fingerTerakhir);
        var _maxStartDate = new Date();
        _minStartDate.setDate(_minStartDate.getDate() + _refDate.start_date_min);
        _maxStartDate.setDate(_maxStartDate.getDate() + _refDate.start_date_max);

        var _minEndDate = new Date();
        var _maxEndDate = new Date();
        _minEndDate.setDate(_minEndDate.getDate() + _refDate.end_date_min);
        _maxEndDate.setDate(_maxEndDate.getDate() + _refDate.end_date_max);

        _startDate.datepicker('option', 'minDate', _minStartDate);
        _startDate.datepicker('option', 'maxDate', _maxStartDate);

        _endDate.datepicker('option', 'minDate', _minEndDate);
        _endDate.datepicker('option', 'maxDate', _maxEndDate);

        _startDate.val('');
        _endDate.val('');
    },

    setTanggalCL: function(_form, _refDate) {
        var _startDate = _form.find('#start_date');
        var _endDate = _form.find('#end_date');

        var _minStartDate = new Date();
        var _maxStartDate = new Date();
        _minStartDate.setDate(_minStartDate.getDate() + _refDate.start_date_min);
        _maxStartDate.setDate(_maxStartDate.getDate() + _refDate.start_date_max);

        var _minEndDate = new Date();
        var _maxEndDate = new Date();
        _minEndDate.setDate(_minEndDate.getDate() + _refDate.end_date_min);
        _maxEndDate.setDate(_maxEndDate.getDate() + _refDate.end_date_max);

        _startDate.datepicker('option', 'minDate', _minStartDate);
        _startDate.datepicker('option', 'maxDate', _maxStartDate);

        _endDate.datepicker('option', 'minDate', _minEndDate);
        _endDate.datepicker('option', 'maxDate', _maxEndDate);
        _startDate.val('');
        _endDate.val('');
    },

    removeEmployee: function(elm) {
        var _tr = $(elm).closest('tr');
        var _tbody = _tr.closest('tbody');
        var _totalTr = _tbody.find('tr').length;
        if (_totalTr > 1) {
            _tr.remove();
        } else {
            App.alertDialog('Warning', 'Baris hanya 1 tidak boleh dihapus');
        }
    },

    addEmployee: function(elm) {
        var _tr = $(elm).closest('tr');
        var _tbody = _tr.closest('tbody');
        var _nomer = parseInt(_tbody.find('tr:last td.nomer').text()) + 1;
        var _clone = _tr.clone();
        _clone.find('select').closest('td').html(_clone.find('select').removeClass('select2-hidden-accessible'));
        _clone.find('td.nomer').text(_nomer);
        _clone.find('input').val('');
        _tbody.append(_clone);
        _clone.find('select').select2({
            placeholder: "&#xf002 silakan dipilih",
            width: "100%",
            escapeMarkup: function(m) {
                return m;
            },
            allowClear: true
        });
    },

    getTimetable: function(elm) {
        /** pastikan sudah dipilih tanggal dan jenis pengajuannya */
        var _optionsterpilih = $('#absent_type_id').find('option:selected');
        var _jenisPengajuan = _optionsterpilih.data('code');
        var _start_date = $('#start_date').val();
        var _val = $(elm).val();

        if (empty(_val) || _val == '0') {
            this.setBarisTimetable(elm, {}, _jenisPengajuan);
            return false;
        }

        if (empty(_jenisPengajuan)) {
            App.alertDialog('Informasi', 'Jenis pengajuan harus dipilih terlebih dahulu');
            $(elm).val(null).trigger('change');
            return false;
        }

        if (empty(_start_date)) {
            App.alertDialog('Informasi', 'Tanggal harus dipilih terlebih dahulu');
            $(elm).val(null).trigger('change');
            return false;
        }

        /** pastikan karyawannya belum dipilih */
        var _sudahAda = 0;
        $('select[name=employee]').not(elm).map(function() {
            if ($(this).val() == _val) {
                App.alertDialog('Informasi', 'Nik ' + _val + ' dipilih terlebih dahulu');
                $(elm).val(null).trigger('change');
                _sudahAda++;
                return false;
            }
        });
        if (_sudahAda) {
            return false;
        }

        var _dataKaryawan = this.getDataKaryawan(_val, getValueDateSQL('#start_date'));
        if (!empty(_dataKaryawan)) {
            this.setBarisTimetable(elm, _dataKaryawan, _jenisPengajuan);
        }
    },

    setBarisTimetable: function(elm, dataKaryawan, jenisPengajuan) {
        var _editTime = ['DLS', 'LB', 'LBA', 'LBD'];
        var _tr = $(elm).closest('tr');
        if (empty(dataKaryawan)) {
            _tr.find('input').val('');
        } else {
            _tr.find('input[name=jabatan]').val(dataKaryawan['jabatan']);
            _tr.find('input[name=timestables]').val(dataKaryawan['timestables']['timestables']);
            _tr.find('input[name=start_time]').val(dataKaryawan['timestables']['jam_masuk']);
            _tr.find('input[name=end_time]').val(dataKaryawan['timestables']['jam_pulang']);

            if (App.inArray(jenisPengajuan, _editTime)) {
                _tr.find('input[name$=time]').prop('readonly', 0);
            }
        }
    },
    getDataKaryawan: function(nik, tanggalabsensi) {
        if (this.dataKaryawan[nik] == undefined) {
            var _data = { ref_nik: nik, tanggalabsensi: tanggalabsensi };
            var _fields = ['menus_id'];
            $.ajax({
                url: 'master/user/searchTimetableAjax',
                data: { data: _data, fields: _fields },
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        Absensi.dataKaryawan[nik] = {};
                        if (!empty(data.content)) {
                            Absensi.dataKaryawan[nik] = data.content;
                        }
                    } else {
                        App.alertDialog('Informasi', 'Jadwal kerja NIK ' + nik + ' tanggal ' + tanggalabsensi + ' tidak ditemukan');
                    }
                },
                async: false,
                cache: false,
            });
        }
        return this.dataKaryawan[nik];
    },

    getFingerTerakhir: function() {
        if (empty(this.fingerTerakhir)) {
            var _data = {};
            var _fields = ['tanggalabsensi'];
            $.ajax({
                url: 'report/fingerprint/searchAjax',
                data: { data: _data, fields: _fields, order: { 'tanggalabsensi': 'desc' }, single: true },
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        if (!empty(data.content)) {
                            Absensi.fingerTerakhir = data.content.tanggalabsensi;
                        }
                    } else {
                        App.alertDialog('Informasi', 'Data fingerprint terakhir ' + nik + ' tidak ditemukan');
                    }
                },
                async: false,
                cache: false,
            });
        }
        return this.fingerTerakhir;
    },
    approve: function(elm) {
        var _id = $(elm).data('id');
        var _url = $(elm).data('url');
        App.saveDialog('Approval Pengajuan ', 'Apakah anda yakin akan melakukan approval ini ?', function(r) {
            if (r) {
                Absensi.simpanApproval(_id, _url);
            }
        });
    },
    reject: function(elm) {
        var _id = $(elm).data('id');
        var _url = $(elm).data('url');
        this.confirmRejectDialog(elm, 'Batalkan Pengajuan ', function(elm, _alasan, _status) {
            Absensi.rejectApproval(_id, _url, _alasan, _status);
        });
    },
    simpanApproval: function(_id, _url) {
        var _sendData = { key: { id: _id } };
        $.ajax({
            url: _url,
            data: _sendData,
            type: 'post',
            beforeSend: function() {
                // bootbox.alert('Proses insert data, mungkin membutuhkan waktu beberapa lama. Mohon ditunggu .....');
            },
            success: function(data) {
                App.alertDialog('Informasi', data.message, function() {
                    bootbox.hideAll();
                    if (data.nexturl != undefined) {
                        App.postContentView(data.nexturl);
                    }
                });
            },
            dataType: 'json'
        });
    },

    rejectApproval: function(_id, _url, _alasan, _status) {
        var _sendData = { key: { id: _id }, data: { comment: _alasan, status: _status } };
        $.post(_url, _sendData, function(data) {
            App.alertDialog('Informasi', data.message, function() {
                if (data.nexturl != undefined) {
                    App.postContentView(data.nexturl);
                }
            });
        }, 'json');
    },

    confirmRejectDialog: function(elm, message, callback) {
        bootbox.dialog({
            title: message,
            message: '<form class="bootbox-form form form-horizontal"><div class="form-group"><label class="col-md-2">Alasan (Wajib)</label><div class="col-md-10"><textarea class="bootbox-input bootbox-input-textarea form-control" required></textarea></div></div></form>',
            required: true,
            buttons: {
                revisi: {
                    label: 'Revisi',
                    className: 'btn-primary',
                    callback: function(e) {
                        var _elm = $(e.target);
                        var _b = _elm.closest('.bootbox');
                        var _comment = _b.find('.bootbox-input').val();
                        if (empty(_comment)) {
                            bootbox.alert('Mohon isi kolom keterangan alasan penolakan.');
                            return false;
                        } else {
                            callback(elm, _comment, 'R');
                        }
                    }
                },
                batal: {
                    label: 'Batal Total',
                    className: 'btn-danger',
                    callback: function(e) {
                        var _elm = $(e.target);
                        var _b = _elm.closest('.bootbox');
                        var _comment = _b.find('.bootbox-input').val();
                        if (empty(_comment)) {
                            bootbox.alert('Mohon isi kolom keterangan alasan penolakan.');
                            return false;
                        } else {
                            callback(elm, _comment, 'V');
                        }
                    }
                }
            },
        });
    }, // end -  confirmRejectDialog

};
$(function() {
    $('<ul class="file_template"></ul>').insertAfter($('#attachment').closest('.btn-file'));

    $('#attachment').change(function() {
        var $fileUpload = $(this);
        if (parseInt($fileUpload.get(0).files.length) > 1) {
            alert("Jumlah photo yang bisa diupload hanya 1 foto");
            return false;
        }
        var _template = $(this).closest('.form-group').find('.file_template');
        _template.empty();
        for (var i = 0, len = this.files.length; i < len; i++) {
            (function(j, self) {
                var reader = new FileReader()
                reader.onload = function(e) {
                    _template.append('\
                                        <li>\
                                            <div class="site-photo site-photo-64 site-photo-left">\
                                                <img class="image-post" src="' + e.target.result + '">\
                                            </div>\
                                        </li>');
                    $(".image-post").colorbox();
                }
                reader.readAsDataURL(self.files[j]);
            })(i, this);
        }
    });

    if ($('#attachment').data('src') !== undefined) {
        var _template = $('#attachment').closest('.form-group').find('.file_template');
        _template.append('\
                                        <li>\
                                        <a href="' + $('#attachment').data('src') + '" class="image-post">\
                                            <div class="site-photo site-photo-64 site-photo-left">\
                                                <img  src="' + $('#attachment').data('src') + '" >\
                                            </div>\
                                            </a>\
                                        </li>');
        $(".image-post").colorbox({ width: "95%", height: "95%" });
    }

    $('input[name=start_date],input[name=end_date]').datepicker({
        dateFormat: 'dd M yy',
        locale: 'id',
        beforeShowDay: function(date) {
            var string = jQuery.datepicker.formatDate('yy-mm-dd', date);
            return [Absensi.getHariLibur().indexOf(string) == -1, ' '];
        },
        onSelect: function(date, e) {
            if (e.lastVal != date) {
                var _elm = e.input;
                var _n = $(this).attr('name');
                var _form = $(_elm).closest('form');
                var _option = _form.find('#absent_type_id option:selected');
                var _ref = _option.data('ref');
                var _code = _option.data('code');
                var _refDate = {
                    'start_date_min': _option.data('start_date_min'),
                    'start_date_max': _option.data('start_date_max'),
                    'end_date_min': _option.data('end_date_min'),
                    'end_date_max': _option.data('end_date_max'),
                };
                if (_n == 'start_date') {
                    var _maxEndDate = new Date(e.selectedYear, e.selectedMonth, e.selectedDay);
                    var _jumlahLiburEnd = 0;
                    if (_refDate.end_date_max <= 10) {
                        _jumlahLiburEnd = Absensi.getJmlLibur(_maxEndDate, _refDate.end_date_max);
                    }
                    /** untuk case melahirkan */
                    if (_code == 'CK10') {
                        _maxEndDate.setMonth(_maxEndDate.getMonth() + parseInt(_refDate.end_date_max / 30));
                    } else {
                        _maxEndDate.setDate(_maxEndDate.getDate() + (_refDate.end_date_max + _jumlahLiburEnd));
                    }

                    $('input[name=end_date]').datepicker('option', 'minDate', date);
                    $('input[name=end_date]').datepicker('option', 'maxDate', _maxEndDate);
                }
            }
        },
    });
});