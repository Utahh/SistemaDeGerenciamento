<div class="page-header">
	<h1>Produtos</h1>
</div>

<div>


	<?php

		$ProdutoDao = new ProdutoDAO;
		$ProdutoDao->listar();

	?>




<?php

	//Exclui usuário caso a variável idExcluir esteja setada
	if( isset($_POST["idExcluir"]) ){
		$funcionarioDao = new FuncionarioDAO();
		$funcionarioDao->excluir( $_POST["idExcluir"] );

		//flag para sinalizar que usuario foi excluído
		$excluirSucesso = true;
	}


	//Edita usuário com valores 
	if( isset($_POST["nIdEditar"]) && isset($_POST["nNomeEditar"]) &&
		isset($_POST["nUsuarioEditar"]) &&
		isset($_POST["nPermissaoEditar"]) ){

			$funcionario = new Funcionario();
			$funcionario->idusuario = $_POST["nIdEditar"];
			$funcionario->nome = $_POST["nNomeEditar"];
			$funcionario->usuario = strtolower($_POST["nUsuarioEditar"]);
			$funcionario->admin = $_POST["nPermissaoEditar"];

			$funcionarioDao = new FuncionarioDAO();
			$funcionarioDao->atualizarSemSenha( $funcionario);

			$inserirSucesso = true;
	}

?>