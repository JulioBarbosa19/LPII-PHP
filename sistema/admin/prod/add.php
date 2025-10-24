<?php

include("../config.inc.php");
include("../session.php");
validaSessao();

$link = mysqli_connect("localhost", "root", "", "sistema");
$categorias = mysqli_query($link, "SELECT id, nome FROM categoria");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	extract($_POST);
	$error = "";
	if (!$nome) {
		$error .= " Nome obrigatório! ";
	}
	if (!$preco) {
		$error .= " Preço obrigatório! ";
	}
	if (!$categoria_id) {
		$error .= " Categoria obrigatória! ";
	}
	if (!$error) {
		$sql = "";
		$sql .= " INSERT INTO prod ";
		$sql .= " (nome, preco, id_categoria) ";
		$sql .= " VALUES ";
		$sql .= " ('".$nome."', '".$preco."', '".$id_categoria."')";
		$result = mysqli_query($link, $sql);
		header("Location: /sistema/admin/prod");
		exit;
	}
}

include("../../header.php");
include("../menu.php");

?>

<h3>ADICIONAR PRODUTO</h3>

<?php
if (isset($error)) {
	echo "<span style=\"color: red; font-style: italic;\">";
	echo $error;
	echo "</span>";
}
?>

<form method="POST">
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
			<td style="text-align: right;">Categoria:</td>
			<td>
				<select name="categoria_id">
					<option value="">Selecione</option>
					<?php while($cat = mysqli_fetch_assoc($categorias)): ?>
						<option value="<?=$cat['id']?>" <?=isset($id_categoria)&&$id_categoria==$cat['id']?'selected':'';?>>
							<?=$cat['nome']?>
						</option>
					<?php endwhile; ?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="text-align: center;">
				<input type="submit" name="submit" value="Cadastrar">
			</td>
		</tr>
	</table>
</form>

<?php
include("../../footer.php");
?>