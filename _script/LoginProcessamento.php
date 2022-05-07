<?php


/* Inicia nova sessão de navegação onde é possível setar variáveis de seção */
session_start(['login']);
/* Configura diretivas de processamento p/ mostrar e reportar erros do código*/
ini_set('error_reporting', E_ALL|E_STRICT);
ini_set('display_errors', 1);


/* Inclui classe UsuarioDAO */
require_once("FuncionarioDAO.php");

/* Pega variáveis que vieram de index.php no método POST */
$usuario = strtolower($_POST["nUsuario"]);
$senha = $_POST["nSenha"];


/* Cria novo objeto da classe UsuarioDAO */
$funcionarioDao = new FuncionarioDAO();

/* Manda buscar os dados do usuário com e-mail igual ao recebido de index.php*/
/* Se não encontrar nada no banco de dados, retorna null */
$funcionario = $funcionarioDao->buscaPorUsuario($usuario);



/* Testa se encontrou algum usuário cadastrado com aquele e-mail */
if($funcionario != null){
	/* Criptografa a senha recebida de index.php pra poder comparar */
	 $senhaCriptografada = md5($senha);
	//$senhaCriptografada = $senha;
	/* Agora testa se a senha recebida é igual à que consta do banco de dados*/
	if($senhaCriptografada == $funcionario->senha){
		/* Seta variáveis de sessão com informações do usuario logado*/
		$_SESSION['id_funcionario_logado'] = $funcionario->idfuncionario;
		$_SESSION['nome_funcionario_logado'] = $funcionario->nome;
		$_SESSION['usuario_funcionario_logado'] = $funcionario->usuario;
		$_SESSION['permissao_funcionario_logado'] = $funcionario->admin;

		//print_r($usuario);
		header('Location: ../console.php');
	}
	/* Caso a senha esteja incorreta gera ERRO 1*/
	else
		header('Location: ../index.php?ERRO=1');

}
/* Caso não tenha encontrado nenhum e-mail válido no banco de dados gera ERRO 1 */
else
	header('Location: ../index.php?ERRO=1')


?>