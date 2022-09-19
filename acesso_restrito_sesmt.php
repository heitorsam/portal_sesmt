<?php

//Se o usuário não tiver permissão
if($_SESSION['papel_sesmt'] == 'N'){

	unset(
		$_SESSION['usuarioLogin'],
		$_SESSION['usuarioNome'],
		$_SESSION['papel_sesmt'],
		$_SESSION['papel_sesmt_adm']
	);

	$_SESSION['msgerro'] = "Usuário sem permissão de administrador!";
	header("Location: index.php");
}

?>