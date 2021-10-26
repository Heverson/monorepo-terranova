<?
ini_set( 'session.cookie_httponly', 1 );

date_default_timezone_set('America/Asuncion');

error_reporting(7); // tem outro que pode influenciar no urlinterp.php

function xss(&$item, $key) {
	$item = htmlspecialchars($item, ENT_QUOTES, 'ISO-8859-1',true);
}

function aspas(&$item, $key) {
	$item = addslashes($item);
}

if (strpos($_SERVER['REQUEST_URI'],'/sisadm')===false) {
	array_walk_recursive($_GET,'xss');
	array_walk_recursive($_POST,'xss');
	array_walk_recursive($_REQUEST,'xss');
	array_walk_recursive($_COOKIE,'xss');
} else {
	array_walk_recursive($_GET,'aspas');
	array_walk_recursive($_POST,'aspas');
	array_walk_recursive($_REQUEST,'aspas');
	array_walk_recursive($_COOKIE,'aspas');
}

class object {};
$CFG = new object();

$seguro = '1';

if (strstr($_SERVER['REMOTE_ADDR'],'127.0.0.')!==false || strstr($_SERVER['REMOTE_ADDR'],'::1')!==false ) {
	require("_config.local.php");
} else {
	require("_config.php");
}
include("class.cart.php");
include("class.xml.php");
require_once("class.phpmailer.php");
require("class.cielo.php");


if (!isset($nosession)) {

	if (!isset($segcont)) {

		if (isset($seguro) && $_SERVER["SERVER_PORT"] != 443 && $certificado == '1') {
			header("Location: ".$CFG->wwwpath.$_SERVER['REQUEST_URI']);
			die;
		}
		if (!isset($seguro) && $_SERVER["SERVER_PORT"] == 443 && $certificado == '1') {
			header("Location: ".$CFG->wwwpath.$_SERVER['REQUEST_URI']);
			die;
		}
	}

	session_start();

	if (!isset($_SESSION['initiated'])) {
		session_regenerate_id();
		$_SESSION['initiated'] = true;
	}

	if (isset($_SESSION['HTTP_USER_AGENT'])) {
		if ($_SESSION['HTTP_USER_AGENT'] != md5('Ter46NoShop183Intg'.$_SERVER['HTTP_USER_AGENT'])) {
			die;
		}
	} else {
		$_SESSION['HTTP_USER_AGENT'] = md5('Ter46NoShop183Intg'.$_SERVER['HTTP_USER_AGENT']);
	}

	if (!isset($_SESSION['CART'])) {
		$_SESSION['CART'] = new Cart;
	}
	if (!isset($_SESSION['USER'])) {
		$_SESSION['USER'] = array();
	}
	if (!isset($_SESSION['GRADE'])) {
		$_SESSION['GRADE'] = 'grade';
	}

	if (!isset($_SESSION['MOEDA'])) {
		$_SESSION['MOEDA'] = 'guarani';
	}

	$hash = session_id();

	/*
	if ($_SESSION['liberasite']<>'1') {
		if (isset($_GET['novosite'])) {
			$_SESSION['liberasite']='1';
		} else {
			print("Sitio en desarrollo");
			die;
		}
	}
*/
	

}
$moedas = array('usd' => 'dolar', 'brl' => 'real', 'pyg' => 'guarani');
$moedasnome = array('dolar' => 'US$', 'real' => 'R$', 'guarani' => 'G$');

if (isset($_GET['setmoeda'])) {
	if (isset($moedas[$_GET['setmoeda']])) {
		$_SESSION['MOEDA'] = $moedas[$_GET['setmoeda']];
	}
}


if (isset($_GET['liberapgto'])) {
	$_SESSION['liberapgto'] = '1';
}
if (isset($_GET['codigopgto'])) {
	$_SESSION['codigopgto'] = $_GET['codigopgto'];
}

if (isset($_GET['debug'])) {
	$_SESSION['debug'] = '1';
}

if (isset($_SESSION['debug'])) {
	$psaida = '1';
}



require("class.sql.php");
$obj_sql = new Sql();

$rowloja = $obj_sql->Get_Array("select * from ".TB_LOJA." limit 1");

$CFG->sitetitulo = $rowloja['loj_nome'];

$CFG->Semanas = array('Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado');

$var_est["AC"]="Acre";
$var_est["AL"]="Alagoas";
$var_est["AP"]="Amapá";
$var_est["AM"]="Amazonas";
$var_est["BA"]="Bahia";
$var_est["CE"]="Ceará";
$var_est["DF"]="Distrito Federal";
$var_est["ES"]="Esp&iacute;rito Santo";
$var_est["GO"]="Goiás";
$var_est["MA"]="Maranhão";
$var_est["MG"]="Minas Gerais";
$var_est["MS"]="Mato Grosso do Sul";
$var_est["MT"]="Mato Grosso";
$var_est["PA"]="Pará";
$var_est["PB"]="Paraíba";
$var_est["PE"]="Pernambuco";
$var_est["PI"]="Piauí";
$var_est["PR"]="Paraná";
$var_est["RJ"]="Rio de Janeiro";
$var_est["RN"]="Rio Grande do Norte";
$var_est["RO"]="Rondônia";
$var_est["RR"]="Roraima";
$var_est["RS"]="Rio Grande do Sul";
$var_est["SC"]="Santa Catarina";
$var_est["SE"]="Sergipe";
$var_est["SP"]="São Paulo";
$var_est["TO"]="Tocantins";

$var_zona = array(
	"1" => "Zona 1",
	"2" => "Zona 2",
	"3" => "Zona 3",
	"4" => "Zona 4",
	"5" => "Zona 5",
	"6" => "Zona 6",
	"7" => "Zona 7"
);

$situacao[1]['txt'] = "En espera de pago";
$situacao[1]['cor'] = "#0086FF";

$situacao[2]['txt'] = "Pago sin confirmar";
$situacao[2]['cor'] = "#FF0000";

$situacao[3]['txt'] = "Análisis de pago";
$situacao[3]['cor'] = "#18FF00";

$situacao[4]['txt'] = "Pago aceptado";
$situacao[4]['cor'] = "#18FF00";

$situacao[5]['txt'] = "Pedido em Separação";
$situacao[5]['cor'] = "#FFE400";

$situacao[6]['txt'] = "Encaminhado para Transportadora";
$situacao[6]['cor'] = "#AE00FF";

$situacao[7]['txt'] = "Pedido Entregue";
$situacao[7]['cor'] = "#111111";

$situacao[8]['txt'] = "Pedido Cancelado";
$situacao[8]['cor'] = "#900000";

$iconmenu[1] = "&#8226;";
$iconmenu[2] = "+";
$iconmenu[3] = "-";
$iconmenu[4] = ":";
$iconmenu[5] = ">";
$iconmenu[6] = "*";
$iconmenu[7] = "#";

$pedstatus[1] = 'Aguardando confirmação';
$pedstatus[2] = 'Crédito Reprovado';
$pedstatus[3] = 'Confirmado';
$pedstatus[4] = 'Enviado';
$pedstatus[5] = 'Cancelado';

//local do bannner
$locbanner[0] = "Todas as páginas";
$locbanner[1] = "Somente na inicial";
$locbanner[2] = "Somente na categoria selecionada (interna)";
$locbanner[3] = "Qualquer página interna";
$locbanner[4] = "Menus";

//$posbanner[0]["backg"] = "Background (1920 x 1250)" ;
$posbanner[0]["infoh"] = "Info Home (290 x 45)" ;
$posbanner[0]["meio"] = "Meio (360 x 220)" ;
$posbanner[1]["infoh"] = "Info Home (290 x 45)" ;
$posbanner[1]["meio"] = "Meio (360 x 220)" ;
$posbanner[2]["lateral"] = "Lateral (250 x 250)" ;


$tipotamanhos = array("parabra" => "Paraguay/Brasil", "usa" => "USA/Americano", "euroarge" => "Europeo/Argentina", "uk" => "UK");

$letras = array("0-9","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","W","V","X","Y","Z");

$tipopagamento[1] = "À Prazo";
$tipopagamento[2] = "À Vista";
$tipopagamento[3] = "Multiplo";

$tipopagamentolista['boleto'] = "Boleto Bancário";
$tipopagamentolista['cartao'] = "Cartão de Crédito/Débito";
$tipopagamentolista['debito'] = "Transferência Online";
$tipopagamentolista['outro'] = "Gateways de Pagamento";


$tipointerface['pgto_bancard']['titulo'] = "Bancard";
$tipointerface['pgto_bancard']['tipo'] = "1";

$tipointerface['pgto_bancardzimple']['titulo'] = "Zimple";
$tipointerface['pgto_bancardzimple']['tipo'] = "1";

$tipointerface['pgto_tigo']['titulo'] = "Tigo";
$tipointerface['pgto_tigo']['tipo'] = "2";

$tipointerface['pgto_deposito']['titulo'] = "Deposito/Transferencia";
$tipointerface['pgto_deposito']['tipo'] = "2";

$tipointerface['pgto_contraentrega']['titulo'] = "Cobro Contra-Entrega";
$tipointerface['pgto_contraentrega']['tipo'] = "2";

$tipointerface['pgto_loja']['titulo'] = "Pago en la tienda";
$tipointerface['pgto_loja']['tipo'] = "3";

$setorcontato['comercial'] = "Comercial";
$setorcontato['marketing'] = "Marketing";
$setorcontato['administrativo'] = "Administrativo";
$setorcontato['imprensa'] = "Imprensa";
$setorcontato['web'] = "Web";

//---------------------------
// PESO E CUBAGEM MÍNIMA
$pesoMin = 50;
$cuboMin = 216000;

$fretegra = $obj_sql->Get_Array("select * from ".TB_FRETEGRATIS." where fgr_tipo='3' limit 1");
if ($fretegra['fgr_id']>0) {
	define("FRETEGRATISACIMA", $fretegra['fgr_gratisacima']);
} else {
	define("FRETEGRATISACIMA", 999999999);
}

/** variaveis **/
$formapgto = $obj_sql->Get_Array("SELECT fpg_numaxparc,fpg_valminparc,fpg_jurosapartir,fpg_jurosapartir-1 as fpg_semjuros, fpg_juros FROM ".TB_FORMAPGTO." WHERE (fpg_tipo='1' or fpg_tipo='3') and fpg_status='1' and fpg_del<>'1' ORDER BY fpg_tipo asc, fpg_numaxparc DESC LIMIT 1");

$formapgtovista = $obj_sql->Get_Array("SELECT fpg_descontoavista, fpg_descontoporcento FROM ".TB_FORMAPGTO." WHERE fpg_tipo='2' and fpg_status='1' and fpg_del<>'1' ORDER BY fpg_descontoporcento DESC LIMIT 1");

include("_functions.php");
if ($rowloja['pmo_status']=='1' && retmktime($rowloja['pmo_dataini'])<=time() && retmktime($rowloja['pmo_datafim'])>time()) {
	define("PROMOABA", '1');
} else {
	define("PROMOABA", '0');
}

if (isset($_GET['c'])) {
	$qidcu = $obj_sql->Query("select * from ".TB_CUPOM." where md5(cup_codigo)='".$_GET['c']."' and cup_status='0' and cup_validade>='".date("Y-m-d")."'");
	if ($obj_sql->Num_Rows($qidcu)==1) {
		$linhacupom = $obj_sql->Fetch_Array($qidcu);
		if ($linhacupom['cup_uso']=='2' && is_logged() && $_SESSION['USER']['usu_pcompra']=='1') {
			$saidacup = "0";
		} else {
			$_SESSION['CUPOM']['codigo'] = $linhacupom['cup_codigo'];
			$_SESSION['CUPOM']['tipo'] = $linhacupom['cup_tipo'];
			$_SESSION['CUPOM']['valor'] = $linhacupom['cup_valor'];
			$_SESSION['CUPOM']['limite'] = $linhacupom['cup_limite'];
			$_SESSION['CUPOM']['uso'] = $linhacupom['cup_uso'];
			$_SESSION['CUPOM']['tpval'] = $linhacupom['cup_tpval'];
			if ($_SESSION['CUPOM']['tipo']=='P') {

				$tempm = unserialize($linhacupom['cup_listam']);
				if (valida_array($tempm)) {
					$saidam = array();
					foreach ($tempm as $key => $value) {
						$saidam[$value] = '1';
					}
					$_SESSION['CUPOM']['idsmar'] = $saidam;
				}
				
				$tempp = unserialize($linhacupom['cup_listap']);
				if (valida_array($tempp)) {
					$saidap = array();
					foreach ($tempp as $key => $value) {
						$saidap[$value] = '1';
					}
					$_SESSION['CUPOM']['idspro'] = $saidap;
				}

				$tempc = unserialize($linhacupom['cup_listac']);
				if (valida_array($tempc)) {
					$saidac = array();
					foreach ($tempc as $key => $value) {
						$ids = listacateinc($value);
						foreach ($ids as $chave =>$valor) {
							$saidac[] = $valor;
						}
					}
					$_SESSION['CUPOM']['idscat'] = $saidac;
				}

			}

			$saidacup = "1";
		}
	} else {
		$_SESSION['CUPOM'] = array();
		$saidacup = "0";
	}
}

define('DATABLKINI', '2019-12-19 10:00:00');
define('DATABLKFIM', '2019-12-29 23:59:59');

@header("Content-Type: text/html; charset=ISO-8859-1",true);
?>