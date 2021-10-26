<?
$certificado = '1';

if (!isset($nosession) && $_SERVER['SERVER_NAME']<>'www.shoppingterranova.com.py') {
	header('Location: https://www.shoppingterranova.com.py'.$_SERVER['REQUEST_URI']);
	die;
}
/** conecчуo com banco de dados **/


define("DB_MOD"			,"my");
define("DB_USER"		,"shoppingterranov_sisadm");
define("DB_PASSWORD"	,"T3rr34aNOfga0vaSh9");
define("DB_PORT"		,"");
define("DB_NAME"		,"shoppingterranov_sisadm");
define("DB_HOST"		,"localhost");

//valor maximo para listagem no admin//
define("GE_MAXIMO",15);
define("LISTAPGINIPED",5);
define("LISTAPGINIPRO",5);
define("LISTAPRODUTO",12);
define("PAGMARGEM", 2);

define("MOEDABASE", 'dolar');


$CFG->nomeprojeto = "Shopping Terra Nova";

$CFG->pagmargem = 6;
$CFG->pagmargemsite = 6;
$CFG->confemailhost = "mail.shoppingterranova.com.py";
$CFG->confemailusername = "site@shoppingterranova.com.py";
$CFG->confemailpassword = "site123x";
$CFG->fcontrol = "0";
$CFG->fcontrol_login = "xxx";
$CFG->fcontrol_password = "xxxx";

$CFG->merchantid = "123";
$CFG->clearsale = "0";
$CFG->clearsale_integra = "xxx10b3-e1d0-4f5b-92d2-4d99fcc17be1";

$CFG->buscacep = 'egondola';  // republica - buscarcep - byjg - egondola
$CFG->chaveegondola = '02d598321ef7ec84378d5c75acc3b5c7';
$CFG->chavebuscar = '10hWY1RHM0Wq1HSWPqPKjgSmpZq9Rr/';
$CFG->byjg_usuario = 'playmusic';
$CFG->byjg_senha = 'siteplay';

//integraчуo megabit//
define("MEGABIT", 0);
$dadosmb = array(
	'host' => 'dbupdate.egondola.com.br',
	'user' => 'casadelo_megabit',
	'password' => 'megacasa123bit',
	'name' => 'casadelo_megabit'
);
define("MEGABIT_ACESSO", serialize($dadosmb));

//integraчуo infoserve//
define("INFOSERVE", 0);
$dadosmb = array(
	'host' => 'dbupdate.egondola.com.br',
	'user' => 'construcasa_info',
	'password' => 'info123casaserve',
	'name' => 'construcasa_infoserve'
);
define("INFOSERVE_ACESSO", serialize($dadosmb));

//integraчуo TERRA//
define("SHPTERRA", 1);
$dadossp = array(
	'host' => '143.255.141.55',
	'user' => 'terra',
	'password' => '123',
	'name' => 'pega_terra'
);
define("SHPTERRA_ACESSO", serialize($dadossp));


$CFG->emailadmin[0] = "plataforma@egondola.com.br";

$CFG->basepath = "/home/shoppingterranov/public_html";


if (isset($seguro) && $certificado == '1') {
	$CFG->wwwpath = "https://www.shoppingterranova.com.py";
} else {
	$CFG->wwwpath = "http://www.shoppingterranova.com.py";
}

define("TB_ADMINISTRADORES","administradores");
define("TB_AVISE"		,"aviseme");
define("TB_ACESSOS"		,"acessos");
define("TB_ACEHORA"		,"acehora");
define("TB_ACE_PRO"		,"estatis_produto");
define("TB_BANNERS"		,"banners");
define("TB_ENQUETES"	,"enquetes");
define("TB_CADASTRO"	,"cadastro");
define("TB_CATEGORIA"	,"categoria");
define("TB_FRETE"		,"frete");
define("TB_FORMAPGTO"	,"formapgto");
define("TB_FORNECEDOR"	,"fornecedor");
define("TB_FOTOSPROD"	,"fotosprod");
define("TB_ITENSPED"	,"itensped");
define("TB_LOG"			,"log");
define("TB_LOJA"		,"loja");
define("TB_PEDIDO"		,"pedido");
define("TB_SUPORTE"		,"suporte");
define("TB_PRODUTO"		,"produto");
define("TB_PRODUTO_OPCAO"		,"prodopcoes");
define("TB_SITUACAO"	,"situacao");
define("TB_SUBCATEGORIA","subcategoria");
define("TB_TABELAFRETE"	,"tabelafrete");
define("TB_TRANSPORTADORA","transportadora");
define("TB_CONTATOS"		,"contato");
define("TB_TEXTOS"		,"textos");
define("TB_TEXTO_GALERIA"		,"textos_galeria");

define("TB_USUARIO"		,"usuario");
define("TB_TOPICOS"		,"topicos");
define("TB_AJUDA"		,"ajuda");
define("TB_FAQ"		,"faq");
define("TB_TV"		,"tvcommerce");
define("TB_MUSITECH_LOJAS"		,"musitech_lojas");
define("TB_FORTOPICO"				,"forum_topicos");
define("TB_FORPOST"				,"forum_posts");
define("TB_FORTEXTO"			,"forum_textos");
define("TB_DOUTOR"			,"doutor");
define("TB_DESEJO"			,"desejos");
define("TB_DICAS"			,"dicas");
define("TB_DICAS_FOTOS"				,"dicas_fotos");
define("TB_GALERIA"			,"galeria");
define("TB_GALERIA_FOTOS"			,"galeria_fotos");
define("TB_PRESENTES"			,"presentes");
define("TB_PRESENTES_LISTA"			,"presentes_lista");
define("TB_CARACTERISTICAS"			,"caracteristicas");
define("TB_LIBERAINTER"				,"liberainter");
define("TB_ESTAMPAS"				,"estampas");
define("TB_ICONEPROMO"				,"iconepromo");

define("TB_PRODUTO_RELA"			,"prodrelacio");
define("TB_PRODFOTOS"	,"prodfotos");
define("TB_PRODVIDEOS"	,"prodvideos");
define("TB_PRODCOMENTA"	,"prodcomenta");
define("TB_TAGS"	,"tagscloud");
define("TB_NEWSLETTER"	,"newsletter");

define("TB_CONTRATO"	,"contrato");
define("TB_CUPOM"	,"cupom");
define("TB_FRETEGRATIS"		,"fretegratis");
define("TB_PRODUTOPROMO"		,"produtodesconto");

define("TB_AJUDACOMPRA"		,"ajudacompra");
define("TB_AJUDACOMPRA_ITENS"		,"ajudacompra_itens");

define("TB_BANNERSTXT"		,"bannerstxt");

define("TB_RES_CADASTRO"		,"res_cadastro");
define("TB_RES_FORMAPGTO"		,"res_formapgto");
define("TB_RES_PEDIDO"			,"res_pedido");
define("TB_RES_PEDIDOITENS"		,"res_itensped");
define("TB_RES_TEXTOS"		,"res_textos");

define("TB_MALADIRETA"		,"maladireta");
define("TB_MALADIRETA_CLICKS"		,"maladireta_clicks");
define("TB_MALADIRETA_RESUMO"		,"maladireta_resumo");

define("TB_ACESSOPRODUTO"	,"acesso_produto");
define("TB_PRODUTO_CATEGORIA"		,"produto_categoria");

define("TB_BLOG_POST",		"blog_post");
define("TB_BLOG_FOTOS",		"blog_fotos");

define("TB_LOJAS", "lojas");
define("TB_MODELO"		,"modelo");

define("TB_CIDADESPY", "cidades_zonas_py");
define("TB_COTACAO", "loja");

define("TB_VIDEOS", "videos");
define("TB_CURSOS", "cursos");

define("TB_PROMOCAO"		,"promocao");
define("TB_PROMOCAO_PRODUTO"	,"promocao_produto");

define("TB_PROMOGRES"		,"promogres");
define("TB_PROMOGRES_PRODUTO"	,"promogres_produto");
define("TB_PROMOGRES_FAIXA"	,"promogres_faixa");
?>