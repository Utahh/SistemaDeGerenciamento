<?php
session_start(['login']);

/* Inclui classe UsuarioDAO */
require_once("_script/CLienteDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');
?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Clientes</title>
</head>


<body>
<div id="interface">

	<h1>Clientes cadastrados</h1>


	<!-- Somente usuários com permissão Admin podem cadastrar novo produto -->
	<?php if(isset($_SESSION["permissao_usuario_logado"]) && $_SESSION["permissao_usuario_logado"] == "1"){ ?>
		<a href="usuario_cadastrar.php">Cadastrar</a><br/><br/>
	<?php } ?>


	<!-- Tabela que lista produtos cadastrados no sistema -->
	<table>
		<tr>
			<th>Nome</th>
			<th>CPF</th>
			<th>Telefone</th>
		</tr>
		<!-- Busca todos produtos cadastrados no banco-->
		<?php  
			$clienteDao = new ClienteDAO();
			$lista = $clienteDao->listar();
		?>
		<!-- Imprime na tabela em HTML os usuários utilizando o PHP -->
		<?php foreach ($lista as $indice => $usuario) { ?>
			<tr>
				<td><?php echo $cliente->nome; ?></td>
				<td><?php echo $cliente->CPF; ?></td>
				<td><?php echo $cleinte->telefone; ?></td>
				<!-- Imprime links (opções) na última coluna para editar ou excluir usuário -->
				<td>
					<a href="cliente_editar.php?idproduto=<?php echo $cliente->idcliente; ?>">Editar</a>
					&nbsp;&nbsp;
					<a href="cleinte_excluir.php?idproduto=<?php echo $cliente->idcliente; ?>">Excluir</a>
				</td>
			</tr>
		<?php } ?>
	</table>

	<br/><br/><br/><a href="console.php">Voltar</a>

</div>
</body>

</html>