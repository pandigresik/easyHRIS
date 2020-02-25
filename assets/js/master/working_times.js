var Working_times = {

};
$(function() {
	$("[name='batas_awal_jam_masuk'],[name='batas_akhir_jam_masuk']").datetimepicker({
		format: 'HH:mm',
		useCurrent: true,
		keepOpen: true,
		ignoreReadonly: true
	});
});