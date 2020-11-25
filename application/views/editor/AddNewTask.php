<html>
<head>
	<title>e-Review Teknologi Web</title>
</head>
<body>
	<h1>Form Pembuatan Task Baru</h1>
	<p>
		<?php echo $msg;?>
	</p>
	<form action="managemytask/addingNewTask" method="post">
		Judul: <input type="text" id="judul" name="judul" width="50"/><br/>
		Kata Kunci: <input type="text" id="Kata Kunci" name="Kata Kunci" width="50"/><br/>
		<input type="submit" value="submit">
	</form>
	
</body>
</html>