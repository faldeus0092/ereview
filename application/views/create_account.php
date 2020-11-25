<!DOCTYPE html>
<html>
<head>
	<title>Create Account in EReview</title>
</head>
<body>
	<h1>Form Pembuatan User Baru</h1>
	<p>
		<?php if (strlen($msg)>0) echo $msg;?>
	</p>
	<form action="creatingaccount" method="post">
		<table>
			<tr>
				<td>Nama: </td>
				<td><input type="text" id="nama" name="nama" width="100"/></td>
			</tr>
			<tr>
				<td>Username: </td>
				<td><input type="text" id="username" name="username" width="100"/></td>
			</tr>
			<tr>
				<td>Password: </td>
				<td><input type="password" id="katasandi" name="katasandi" width="100"/></td>
			</tr>
			<tr>
				<td>Email: </td>
				<td><input type="text" id="email" name="email" width="100"/></td>
			</tr>
			<tr>
				<td>Peran: </td>
				<td>
					<select id="peran">
						<option value="1" selected>Editor </option>
						<option value="2">Reviewer</option>
					</select>
				</td>
			</tr>
		</table>
		
		<input type="submit" value="submit">
	</form>
	
</body>
</html>