<?php
session_start(['login']);

/* Inclui classe UsuarioDAO */
require_once("_script/EntradaDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');
?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Entrada</title>
</head>


<body>
<div id="interface">

	<h1>entradas Disponíveis</h1>


	<!-- Somente usuários com permissão Admin podem cadastrar novo entrada -->
	<?php if(isset($_SESSION["permissao_usuario_logado"]) && $_SESSION["permissao_usuario_logado"] == "1"){ ?>
		<a href="usuario_cadastrar.php">Cadastrar</a><br/><br/>
	<?php } ?>


	<!-- Tabela que lista entradas cadastrados no sistema -->
	<table>
		<tr>
			<th>entrada</th>
			<th>Categoria</th>
			<th>Tipo</th>
			<th>Custo</th>
			<th>Preço</th>
			<th>Quantidade</th>
			<th>Ação</th>
		</tr>
		<!-- Busca todos entradas cadastrados no banco-->
		<?php  
			$entradaDao = new EntradaDAO();
			$lista = $entradaDao->listar();
		?>
		<!-- Imprime na tabela em HTML os usuários utilizando o PHP -->
		<?php foreach ($lista as $indice => $usuario) { ?>
			<tr>
				<td><?php echo $entrada->nome; ?></td>
				<td><?php echo $entrada->categoria; ?></td>
				<td><?php echo $entrada->tipo; ?></td>
				<td><?php echo $entrada->custo; ?></td>
				<td><?php echo $entrada->preco; ?></td>
				<td><?php echo $entrada->quantidade; ?></td>
				<!-- Imprime links (opções) na última coluna para editar ou excluir usuário -->
				<td>
					<a href="entrada_editar.php?identrada=<?php echo $entrada->identrada; ?>">Editar</a>
					&nbsp;&nbsp;
					<a href="entrada_excluir.php?identrada=<?php echo $entrada->identrada; ?>">Excluir</a>
				</td>
			</tr>
		<?php } ?>
	</table>

	<br/><br/><br/><a href="console.php">Voltar</a>

</div>
</body>

</html>