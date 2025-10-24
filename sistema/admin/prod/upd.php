<?php

include("../config.inc.php");
include("../session.php");
validaSessao();

$id = "";
if ($_GET["id"]) $id = $_GET["id"];
elseif ($_POST["id"]) $id = $_POST["id"];
if (!$id) {
	header("Location: /sistema/admin/prod/");
	exit;
}
$link = mysqli_connect("localhost", "root", "", "sistema");
$sql = "SELECT * FROM prod WHERE id = '".$id."';";
$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) == 0) {
	header("Location: /sistema/admin/prod/");
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
	if (!$preco) {
		$error .= " Preço obrigatório! ";
	}
	if (!$error) {
		$link = mysqli_connect("localhost", "root", "", "sistema");
		$sql = "UPDATE prod SET nome = '".$nome."', preco = '".$preco."' WHERE id = '".$id."'";
		$result = mysqli_query($link, $sql);
		header("Location: /sistema/admin/prod");
		exit;
	}
}

include("../../header.php");
include("../menu.php");

?>

<h3>EDITAR PRODUTO</h3>

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
			<td style="text-align: right;">Preço:</td>
			<td>
				<input type="text" name="preco" value="<?=isset($preco)?$preco:"";?>">
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