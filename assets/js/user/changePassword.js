
function changePassword(){
	
	var oldPassword = $('#divChangePassword input[name=oldPassword]').val();
	var newPassword = $('#divChangePassword input[name=newPassword]').val();
	var confirmPassword = $('#divChangePassword input[name=confirmPassword]').val();
	var sama = 1;
	if(newPassword != confirmPassword){
		sama = 0;
	}
	if(sama){
		$.ajax({
			url:'user/changePassword',
			data:{oldPassword : oldPassword, newPassword : newPassword},
			type:'POST',
			dataType:'json',
			beforeSend: function(){},
			success: function(data){
				if(data.status){
					$('#divinfo').html('<div class="alert alert-success">'+data.message+'</div>');
					$('#divChangePassword button[type=submit]').addClass('disabled');
				}
				else{
					$('#divinfo').html('<div class="alert alert-danger">'+data.message+'</div>');
				}
			},
			error: function(){}
		});
	}
	else{
		alert('Password belum sama');
	}
	return false;
}

