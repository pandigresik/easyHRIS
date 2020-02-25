var ImportUser = {
    importAll: function(elm) {
        /** pastikan user sudah memilih filter daftar user */
        var _tr = $('#datatable tbody tr');
        if (!_tr.length) {
            bootbox.alert('Belum ada user yang dipilih');
            return false;
        }

        var _params = [],
            _nilai, _data = {};
        var _tmp = $('#divfilterpage').find('form').serializeArray();
        if (empty(_tmp)) {
            bootbox.alert('Belum parameter pencarian yang dipilih');
            return false;
        }
        for (var i in _tmp) {
            _nilai = _tmp[i]['value'];
            if (empty(_nilai)) continue;

            if (_data[_tmp[i]['name']] == undefined) {
                _data[_tmp[i]['name']] = _nilai;
            } else {
                if (Array.isArray(_data[_tmp[i]['name']])) {
                    _data[_tmp[i]['name']].push(_nilai);
                } else {
                    _tmpVal = _data[_tmp[i]['name']];
                    _data[_tmp[i]['name']] = [_tmpVal];
                    _data[_tmp[i]['name']].push(_nilai);
                }
            }
        }
        var _url = $(elm).data('url');

        App.postRequest(_url, _data, 'master/user');
    },
    importChecked: function(elm) {
        var _checked = $('#datatable tbody tr :checked');
        if (!_checked.length) {
            bootbox.alert('Belum ada user yang dipilih');
            return false;
        }
        var _listUser = [];
        var _url = $(elm).data('url');
        _checked.each(function() {
            _listUser.push($(this).closest('tr').data('key')['NIK']);
        });
        App.postRequest(_url, _listUser, 'master/user');
    }
}
$(function() {
    App.initSelect2Ajax();
})