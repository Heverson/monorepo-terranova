<?
include("_setup.php");
$sec = !isset($_GET['sec']) && !isset($_POST['sec']) ? NULL : (isset($_GET['sec']) ? $_GET['sec'] : $_POST['sec']);
$set = !isset($_GET['set']) && !isset($_POST['set']) ? (isset($sec) ? 0 : NULL) : (isset($_GET['set']) ? sonumb($_GET['set']) : sonumb($_POST['set']) );
$bra = !isset($_GET['bra']) && !isset($_POST['bra']) ? NULL : (isset($_GET['bra']) ? sonumb($_GET['bra']) : sonumb($_POST['bra']));
$ord = !isset($_GET['ord']) && !isset($_POST['ord']) ? NULL : (isset($_GET['ord']) ? htmlspecialchars($_GET['ord']) : htmlspecialchars($_POST['ord']));
$pri = !isset($_GET['pri']) && !isset($_POST['pri']) ? NULL : (isset($_GET['pri']) ? sonumb($_GET['pri']) : sonumb($_POST['pri']) );
$prf = !isset($_GET['prf']) && !isset($_POST['prf']) ? NULL : (isset($_GET['prf']) ? sonumb($_GET['prf']) : sonumb($_POST['prf']));
$tam = !isset($_GET['tam']) && !isset($_POST['tam']) ? NULL : (isset($_GET['tam']) ? urldecodetam($_GET['tam']) : urldecodetam($_POST['tam']));
$cor = !isset($_GET['cor']) && !isset($_POST['cor']) ? NULL : (isset($_GET['cor']) ? $_GET['cor'] : $_POST['cor']);
$opcao = !isset($_GET['opcao']) && !isset($_POST['opcao']) ? NULL : (isset($_GET['opcao']) ? sonumb($_GET['opcao']) : sonumb($_POST['opcao']));
$carac = !isset($_GET['carac']) && !isset($_POST['carac']) ? NULL : (isset($_GET['carac']) ? sonumb($_GET['carac']) : sonumb($_POST['carac']));

$qtitpg = !isset($_GET['qtitpg']) && !isset($_POST['qtitpg']) ? 18 : (isset($_GET['qtitpg']) ? sonumb($_GET['qtitpg']) : sonumb($_POST['qtitpg']));
$pag = !isset($_GET['pag']) && !isset($_POST['pag']) ? 1 : (isset($_GET['pag']) ? sonumb($_GET['pag']) : sonumb($_POST['pag']));

$pgcategoria = '1';

if (!isset($set)) {
	header("Location: /");
	die;
}


$sqltxtpromo = "";

if (isset($sec)) {
	
	if (PROMOABA<>'1' && $sec=='promociones') {
		header("Location: /productos");
		die;
	}
	
	$secoes['lancamentos']['campo'] = " and a.pro_lancamento='1' ";
	$secoes['lancamentos']['camposi'] = " pro_lancamento='1' ";
	$secoes['lancamentos']['id'] = "lancamentos";
	$secoes['lancamentos']['titulo'] = "Lanzamientos";
	$secoes['lancamentos']['link'] = "Lanzamientos";
	
	$secoes['marcas']['campo'] = " and a.pro_for_id<>0 ";
	$secoes['marcas']['camposi'] = " pro_for_id<>0 ";
	$secoes['marcas']['id'] = "marcas";
	$secoes['marcas']['titulo'] = "Marcas";
	$secoes['marcas']['link'] = "Marcas";
	
	$secoes['best-sellers']['campo'] = " and a.pro_maisvendidos='1' ";
	$secoes['best-sellers']['camposi'] = " pro_maisvendidos='1' ";
	$secoes['best-sellers']['id'] = "best-sellers";
	$secoes['best-sellers']['titulo'] = "Best-sellers";
	$secoes['best-sellers']['link'] = "Best-sellers";
		
	$secoes['promociones']['campo'] = " and a.pro_oferta='1' ";
	$secoes['promociones']['camposi'] = " pro_oferta='1' ";
	$secoes['promociones']['id'] = "promociones";
	$secoes['promociones']['titulo'] = "Promociones";
	$secoes['promociones']['link'] = "Promociones";

	if ($sec=='listas') {
		if (isset($_SESSION['LISTAID'])) {
			$rowlista = $obj_sql->Get_Array("select * from ".TB_PROMOCAO." where pmo_id='".$_SESSION['LISTAID']."'");
			$secoes['listas']['campo'] = " and spr.pmo_id='".$_SESSION['LISTAID']."' ";
			$secoes['listas']['camposi'] = " spr.pmo_id='".$_SESSION['LISTAID']."' ";
			$secoes['listas']['id'] = "listas";
			$secoes['listas']['titulo'] = $rowlista['pmo_titulo'];
			$secoes['listas']['link'] = "Listas";
			$sqltxtpromo = " where pr.pmo_id='".$_SESSION['LISTAID']."' ";
		} else {
			header("Location: /");
			die;
		}
	}
	
	$secao = $secoes[$sec];
}


$listaordem = array();
$listaordem["destaque"] = " tempreco desc, a.pro_nome asc, a.pro_datacad desc ";
$listaordem["oferta"] = " tempreco desc, a.pro_oferta desc, a.pro_desconto desc, a.pro_datacad desc ";
$listaordem["valorasc"] = " tempreco desc, a.pro_preco asc, a.pro_datacad desc ";
$listaordem["valordesc"] = " tempreco desc, a.pro_preco desc, a.pro_datacad desc ";
$listaordem["marca"] = " tempreco desc, c.for_nome asc, a.pro_datacad desc ";
$listaordem["lancamento"] = " tempreco desc, a.pro_lancamento desc, a.pro_datacad desc ";
$listaordem["vendido"] = " tempreco desc, a.pro_vendido desc, a.pro_datacad desc ";
$listaordem["visitado"] = " tempreco desc, a.pro_visto desc, a.pro_datacad desc ";

if (!isset($ord) || !isset($listaordem[$ord])) {
	$ord = 'lancamento';
}


if ($pag=='0') {$pag=1;};
$quantporpagina = is_numeric($qtitpg) ? $qtitpg : 999999 ;

$regini = ($pag-1)*$quantporpagina;

$temp = caminhocatnomeid($set);
$temp = substr($temp,1);
$caminho = explode("|",$temp);

$temp = explode('-',$caminho[0]);
$idcatpai = $temp[0];
$rowcatpai = $obj_sql->Get_Array("SELECT * FROM ".TB_CATEGORIA." WHERE cat_id='".$idcatpai."'");

$nomecategoria = $set==0 ? 'CATEGORIAS' : $temp[1];
if (isset($sec)) {
	$nomecategoria = $secao['titulo'];
} else {
	$nomecategoria = $rowcatpai['cat_nome'];
}

$categoria = array();
foreach ($caminho as $key => $value) {
	$dad = explode("-",$value);
	$categoria[] = $dad[1];
}

$caminhocategoria = implode(" > ",$categoria);


// ---------------------
$rowcat = $obj_sql->Get_Array("SELECT * FROM ".TB_CATEGORIA." WHERE cat_id='".$set."'");
$TAG_title = tiraASPA($caminhocategoria);
$TAG_description = tiraASPA($rowcat['cat_descricao']);
$TAG_keywords = tiraASPA($rowcat['cat_keywords']);
// ---------------------


$filtro = '';
$filtro .= isset($set) ? '&set='.$set : '' ;
$filtro .= isset($bra) ? '&bra='.$bra : '' ;
$filtro .= isset($ord) ? '&ord='.$ord : '' ;
$filtro .= isset($pri) ? '&pri='.$pri : '' ;
$filtro .= isset($prf) ? '&prf='.$prf : '' ;
$filtro .= isset($tam) ? '&tam='.$tam : '' ;
$filtro .= isset($qtitpg) ? '&qtitpg='.$qtitpg : '' ;
$filtro .= isset($cor) ? '&cor='.$cor : '' ;
$filtro .= isset($carac) && isset($opcao) ? '&carac='.$carac.'&opcao='.$opcao : '' ;

$filtrord = '';
$filtrord .= isset($set) ? '&set='.$set : '' ;
$filtrord .= isset($bra) ? '&bra='.$bra : '' ;
$filtrord .= isset($pri) ? '&pri='.$pri : '' ;
$filtrord .= isset($prf) ? '&prf='.$prf : '' ;
$filtrord .= isset($tam) ? '&tam='.$tam : '' ;
$filtrord .= isset($qtitpg) ? '&qtitpg='.$qtitpg : '' ;
$filtrord .= isset($cor) ? '&cor='.$cor : '' ;
$filtrord .= isset($carac) && isset($opcao) ? '&carac='.$carac.'&opcao='.$opcao : '' ;

$filtroqt = '';
$filtroqt .= isset($set) ? '&set='.$set : '' ;
$filtroqt .= isset($bra) ? '&bra='.$bra : '' ;
$filtroqt .= isset($pri) ? '&pri='.$pri : '' ;
$filtroqt .= isset($prf) ? '&prf='.$prf : '' ;
$filtroqt .= isset($ord) ? '&ord='.$ord : '' ;
$filtroqt .= isset($tam) ? '&tam='.$tam : '' ;
$filtroqt .= isset($cor) ? '&cor='.$cor : '' ;
$filtroqt .= isset($carac) && isset($opcao) ? '&carac='.$carac.'&opcao='.$opcao : '' ;

$listacat = listacatesql($set);	

$titulopg = $caminhocategoria;

include("header.php"); 
if ($bra<>'') {
	$nomemarca = $obj_sql->Get("select for_nome from ".TB_FORNECEDOR." where for_id='$bra'");
}

?> 

	<section class="section-title" style="background: <? if (isset($sec) && $sec=='promociones') { ?>#000 no-repeat top center; height: 250px<? } else { ?>linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), <? if (file_exists("files/cati1_".$rowcatpai['cat_id'].".".$rowcatpai['cat_ext1'])) { ?>url(/files/cati1_<?=$rowcatpai['cat_id']?>.<?=$rowcatpai['cat_ext1']?>) no-repeat top center<? } else { ?>#000<? } } ?>;">
      <div class="container">
        <div class="row">
          <div class="col-sm-12">
            <h1><?=$nomecategoria?></h1>            
          </div>
        </div>
      </div>
	</section>
    
    <section class="container">
		<div class="body-content">

			<div class="row">
				<div class="col-sm-4 col-md-3">					
					<? include("menu_lateral.php") ?>                           
				</div>

				<div class="col-sm-8 col-md-9" style="position: static;">
            		<div class="collapse-products">			
						<?
							$txtsql = '';
							$txtsql .= isset($bra) ? " and a.pro_for_id='$bra' " : '';
							$txtsql .= isset($pri) ? " and a.pro_preco>'$pri' and a.pro_preco<>0 " : '';
							$txtsql .= isset($prf) ? " and a.pro_preco<='$prf' and a.pro_preco<>0 " : '';
							$txtsql .= isset($sec) ? $secao['campo'] : '';	
							$txtsql .= isset($carac) && isset($opcao) ? " and a.pro_cara_".$carac."='$opcao' " : '';
							$ordpreco = ", if(a.pro_preco>0 and a.pro_estoque>a.pro_reserva and a.pro_reserva>=0,'1','0') as tempreco ";

							if (isset($tam)) {
							if (strstr($tam,'x')!==false) {
							$tamx = isset($tam) ? apenasnumero($tam) : "";
							$sqlta = array();
							for ($xta=$tamx; $xta<=($tamx+5); $xta++) {
							$sqlta[] = " d.opc_valor1='$xta' ";
							}
							$txttam = implode(" or ",$sqlta);
							$txtsql .= isset($tam) ? " and (".$txttam.") and d.opc_tipo1='Tamanho' and d.opc_del<>'1' and d.opc_estoque>0" : '';
							} else {
							$txtsql .= isset($tam) ? " and d.opc_valor1='$tam' and d.opc_tipo1='Tamanho' and d.opc_del<>'1' and d.opc_estoque>0" : '';
							}
							}
							$innersql = isset($tam) ? " inner join ".TB_PRODUTO_OPCAO." d on d.opc_pro_id=a.pro_id " : '';
							$fieldsql = isset($tam) ? ", d.opc_id, d.opc_ref, d.opc_ext " : '';
							if(PROMOABA == 1 && $sec=='blackfriday'){
								$sql_produtos_promo = " and pro_oferta=1 ";
							}
							else{
								$sql_produtos_promo = " ";
							}
							$nrows = $obj_sql->Get("select count(distinct a.pro_id) from ".TB_PRODUTO." a
							inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
							inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id 
							left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' ".$sqltxtpromo." group by pr.pro_id) as spr on a.pro_id=spr.pro_id
							".$innersql."
							where a.pro_del<>'1' and a.pro_reserva>=0 and a.pro_situacao='1' ".$sql_produtos_promo." and h.cat_id in (".$listacat.") ".$txtsql."");

							$npagi = ceil($nrows/$quantporpagina);
							
							$qid = $obj_sql->Query("select distinct a.*, c.for_nome, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo,sps.pms_titulo, sps.pms_id ".$fieldsql.$ordpreco." from ".TB_PRODUTO." a
							inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
							inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
							left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' ".$sqltxtpromo." group by pr.pro_id) as spr on a.pro_id=spr.pro_id
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
							".$innersql."
							where a.pro_del<>'1' and a.pro_reserva>=0 and a.pro_situacao='1' ".$sql_produtos_promo." and h.cat_id in (".$listacat.") ".$txtsql." order by ".$listaordem[$ord]." limit $regini,$quantporpagina");



							$npagi = ceil($nrows/$quantporpagina);
							$margem = PAGMARGEM;
							$pageini = $pag-$margem <= 0 ? 1 : $pag-$margem;
							$pagefim = $pag+$margem > $npagi ? $npagi : $pag+$margem;
							$regfim = $quantporpagina + $regini;	

							if ($nrows>0) {
						?>
				        <div class="row">
				          <div class="col-md-12">
				            <? include("_paginacao.php") ?>                   
				          </div>  
				        </div>

				        <div class="row">
				            <?
							while ($row = $obj_sql->Fetch_Array($qid)) {
								$qidf = $obj_sql->Query("select * from ".TB_PRODFOTOS." where fot_pro_id='".$row['pro_id']."' order by fot_principal desc limit 1");
								if ($rowf = $obj_sql->Fetch_Array($qidf)) {
									$imagem = "/files/pro_".$rowf['fot_id']."_m.".$rowf['fot_ext'];
								} else {
									$imagem = "/img/noimg_p.jpg";
								}
							?>
				          <div class="col-sm-6 col-md-4">
				            <?php include("produto-item.php") ?>
				          </div>
				          <? } ?>
				        </div>

				        <div class="row">
				          <div class="col-md-12">
				              <?  
				              $fd = true;
							include("_paginacao.php");                   
							?>                 
				          </div>  
				        </div> 
				        <? 
						} else { ?>
				        <div class="row">
				        	<div class="col-md-12">
				          		<p>No hay productos en esta categor&iacute;a.</p>
				            </div>
				        </div>
				        <? } ?> 
            		</div>
            	</div>

			  	
			</div>
		</div>
    </section>

<? include("footer.php"); ?>