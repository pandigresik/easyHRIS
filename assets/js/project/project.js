var Project = {
    removeMaterial: function(elm) {
        var _tr = $(elm).closest('tr');
        var _tbody = _tr.closest('tbody');
        //var _totalTr = _tbody.find('tr').length;
        _tr.remove();
        /*if (_totalTr > 1) {
            _tr.remove();
        } else {
            App.alertDialog('Warning', 'Baris hanya 1 tidak boleh dihapus');
        }*/
    },

    addMaterial: function(elm) {
        var _groupBtn = $(elm).closest('.input-group');
        var _select = _groupBtn.find('select');
        var _tbody = $('#tableMaterials>tbody');
        var _nama,_satuan,_tmp, _id,_tr = [];
        _id = _select.val();
        if(!empty(_id) && _id != 0){
            _tmp = _select.find('option:selected').text().split(' - ');
            _nama = _tmp[0];
            _satuan = _tmp[1];
            _tr.push('<tr>');
            _tr.push('<td><input class="form-control" size="1" name="idMaterial" value="'+_id+'" readonly /></td>');
            _tr.push('<td>'+_nama+'</td>');
            _tr.push('<td>'+_satuan+'</td>');
            _tr.push('<td><input class="form-control" name="quantityMaterial" value="" required /></td>');
            _tr.push('<td><i class="fa fa-remove" onclick="Project.removeMaterial(this)"></i></td>');
            _tr.push('</tr>');
            _tbody.append(_tr.join(''));
        }
    },   
}