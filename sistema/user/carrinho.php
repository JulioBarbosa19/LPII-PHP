<?php
if (isset($_GET["a"])) {
	if (isset($_COOKIE["carrinho"])) {
		if (strpos($_COOKIE["carrinho"], "'".$_GET["a"]."'") === false) {
			setcookie("carrinho", $_COOKIE["carrinho"].",'".$_GET["a"]."'",
				time()+60*60*24*30);
		}
	} else {
		setcookie("carrinho", "'".$_GET["a"]."'", time()+60*60*24*30);
	}
	header("Location: /sistema/user/carrinho.php");
	exit;
} elseif (isset($_GET["r"])) {
	if (isset($_COOKIE["carrinho"])) {
		if (strpos($_COOKIE["carrinho"], "'".$_GET["r"]."'") !== false) {
			$carrinho = $_COOKIE["carrinho"];
			$carrinho = str_replace(",'".$_GET["r"]."'," , ",", $carrinho);
			$carrinho = str_replace("'".$_GET["r"]."'," , "", $carrinho);
			$carrinho = str_replace(",'".$_GET["r"]."'" , "", $carrinho);
			$carrinho = str_replace("'".$_GET["r"]."'" , "", $carrinho);
			setcookie("carrinho", $carrinho, time()+60*60*24*30);
		}
	}
	header("Location: /sistema/user/carrinho.php");
	exit;
}
?>

<?php
include("./config.inc.php");
include("../header.php");
?>

<h3>CARRINHO</h3>

<a href="/sistema/user/" style="color: black;">Index</a><br><br>

<?php
if (isset($_COOKIE["carrinho"])) {
	$link = mysqli_connect("localhost", "root", "", "sistema");
	$sql = "SELECT * FROM prod WHERE id IN (".$_COOKIE["carrinho"].") ORDER BY nome";
	$result = mysqli_query($link, $sql);
	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<a href=\"/sistema/user/carrinho.php?r=".$row["id"]."\" style=\"color: black;\">(-)</a> ".$row["nome"]."<br>";
		}
	}
} else {
	echo "Carrinho Vazio!<br>";
}
?>

<br><a href="/sistema/user/" style="color: black;">Index</a>

<?php
include("../footer.php");
?>