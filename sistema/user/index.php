<?php
include("./config.inc.php");
include("../header.php");
?>

<h3>USER</h3>

<form method="GET">
Palavra-Chave:
<br>
<input type="text" name="kw" value="<?=(isset($_GET["kw"]) && $_GET["kw"])?$_GET["kw"]:"";?>">
<br>
Categoria:
<br>
<select name="id_categoria">
	<option value="">Selecione</option>
	<?php
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$categorias = mysqli_query($link, "SELECT id, nome FROM categoria");
	while($cat = mysqli_fetch_assoc($categorias)):
	?>
		<option value="<?=$cat['id']?>" <?=isset($_GET['id_categoria'])&&$_GET['id_categoria']==$cat['id']?'selected':'';?> >
			<?=$cat['nome']?>
		</option>
	<?php endwhile; ?>
</select>
<br>
<input type="submit" value="Buscar">
</form>

<a href="/sistema/user/carrinho.php" style="color: black;">CARRINHO</a><br><br>
<?php

$sql = "SELECT prod.*, categoria.nome AS categoria_nome FROM prod INNER JOIN categoria ON prod.id_categoria = categoria.id";
$where = array();
if (isset($_GET["kw"]) && $_GET["kw"]) {
	$where[] = "prod.nome LIKE '%".$_GET["kw"]."%'";
}
if (isset($_GET["id_categoria"]) && $_GET["id_categoria"] && $_GET["id_categoria"] != "") {
	$where[] = "prod.id_categoria = '".$_GET["id_categoria"]."'";
}
if (count($where) > 0) {
	$sql .= " WHERE " . implode(" AND ", $where);
}
$sql .= " ORDER BY prod.nome;";


$result = mysqli_query($link, $sql);
if (mysqli_num_rows($result) > 0) {
	?>
	<table border="1">
		<tr>
			<th>Nome</th>
			<th>Preço</th>
			<th>Categoria</th>
			<th>COMPRAR</th>
		</tr>
		<?php
		while ($row = mysqli_fetch_assoc($result)) {
			?>
			<tr>
				<td><?=$row["nome"];?></td>
				<td><?=$row["preco"];?></td>
				<td><?=$row["categoria_nome"];?></td>
				<td align="center"><a href="/sistema/user/carrinho.php?a=<?=$row["id"];?>" style="color: black;">(+)</a></td>
			</tr>
			<?php
		}
		?>
	</table>
	<?php
} else {
	echo "Sem produtos.";
}
?>

<?php
include("../footer.php");
?>