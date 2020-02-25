(function() {
	'use strict';

	$(function() {
		$.ajaxSetup({
			statusCode : {
				401 : function() {
					bootbox.alert('Session telah habis login lagi', function() {
						window.location.href = 'user/user/login';
					})
				},
				403 : function(xhr, status, text) {
					bootbox.alert(text, function() {
						window.location.href = 'user/user/login';
					})
				},
			},
			cache: false,
			beforeSend:function(){

			},
			success:function(){

			},
			error : function(xhr, status, text) {
				// console.log(xhr);
				// console.log('mbuhkah');
				var pesan = xhr.responseText;
				if (xhr.statusText != 'abort') {
					bootbox.alert('Terjadi error di server \n' + pesan, function() {
					});
				}
			}
		});
	})
}());
