<?php

/* Inclui bibliotecas de classes */
include 'Cliente.php';
include_once "GerenciadorConexao.php";


class ClienteDAO{

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

 		/*Função para inserir novo cliente na tabela usuario do banco de dados*/
 		public function inserir($cliente){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO cliente (id_cliente, nome_cliente, cpf_cliente, telefonecliente) VALUES (DEFAULT,'".$cliente->nome."','".$cliente->cpf."',".$cliente->telefone.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir cliente: ");

 		}

 		/* Função para atualizar os dados de um dos usuários já cadastrados */
 		public function atualizar($cliente){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE cliente SET nome_cliente='".$cliente->nome."', cpf_cliente ='".$cliente->cpf."', telefonecliente= ".$cliente->telefone." WHERE id_cliente=".$cliente->idcliente;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar cliente: ");
 							
 		}

 		/* Função para excluir uma entrada de usuário do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM cliente WHERE id_cliente = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir cliente: ");

 		}

 		/* Função que lista todos os usuários e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM cliente ORDER BY nome_cliente";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar cliente: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new cliente();
 				//Preenche todos os campos do novo objeto
 				$retorno->idusuario = $row["id_cliente"];
 				$retorno->nome = $row["nome_cliente"];
 				$retorno->cpf = $row["cpf_cliente"];
 				$retorno->telefone = $row["telefonecliente"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM cliente WHERE id_cliente = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar clientes por ID: ");

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new cliente();
 				//Preenche todos os campos do novo objeto
				 $retorno->idusuario = $row["id_cliente"];
 				$retorno->nome = $row["nome_cliente"];
 				$retorno->cpf = $row["cpf_cliente"];
 				$retorno->telefone = $row["telefonecliente"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM cliente WHERE nome_cliente LIKE '%".$nome."%' ORDER BY nome_cliente";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar cliente por nome: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new cliente();
 				//Preenche todos os campos do novo objeto
				 $retorno->idusuario = $row["id_cliente"];
 				$retorno->nome = $row["nome_cliente"];
 				$retorno->cpf = $row["cpf_cliente"];
 				$retorno->telefone = $row["telefonecliente"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */

 		/*  */
 		public function buscaPorUsuario($cpf){

 			/* Primeiro cria a query do MySQL */
 			$cliente_query = "SELECT * FROM cliente WHERE nome_cliente = '".$cpf."'";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $cliente_query)
 			or die("Erro ao listar usuários por e-mail: ");

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new cliente();
 				//Preenche todos os campos do novo objeto
				 $retorno->idusuario = $row["id_cliente"];
 				$retorno->nome = $row["nome_cliente"];
 				$retorno->cpf = $row["cpf_cliente"];
 				$retorno->telefone = $row["telefonecliente"];
 			}
 			
 			return $retorno;

 		}

}
?>