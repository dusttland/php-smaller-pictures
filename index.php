<?php $img = 'back3.jpg' ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Pildivärk</title>
</head>
<body>	

	<form action="mksmall.php" method="get">
		<input type="hidden" name="name" value="<?php echo $img; ?>">
		<input type="submit" value="Tee Väike Pilt!">
	</form>

	<br>

	<img src="img/<?php echo $img; ?>">

</body>
</html>