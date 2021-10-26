<?php
/** **/

/**
* @description	: classe de manipulação do banco de dados MYSQL
* @author		: rogerinhu@yahoo.com.br
*/

class Sql {

// internal vars
public	$gravalog	= "0";			// SQL string 
private $sqlLog		= "";			// SQL string 
private	$tabelalog  = "log";
private $id			= NULL;
private $num_rows	= 0;			// LAST NUM of rows returned
private $conx		= NULL;			// SQL handler
private $query		= NULL;
private $query_last = NULL;			// SQL last query's handler
private $sql		= "";			// SQL string 
private $msg		= array (
					  1 => 'O registro foi inserido com sucesso',
					  2 => 'Ocorreu um erro na inserção do registro, tente novamente.',
					  3 => 'O registro foi atualizado com sucesso',
					  4 => 'Ocorreu um erro na atualização do registro, tente novamente.'
					  );
/**
* class construtor
* @parametro: void
*/
public function Sql($dados = false) {
	if ($dados===false) {
		$this->connect();
	} else {
		$this->connectoutro($dados);
	}
}

/**
* Connect
* @descrição		: conecta ao banco de dados
* @parametros		: void
* @return			: void
*/
private function connect() {
	$this->conx = @mysql_connect( DB_HOST, DB_USER, DB_PASSWORD ) or die( mysql_error() ) ;
	@mysql_select_db( DB_NAME, $this->conx ) or die( mysql_error() ) ;
}

private function connectoutro($dados) {
	$this->conx = @mysql_connect( $dados['host'], $dados['user'], $dados['password'] ) or die( mysql_error() ) ;
	@mysql_select_db( $dados['name'], $this->conx ) or die( mysql_error() ) ;
}

/**
* Disconnect
* @descrição		: desconecta do banco de dados
* @parametros		: void
* @return			: void
*/
private function disconnect() {
	@mysql_close( $this->conx ) or die( mysql_error() ) ;
}


/**
* Query
* @descrição		: DO the query
* @param string $q	: Query's string
* @param bool #log 	: log ( class_log )
* @return $query	: db handler
*/
public function query( $sql = "" ) {

	$temp = explode(" ",$sql);
	if( ($this->gravalog) && ($temp[0]=="DELETE") ){
		$conteudo	= $sql;
		$idtemp		= explode("=",$temp[4]);
		
		$realizou	= "EXCLUIU O REGISTRO ".$idtemp[1]." DA TABELA ".$temp[2]."";
		
		mysql_query("INSERT INTO ".$this->tabelalog." (log_use_id,log_datahora,log_acao,log_conteudo) VALUES ('".$_SESSION['ADMIN']['use_id']."','".date("Y-m-d H:i:s")."','".$realizou."','".$conteudo."')");
	}
	$this->sql 			= $sql;
		
	$this->last_query 	= @mysql_query( $this->sql, $this->conx );
	if ( $this->last_query ) {
		$this->num_rows 	= @mysql_num_rows( $this->last_query );
	} else {
		$informaerr =  mysql_errno() . ': ' . mysql_error(). ' Linha : '. __LINE__ . ' Script: '. __FILE__;
		$queryerr = $this->sql;
		//print("Problema encontrado <br><br>Erro: 0L6541");
		throw new Exception('Houve um problema na conexão com o servidor mysql. Erro: 0L6541 -> '.$informaerr.' -> '.$queryerr);
		//print($informaerr.'---'.$queryerr);
		
		//enviaerromysql($informaerr,$queryerr);
		return false;
	}

	return $this->last_query;

}

/**
* Fetch_Obj
* @descrição		: Fetch & Return an object
* @param string $q	: If the $q is empty, its fetches the $last_query
* @return void
*/
public function fetch_obj( $sql = 0 ) {
	if( ! $sql ) $sql = $this->last_query;
	return( @mysql_fetch_object( $sql ) );
}

/**
* Fetch_Array
* @descrição		: Fetch & retorna um array
* @param string $q	: If the $q is empty, its fetches the $last_query and returns and array; 
* @return void
*/
public function fetch_array( $sql = 0 ) {
	if( ! $sql ) $sql = $this->last_query;
	return( @mysql_fetch_array( $sql ) );
}

public function num_rows( $sql = 0 ) {
	if( ! $sql ) $sql = $this->last_query;
	return( @mysql_num_rows ( $sql ) );
}

public function insert_id() {
	return( @mysql_insert_id ( $this->conx ) );
}

public function fetch_assoc( $sql = 0 ) {
	if( ! $sql ) $sql = $this->last_query;
	return( @mysql_fetch_assoc( $sql ) );

}

/**
* Get_Array
* @description		: retorna o valor (1 campo) direto (executa a query e a fetch) duma vez só !
* @param string $s
*/
public function get_array( $sql = "" ) {

	$query 		= $this->query( $sql );
	$resultado 	= $this->fetch_array( $query );
	return( $resultado );
}

public function get_assoc( $sql = "" ) {
	$query 		= $this->query( $sql );
	$resultado 	= $this->fetch_assoc( $query );
	return( $resultado );
}

/**
* Get
* @description		: retorna o valor (1 campo) direto (executa a query e a fetch) duma vez só !
* @param string $s
*/
public function get( $sql = "" ) {
	$query 		= $this->query( $sql );
	$resultado 	= $this->fetch_array( $query );
	return( $resultado[0] );
}


/*
*Insert
*@descricao: constroi a sql para ser inserida no banco de dados
*@parametro:  
*/
public function insert( $campo, $valor, $tabela ) {
	
	if($this->gravalog){
		$conteudo = $this->logConteudo($campo,$valor);
		$realizou = "INSERIU NA TABELA ".$tabela."";
		
		mysql_query("INSERT INTO ".$this->tabelalog." (log_use_id,log_datahora,log_acao,log_conteudo) VALUES ('".$_SESSION['ADMIN']['use_id']."','".date("Y-m-d H:i:s")."','".$realizou."','".$conteudo."')");
	}
	
	$valor = $this->aspas($valor);

	$this->sql  = 'INSERT INTO ' .$tabela;
	$this->sql .= ' (' .implode(', ', $campo)  .') ';
	$this->sql .= 'VALUES';
	$this->sql .= ' (' .implode(', ', $valor)  .') ';
	//print $this->sql;
	if ( $this->query($this->sql) )	{
		$this->id = $this->insert_id();
		return $this->msg[1]; 
	} else {
		$informaerr =  mysql_errno() . ': ' . mysql_error(). ' Linha : '. __LINE__ . ' Script: '. __FILE__;
		$queryerr = $this->sql;
		//print("Problema encontrado, o script teve que ser finalizado<br><br>Erro: 1N2357");
		throw new Exception('Houve um problema na conexão com o servidor mysql. Erro: 1N2357');
		//print($informaerr.'---'.$queryerr);
		return false;
	}

}

/*
*Update
*descricao: constroi a sql para ser editar os registros no banco de dados
*parametro: 
*/
public function update( $id, $campo, $valor, $tabela) {
	if($this->gravalog){
		$conteudo = $this->logConteudo($campo,$valor);
		$realizou = "ATUALIZOU REGISTRO ".$id." DA TABELA ".$tabela."";

		mysql_query("INSERT INTO ".$this->tabelalog." (log_use_id,log_datahora,log_acao,log_conteudo) VALUES ('".$_SESSION['ADMIN']['use_id']."','".date("Y-m-d H:i:s")."','".$realizou."','".$conteudo."')");	
	}
	$valor = $this->aspas($valor);
	$this->sql  = "UPDATE ".$tabela." SET "; 
	for ($i = 0; $i < sizeof($campo)-1; $i++) { 
		$this->sql .= $i != sizeof($campo) - 2  ?  $campo[$i] ."=" .$valor[$i]. "," : $campo[$i] ."=" .$valor[$i]. ""; 
	}  
	$this->sql .= " WHERE ".$campo['id']."='".$id."'"; 
	//print($this->sql."\n");
	if ( $this->query($this->sql) )	{
		return $this->msg[3];
	
	} else {
		$informaerr =  mysql_errno() . ': ' . mysql_error(). ' Linha : '. __LINE__ . ' Script: '. __FILE__;
		$queryerr = $this->sql;
		//print("Problema encontrado, o script teve que ser finalizado<br><br>Erro: 3P9473");
		throw new Exception('Houve um problema na conexão com o servidor mysql. Erro: 3P9473');
		//print($informaerr.'---'.$queryerr);
		return false;
	}
}


/**
*Id
*descricao: retorna o ID da ultima inserção
*/
public function id () {
	return $this->id;
}

/*
*Aspas
*@descrição: coloca uma aspa simples em todas palavras do array
*@paramaetro: array $valores
*/	
protected function aspas ($valores) {
	for ($i = 0; $i < sizeof($valores); $i++) {  $v[$i] = "'". $valores[$i] . "'";  }
	return $v;	
}

protected function logConteudo ($campos,$valores) {
	$v = "";
	for ($i = 0; $i < sizeof($valores); $i++) {  $v .= $campos[$i]. " = ". $valores[$i]. "\n ";  }
	return $v;	
}

}

function enviaerromysql($informaerr,$queryerr) {
	global $CFG, $obj_sql;
	$msg_email = 62;
	include($CFG->basepath."/sisadm/__emails.php");
	return true;
}

?>