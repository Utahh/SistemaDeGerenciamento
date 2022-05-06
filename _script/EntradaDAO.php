<?php

/* Inclui bibliotecas de classes */
include 'Entrada.php';
include_once "GerenciadorConexao.php";


class EntradaDAO{

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

 		/*Função para inserir novo entrada na tabela produto do banco de dados*/
 		public function inserir($entrada){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO entrada_produto (identrada, nome, Valor, Quantidade, Data ) VALUES (DEFAULT,'".$entrada->nome."',".$entrada->valor.",".$entrada->quantidade.",".$entrada->data.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir entrada: ");

 		}

 		/* Função para atualizar os dados de um dos produtos já cadastrados */
 		public function atualizar($entrada){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE entrada_produto SET nome = '".$entrada->nome."', Valor = ".$entrada->valor.", Quantidade = ".$entrada->quantidade.", Data = ".$entrada->data." WHERE identrada = ".$entrada->identrada;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar o entrada: ");
 							
 		}

 		/* Função para excluir uma entrada de produto do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM entrada_produto WHERE identrada = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir o entrada: ");

 		}

 		/* Função que lista todos os entradas e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM entrada_produto ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar entrada: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Produto
 				$retorno = new entrada();
 				//Preenche todos os campos do novo objeto
 				$retorno->identrada = $row["identrada"];
 				$retorno->nome = $row["nome"];
 				$retorno->valor = $row["Valor"];
 				$retorno->quantidade = $row["Quantidade"];
				$retorno->data = $row["Data"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM entrada_produto WHERE identrada = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar entradas por ID: ");

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new entrada();
 				//Preenche todos os campos do novo objeto
 				$retorno->identrada = $row["identrada"];
 				$retorno->nome = $row["nome"];
 				$retorno->valor = $row["Valor"];
 				$retorno->quantidade = $row["Quantidade"];
				$retorno->data = $row["Data"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM entrada_produto WHERE nome LIKE = '%".$nome."%' ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar entradas por nome: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new entrada();
 				//Preenche todos os campos do novo objeto
 				$retorno->identrada = $row["identrada"];
 				$retorno->nome = $row["nome"];
 				$retorno->valor = $row["Valor"];
 				$retorno->quantidade = $row["Quantidade"];
				$retorno->data = $row["Data"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		
 		}
};

?>