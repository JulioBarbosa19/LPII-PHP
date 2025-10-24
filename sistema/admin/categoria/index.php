<?php
include("../config.inc.php");
include("../session.php");
validaSessao();
include("../../header.php");
include("../menu.php");
?>

<h3>CATEGORIAS</h3>

<a href="/sistema/admin/categoria/add.php" style="color: black;">+ Adicionar</a>

<br><br>
<table border="1">
	<tr>
		<th>Nome</th>
        <th>EDITAR</th>
		<th>APAGAR</th>
	</tr>
	<?php
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "SELECT * FROM categoria ORDER BY nome;";
	$result = mysqli_query($link, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		?>
		<tr>
			<td><?=$row["nome"];?></td>
			<td><a href="/sistema/admin/categoria/update.php?id=<?=$row["id"];?>" style="color: black;">editar</a></td>
			<td><a href="/sistema/admin/categoria/delete.php?id=<?=$row["id"];?>" style="color: black;">apagar</a></td>
			
		</tr>
		<?php
	}
	?>
</table>
<br><br>



<?php
include("../../footer.php");
?>