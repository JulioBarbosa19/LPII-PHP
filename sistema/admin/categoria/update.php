<?php

include("../config.inc.php");
include("../session.php");
validaSessao();

$id = "";
if ($_GET["id"]) $id = $_GET["id"];
elseif ($_POST["id"]) $id = $_POST["id"];
if (!$id) {
	header("Location: /sistema/admin/categoria/");
	exit;
}
$link = mysqli_connect("localhost", "root", "", "sistema");
$sql = "SELECT * FROM categoria WHERE id = '".$id."';";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) == 0) {
	header("Location: /sistema/admin/categoria/");
	exit;
}
$row = mysqli_fetch_assoc($result);
extract($row);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	extract($_POST);
	$error = "";
	if (!$nome) {
		$error .= " Nome obrigatório! ";
	}
	if (!$error) {
		$link = mysqli_connect("localhost", "root", "", "sistema");
		$sql = "UPDATE categoria SET nome = '".$nome."' WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
		header("Location: /sistema/admin/categoria");
		exit;
	}
}

include("../../header.php");
include("../menu.php");

?>

<h3>EDITAR CATEGORIA</h3>

<?php
if (isset($error)) {
	echo "<span style=\"color: red; font-style: italic;\">";
	echo $error;
	echo "</span>";
}
?>

<form method="POST">
	<input type="hidden" name="id" value="<?=isset($id)?$id:"";?>">
	<table>
		<tr>
			<td style="text-align: right;">Nome:</td>
			<td>
				<input type="text" name="nome" value="<?=isset($nome)?$nome:"";?>">
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" name="submit" value="Atualizar">
			</td>
		</tr>
	</table>
</form>

<?php
include("../../footer.php");
?>