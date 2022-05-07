<?php

/* Inclui bibliotecas de classes */
include 'Produto.php';
include_once "GerenciadorConexao.php";


class ProdutoDAO{

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

 		/*Função para inserir novo produto na tabela produto do banco de dados*/
 		public function inserir($produto){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO produtos (id_produtos, nome_produto, preco_produto, quantidade,id_categoria) VALUES (DEFAULT,'".$produto->nome."',".$produto->preco.",".$produto->quantidade.",".$produto->preco.",',".$produto->idcategoria.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir produto: " );

 		}

 		/* Função para atualizar os dados de um dos produtos já cadastrados */
 		public function atualizar($produto){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE produtos SET nome_produtos = '".$produto->nome."', preco_produto = ".$produto->preco.", quantidade= ".$produto->quantidade.", preco = ".$produto->preco.", id_categoria = ".$produto->idcategoria." WHERE id_produto = ".$produto->idproduto;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar produto: ");
 							
 		}

 		/* Função para excluir uma entrada de produto do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM produtos WHERE id_produtos = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir produto: " );

 		}

 		/* Função que lista todos os produtos e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM produtos ORDER BY nome_produto";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar produtos: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Produto
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
 				$retorno->idproduto = $row["id_produtos"];
 				$retorno->nome = $row["nome_produto"];
 				$retorno->preco = $row["preco_produto"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->idcategoria = $row["id_categoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM produto WHERE idproduto = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar produtos por ID: " );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
				$retorno->idproduto = $row["id_produtos"];
 				$retorno->nome = $row["nome_produto"];
 				$retorno->preco = $row["preco_produto"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->idcategoria = $row["id_categoria"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM produtos WHERE nome_produto LIKE = '%".$nome."%' ORDER BY nome_produto";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar produtos por nome: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe produto
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
 				$retorno->idproduto = $row["id_produtos"];
 				$retorno->nome = $row["nome_produto"];
 				$retorno->preco = $row["preco_produto"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->idcategoria = $row["id_categoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/* Função que busca todos produtos cadastrados em determinada categoria */
		public function buscaPorCategoria($idcategoria){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM produtos WHERE id_categoria = ".$idcategoria;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao buscar produtos por categoria cadastrada: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new Produto();
 				//Preenche todos os campos do novo objeto
				 $retorno->idproduto = $row["id_produtos"];
 				$retorno->nome = $row["nome_produto"];
 				$retorno->preco = $row["preco_produto"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->idcategoria = $row["id_categoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;
 		}
}


?>