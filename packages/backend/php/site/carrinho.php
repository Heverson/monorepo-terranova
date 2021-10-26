<?
include("_setup.php");
$TAG_title = 'Mis Pedidos';
$passo = '1';

$act = !isset($_GET['act']) && !isset($_POST['act']) ? NULL : (isset($_GET['act']) ? $_GET['act'] : $_POST['act']);
$cidad = !isset($_GET['cidad']) && !isset($_POST['cidad']) ? NULL : (isset($_GET['cidad']) ? $_GET['cidad'] : $_POST['cidad']);
$cat = !isset($_GET['cat']) && !isset($_POST['cat']) ? 1 : (isset($_GET['cat']) ? $_GET['cat'] : $_POST['cat']);
$idlist = !isset($_GET['idlist']) && !isset($_POST['idlist']) ? NULL : (isset($_GET['idlist']) ? $_GET['idlist'] : $_POST['idlist']);
$cupom = isset($_POST['cupom']) ? $_POST['cupom'] : NULL;

$sorodape = '1';

$errocart = array();
$msgFrete = '';

if ($cupom<>'') {
	$qidcu = $obj_sql->Query("select * from ".TB_CUPOM." where cup_codigo='$cupom' and cup_status='0' and cup_validade>='".date("Y-m-d")."'");
	if ($obj_sql->Num_Rows($qidcu)==1) {
		$_SESSION['CUPOM'] = array();
		$linhacupom = $obj_sql->Fetch_Array($qidcu);
		
		if ($linhacupom['cup_uso']=='2' && is_logged() && $_SESSION['USER']['usu_pcompra']=='1') {
			$errocart[] = "Cupom de desconto valido somente para primeira compra";
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
		}
		
	} else {
		$_SESSION['CUPOM'] = array();
		$errocart[] = "Cupón de descuento no válido o con validez vencida";
	}
}

if ($act == 'salvafrete' && $_POST['frete_id'] <> '') {
    $_SESSION['IDFRETE'] = $_POST['frete_id'];
}

if ($act== 'limpar') {
	$_SESSION['CART']->init();
	$_SESSION['CART']->cleanup();
}

if ($act=='add') {
	foreach ($_POST['proid'] as $idprocompleto => $quantidade) {
		if ($quantidade<1) {continue;}
		$temp = explode('-',$idprocompleto);
		$idproduto = $temp[0];
		
		$qidtote = $obj_sql->Get_Array("SELECT * FROM ".TB_PRODUTO." WHERE pro_id='".$idproduto."' and pro_situacao='1'");
		$totest = $qidtote['pro_estoque']>$qidtote['pro_reserva'] && $qidtote['pro_reserva']>=0 ? $qidtote['pro_estoque']-$qidtote['pro_reserva'] : 0;
		$valorproduto = $qidtote['pro_preco'];
		if ($valorproduto>0) {
			if (isset($_POST['opc'][$idproduto]) && $_POST['opc'][$idproduto]>0) {
				$temp = $obj_sql->Get_Array("SELECT opc_estoque, opc_reserva FROM ".TB_PRODUTO_OPCAO." WHERE opc_pro_id='".$idproduto."' and opc_id='".$_POST['opc'][$idproduto]."'");
				if ($temp>0) {
					$totest = $temp['opc_estoque']>$temp['opc_reserva'] && $temp['opc_reserva']>=0 ? $temp['opc_estoque']-$temp['opc_reserva'] : 0;
				}
				$opcid = $_POST['opc'][$idproduto];
			} else {
				$opcid = '0';
			}
			$pro_id = $idprocompleto.'.'.$opcid;
			$totaldesejado = $quantidade+$_SESSION['CART']->items[$pro_id];
			
			
			if ($totest<$totaldesejado) {
				$errocart[] = "Cantidad de inventario insuficiente (".$totaldesejado.")";
				$quantidade = $totest-$_SESSION['CART']->items[$pro_id];
			} 
			if ($quantidade>0) {
				$_SESSION['CART']->add($pro_id,$quantidade);
				$_SESSION['CART']->cleanup();
				$aviso = $qidtote['pro_nome']." ha sido agregado a su carrito.";					
			}
		} else {
			$errocart[] = "La venta de este producto se realiza solamente bajo consulta.";
		}
	}
}

if ($act == 'del') {
    $_SESSION['CART']->remove($_GET['proid']);
    $_SESSION['CART']->cleanup();
}
if ($act == 'recalcula') {
    foreach ($_POST['itenped'] as $chave => $valor) {
        list($pro_id, $opc_id) = explode('.', $chave);
        $temp = $obj_sql->Get_Array("SELECT pro_estoque,pro_reserva FROM " . TB_PRODUTO . " WHERE pro_id='$pro_id' and pro_situacao='1'");
		$totest = $temp['pro_estoque']>$temp['pro_reserva'] && $temp['pro_reserva']>=0 ? $temp['pro_estoque']-$temp['pro_reserva'] : 0;
        if ($opc_id <> '0') {
            $temp = $obj_sql->Get_Array("SELECT opc_estoque,opc_reserva FROM " . TB_PRODUTO_OPCAO . " WHERE opc_pro_id='$pro_id' and opc_id='$opc_id'");
			$totest = $temp['opc_estoque']>$temp['opc_reserva'] && $temp['opc_reserva']>=0 ? $temp['opc_estoque']-$temp['opc_reserva'] : 0;
        }
		
        if ($totest < $valor) {
            $errocart[] = "Cantidad de inventario insuficiente (" . $valor . ")";
        } else {
            $_SESSION['CART']->set($chave, $valor);
        }
    }
    $_SESSION['CART']->cleanup();
}

if ($cidad <> '') {
	$retorno = $obj_sql->Get_Array("SELECT * FROM ".TB_CIDADESPY." WHERE cpy_cidade ='$cidad'");
    if (isset($retorno['cpy_id'])) {
        $_SESSION['CIDAD']['cidade'] = $retorno['cpy_cidade'];
        $_SESSION['CIDAD']['zona'] = $retorno['cpy_zona'];
    } else {
        $errocart[] = "Ciudad que no se encuentra o no válido";
    }
}

include("header-pgto.php");
?> 

  <div class="container">
    <div class="header-content">
      <div class="row">
        <div class="col-md-12">
          <h1 class="title">Carrito</h1>
        </div>
      </div>
    </div>
  </div>
	
	<? 
	/*
	if (!is_logged() || (is_logged() && $_SESSION['USER']['usu_pcompra']=='0')) { ?>
  <div style="background: #5cd7d2; margin-top: 30px;">
  	<div class="container"> 
	    <div class="row">
      	<a href="/meu-carrinho?c=9fa28e96af1cf676644e1ddb6bed6b1a">
  	  	<div class="col-md-12" style="font-weight:bold; color: #FFF; padding:20px 0; text-align:center">
        	Usted ganï¿½ un cupón de descuento del <span style="font-size:16px; color: #F00">10%</span> para su primera compra. <span style="background: #FFF; color: #F00; padding:5px">PRIMERA19</span>. Haga clic aquï¿½ o introduzca el código.
        </div>
        </a>
      </div>
     </div>
     </div>
    <? }
		*/ ?>
      
    


  <div class="container"> 
    <div class="body-content">
    
	<? if (isset($_GET['er12'])) { ?>
      <div class="col-md-12" style="font-weight:bold; color: #F00; padding:20px 0;">ADVERTENCIA: LA SU SOLICITUD DE DATOS NO SE PUDO VALIDAR. FAVOR DE MARCAR EN LOS DATOS ABAJO Y VUELVE A INTENTARLO.
      </div>
      <? } ?>
    <? if (isset($_GET['er41'])) { ?>
      <div class="col-md-12" style="font-weight:bold; color: #F00; padding:20px 0;">ADVERTENCIA: SUS ART&Iacute;CULOS FUERON ALTERADOS ALGUNOS CESTA DE LA COMPRA O EXCLUIDO NO SER M&Aacute;S DISPONIBLE EN STOCK.<br />
        POR FAVOR HAGA CLIC EN EL BOT&Oacute;N &quot;MI CARRITO&quot; Y CONFIRMAR LOS ART&Iacute;CULOS DE SU SOPORTE ANTES DE TERMINAR SU COMPRA DE NUEVO.
      </div>
      <? } ?>    
    
    
    <form name="formCarrinho" id="formCarrinho" method="post" action="/meu-carrinho"><input name="act" type="hidden" id="act" value="recalcula">
<?
                if ($_SESSION['CART']->itemcount() > 0) {
                    $acu_valor = 0;
                    $acu_peso = 0;
                    $acu_volu = 0;
                    $maiorprazo = 0;
                    $x = 1;
                    $linhas = '';
                    $apro = array();
                    $avisodescontoavista = '';
                    $descontoavistap = 0;
					$valordecontoprocat = 0;
					
					$prodqtds = array();
					foreach ($_SESSION['CART']->items as $prodid => $quant) {
						list($pro_id, $opc_id) = explode('.', $prodid);
						
						$pms_id = $obj_sql->Get("select sps.pms_id from ".TB_PRODUTO." a
										left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id
										where a.pro_id='$pro_id'");
										
						if ($pms_id>0) {
							$prodqtds[$pms_id] = isset($prodqtds[$pms_id]) ? $prodqtds[$pms_id]+$quant : $quant;
						}
					}

                    foreach ($_SESSION['CART']->items as $prodid => $quant) {
                        list($pro_id, $opc_id) = explode('.', $prodid);

                        $proQuery = $obj_sql->Query("select a.*, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo,sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                        left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id 
										left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id
										where a.pro_id='$pro_id'");
										
                        $pro = $obj_sql->Fetch_Array($proQuery);
						$precobase = array('pro_preco' => $pro['pro_preco'], 'pro_desconto' => $pro['pro_desconto']);
						if ((isset($pro['pmo_perc']) && $pro['pmo_perc']>0) || (isset($pro['pmo_perca']) && $pro['pmo_perca']>0)) {
							$pro['pro_desconto'] = $precobase['pro_desconto'] + (isset($pro['pmo_perc']) && $pro['pmo_perc']>0 ? $pro['pro_preco']*($pro['pmo_perc']/100) : 0);
						}
						if (isset($pro['pms_id'])) {
							$quanttotal = $prodqtds[$pro['pms_id']];
							$rowfaixa = $obj_sql->Get_Array("select * from ".TB_PROMOGRES_FAIXA." where pms_id='".$pro['pms_id']."' and pmf_qtd<='".$quanttotal."' order by pmf_qtd desc limit 1");
							if (isset($rowfaixa['pmf_id'])) {
								$pro['pro_desconto'] = $precobase['pro_desconto'] + ($rowfaixa['pmf_perc']>0 ? $precobase['pro_preco']*($rowfaixa['pmf_perc']/100) : 0);	
							}
						}
						
                        $ite_peso = $pro['pro_peso'];
                         $ite_volu = retcubicopro($pro['pro_id']);
                        
                        if($pro['pro_descper']>0){
                          $tempdesc = $pro['pro_preco'] * ($pro['pro_descper']/100);
                          $pro['pro_desconto'] = $pro['pro_desconto']+$tempdesc;
                        }
                        $ite_valor = desconto($pro['pro_preco'],$pro['pro_desconto']);
                        
                        $ite_quant = $quant;
                        $referencia = $pro['pro_ref'];
						$descprocat = 0;
						
						if ($pro['pro_descontoavista'] > 0) {
                            $descontoavistap += $pro['pro_descontoavista'];
                            $avisodescontoavista = '<span class="avisodesconto">* La vista en productos con descuento se calculará despuês</span>';
                            $temdescavista = '*';
                        } else {
                            $temdescavista = '';
                        }
                        if ($opc_id <> 0) {
                            $opcQuery = $obj_sql->Query("SELECT * FROM " . TB_PRODUTO_OPCAO . " WHERE opc_pro_id='$pro_id' and opc_id='$opc_id'");
                            $opc = $obj_sql->Fetch_Array($opcQuery);
                            $referencia = $opc['opc_ref'];
                            if ($opc['opc_preco'] > 0) {
                                $ite_valor = $opc['opc_preco'];
                            }
                            if ($opc['opc_peso'] > 0) {
                                $ite_peso = $opc['opc_peso'];
                            }
                            if ($opc['opc_cubico'] > 0) {
                                $ite_volu = $opc['opc_cubico'];
                            }
                        }

						// desconto do cupom por produto ou categoria ou marca
						if ($_SESSION['CUPOM']['codigo']<>'' && $_SESSION['CUPOM']['tipo']=='P') { 
							if ( isset($_SESSION['CUPOM']['idspro'][$pro_id]) || isset($_SESSION['CUPOM']['idscat'][$pro['pro_cat_id']]) || isset($_SESSION['CUPOM']['idsmar'][$pro['pro_for_id']]) ) {
								$descprocat =  $ite_valor*$ite_quant * ($_SESSION['CUPOM']['valor']/100);
								$valordecontoprocat += $descprocat;
							}
						}				


                        //forma array para calculo do frete
                        $apro[$x]['idp'] = $prodid;
                        $apro[$x]['opc'] = $pro['pro_transp'] <> '' ? '-' . str_replace('|', '', $pro['pro_transp']) : '';
                        $apro[$x]['tra'] = '';
                        $apro[$x]['pes'] = $ite_peso * $ite_quant;
                        $apro[$x]['vol'] = $ite_volu * $ite_quant;
                        $apro[$x]['val'] = $ite_valor * $ite_quant;
                        $apro[$x]['gra'] = $pro['pro_fretegratis'];


                        $acu_valor += $ite_valor * $ite_quant;
                        $acu_peso += $ite_peso * $ite_quant;
                        $acu_volu += $ite_volu * $ite_quant;
                        if ($maiorprazo < $pro['pro_praentrega']) {
                            $maiorprazo = $pro['pro_praentrega'];
                        }
                        $proopc1 = ($opc_id <> 0 && $opc['opc_tipo1'] <> '') ? '<br />' . $opc['opc_tipo1'].': '.$opc['opc_valor1'] : '<br />';
                        $proopc2 = ($opc_id <> 0 && $opc['opc_tipo2'] <> '') ? ' - ' . $opc['opc_tipo2'] . ': ' . $opc['opc_valor2'] : '';
                        $produto = $pro['pro_nome'] . $temdescavista . $proopc1 . $proopc2;

                        $rowf = $obj_sql->Get_Array("select * from " . TB_PRODFOTOS . " where fot_pro_id='" . $pro_id . "' order by fot_principal desc limit 1");
                        $x++;
                        ?> 
      <div class="section-box">
        <div class="row">
          <div class="col-sm-12">
              <div class="row">
              
                <div class="col-sm-1 col-md-1">
                  <img src="img/ico-remove.svg" height="14" alt="">  <a href="javascript://" onClick="if (confirm('¿De verdad quieres eliminar este elemento de lo carrito?')) {document.location.href='/meu-carrinho?act=del&proid=<?= $prodid ?>';} return false;" class="bt-remove">Eliminar</a>
                </div>

                <div class="col-sm-2 col-md-2" align="center">
                  <a href="<?=linkpro($pro['pro_id'])?>"><img src="<?= file_exists($CFG->wwwpath . "/files/propc_" . $opc['opc_id'] . "_p." . $opc['opc_ext']) ? "/files/propc_" . $opc['opc_id'] . "_p." . $opc['opc_ext'] : "/files/pro_" . $rowf['fot_id'] . "_p." . $rowf['fot_ext'] ?>" class="img-cart" /></a>
                </div>

                <div class="col-sm-5 col-md-5">
                  <a href="<?=linkpro($pro['pro_id'])?>"><?= $produto ?></a>
                </div>                 
                
                <div class="col-sm-2 col-md-2" align="center">
                Cantidad:<br><br>

                    <input type="button" value="-" class="qtyminus" data-submit="formCarrinho" field="itenped_<?= str_replace(".", "_", $prodid) ?>" />
                    <input type="text" name="itenped[<?= $prodid ?>]" id="itenped_<?= str_replace(".", "_", $prodid) ?>" value="<?= $ite_quant ?>" class="qty" onKeyPress="return apenasValor(this,event)" onBlur="avisoPost();$('#formCarrinho').submit();" umv="<?=$pro['pro_qtgrupovenda']?>" readonly />
                    <input type="button" value="+" class="qtyplus" data-submit="formCarrinho" field="itenped_<?= str_replace(".", "_", $prodid) ?>" />

                </div>
                
                <div class="col-sm-2 col-md-2">
                  Subtotal:<br>
                        <!--
                          subtotal
                        <?php echo $ite_valor;?>
                      -->

                  <span class="price-submain"><?=convertval($ite_valor * $ite_quant,MOEDABASE,$_SESSION['MOEDA'],'1')?></span><? if ($descprocat>0) { ?>
			<br /><span style="color:#009900; font-size:9px">Descuento: <?=convertval($descprocat,MOEDABASE,$_SESSION['MOEDA'],'1')?></span><? } ?>
                </div>                       
              </div>            
          </div>
        </div>
      </div>
<? } ?>
                <? } else { ?>
                <div class="section-carrinho-box">
    <div class="row">
        <div class="col-md-12">
            <div class="aviso">
                <strong>Su carrito est&aacute; vac&iacute;o!</strong>
            </div>
        </div>
    </div>
    </div>
                <? } ?>      
                <? if (count($errocart) > 0) { ?>
                   <div class="section-carrinho-box">
    <div class="row">
      <div class="col-md-12">
						<div class="alert alert-error"><?= implode("<br>", $errocart) ?></div>
                        </div>
      </div>
      </div>
                <? } ?>
  </form>
      
      
      
<?
        if ($_SESSION['CART']->itemcount() > 0) {
            $txtfrete = 'Calcule';
            if ($_SESSION['CIDAD']['cidade'] <> '') {
                $arfrete = calcfretemulti(str_replace("'", "", $_SESSION['CIDAD']['cidade']), $_SESSION['CIDAD']['zona'], $maiorprazo, $acu_peso, $acu_volu, $acu_valor, $apro);
				
                if (!is_array($arfrete) || count($arfrete) < 1) {
                    $bloqueia = '1';
                }
            }
            ?> 
		<div class="section-box">
    <div class="row">
      <div class="col-md-9">
						<div class="cart-frete">
                      <form id="formCupom" name="formCupom" method="post" action="/meu-carrinho" onSubmit="return verificacupom()">
                        <h2>Cupón de descuento:</h2>
                       <input name="cupom" class="frete-input" id="cupom" type="text" value="<?= $_SESSION['CUPOM']['codigo'] ?>" maxlength="18"  /> <button class="frete-bt">Calcular</button>
                        
                        <div class="small">Si ya tienes un cupón de descuento o regalo, rellene el código arriba y haga un click en "Calcular".</div>
                        </form>
                      </div>
            
         </div>
         <div class="col-md-3">
         	<p>Subtotal:<br> <span class="price-main"><strong><?=convertval($acu_valor,MOEDABASE,$_SESSION['MOEDA'],'1')?></strong></span></p>
         </div>
      </div>
      </div>            
            
            
            
      <div class="section-box section-cart-extra">
        <div class="row">
          <div class="col-sm-12">
            <div class="container-interno">  
						<? 
										$valor_cupom = 0;
										$saida_cupom = '';
										if ($_SESSION['CUPOM']['codigo']<>'' && $acu_valor>=$_SESSION['CUPOM']['limite']) { 
											if ($_SESSION['CUPOM']['tipo']=='F') {
												$saida_cupom = 'Frete Grátis';
											} else if ($_SESSION['CUPOM']['tipo']=='V') {
												if ($_SESSION['CUPOM']['tpval']=='P') {
													$valorfinalcup = round($acu_valor*($_SESSION['CUPOM']['valor']/100),2);
												} else {
													$valorfinalcup = $_SESSION['CUPOM']['valor'];
												}
												$saida_cupom = convertval($valorfinalcup,MOEDABASE,$_SESSION['MOEDA'],'1');
												$valor_cupom = $valorfinalcup;
											} else if ($_SESSION['CUPOM']['tipo']=='P') {
												$saida_cupom = convertval($valordecontoprocat,MOEDABASE,$_SESSION['MOEDA'],'1');
												$valor_cupom = $valordecontoprocat;
											}
										}
										?>        
              <div class="row">
                 <div class="col-md-4">
                 <h2>OPCIÓN 1</h2>
                 Sólo imprimir tu presupuesto.
                 <Br><br><br>
                 
                 <? if ($_SESSION['CART']->itemcount()>0) { ?><a href="javascript:void(0)" onClick="popWin('/printcarrinho.php','printcarrinho','800','600')" class="btn">Imprimir</a><? } ?>
                 
                   
                </div>
                
                
                <? 
								if ($_SESSION['liberapgto']=='1') {$txtpgto= " "; } else {$txtpgto= " and fpg_status='1' ";}
								$totalpgto = $obj_sql->Get("SELECT count(fpg_id) FROM ".TB_FORMAPGTO." WHERE fpg_del<>'1' ".$txtpgto);
								if ($totalpgto>0) { ?>
                
                <div class="col-md-4">
                <? /*
                <h2>OPCI&Oacute;N 2</h2>
                Finalizar su pedido, pagar y retirar en la tienda.
                <Br><Br><Br>
                <?
								$valorfinalorca = $acu_valor-$valor_cupom;
								$valorfinalorca = $valorfinalorca<=0 ? 0.01 : $valorfinalorca;
                if ($saida_cupom<>'') {
										?>
                   <p>Cupón descuento:<br><strong style="color:#009900"><?=$saida_cupom?></strong></p>
										<? } ?>

                  <span>Total:</span>                
                  <span class="price-main"><strong><?=convertval($valorfinalorca,MOEDABASE,$_SESSION['MOEDA'],'1')?></strong></span>    
                  <? if ($_SESSION['MOEDA']<>'guarani') { ?><br>          
                  <span class="price-strong"><?=convertval($valorfinalorca,MOEDABASE,'guarani','1')?></span>
                  <? } ?>
                  <br><Br>
                  
                  <? if ($_SESSION['CART']->itemcount()>0) { ?><a href="login?go=orcamento" onClick="return confirm('ï¿½Desea realmente enviar el pedido como esta? Atenciï¿½n: ya no serï¿½ posible realizar cambios.')" class="btn">Enviar Pedido</a><? } ?>
                  */ ?>
                  
                  <h2>OPCI&Oacute;N 2</h2>
                      Pagar ahora.
                      <br><br>

                      <div class="cart-frete">
                        <div class="small"><strong>Para calcular el valor del flete y el plazo de entrega, rellene abajo su Ciudad.</strong></div>
                        <form id="formCep" name="formCep" method="post" action="/meu-carrinho" onSubmit="return verificacidad()">
              <input name="cidad" class="frete-input" type="text" id="cidad" placeholder="Rellene tu ciudad" value="<?= $_SESSION['CIDAD']['cidade'] ?>" style="width:70%">
              
                        <button class="frete-bt">OK</button>
                        </form>

                         </div>
                         
                   
                </div>
                
                
                <div class="col-md-4">
                      
                        <? if ( isset($_SESSION['CIDAD']['cidade']) ) { ?>

                        <h2>Flete e plazo de entrega:</h2>

                        <div class="row">
				
					 <? if ($bloqueia == '1') { ?>
                        <div style="background: #FFF; border: 1px solid #CCC; padding: 10px;">
                            <strong>Atenci&oacute;n:</strong><bR />
                            Para este producto, esta cantidad no ser&aacute; posible finalizar la solicitud. Pedimos que se ponga en contacto por tel&eacute;fono o correo electr&oacute;nico se describe en <a href="/central-de-atendimento">centro de atenci&oacute;n al cliente</a>.
                        </div>
                    <?
                    } else {

                        if ( !isset($arfrete[$_SESSION['IDFRETE']]) ) {
                            unset($_SESSION['IDFRETE']);
                        }


                        $valfrete = $arfrete[1]['valor'];
                        $frete_id = 1;
                        $prazomaior = $arfrete[1]['prazo'];
                        foreach ($arfrete as $key => $value) {
                            if ($_SESSION['CUPOM']['codigo'] <> '' && $_SESSION['CUPOM']['tipo'] == 'F' && $acu_valor >= $_SESSION['CUPOM']['limite']) {
                                $valfrete = 0;
                                if ($prazomaior < $value['prazo']) {
                                    $prazomaior = $value['prazo'];
                                    $frete_id = $key;
                                }
                            } else {
                                if ($_SESSION['IDFRETE'] <> '') {
                                    if ($_SESSION['IDFRETE'] == $key) {
                                        $valfrete = $value['valor'];
                                    }
                                } else {
                                    if ($valfrete > $value['valor']) {
                                        $valfrete = $value['valor'];
                                        $frete_id = $key;
                                    }
                                }
                            }
                        }
                        if ($_SESSION['IDFRETE'] == '') {
                            $_SESSION['IDFRETE'] = $frete_id;
                        }
                        $txtfrete = $valfrete==0 ? 'Grátis' : convertval($valfrete,MOEDABASE,$_SESSION['MOEDA'],'1');
                        if ($_SESSION['CUPOM']['codigo'] <> '' && $_SESSION['CUPOM']['tipo'] == 'F' && $acu_valor >= $_SESSION['CUPOM']['limite']) {
                            $txtfrete = "Grátis";
                            ?>
                            
                 <div class="col-xs-12 col-md-12">
                  <div class="field">
                    &nbsp;
                  </div>

                  <div class="field-desc">
                    Transportadora - <?= $prazomaior ?> dia<?= $prazomaior > 1 ? 's' : '' ?> &uacute;teis<br>
                    <strong>Grátis</strong>
                  </div>  
                </div>
                <hr>
				
                        <? } else { ?>
                            <form action="/meu-carrinho" method="post" name="formFrete" id="formFrete">
							<input name="act" type="hidden" id="act" value="salvafrete">
                            <?
                                    $x = 0;
                                    foreach ($arfrete as $key => $value) {
                                        $x++;
                                        ?>
                <div class="col-xs-12 col-md-12 section-box">
                  <div class="field">
                    <input type="radio" name="frete_id" id="radio" value="<?= $key ?>" align="bottom" onClick="$('form#formFrete').submit()" <?= $key == $_SESSION['IDFRETE'] ? 'checked="checked"' : '' ?> />&nbsp;
                  </div>

                  <div class="field-desc">
                    <?= $value['nome'] ?> - <?= $value['prazo'] ?> dia<?= $value['prazo'] > 1 ? 's' : '' ?> &uacute;teis<br>
                    <strong><?= $value['valor'] == 0 ? 'Grátis' : convertval($value['valor'],MOEDABASE,$_SESSION['MOEDA'],'1') ?></strong>
                  </div>  
                </div>
                                    <? } ?>
                            </form>  
                        <? }
						} ?>
                        
                     </div> 
                     <? } else {
											  ?>                
                                          
                  <p>Flete:<br> <span class="price-strong">Calcule</span></p>
                  <? } ?>
                     
                      <div class="row">                           
										<div class="col-xs-12 col-md-12 section-box">
                   
                    <?
										$valorfinal = $acu_valor+$valfrete-$valor_cupom;
										$valorfinal = $valorfinal<=0 ? 0.01 : $valorfinal;
										if ($saida_cupom<>'') {
										?>
                                        <p>Cupón descuento:<br><strong style="color:#009900"><?=$saida_cupom?></strong></p>
										<? } ?>

                  <span>Total:</span>                
                  <span class="price-main"><strong><?=convertval($valorfinal,MOEDABASE,$_SESSION['MOEDA'],'1')?></strong><? if ( $txtfrete=='Calcule' ) { ?> + Flete<? } ?></span>    
                  <? if ($_SESSION['MOEDA']<>'dolar') { ?>       
                  <small class="price-strong"><?=convertval($valorfinal,MOEDABASE,'dolar','1')?></small>
                  <? } ?>
                  </div>
                  </div>
                  <? if ($_SESSION['CART']->itemcount()>0 && $bloqueia<>'1') { ?><a href="login?go=pagamento" class="btn">Realizar el pago ahora</a><? } ?>
                </div> 
                <? } ?>                    
              </div>
            </div>          
          </div>    
        </div>
      </div>  
      <? } ?>    
    </div>
  </div>   

  <div class="container">    
      <div class="row">
        <div class="col-sm-12" align="center">
            <a href="<?= isset($cat) ? linkcat($cat) : '/' ?>" class="btn">Seguir comprando</a> 
            <br>
            <br>
        </div>
      </div>
  </div>

<? include("footer-pgto.php"); ?>