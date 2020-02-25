var Jadwal = {
    simpan: function(elm) {
        var _form = $(elm).closest('form');
        var _attachment = _form.find('input[name=attachment]').val();
        if (empty(_attachment)) {
            bootbox.alert('Tidak ada file yang diupload');
            return false;
        }
        return true;
    },
    approve: function(elm) {
        var _id = $(elm).data('id');
        App.saveDialog('Approval Jadwal Kerja', 'Apakah anda yakin akan melakukan approval ini ?', function(r) {
            if (r) {
                Jadwal.simpanApproval(_id);
            }
        });
    },
    reject: function(elm) {
        var _id = $(elm).data('id');
        App.confirmRejectDialog(elm, 'Batalkan Pengajuan ', function(elm, _alasan) {
            Jadwal.rejectApproval(_id, _alasan);
        });
    },
    simpanApproval: function(_id) {
        var _url = 'master/jadwal/approve';
        var _nexturl = 'master/jadwal';
        var _sendData = { key: { id: _id } };
        $.ajax({
            url: _url,
            data: _sendData,
            type: 'post',
            beforeSend: function() {
                bootbox.alert('Proses insert data, mungkin membutuhkan waktu beberapa lama. Mohon ditunggu .....');
            },
            success: function(data) {
                App.alertDialog('Informasi', data.message, function() {
                    bootbox.hideAll();
                    App.postContentView(_nexturl);
                });
            },
            dataType: 'json'
        });
    },

    rejectApproval: function(_id, _alasan) {
        var _url = 'master/jadwal/reject';
        var _nexturl = 'master/jadwal';
        var _sendData = { key: { id: _id }, data: { comment: _alasan } };
        $.post(_url, _sendData, function(data) {
            App.alertDialog('Informasi', data.message, function() {
                App.postContentView(_nexturl);
            });
        }, 'json');
    }

};

$(function() {
    if (Dropzone !== undefined) {
        Dropzone.autoDiscover = false;

        var fileUpload = new Dropzone(".dropzone", {
            url: "master/jadwal/uploadFile",
            maxFilesize: 2,
            createImageThumbnails: false,
            method: "post",
            acceptedFiles: ".xls,.xlsx",
            paramName: "userfile",
            dictInvalidFileType: "Type file ini tidak dizinkan",
            addRemoveLinks: true,
            maxFiles: 1,
            init: function() {
                this.on("sending", function(file, xhr, data) {
                    if (file.fullPath) {
                        data.append("fullPath", file.fullPath);
                    }
                });
                this.on("error", function(file, message, xhr) {
                    if (xhr == null) this.removeFile(file); // perhaps not remove on xhr errors
                    App.alertDialog('Notifikasi', message);
                });
            },
            success: function(file, response) {
                if (response.status) {
                    $('input[name=file_name]').val(file.name);
                    $('input[name=attachment]').val(response.attachment);
                    $('#divTableJadwal').html(response.content).promise().done(function() {
                        $(document).trigger("stickyTable");
                    });
                } else {
                    App.alertDialog('Notifikasi', response.message.join('<br />'));
                    this.removeFile(file);
                }
            }
        });

    }

    //Event ketika Memulai mengupload
    /*fileUpload.on("sending", function(a, b, c) {
        a.token = Math.random();
        c.append("token_foto", a.token); //Menmpersiapkan token untuk masing masing foto
    });*/
})