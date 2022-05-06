<?php
session_start(['login']);

/* Inclui classe UsuarioDAO */
require_once("_script/VendaDAO.php");

/* Testa se a variável de sessão está setada corretamente */
/* Caso contrário, gera erro acusando que o login não foi feito */
if( !isset($_SESSION["nome_usuario_logado"]) )
	header('Location: index.php?ERRO=2');
?>


<!DOCTYPE html>
<html lan="pt-br">
<head>
	<meta charset="UTF-8"/>
	<title>Sistema de Gerenciamento | Estoque</title>
</head>


<body>
<div id="interface">

	<h1>Vendas Disponíveis</h1>


	<!-- Somente usuários com permissão Admin podem cadastrar novo venda -->
	<?php if(isset($_SESSION["permissao_usuario_logado"]) && $_SESSION["permissao_usuario_logado"] == "1"){ ?>
		<a href="usuario_cadastrar.php">Cadastrar</a><br/><br/>
	<?php } ?>


	<!-- Tabela que lista vendas cadastrados no sistema -->
	<table>
		<tr>
			<th>venda</th>
			<th>Categoria</th>
			<th>Tipo</th>
			<th>Custo</th>
			<th>Preço</th>
			<th>Quantidade</th>
			<th>Ação</th>
		</tr>
		<!-- Busca todos vendas cadastrados no banco-->
		<?php  
			$vendaDao = new VendaDAO();
			$lista = $vendaDao->listar();
		?>
		<!-- Imprime na tabela em HTML os usuários utilizando o PHP -->
		<?php foreach ($lista as $indice => $usuario) { ?>
			<tr>
				<td><?php echo $venda->nome; ?></td>
				<td><?php echo $venda->categoria; ?></td>
				<td><?php echo $venda->tipo; ?></td>
				<td><?php echo $venda->custo; ?></td>
				<td><?php echo $venda->preco; ?></td>
				<td><?php echo $venda->quantidade; ?></td>
				<!-- Imprime links (opções) na última coluna para editar ou excluir usuário -->
				<td>
					<a href="venda_editar.php?idvenda=<?php echo $venda->idvenda; ?>">Editar</a>
					&nbsp;&nbsp;
					<a href="venda_excluir.php?idvenda=<?php echo $venda->idvenda; ?>">Excluir</a>
				</td>
			</tr>
		<?php } ?>
	</table>

	<br/><br/><br/><a href="console.php">Voltar</a>

</div>
</body>

</html>