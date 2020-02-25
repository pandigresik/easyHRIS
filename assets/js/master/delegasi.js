var Delegasi = {
    menu: {},
    getMenuRole: function(roleId) {
        if (this.menu[roleId] == undefined) {
            var _data = { roles_id: roleId };
            var _fields = ['menus_id'];
            $.ajax({
                url: 'master/role_menu/searchAjax',
                data: { data: _data, fields: _fields },
                type: 'post',
                dataType: 'json',
                success: function(data) {
                    if (data.status) {
                        if (!empty(data.content)) {
                            Delegasi.menu[roleId] = [];
                            for (var _x in data.content) {
                                Delegasi.menu[roleId].push(data.content[_x]['menus_id']);
                            }
                        }

                    }
                },
                async: false,
                cache: false,
            });
        }
        return this.menu[roleId];
    }
}
$(function() {
    App.initSelect2Ajax();
    $('#id_penyetuju').change(function() {
        var _v = $(this).val();
        if (!empty(_v)) {
            var _tmp = $(this).find('option:selected').text().split(' - ');
            _tmp.shift();
            $('#jabatan_penyetuju').val(_tmp.join(' '));
            var _roleId = _v.split('_')[1];
            //$('#jabatan_penyetuju').data('role_id', _v.split('_')[1]);
            /** set default otorisasi */
            var _menuRole = Delegasi.getMenuRole(_roleId);
            $.when(_menuRole).done(function() {
                if (!empty(_menuRole)) {
                    $('#otorisasi').select2('val', [_menuRole]);
                }
            });
        }
    });
    $('#id_delegasi').change(function() {
        var _v = $(this).val();
        if (!empty(_v)) {
            var _tmp = $(this).find('option:selected').text().split(' - ');
            _tmp.shift();
            $('#jabatan_delegasi').val(_tmp.join(' '));
        }
    });
})