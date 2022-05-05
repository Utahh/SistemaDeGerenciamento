<?php

	if( isset($_GET["action"]) && ($_GET["action"] == "Cadastrar") ){
		$funcionario = new funcionario();
		$funcionario->nome = $_POST["nNome"];
		$funcionario->usuario = strtolower($_POST["nEmail"]);
		$funcionario->senha = $_POST["nSenha"];

		if( $_POST["nPermissao"] == "normal" )
			$funcionario->admin = "0";
		elseif( $_POST["nPermissao"] == "admin" )
			$funcionario->admin = "1";

		$funcionarioDao = new funcionarioDAO();
		$funcionarioDao->inserir($funcionario);

		$inserirSucesso = true;
	}


?>


<div class="page-header text-center">
	<h1>Cadastrar funcionario</h1>
</div>



<div id="form">

	<!-- Somente usuários com permissão Admin podem cadastrar novo funcionario -->
	<?php if(isset($_SESSION["permissao_funcionario_logado"]) && $_SESSION["permissao_funcionario_logado"] == "1"){ ?>
		<a href="funcionario_cadastrar.php">Cadastrar</a><br/><br/>
	<?php } ?>


	<?php
		if( $inserirSucesso ) { ?>

			<div class="alert alert-success" role="alert">
			  	<p><span class="glyphicon glyphicon-exclamation-sign"></span> funcionário cadastrado com sucesso!</p>
			</div>

		<?php } 
	?>


	<!-- Aqui começa o formulário de cadastro -->
	<form action="?page=FuncionarioCadastrar&action=Cadastrar" method="post" role="form">

		<div class="form-group">
			<label for="idNome" class="control-label">Nome:</label>
			<input type="text" class="form-control" id="idNome" name="nNome" required />
		</div>

		<div class="form-group">
			<label for="idusuario" class="control-label">Usuário:</label>
			<input type="text" class="form-control" id="idusuario" name="nusuario" required />
		</div>

		<div class="form-group">
			<label for="idSenha" class="control-label">Senha Provisória:</label>
			<input type="password" class="form-control" id="idSenha" name="nSenha" required />
		</div>

		<div class="form-group">
			<label class="control-label">Permissão:</label><br/>

			<div class="row">
				<div class="col-sm-6">
					<label for="idNormal" class="radio-inline">
						<input type="radio" id="idNormal" name="nPermissao" value="normal" checked />
						Normal
					</label>
				</div>

				<div class="col-sm-6">
					<label for="idAdmin" class="radio-inline">
						<input type="radio" id="idAdmin" name="nPermissao" value="admin" />
						Administrador
					</label>
				</div>
			</div>
		</div>
		<br/>

		<div class="row">
			<div class="col-xs-6">
				<div class="form-group">
					<button type="submit" class="btn btn-success btn-block"/>Salvar</button>
				</div>
			</div>
			<div class="col-xs-6">
				<div class="form-group">
					<button type="reset" class="btn btn-default btn-block"/>Limpar</button>
				</div>
			</div>
		</div>

	</form>

</div>