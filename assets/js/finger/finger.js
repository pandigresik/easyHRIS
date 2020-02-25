var Finger = {
    urlShowData: 'finger/finger/showDataMachine',
    showData: function(elm) {
        var _form = $(elm).closest('form');
        var _ip = _form.find('select[name=machineId]').val();
        if (!empty(_ip)) {
            App.getContentView(this.urlShowData, { ip: _ip }, function() {
                //init_DataTables();
            });
        } else {
            App.alertDialog('Peringatan', 'Mesin harus dipilih dulu');
        }
    }
};