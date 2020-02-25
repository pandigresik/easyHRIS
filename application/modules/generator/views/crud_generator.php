<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to CodeIgniter</title>

	<style type="text/css">

	::selection{ background-color: #E13300; color: white; }
	::moz-selection{ background-color: #E13300; color: white; }
	::webkit-selection{ background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body{
		margin: 0 15px 0 15px;
	}
	
	p.footer{
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}
	
	#container{
		margin: 10px;
		border: 1px solid #D0D0D0;
		-webkit-box-shadow: 0 0 8px #D0D0D0;
	}

    .dev_link{
        text-decoration: none;
        color: #000000;
    }
	</style>
</head>
<body>

<div id="container">
	<form action="" method="POST">
		<table cellpadding=4>
			<tr>
				<td>Table</td>
				<td>
					<select name="table_name" id="table_name" onchange="this.form.submit()">
						<option value="">Pilih tabel</option>
						<?php 
							foreach($tables as $t){
								$selected = $table_name == $t ? 'selected' : '';
								echo '<option '.$selected.'>'.$t.'</option>';
							}
						?>
					</select>
				</td>
			</tr>
			<tr>
				<td>Module</td>
				<td><input type="text" name="module" id="module" value="<?php echo $module ?>"></td>
			</tr>
			<tr>
				<td>Controller</td>
				<td><input type="text" name="controller" id="controller" value="<?php echo $controller ?>"></td>
			</tr>
			<tr>
				<td>Model</td>
				<td><input type="text" name="model" id="model" value="<?php echo $model ?>"></td>
			</tr>
			<tr>
				<td colspan=2>
					<div>Form Generator</div>
					<table cellpadding=10 cellspacing=4 width='100%'>
						<thead>
							<tr>
								<th>Field</th>
								<th>Type</th>
								<th>Length</th>
								<th>Options Form</th>
								<th>Alias</th>
								<th>In Form</th>
								<th>Required</th>
								<th>Fillable</th>
								<th>Is Heading</th>
								<th>Rules</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if(!empty($field_table)){
								$listOptions = ['input','number','email','tel','date','textarea','file','dropdown','checkbox','radio'];
								$listOptionStr = [];
								foreach($listOptions as $ls){
									array_push($listOptionStr,'<option>'.$ls.'</option>');
								}
								foreach($field_table as $ft){
									echo '<tr>
											<td>'.$ft->name.'</td>
											<td>'.$ft->type.'</td>
											<td>'.$ft->max_length.'</td>
											<td><select name="form_element[options]['.$ft->name.']" value="'.$ft->name.'">'.implode('',$listOptionStr).'</select></td>
											<td><input type="text" name="form_element[alias]['.$ft->name.']" value="'.$ft->name.'" checked></td>
											<td><input type="checkbox" name="form_element[inform][]" value="'.$ft->name.'" checked></td>
											<td><input type="checkbox" name="form_element[required]['.$ft->name.']" value="'.$ft->name.'" checked></td>
											<td><input type="checkbox" name="form_element[fillable][]" value="'.$ft->name.'" checked></td>
											<td><input type="checkbox" name="form_element[heading][]" value="'.$ft->name.'" checked></td>
											<td></td>
										</tr>';
								}
							}	
						?>
						</tbody>
					</table>		
				</td>
			</tr>
			<tr>
				<td></td>
				<td><button type="submit">Generate Code</button></td>
			</tr>
		</table>

	</form>
</div>

</body>
</html>