<?php

/* Inclui bibliotecas de classes */
include 'Cliente.php';
include_once "GerenciadorConexao.php";


class clienteDAO{

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

 		/*Função para inserir novo cliente na tabela produto do banco de dados*/
 		public function inserir($cliente){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO cliente (idcliente, nome, CPF, telefone) VALUES (DEFAULT,'".$cliente->nome."',".$cliente->CPF.",".$cliente->telefone.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir Cliente: ");

 		}

 		/* Função para atualizar os dados de um dos produtos já cadastrados */
 		public function atualizar($cliente){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE cliente SET nome = '".$cliente->nome."', CPF = ".$cliente->CPF.", telefone = ".$cliente->telefone." WHERE idcliente = ".$cliente->idcliente;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar o cliente: ");
 							
 		}

 		/* Função para excluir uma entrada de produto do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM cliente WHERE idcliente = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir o cliente: ");

 		}

 		/* Função que lista todos os clientes e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM cliente ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar cliente: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Produto
 				$retorno = new Cliente();
 				//Preenche todos os campos do novo objeto
 				$retorno->idcliente = $row["idcliente"];
 				$retorno->nome = $row["nome"];
 				$retorno->CPF = $row["CPF"];
 				$retorno->telefone = $row["Telefone"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM cliente WHERE idcliente = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar clientes por ID: ");

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Cliente();
 				//Preenche todos os campos do novo objeto
 				$retorno->idcliente = $row["idcliente"];
 				$retorno->nome = $row["nome"];
 				$retorno->CPF = $row["CPF"];
 				$retorno->telefone = $row["telefone"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM cliente WHERE nome LIKE = '%".$nome."%' ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar clientes por nome: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Cliente();
 				//Preenche todos os campos do novo objeto
 				$retorno->idcliente = $row["idcliente"];
 				$retorno->nome = $row["nome"];
 				$retorno->CPF = $row["CPF"];
 				$retorno->telefone = $row["telefone"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		
 		}
};

?>