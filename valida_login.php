<?php
	session_start();	
		
	//Incluindo a conexão com banco de dados
	include 'conexao.php';

	$pag_apos = 'home.php';	
	$pag_login = 'index.php';

	//O campo usuário e senha preenchido entra no if para validar
	if((isset($_POST['login'])) && (isset($_POST['senha']))){

		//Buscar na tabela usuario o usuário que corresponde com os dados digitado no formulário		
		//$result_usuario = "SELECT * FROM usuarios WHERE login = '$usuario' && senha = '$senha' LIMIT 1";
		
		$usuario = strtoupper($_POST['login']);
		$senha = $_POST['senha'];	
		
		echo $usuario;	echo '</br>'; echo $senha; echo '</br>';

		$result_usuario = oci_parse($conn_ora, "SELECT portal_sesmt.VALIDA_SENHA_FUNC_LOGIN(:usuario,:senha) AS RESP_LOGIN,
												(SELECT INITCAP(usu.NM_USUARIO)
													FROM dbasgu.USUARIOS usu
													WHERE usu.CD_USUARIO = :usuario) AS NM_USUARIO,	

													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 389) THEN 'S' --PORTAL_SESMT ACESSO GERAL 
														ELSE 'N'
													END SN_USUARIO_SESMT,

													
													CASE
														WHEN :usuario IN (SELECT DISTINCT puia.CD_USUARIO
																			FROM dbasgu.PAPEL_USUARIOS puia
																			WHERE puia.CD_PAPEL = 390) THEN 'S' --PORTAL_SESMT_ADM
														ELSE 'N'
													END SN_USUARIO_SESMT_ADM


												FROM DUAL");																															
												
		oci_bind_by_name($result_usuario, ':usuario', $usuario);
		oci_bind_by_name($result_usuario, ':senha', $senha);

		echo '</br> RESULT USUARIO:' . $result_usuario . '</br>';

		//EXECUTANDO A CONSULTA SQL (ORACLE) [VALIDANDO AO MESMO TEMPO]
		$valida_result_usuario = oci_execute($result_usuario); 		 
	
		//VALIDACAO
		if (!$valida_result_usuario) {   
	
			$erro = oci_error($result_usuario);																							
			$_SESSION['msgerro'] = htmlentities($erro['message']);
			header("Location: $pag_login");

		}else{

			$resultado = oci_fetch_row($result_usuario);

			echo '</br> COLUNA 0:' . $resultado['0']  . ' - ' . $resultado['1'] . '</br>';
			
			//Encontrado um usuario na tabela usuário com os mesmos dados digitado no formulário
			if(isset($resultado)){
				
				if($resultado[0] == 'Login efetuado com sucesso') {
					$cons_acesso_login="INSERT INTO portal_projetos.ACESSO
										SELECT portal_projetos.SEQ_CD_ACESSO.NEXTVAL AS CD_ACESSO,
										11 AS CD_PORTFOLIO,
										'PORTAL SESMT' AS DS_PROJETO,
										'$usuario' AS CD_USUARIO_ACESSO,
										SYSDATE AS HR_ACESSO
										FROM DUAL";

					$result_acesso = oci_parse($conn_ora,$cons_acesso_login);

					$valida_acesso = oci_execute($result_acesso);

					if($valida_acesso){

						$_SESSION['usuarioLogin'] = $usuario;
						$_SESSION['usuarioNome'] = $resultado[1];
						$_SESSION['papel_sesmt'] = $resultado[2];
						$_SESSION['papel_sesmt_adm'] = $resultado[3];
						header("Location: $pag_apos");

					}

				} else { 
					$_SESSION['msgerro'] = $resultado[0] . '!';
					header("Location: $pag_login");		
				}

			}

		}
		
	}
?>