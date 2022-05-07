<?php

/* Inclui bibliotecas de classes */
include 'Funcionario.php';
include_once "GerenciadorConexao.php";


class FuncionarioDAO{

	/* Variável privada que armazena o identificador da conexão com o banco */
	private $conexao = null;

		/* Construtor da classe: estabelece conexão com o banco */
		/* Utiliza o método estático da classe GerenciadorConexao */
		public function __construct(){
			/* Recebe o identificador da conexão e armazena */
			$this->conexao = GerenciadorConexao::conectar();
		}

		/* Destrutor da classe: finaliza conexão com o banco */
		public function __destruct(){
			/* Verifica se a conexão havia sido estabelecida anteriormente */
			if($this->conexao)
				mysqli_close($this->conexao);
		}

/* -----------------------------------------------------------------------------
 * Aqui começa a implementação do CRUD
 *
 * C = Create 		-> 		Insere novas linhas na tabela
 * R = Retrieve 	-> 		Busca entradas na tabela
 * U = Update 		-> 		Atualiza linhas da tabela
 * D = delete 		->		Deleta linhas da tabela
 -----------------------------------------------------------------------------*/

 		/*Função para inserir novo funcionario na tabela usuario do banco de dados*/
 		public function inserir($funcionario){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO funcionario (id_funcionario, nome_funcionario, usuario, senha, admin) VALUES (DEFAULT,'".$funcionario->nome."','".$funcionario->usuario."','".md5($funcionario->senha)."',".$funcionario->admin.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir funcionário: ");

 		}

 		/* Função para atualizar os dados de um dos usuários já cadastrados */
 		public function atualizar($funcionario){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE funcionario SET nome_funcionario='".$funcionario->nome."', usuario='".$funcionario->usuario."', senha = '".md5($funcionario->senha)."', admin= ".$funcionario->admin." WHERE id_funcionario=".$funcionario->idfuncionario;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar funcionário: ");
 							
 		}

		/* Função para atualizar os dados de um dos usuários semm modificar a senha */
 		public function atualizarSemSenha($funcionario){

 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE funcionario SET nome_funcionario='".$funcionario->nome."', usuario='".$funcionario->usuario."', admin= ".$funcionario->admin." WHERE id_funcionario=".$funcionario->idfuncionario;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar usuário: " );

 		}

 		/* Função para excluir uma entrada de usuário do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM funcionario WHERE id_funcionario = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir funcionario: ");

 		}

 		/* Função que lista todos os usuários e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM funcionario ORDER BY nome_funcionario";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar funcionários: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Funcionario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["id_funcionario"];
 				$retorno->nome = $row["nome_funcionario"];
 				$retorno->usuario = $row["usuario"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM funcionario WHERE id_funcionario = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar usuários por ID: ");

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Funcionario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["id_funcionario"];
 				$retorno->nome = $row["nome_funcionario"];
 				$retorno->usuario = $row["usuario"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM funcionario WHERE nome_funcionario LIKE '%".$nome."%' ORDER BY nome_funcionario";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar funcionario por nome: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Funcionario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idfuncionario= $row["id_funcionario"];
 				$retorno->nome = $row["nome_funcionario"];
 				$retorno->usuario = $row["usuario"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */

 		/*  */
 		public function buscaPorUsuario($usuario){

 			/* Primeiro cria a query do MySQL */
 			$funcionario_query = "SELECT * FROM funcionario WHERE usuario = '".$usuario."'";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $funcionario_query)
 			or die("Erro ao listar usuários por e-mail: ");

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Funcionario();
 				//Preenche todos os campos do novo objeto
 				$retorno->idfuncionario = $row["idfuncionario"];
 				$retorno->nome = $row["nome_funcionario"];
 				$retorno->usuario = $row["usuario"];
 				$retorno->senha = $row["senha"];
 				$retorno->admin = $row["admin"];
 			}
 			
 			return $retorno;

 		}

}
?>