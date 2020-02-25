var Timetables = {
	setJamKerja: function(elm) {
		var data = $(elm).select2('data');
		var jam_kerja = data[0].text;
		var result_temp = jam_kerja.split('(');
		var result = result_temp[1].split(' ');
		$("[name='jam_kerja']").val(result[0]);
    },
	setJamPulang: function(elm) {
		var jam_kerja = $("[name='jam_kerja']").val();
		var jam_pulang = moment.utc(elm.format("HH:mm"),'HH:mm').add(jam_kerja,'hour').format('HH:mm');
		$("[name='jam_pulang']").val(jam_pulang);
    },
};
$(function() {
	$("[name='jam_masuk']").datetimepicker({
		format: 'HH:mm',
		useCurrent: true,
		keepOpen: true,
		ignoreReadonly: true
	}).on('dp.change', function(e){ Timetables.setJamPulang(e.date); });
});