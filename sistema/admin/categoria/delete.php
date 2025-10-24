<?php

include("../config.inc.php");
include("../session.php");
validaSessao();

if (!$_GET["id"]) {
	header("Location: /sistema/admin/categoria/");
	exit;
}
$link = mysqli_connect("localhost", "root", "", "sistema");
$sql = "SELECT * FROM categoria WHERE id = '".$_GET["id"]."';";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) == 0) {
	header("Location: /sistema/admin/categoria/");
	exit;
}
$row = mysqli_fetch_assoc($result);

if (isset($_GET["del"]) && ($_GET["del"] == "yes")) {
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "DELETE FROM categoria WHERE id = '".$_GET["id"]."';";
	$result = mysqli_query($link, $sql);
	header("Location: /sistema/admin/categoria/");
	exit;
}

include("../../header.php");
include("../menu.php");

?>

<h3>APAGAR CATEGORIA</h3>

<table>
	<tr>
		<td colspan="2" style="text-align: center;">
			Tem certeza que realmente quer apagar a categoria "<?=$row["nome"];?>"?
		</td>
	</tr>
	<tr>
		<td style="text-align: center;">
			<a href="/sistema/admin/categoria/delete.php?id=<?=$row["id"];?>&del=yes"><input type="button" value="SIM">
		</td>
		<td style="text-align: center;">
			<a href="/sistema/admin/prod/"><input type="button" value="NÃO"></a>
		</td>
	</tr>
</table>

<?php
include("../../footer.php");
?>