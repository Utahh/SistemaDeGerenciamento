<?php

/* Inclui bibliotecas de classes */
include 'Venda.php';
include_once "GerenciadorConexao.php";


class VendaDAO{

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

 		/*Função para inserir novo venda na tabela venda do banco de dados*/
 		public function inserir($venda){

 			/* Primeiro cria a query do MySQL */
 			$insert_query =	"INSERT INTO venda (idvenda, nome, quantidade, custo, preco, descricao, idcategoria) VALUES (DEFAULT,'".$venda->nome."',".$venda->quantidade.",".$venda->custo.",".$venda->preco.",'".$venda->descricao."',".$venda->idcategoria.")";
			
			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $insert_query)
			or die("Erro ao inserir venda: " );

 		}

 		/* Função para atualizar os dados de um dos vendas já cadastrados */
 		public function atualizar($venda){
 			
 			/* Primeiro cria a query do MySQL */
 			$update_query =	"UPDATE venda SET nome = '".$venda->nome."', quantidade = ".$venda->quantidade.", custo = ".$venda->custo.", preco = ".$venda->preco.", descricao = '".$venda->admin."', idcategoria = ".$venda->idcategoria." WHERE idvenda = ".$venda->idvenda;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $update_query)
			or die("Erro ao atualizar venda: ");
 							
 		}

 		/* Função para excluir uma entrada de venda do banco de dados */
 		public function excluir($id){

 			/* Primeiro cria a query do MySQL */
 			$delete_query = "DELETE FROM venda WHERE idvenda = " . $id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
			mysqli_query($this->conexao, $delete_query)
			or die("Erro ao excluir venda: " );

 		}

 		/* Função que lista todos os vendas e devolve em ordem alfabética */
 		public function listar(){

 			/* Primeiro cria a query do MySQL */
 			$list_query = "SELECT * FROM venda ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $list_query)
 			or die("Erro ao listar vendas: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe venda
 				$retorno = new venda();
 				//Preenche todos os campos do novo objeto
 				$retorno->idvenda = $row["idvenda"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/*  */
 		public function buscaPorId($id){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM venda WHERE idvenda = ".$id;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao listar vendas por ID: " );

 			/* Cria variável de retorno e inicializa com NULL */
 			$retorno = null;

 			/* Se encontrou algo, pega todos os campos do resultado obtido */
 			if( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe venda
 				$retorno = new venda();
 				//Preenche todos os campos do novo objeto
 				$retorno->idvenda = $row["idvenda"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 			}
 			
 			return $retorno;

 		}

 		/*  */
 		public function buscaPorNome($nome){

 			/* Primeiro cria a query do MySQL */
 			$nome_query = "SELECT * FROM venda WHERE nome LIKE = '%".$nome."%' ORDER BY nome";

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $nome_query)
 			or die("Erro ao listar vendas por nome: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe venda
 				$retorno = new venda();
 				//Preenche todos os campos do novo objeto
 				$retorno->idvenda = $row["idvenda"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;

 		}

 		/* Função que busca todos vendas cadastrados em determinada categoria */
		public function buscaPorCategoria($idcategoria){

 			/* Primeiro cria a query do MySQL */
 			$id_query = "SELECT * FROM venda WHERE idcategoria = ".$idcategoria;

 			/* Envia a query para o banco de dados e verifica se funcionou */
 			$result = mysqli_query($this->conexao, $id_query)
 			or die("Erro ao buscar vendas por categoria cadastrada: ");

 			/* Cria um array que receberá as linhas da tabela */
 			$lista = array();

 			/* Loop que que vai pegando linha por linha do resultado obtido */
 			while( $row = mysqli_fetch_array($result, MYSQLI_ASSOC) ){
 				//Cria nova instância da classe Usuario
 				$retorno = new venda();
 				//Preenche todos os campos do novo objeto
 				$retorno->idvenda = $row["idvenda"];
 				$retorno->nome = $row["nome"];
 				$retorno->quantidade = $row["quantidade"];
 				$retorno->custo = $row["custo"];
 				$retorno->preco = $row["preco"];
 				$retorno->descricao = $row["descricao"];
 				$retorno->idcategoria = $row["idcategoria"];
 				//Coloca no array
 				$lista[] = $retorno;
 			}

 			return $lista;
 		}
}


?>