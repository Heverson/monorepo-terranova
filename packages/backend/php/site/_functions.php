<?

function linkcat($set=NULL,$pag=NULL,$ord=NULL,$bra=NULL,$pri=NULL,$prf=NULL,$qtitpg=NULL,$tam=NULL,$cor=NULL,$carac=NULL,$opcao=NULL,$filtro=NULL,$secao=NULL) {
	global $obj_sql;
	if (isset($filtro)) {
		parse_str($filtro);
	}
	
	$caminhocategoria = $set<>0 && isset($set) ? "/" . linktexto(substr(caminhocatnomelink($set),1)) : "" ;
	$nomemarca = isset($bra) ? "/".linktexto($obj_sql->Get("select for_nome from ".TB_FORNECEDOR." where for_id='$bra'")) : '';
	if ($secao=='categorias' || !isset($secao)) {
		$saida = "/CategoriaId_".$set;
	}
	if ($secao=='promociones') {
		$saida = "/promociones_".$set;
	}
	if ($secao=='marcas') {
		$saida = "/marcas_".$set;
	}
	if ($secao=='lancamentos') {
		$saida = "/lancamentos_".$set;
	}
	if ($secao=='best-sellers') {
		$saida = "/best-sellers_".$set;
	}
	if ($secao=='blackfriday') {
		$saida = "/blackfriday_".$set;
	}
	if ($secao=='listas') {
		$saida = "/listas_".$set;
	}
	if ( isset($pag) || isset($ord) || isset($bra) || isset($pri) || isset($prf) || isset($qtitpg) || isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($pag) ) {
		$saida .= $pag;
	}

	if ( isset($ord) || isset($bra) || isset($pri) || isset($prf) || isset($qtitpg) || isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($ord) ) {
		$saida .= $ord;
	}
	if ( isset($bra) || isset($pri) || isset($prf) || isset($qtitpg) || isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($bra) ) {
		$saida .= $bra;
	}
	if ( isset($pri) || isset($prf) || isset($qtitpg) || isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($pri) ) {
		$saida .= $pri;
	}
	if ( isset($prf) || isset($qtitpg) || isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($prf) ) {
		$saida .= $prf;
	}
	if ( isset($qtitpg) || isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($qtitpg) ) {
		$saida .= $qtitpg;
	}
	if (isset($tam) || isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($tam) ) {
		$saida .= $tam;
	}
	if (isset($cor) || isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($cor) ) {
		$saida .= $cor;
	}
	if (isset($carac) || isset($opcao) ) {
		$saida .= ",";
	}
	if ( isset($carac) ) {
		$saida .= $carac;
	}
	if ( isset($opcao) ) {
		$saida .= ",";
		$saida .= $opcao;
	}
	$saida .=  $caminhocategoria . $nomemarca . ".html";

	return $saida;
}

function linkpro($id,$set=0) {
	global $obj_sql;
	if ($set>0) {
		$rowpro = $obj_sql->Get_Array("select a.pro_nome from ".TB_PRODUTO." a where a.pro_id='$id'");
	} else {
		$rowpro = $obj_sql->Get_Array("select a.pro_nome, b.cat_id from ".TB_PRODUTO." a
					inner join ".TB_PRODUTO_CATEGORIA." b on a.pro_id=b.pro_id
					where a.pro_id='$id' limit 1");
		$set = $rowpro['cat_id'];
	}
	$caminhocategoria = linktexto(substr(caminhocatnomelink($set),1)) ;
	$saida = "/ProdutoId_".$id.",".$set."/".$caminhocategoria. "/". linktexto($rowpro['pro_nome']).".html";
	return $saida;
	
}

function linkblog($pag=NULL,$per=NULL,$tag=NULL,$bus=NULL) {
	global $obj_sql, $CFG;
	$saida = "/Blog";
	if ( isset($pag) || isset($per) ) {
		$saida .= "_";
	}
	if ( isset($pag) ) {
		$saida .= $pag;
	}

	if ( isset($per) ) {
		$saida .= ",";
		$saida .= $per;
	}
	if ( isset($tag) || isset($bus) ) {
		$saida .= "_";
	}
	if ( isset($tag) ) {
		$saida .= urlencode($tag);
	}
	if ( isset($bus) ) {
		$saida .= "-";
		$saida .= urlencode($bus);
	}

	$saida .=  "/pg.html";

	return $saida;
}

function linkblogview($id,$nome='') {
	global $obj_sql;
	$nome = $obj_sql->Get("select blp_titulo from ".TB_BLOG_POST." where blp_id='$id'");
	$saida = "/BlogView_".$id."/". linktexto($nome).".html";
	return $saida;
}


function valida_array($array) {
	if (is_array($array) && count($array)>0) {
		return true;
	} else {
		return false;
	}
}

function sonumb($n) { 
	if (!is_null($n)) {
		$saida = preg_replace("/[^0-9]/", "",$n); 
		if (trim($saida)=='') {
			return NULL;
		} else {
			return $saida;
		}
	} else {
		return NULL;
	}
}

function sonumb_testa($n) { 
	if (!is_null($n)) {
		if (is_numeric(trim($n))) {
			return $n;
		} else {
			return NULL;
		}
	} else {
		return NULL;
	}
}
function calculacubico($vol,$calculo) {
	if ($vol>0 && $calculo<>'') {
		$string = '$resultado ='. $calculo.';';
		@eval($string);
	} else {
		$resultado = $vol;
	}
	return $resultado;
}

function cmdx($a,$b) {
	global $tipodamedidadousort, $calculocubico;
	switch ($tipodamedidadousort) {
		case "peso" :
			$valor_a = $a['pes'];
			$valor_b = $b['pes'];
			break;

		case "cubico" :
			$valor_a = calculacubico($a['vol'],$calculocubico);
			$valor_b = calculacubico($b['vol'],$calculocubico);
			break;

		case "maior" :
			$valor_a = calculacubico($a['vol'],$calculocubico) > $a['pes'] ? calculacubico($a['vol'],$calculocubico) : $a['pes'];
			$valor_b = calculacubico($b['vol'],$calculocubico) > $b['pes'] ? calculacubico($b['vol'],$calculocubico) : $b['pes'];
			break;

		case "volume" :
			$valor_a = $a['vol'];
			$valor_b = $b['vol'];
			break;
	
	}
	if ($valor_a == $valor_b) {
		return 0;
    }
    return ($valor_a < $valor_b) ? -1 : 1;
}


function calcfretemulti ($cidade,$estado,$maiorprazo,$peso,$volume,$valortotal,$apro,$cep=NULL) {
	global $tipodamedidadousort, $calculocubico, $obj_sql, $rowloja;

	$transporta = array();

	//x uma transportadora pode nao enviar pra um certa regiao
	//- pode acontecer que um produto so pode ser enviado por uma transportadora
	//- os correios tem um limite de 30 kilos
	//- algumas transportadoras levam em consideraÁ„o o volume

	$traespe = array();
	$qtd_pro_traesp = 0;
	$aprobkp = $apro;
	foreach ($apro as $prochave => $dados) {
		$temp = trim(substr($dados['opc'],1,-1));
		$qtd_pro_traesp = str_replace(array("","-"),array("",""),$temp)<>'' ? $qtd_pro_traesp + 1 : $qtd_pro_traesp;
		$temp = explode("-",$temp);
		foreach ($temp as $tempval) {
			if ($tempval<>'') {
				$totaltra = $obj_sql->Get("select count(tra_id) from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_del<>'1' and tra_atuacao like '%|$estado%' and tra_id='$tempval'");
				if ($totaltra>0) {
					$totloc = $obj_sql->Get("SELECT count(loc_id) FROM ".TB_FRETE." WHERE loc_tra_id='$tempval' and ((loc_destino='".$cidade."' and loc_uf='".$estado."' and loc_tipo='1') or (loc_destino='".$estado."' and loc_uf='".$estado."' and loc_tipo='2'))");
					if ($totloc>0) {
						$traespe[$tempval]++;
					} else {
						$apro[$prochave]['opc']='';
					}
				} else {
					$apro[$prochave]['opc']='';
				}
			}
		}


		//meio que temporario para resolver o problema do frete gratis por produto, depois tem que ver como vai fazer pra colocar frete gratis por categoria, com isso nao podera apenas zerar o valor e o peso do produto
		if ($dados['gra']=='1') {
			$apro[$prochave]['pes'] = 0;
			$apro[$prochave]['vol'] = 0;
			$apro[$prochave]['val'] = 0;
		}

	}

	printsaida($traespe);

	$rowloja = $obj_sql->Get_Array("SELECT * FROM ".TB_LOJA);

	// tipo de frete unico mas com 1 ou mais transportadoras, pois os produtos tinham transportadoras especificas
	if (count($traespe)>0) {
		if (count($traespe)==1) {
			printsaida("UMA TRANSPORTADORA");
		} else {
			printsaida("UM FRETE VARIAS TRANSPORTADORA");
		}

		printsaida($apro);

		printsaida($qtd_pro_traesp);

		if (count($apro)>1 && $qtd_pro_traesp>1) {
			printsaida("VARIOS PRODUTOS, CHAMA OUTRA FUNCAO");

			return calcfrete ($cidade,$estado,$maiorprazo,$peso,$volume,$valortotal,$aprobkp);

		} else {
			printsaida("UM PRODUTO OU VARIOS PRODUTOS MAS APENAS 1 COM TRANSPORTADORAS ESPECIFICAS");


			$observacoes = '';
			foreach ($traespe as $traid => $temp) {
				$rowt = $obj_sql->Get_Array("select * from ".TB_TRANSPORTADORA." where tra_id='$traid'");

				$tipodamedidadousort = $rowt['tra_tipo'];
				$calculocubico = $rowt['tra_calculo'];
				usort($apro,"cmdx");
				$totalprazo = 0;
				$totalfrete = 0;
				$observacoes = "Transportadora"."<br>".$rowt['tra_id'].' - '.$rowt['tra_nome']."<br>";
				$cancelatra = '0';
				$tmedida = 0;
				$tvalor = 0;
				$afre = array();
				$listapro = '';
				$wp = 0;
				printsaida($apro);

				$tempro = $apro;
				$napro = $apro;
				foreach ($tempro as $prochave => $dados) {

					if ($dados['opc']<>'' && strpos($dados['opc'],'-'.$traid.'-')===false) {
						printsaida("transp nao esta na lista");
						continue;
					}

					switch ($rowt['tra_tipo']) {
						case "peso" :
							if ($dados['pes'] > $rowt['tra_limite']) {
								printsaida('medida unitaria maior que o limite peso: '.$traid);
								$cancelatra = '1';
								break 2;
							}
							if ($tmedida + $dados['pes'] >$rowt['tra_limite']) {
								$afre[$wp]['valor'] = $tvalor;
								$afre[$wp]['medida'] = $tmedida;
								$afre[$wp]['listap'] = substr($listapro,2);
								$afre[$wp]['tipome'] = $rowt['tra_tipo'];
								$tmedida = 0;
								$tvalor = 0;
								$listapro = '';
								$wp++;
							}
							$tmedida += $dados['pes'];
							$tvalor += $dados['val'];
							$listapro .= ', '.$dados['idp'];
							break;

						case "cubico" :
							$cubicototal = calculacubico($dados['vol'],$rowt['tra_calculo']);
							if ($cubicototal > $rowt['tra_limite']) {
								printsaida('medida unitaria maior que o limite cubico: '.$traid);
								$cancelatra = '1';
								break 2;
							}
							if ($tmedida + $cubicototal >$rowt['tra_limite']) {
								$afre[$wp]['valor'] = $tvalor;
								$afre[$wp]['medida'] = $tmedida;
								$afre[$wp]['listap'] = substr($listapro,2);
								$afre[$wp]['tipome'] = $rowt['tra_tipo'];
								$tvalor = 0;
								$tmedida = 0;
								$listapro = '';
								$wp++;
							}
							$tmedida += $cubicototal;
							$tvalor += $dados['val'];
							$listapro .= ', '.$dados['idp'];
							
							break;

						case "maior" :
							$cubicototal = calculacubico($dados['vol'],$rowt['tra_calculo']);
							if ($cubicototal>$dados['pes']) {
								$valortemp = $cubicototal;
							} else {
								$valortemp = $dados['pes'];
							}
							if ($valortemp > $rowt['tra_limite']) {
								printsaida($valortemp.'-'.$rowt['tra_limite']);
								printsaida('medida unitaria maior que o limite maior: '.$traid);
								$cancelatra = '1';
								break 2;
							}

							if ($tmedida + $valortemp >$rowt['tra_limite']) {
								$afre[$wp]['valor'] = $tvalor;
								$afre[$wp]['medida'] = $tmedida;
								$afre[$wp]['listap'] = substr($listapro,2);
								$afre[$wp]['tipome'] = $rowt['tra_tipo'];
								$tvalor = 0;
								$tmedida = 0;
								$listapro = '';
								$wp++;
							}
							$tmedida += $valortemp;
							$tvalor += $dados['val'];
							$listapro .= ', '.$dados['idp'];
							break;

						case "volume" :
							if ($dados['vol'] > $rowt['tra_limite']) {
								printsaida('medida unitaria maior que o limite volume: '.$traid);
								$cancelatra = '1';
								break 2;
							}

							if ($tmedida + $dados['vol'] >$rowt['tra_limite']) {
								$afre[$wp]['valor'] = $tvalor;
								$afre[$wp]['medida'] = $tmedida;
								$afre[$wp]['listap'] = substr($listapro,2);
								$afre[$wp]['tipome'] = $rowt['tra_tipo'];
								$tvalor = 0;
								$tmedida = 0;
								$listapro = '';
								$wp++;
							} 
							$tmedida += $dados['vol'];
							$tvalor += $dados['val'];
							$listapro .= ', '.$dados['idp'];
							break;
			
					}
					unset($npro[$prochave]);
				}
				if ($cancelatra=='1') {
					printsaida('limite nao deu, pega outra '.$traid);
					continue;
				}
				if ($tmedida>0 || $listapro<>'') {
					$afre[$wp]['valor'] = $tvalor;
					$afre[$wp]['medida'] = $tmedida;
					$afre[$wp]['listap'] = substr($listapro,2);
					$afre[$wp]['tipome'] = $rowt['tra_tipo'];
					$listapro = '';
				}
				$ctra++;



				printsaida('deu medida------------------------------------');

				printsaida($afre);
				printsaida('------------------------------------');

				$qidf = $obj_sql->Query("SELECT * FROM ".TB_FRETE." WHERE loc_tra_id='$traid' and ((loc_destino='".$cidade."' and loc_uf='".$estado."' and loc_tipo='1') or (loc_destino='".$estado."' and loc_uf='".$estado."' and loc_tipo='2')) ORDER BY loc_tipo ASC");

				$totalloca = $obj_sql->Num_Rows($qidf);
				if ($totalloca>0) {
					$rowf = $obj_sql->Fetch_Array($qidf);
				}

				$qidg = $obj_sql->Query("select * from ".TB_FRETEGRATIS." where fgr_tra_id like '%|".$traid."|%' and ((fgr_destino='".$cidade."' and fgr_uf='".$estado."' and fgr_tipo='1') or (fgr_destino like '%|".$estado."|%' and fgr_tipo='2') or (fgr_tipo='3')) ORDER BY fgr_tipo ASC limit 1");
				$fretegratis = '0';
				if ($obj_sql->Num_Rows($qidg)==1) {
					$rowg = $obj_sql->Fetch_Array($qidg);
					if ($valortotal>=$rowg['fgr_gratisacima']) {
						$fretegratis='1';
					}
				}

				foreach ($afre as $chafre => $posif) {

					if ($totalloca>0) {
						$prazoentrega = $rowf['loc_prazo']+$maiorprazo;
						printsaida($rowf['loc_fretegratis'].'|'.$valortotal.'|'.$rowf['loc_gratisacima']);

						if ($fretegratis=='1' || $posif['medida']==0) {
							$freteloja = 0;
							printsaida("Entrou frete gratis");
						} else {
							$freteinicial = tabelafrete($rowf['loc_id'],$posif['medida'],$posif['valor']);
							printsaida('frete: '.$freteinicial);
							if ($rowf['loc_txnota']<>0) {
								$txsobrevalornota = $posif['valor'] * ($rowf['loc_txnota']/100);
								$freteinicial += $txsobrevalornota;
								printsaida('valor gris: '.$txsobrevalornota);
								printsaida('mais gris: '.$freteinicial);
							}
							if ($rowf['loc_txtrf']<>0) {
								$txsobrevalornota = $posif['valor'] * ($rowf['loc_txtrf']/100);
								if ($txsobrevalornota<$rowf['loc_vlmintrf']) {
									$txsobrevalornota=$rowf['loc_vlmintrf'];
								}
								printsaida('taxa trf: '.$posif['valor'].'---'.($rowf['loc_txtrf']/100).'----'.$rowf['loc_vlmintrf'].'---'.$txsobrevalornota);

								$freteinicial += $txsobrevalornota;
							}
							printsaida('frete faixa + taxa sobre nota + trf: '.$freteinicial);

							if ($rowf['loc_vlnota']<>0) {
								$freteinicial += $rowf['loc_vlnota'];
								printsaida('mais valor fixo: '.$freteinicial);
							}
							if ($rowf['loc_txicms']<>0) {
								$freteinicial = $freteinicial / $rowf['loc_txicms'];
								printsaida('com icms: '.$freteinicial);
							}
							if ($rowf['loc_txfrete']<>0) {
								$txsobrevalorfrete = $freteinicial * ($rowf['loc_txfrete']/100);
								$freteinicial += $txsobrevalorfrete;
								printsaida('administracao: '.$freteinicial);
							}
							if ($freteinicial<$rowf['loc_vlminfrete']) {
								$freteinicial=$rowf['loc_vlminfrete'];
								printsaida('usou frete minimo: '.$freteinicial.'---'.$rowf['loc_vlminfrete']);
							}

							printsaida('final: '.$freteinicial);
							$freteloja = $freteinicial;

							//$freteloja = $freteloja>0 ? $freteloja : $rowloja['loj_frete'];
						}
					} else {
						$prazoentrega = $rowloja['loj_prazo'] + $maiorprazo;
						if ($fretegratis=='1') {
							$freteloja = 0;
						} else {
							$freteloja = $rowloja['loj_frete'];
						}
					}
					if ($totalprazo<$prazoentrega) {
						$totalprazo = $prazoentrega;
					}
					$totalfrete += $freteloja;
					$observacoes .= $posif['listap'].' > '.$posif['tipome'].'='.$posif['medida'].' > $ '.$freteloja."\n";
				}
				$observacoes .= 'Prazo = '.$totalprazo."<br>--------------------------<Br>";

				$retornarray[$ctra]['id'] = $rowt['tra_id'];
				$retornarray[$ctra]['nome'] = $rowt['tra_nome'];
				$retornarray[$ctra]['prazo'] = $totalprazo;
				$retornarray[$ctra]['valor'] = convertval($totalfrete,'guarani');
				$retornarray[$ctra]['obs'] = $observacoes;
				$retornarray[$ctra]['aviso'] = $rowt['tra_restricao'];

			}
		}

	} // finaliza tipo > 0
	// lista o valor com cada transportadora
	if (count($traespe)==0) {
		printsaida("LISTA TODAS");

		printsaida('estado '.$estado);

		$ctra = 0;
		$qidtra = $obj_sql->Query("select * from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_del<>'1' and tra_atuacao like '%|$estado%' order by tra_id");
		while ($rowt = $obj_sql->Fetch_Array($qidtra)) {
			$traid = $rowt['tra_id'];

			//if ($rowt['tra_tipocalc']=='tabela') {
				$totloc = $obj_sql->Get("SELECT count(loc_id) FROM ".TB_FRETE." WHERE loc_tra_id='$traid' and ((loc_destino='".$cidade."' and loc_uf='".$estado."' and loc_tipo='1') or (loc_destino='".$estado."' and loc_uf='".$estado."' and loc_tipo='2'))");
				printsaida('-------------------------------------------------------------trans '.$traid);
				if ($totloc==0) {
					printsaida('pulou');
					continue;
				}
			//}
			
			$tipodamedidadousort = $rowt['tra_tipo'];
			$calculocubico = $rowt['tra_calculo'];
			usort($apro,"cmdx");
			$totalprazo = 0;
			$totalfrete = 0;
			$observacoes = "Transportadora"."<br>".$rowt['tra_id'].' - '.$rowt['tra_nome']."<br>";
			$cancelatra = '0';
			$tmedida = 0;
			$tvalor = 0;
			$afre = array();
			$listapro = '';
			$wp = 0;
			printsaida($apro);

			$tempro = $apro;
			$napro = $apro;

			$comprimentopro = 0;
			$largurapro = 0;
			$alturapro = 0;
			$pesopro = 0;

			foreach ($tempro as $prochave => $dados) {

				$codpro = explode(".",$dados['idp']);
				$rowvol = $obj_sql->Get_Array("select * from ".TB_PRODUTO." where pro_id='".$codpro[0]."'");
				$base1 = $rowvol['pro_comprimento']>$rowvol['pro_largura'] ? $rowvol['pro_comprimento'] : $rowvol['pro_largura'];
				$base2 = $rowvol['pro_comprimento']>$rowvol['pro_largura'] ? $rowvol['pro_largura'] : $rowvol['pro_comprimento'];
				if ($comprimentopro<$base1) {
					$comprimentopro = $base1;
				}
				if ($largurapro<$base2) {
					$largurapro = $base2;
				}
				$alturapro += $rowvol['pro_altura'];
				$pesopro += $dados['pes'];



				switch ($rowt['tra_tipo']) {
					case "peso" :
						if ($dados['pes'] > $rowt['tra_limite']) {
							printsaida('medida unitaria maior que o limite peso: '.$traid);
							$cancelatra = '1';
							break 2;
						}
						if ($tmedida + $dados['pes'] >$rowt['tra_limite']) {
							$afre[$wp]['valor'] = $tvalor;
							$afre[$wp]['medida'] = $tmedida;
							$afre[$wp]['listap'] = substr($listapro,2);
							$afre[$wp]['tipome'] = $rowt['tra_tipo'];
							$tmedida = 0;
							$tvalor = 0;
							$listapro = '';
							$wp++;
						}
						$tmedida += $dados['pes'];
						$tvalor += $dados['val'];
						$listapro .= ', '.$dados['idp'];
						break;

					case "cubico" :
						$cubicototal = calculacubico($dados['vol'],$rowt['tra_calculo']);
						if ($cubicototal > $rowt['tra_limite']) {
							printsaida('medida unitaria maior que o limite cubico: '.$traid);
							$cancelatra = '1';
							break 2;
						}
						if ($tmedida + $cubicototal >$rowt['tra_limite']) {
							$afre[$wp]['valor'] = $tvalor;
							$afre[$wp]['medida'] = $tmedida;
							$afre[$wp]['listap'] = substr($listapro,2);
							$afre[$wp]['tipome'] = $rowt['tra_tipo'];
							$tvalor = 0;
							$tmedida = 0;
							$listapro = '';
							$wp++;
						}
						$tmedida += $cubicototal;
						$tvalor += $dados['val'];
						$listapro .= ', '.$dados['idp'];
						
						break;

					case "maior" :
						$cubicototal = calculacubico($dados['vol'],$rowt['tra_calculo']);
						if ($cubicototal>$dados['pes']) {
							$valortemp = $cubicototal;
						} else {
							$valortemp = $dados['pes'];
						}
						if ($valortemp > $rowt['tra_limite']) {
							printsaida($valortemp.'-'.$rowt['tra_limite']);
							printsaida('medida unitaria maior que o limite maior: '.$traid);
							$cancelatra = '1';
							break 2;
						}

						if ($tmedida + $valortemp >$rowt['tra_limite']) {
							$afre[$wp]['valor'] = $tvalor;
							$afre[$wp]['medida'] = $tmedida;
							$afre[$wp]['listap'] = substr($listapro,2);
							$afre[$wp]['tipome'] = $rowt['tra_tipo'];
							$tvalor = 0;
							$tmedida = 0;
							$listapro = '';
							$wp++;
						}
						$tmedida += $valortemp;
						$tvalor += $dados['val'];
						$listapro .= ', '.$dados['idp'];
						break;

					case "volume" :
						if ($dados['vol'] > $rowt['tra_limite']) {
							printsaida('medida unitaria maior que o limite volume: '.$traid);
							$cancelatra = '1';
							break 2;
						}

						if ($tmedida + $dados['vol'] >$rowt['tra_limite']) {
							$afre[$wp]['valor'] = $tvalor;
							$afre[$wp]['medida'] = $tmedida;
							$afre[$wp]['listap'] = substr($listapro,2);
							$afre[$wp]['tipome'] = $rowt['tra_tipo'];
							$tvalor = 0;
							$tmedida = 0;
							$listapro = '';
							$wp++;
						} 
						$tmedida += $dados['vol'];
						$tvalor += $dados['val'];
						$listapro .= ', '.$dados['idp'];
						break;
		
				}
				unset($npro[$prochave]);
			}
			if ($cancelatra=='1') {
				printsaida('limite nao deu, pega outra '.$traid);
				continue;
			}
			if ($tmedida>0 || $listapro<>'') {
				$afre[$wp]['valor'] = $tvalor;
				$afre[$wp]['medida'] = $tmedida;
				$afre[$wp]['listap'] = substr($listapro,2);
				$afre[$wp]['tipome'] = $rowt['tra_tipo'];
				$listapro = '';
			}
			$ctra++;



			printsaida('deu medida------------------------------------');

			printsaida($afre);
			printsaida('------------------------------------');

			$qidg = $obj_sql->Query("select * from ".TB_FRETEGRATIS." where fgr_tra_id like '%|".$traid."|%' and ((fgr_destino='".$cidade."' and fgr_uf='".$estado."' and fgr_tipo='1') or (fgr_destino like '%|".$estado."|%' and fgr_tipo='2') or (fgr_tipo='3')) ORDER BY fgr_tipo ASC limit 1");
			$fretegratis = '0';
			if ($obj_sql->Num_Rows($qidg)==1) {
				$rowg = $obj_sql->Fetch_Array($qidg);
				if ($valortotal>=$rowg['fgr_gratisacima']) {
					$fretegratis='1';
				}
			}

			if ($rowt['tra_tipocalc']=='webservice') {

				if ($rowt['tra_webservice']=='correios') {

					$nomeservicoscor = array('40010' => 'Correios - Sedex', '41106' => 'Correios - Pac', '81019' => 'Correios - e-Sedex', '41068' => 'Correios - Pac', '40096' => 'Correios - Sedex', '40169' => 'Correios - Sedex 12', '40215' => 'Correios - Sedex10', '41300' => 'Correios - Pac GF' );
					$servicosaida = array();
					$endereco = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazoData';
					$dadospost = array(
						"nCdEmpresa" => $rowt['tra_param1'],
						"sDsSenha" => $rowt['tra_param2'],
						"nCdServico" => $rowt['tra_param3'],
						"sCepOrigem" => apenasnumero($rowloja['loj_cep']),
						"sCepDestino" => apenasnumero($cep),
						"nVlPeso" => $pesopro,
						"nCdFormato" => '1',
						"nVlComprimento" => $comprimentopro>16 ? $comprimentopro : 16,
						"nVlAltura" => $altura>2 ? $altura : 2,
						"nVlLargura" => $largurapro>11 ? $largurapro : 11,
						"nVlDiametro" => '0',
						"sCdMaoPropria" => 'N',
						"nVlValorDeclarado" => '0',
						"sCdAvisoRecebimento" => 'N',
						"sDtCalculo" => date("d/m/Y")
					);
printsaida('correios');
					printsaida($dadospost);

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $endereco);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($dadospost));
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_TIMEOUT, 30);
					$retorno = curl_exec($ch);

					printsaida($retorno);

					$saida = simplexml_load_string($retorno,'SimpleXMLElement');
					printsaida($saida);

					foreach ($saida->Servicos->cServico as $dadoscor) {
						$codigocor = (string)$dadoscor->Codigo;
						if ($dadoscor->Erro=='0' || $dadoscor->Erro=='010') {
							$valor = (float)str_replace(",",".",$dadoscor->Valor);
							$valor = number_format($valor,2,'.','');
							$prazo = (int)$dadoscor->PrazoEntrega;
				
							$observacoes = "Transportadora"."<br>".$rowt['tra_id'].' - '.$rowt['tra_nome']."<br>";
							$observacoes .= '$ '.$valor."\n";
							$observacoes .= 'Prazo = '.$prazo."<br>--------------------------<Br>";
							$retornarray[$ctra]['id'] = $rowt['tra_id'];
							$retornarray[$ctra]['nome'] = $nomeservicoscor[$codigocor];
							$retornarray[$ctra]['prazo'] = $prazo + $maiorprazo;
							$retornarray[$ctra]['valor'] = $fretegratis=='1' ? 0 : $valor;
							$retornarray[$ctra]['obs'] = $observacoes;
							$retornarray[$ctra]['aviso'] = $rowt['tra_restricao'];
							$ctra++;
						}
					}

					printsaida($retornarray);

				}

				if ($rowt['tra_webservice']=='tnt') {

					$prazofinal = 0;
					$valorfinal = 0;
					foreach ($afre as $chafre => $posif) {

						$param = array(
							"cepDestino" => apenasnumero($cep),
							"cepOrigem" => apenasnumero($rowloja['loj_cep']),
							"psReal" => $posif['medida'],
							"vlMercadoria" => $posif['valor'],
							"cdDivisaoCliente" => $rowt['tra_param2'],
							"login" => $rowt['tra_param1'],
							"nrIdentifClienteDest" => '00000000000',
							"nrIdentifClienteRem" => $rowloja['loj_cnpj'],
							"nrInscricaoEstadualDestinatario" => '',
							"nrInscricaoEstadualRemetente" => $rowloja['loj_inscriestadual'],
							"senha" => '',
							"tpFrete" => 'C',
							"tpPessoaDestinatario" => 'F',
							"tpPessoaRemetente" => 'J',
							"tpServico" => 'RNC',
							"tpSituacaoTributariaDestinatario" => 'NC',
							"tpSituacaoTributariaRemetente" => $rowt['tra_param3']
						);
						
						
						$wsdl = "http://ws.tntbrasil.com.br/servicos/CalculoFrete?wsdl"; 

						try {
							$client = new soapClient($wsdl);
							$retcall = $client->calculaFrete(array('in0' => $param)); 
							$prazo = (int)$retcall->out->prazoEntrega;
							$valor = (float)$retcall->out->vlTotalFrete;
							
							$prazofinal = $prazo>$prazofinal ? $prazo : $prazofinal;
							$valorfinal += $valor;
					
						} catch (Exception $e) {

						}

					}
					if ($prazofinal>0) {
						$observacoes .= $posif['listap'].' > '.$posif['tipome'].'='.$posif['medida'].' > $ '.$valorfinal."\n";
						$observacoes .= 'Prazo = '.$prazofinal."<br>--------------------------<Br>";
						$retornarray[$ctra]['id'] = $rowt['tra_id'];
						$retornarray[$ctra]['nome'] = $rowt['tra_nome'];
						$retornarray[$ctra]['prazo'] = $prazofinal + $maiorprazo;
						$retornarray[$ctra]['valor'] = $fretegratis=='1' ? 0 : $valorfinal;
						$retornarray[$ctra]['obs'] = $observacoes;
						$retornarray[$ctra]['aviso'] = $rowt['tra_restricao'];
					}
				}



			} else {

				$qidf = $obj_sql->Query("SELECT * FROM ".TB_FRETE." WHERE loc_tra_id='$traid' and ((loc_destino='".$cidade."' and loc_uf='".$estado."' and loc_tipo='1') or (loc_destino='".$estado."' and loc_uf='".$estado."' and loc_tipo='2')) ORDER BY loc_tipo ASC");

				$totalloca = $obj_sql->Num_Rows($qidf);
				if ($totalloca>0) {
					$rowf = $obj_sql->Fetch_Array($qidf);
				}


				foreach ($afre as $chafre => $posif) {

					if ($totalloca>0) {
						$prazoentrega = $rowf['loc_prazo']+$maiorprazo;
						printsaida($rowf['loc_fretegratis'].'|'.$valortotal.'|'.$rowf['loc_gratisacima']);

						if ($fretegratis=='1' || $posif['medida']==0) {
							$freteloja = 0;
							printsaida("Entrou frete gratis");
						} else {
							$freteinicial = tabelafrete($rowf['loc_id'],$posif['medida'],$posif['valor']);
							printsaida('frete: '.$freteinicial);
							if ($rowf['loc_txnota']<>0) {
								$txsobrevalornota = $posif['valor'] * ($rowf['loc_txnota']/100);
								$freteinicial += $txsobrevalornota;
								printsaida('valor gris: '.$txsobrevalornota);
								printsaida('mais gris: '.$freteinicial);
							}
							if ($rowf['loc_txtrf']<>0) {
								$txsobrevalornota = $posif['valor'] * ($rowf['loc_txtrf']/100);
								if ($txsobrevalornota<$rowf['loc_vlmintrf']) {
									$txsobrevalornota=$rowf['loc_vlmintrf'];
								}
								printsaida('taxa trf: '.$posif['valor'].'---'.($rowf['loc_txtrf']/100).'----'.$rowf['loc_vlmintrf'].'---'.$txsobrevalornota);

								$freteinicial += $txsobrevalornota;
							}
							printsaida('frete faixa + taxa sobre nota + trf: '.$freteinicial);

							if ($rowf['loc_vlnota']<>0) {
								$freteinicial += $rowf['loc_vlnota'];
								printsaida('mais valor fixo: '.$freteinicial);
							}
							if ($rowf['loc_txicms']<>0) {
								$freteinicial = $freteinicial / $rowf['loc_txicms'];
								printsaida('com icms: '.$freteinicial);
							}
							if ($rowf['loc_txfrete']<>0) {
								$txsobrevalorfrete = $freteinicial * ($rowf['loc_txfrete']/100);
								$freteinicial += $txsobrevalorfrete;
								printsaida('administracao: '.$freteinicial);
							}
							if ($freteinicial<$rowf['loc_vlminfrete']) {
								$freteinicial=$rowf['loc_vlminfrete'];
								printsaida('usou frete minimo: '.$freteinicial.'---'.$rowf['loc_vlminfrete']);
							}

							printsaida('final: '.$freteinicial);
							$freteloja = $freteinicial;

							//$freteloja = $freteloja>0 ? $freteloja : $rowloja['loj_frete'];
						}
					} else {
						$prazoentrega = $rowloja['loj_prazo'] + $maiorprazo;
						if ($fretegratis=='1') {
							$freteloja = 0;
						} else {
							$freteloja = $rowloja['loj_frete'];
						}
					}
					if ($totalprazo<$prazoentrega) {
						$totalprazo = $prazoentrega;
					}
					$totalfrete += $freteloja;
					$observacoes .= $posif['listap'].' > '.$posif['tipome'].'='.$posif['medida'].' > $ '.$freteloja."\n";
				}
				$observacoes .= 'Prazo = '.$totalprazo."<br>--------------------------<Br>";
				$retornarray[$ctra]['id'] = $rowt['tra_id'];
				$retornarray[$ctra]['nome'] = $rowt['tra_nome'];
				$retornarray[$ctra]['prazo'] = $totalprazo;
				$retornarray[$ctra]['valor'] = convertval($totalfrete,'guarani');
				$retornarray[$ctra]['obs'] = $observacoes;
				$retornarray[$ctra]['aviso'] = $rowt['tra_restricao'];


			}

		}


	} // cada transportadora 
	
	printsaida($retornarray);

	return $retornarray;


}


function calcfrete ($cidade,$estado,$maiorprazo,$peso,$volume,$valortotal,$apro) {
	global $obj_sql,$psaida;
	$pro = $apro;
	printsaida($apro);
	$transporta = array();



	$maxatual_id = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_del<>'1' and tra_atuacao like '%|$estado%' order by tra_prioridade desc limit 1");
	
	printsaida("transportadora selecionada: ".$maxatual_id);
	
	$rowtra = $obj_sql->Get_Array("select * from ".TB_TRANSPORTADORA." where tra_id='$maxatual_id'");
	$pesototal = 0;
	$volumetotal = 0;
	for ($x=1 ; $x<=count($pro); $x++) {
		if ($pro[$x]['opc']=='') {
			$pesototal += $pro[$x]['pes'];
			$volumetotal += $pro[$x]['vol'];
		}
	}
	
	switch ($rowtra['tra_tipo']) {
		case "peso" :
			if ($pesototal>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_del<>'1' and tra_atuacao like '%|$estado%' and tra_limite>$pesototal order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;

		case "cubico" :
			$cubicototal = calculacubico($volumetotal,$rowtra['tra_calculo']);
			if ($cubicototal>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$cubicototal order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;

		case "maior" :
			$cubicototal = calculacubico($volumetotal,$rowtra['tra_calculo']);
			if ($cubicototal>$pesototal) {
				$valor = $cubicototal;
			} else {
				$valor = $pesototal;
			}
			if ($valor>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$valor order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;

		case "volume" :
			if ($volumetotal>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$volumetotal order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;
	}

	for ($x=1 ; $x<=count($pro); $x++) {
		if ($pro[$x]['opc']=='') {
			$pro[$x]['tra'] = "$maxatual_id";
			$pro[$x]['apr'] = "i";
			$transporta[$maxatual_id][]=$x;
		}
	}
	printsaida("Produtos");

	printsaida($pro);



	for ($p=1 ; $p<=count($pro); $p++) {
		if ($pro[$p]['opc']=='') {
			continue;
		}
		$ok = 0;
		$ite = explode('-',substr($pro[$p]['opc'],1,-1));
		$opcs = $pro[$p]['opc'];

		for ($x=1 ; $x<=count($pro); $x++) {
			if ($pro[$x]['tra']<>'') {
				$procu = '-'.$pro[$x]['tra'].'-';
				printsaida($opcs.'----'.$procu);
				if (strstr($opcs,$procu)!==false) {
					printsaida('acho');
					if (ehmaior($pro[$x]['tra'],$pro,$p)==false) {
						printsaida('pegou');
						$pro[$p]['tra'] = $pro[$x]['tra'];
						$pro[$p]['apr'] = 'a';
						$transporta[$pro[$p]['tra']][]=$p;
						$ok=1;
						break;
					}
				}
			}
		}
		if ($ok==1) {
			continue;
		}
		$maxatual_id = 0;
		$maxatual_va = 0;
		for ($w=0 ; $w<=count($ite)-1; $w++) {
			$procu = '-'.$ite[$w].'-';
			$contador = 0;
			for ($h=1 ; $h<=count($pro); $h++) {
				if ($pro[$h]['opc']=='') {
					continue;
				}
				$topcs = $pro[$h]['opc'];
				if (strstr($topcs,$procu)!==false) {
					$contador++;
				}
			}
			if ($contador>=$maxatual_va && ehmaior($ite[$w],$pro,$p)==false) {
				$maxatual_id = $ite[$w];
				$maxatual_va = $contador;
			}
			$menospior = $ite[$w];
		}
		if ($maxatual_id<>0) {
			$pro[$p]['tra'] = $maxatual_id;
		} else {
			printsaida("usou menos pior: ".$menospior);
			$pro[$p]['tra'] = $menospior;
		}
		$pro[$p]['apr'] = 'm';
		$transporta[$pro[$p]['tra']][]=$p;
	}



	printsaida("Produtos");

	printsaida($pro);

	$maxatual_id = 0;
	$maxatual_va = 0;
	foreach ($transporta as $chave => $valor) {
		$contador = count($valor);
		if ($contador>=$maxatual_va) {
			$maxatual_id = $chave;
			$maxatual_va = $contador;
		}
	}
	for ($x=1 ; $x<=count($pro); $x++) {
		if ($pro[$x]['opc']=='') {
			$key = array_search($x,$transporta[$pro[$x]['tra']]);
			unset($transporta[$pro[$x]['tra']][$key]);
			if (count($transporta[$pro[$x]['tra']])==0) {
				unset($transporta[$pro[$x]['tra']]);
			}
			printsaida('chave da transportadora: '.$key);
		}
	}

	printsaida("transportadora de maior numero: ".$maxatual_id);
	// verificar se o peso nao passou do limite da transportadora; 


	$rowtra = $obj_sql->Get_Array("select * from ".TB_TRANSPORTADORA." where tra_id='$maxatual_id'");

	$pesototal = 0;
	$volumetotal = 0;

	for ($x=1 ; $x<=count($pro); $x++) {
		if ($pro[$x]['opc']=='' || $pro[$x]['tra']==$maxatual_id) {
			$pesototal += $pro[$x]['pes'];
			$volumetotal += $pro[$x]['vol'];
		}
	}
	
	switch ($rowtra['tra_tipo']) {
		case "peso" :
			if ($pesototal>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$pesototal order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;

		case "cubico" :
			$cubicototal = calculacubico($volumetotal,$rowtra['tra_calculo']);
			if ($cubicototal>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$cubicototal order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;

		case "maior" :
			$cubicototal = calculacubico($volumetotal,$rowtra['tra_calculo']);
			if ($cubicototal>$pesototal) {
				$valor = $cubicototal;
			} else {
				$valor = $pesototal;
			}
			if ($valor>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$valor order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;

		case "volume" :
			if ($volumetotal>$rowtra['tra_limite']) {
				$temp = $obj_sql->Get("select tra_id from ".TB_TRANSPORTADORA." where tra_situacao='1' and tra_atuacao like '%|$estado%' and tra_del<>'1' and tra_limite>$volumetotal order by tra_prioridade desc limit 1");
				if ($temp) {
					$maxatual_id = $temp;
				}
			}
			break;
	}

	for ($x=1 ; $x<=count($pro); $x++) {
		if ($pro[$x]['opc']=='') {
			$pro[$x]['tra'] = "$maxatual_id";
			$pro[$x]['apr'] = "p";
			$transporta[$maxatual_id][]=$x;
		}
	}
	printsaida("Produtos");

	printsaida($pro);



	printsaida("transportadoras");

	printsaida($transporta);




	$cidade = strtolower($cidade);
	$estado = strtolower($estado);
	$totalprazo = 0;
	$totalfrete = 0;
	$observacoes = '';
	foreach ($transporta as $chave => $valor) {
		
		$rowt = $obj_sql->Get_Array("select * from ".TB_TRANSPORTADORA." where tra_id='$chave'");
		$observacoes .= "Transportadora"."<br>".$rowt['tra_id'].' - '.$rowt['tra_nome']."<br>";
		$qidf = $obj_sql->Query("SELECT * FROM ".TB_FRETE." WHERE loc_tra_id='$chave' and ((loc_destino='".$cidade."' and loc_uf='".$estado."' and loc_tipo='1') or (loc_destino='".$estado."' and loc_uf='".$estado."' and loc_tipo='2')) ORDER BY loc_tipo ASC");

		$rowloja = $obj_sql->Get_Array("SELECT * FROM ".TB_LOJA);
		$listaf = true;
		$tmedida = 0;
		$tvalor = 0;
		$afre = array();
		$listapro = '';
		$wp = 0;
		printsaida($valor);
		$valor = sortarray($valor,$rowt['tra_tipo'],$pro,$rowt['tra_calculo']);
		printsaida($valor);
		foreach ($valor as $prochave => $idproduto) {
			switch ($rowt['tra_tipo']) {
				case "peso" :
					if ($tmedida + $pro[$idproduto]['pes'] >$rowt['tra_limite']) {
						$afre[$wp]['valor'] = $tvalor;
						$afre[$wp]['medida'] = $tmedida;
						$afre[$wp]['listap'] = substr($listapro,2);
						$afre[$wp]['tipome'] = $rowt['tra_tipo'];
						$tmedida = 0;
						$tvalor = 0;
						$listapro = '';
						$wp++;
					}
					$tmedida += $pro[$idproduto]['pes'];
					$tvalor += $pro[$idproduto]['val'];
					$listapro .= ', '.$pro[$idproduto]['idp'];
					break;

				case "cubico" :
					$cubicototal = calculacubico($pro[$idproduto]['vol'],$rowt['tra_calculo']);
					if ($tmedida + $cubicototal >$rowt['tra_limite']) {
						$afre[$wp]['valor'] = $tvalor;
						$afre[$wp]['medida'] = $tmedida;
						$afre[$wp]['listap'] = substr($listapro,2);
						$afre[$wp]['tipome'] = $rowt['tra_tipo'];
						$tvalor = 0;
						$tmedida = 0;
						$listapro = '';
						$wp++;
					}
					$tmedida += $cubicototal;
					$tvalor += $pro[$idproduto]['val'];
					$listapro .= ', '.$pro[$idproduto]['idp'];
					
					break;

				case "maior" :
					$cubicototal = calculacubico($pro[$idproduto]['vol'],$rowt['tra_calculo']);
					if ($cubicototal>$pro[$idproduto]['pes']) {
						$valortemp = $cubicototal;
					} else {
						$valortemp = $pro[$idproduto]['pes'];
					}
					if ($tmedida + $valortemp >$rowt['tra_limite']) {
						$afre[$wp]['valor'] = $tvalor;
						$afre[$wp]['medida'] = $tmedida;
						$afre[$wp]['listap'] = substr($listapro,2);
						$afre[$wp]['tipome'] = $rowt['tra_tipo'];
						$tvalor = 0;
						$tmedida = 0;
						$listapro = '';
						$wp++;
					}
					$tmedida += $valortemp;
					$tvalor += $pro[$idproduto]['val'];
					$listapro .= ', '.$pro[$idproduto]['idp'];
					break;

				case "volume" :
					if ($tmedida + $pro[$idproduto]['vol'] >$rowt['tra_limite']) {
						$afre[$wp]['valor'] = $tvalor;
						$afre[$wp]['medida'] = $tmedida;
						$afre[$wp]['listap'] = substr($listapro,2);
						$afre[$wp]['tipome'] = $rowt['tra_tipo'];
						$tvalor = 0;
						$tmedida = 0;
						$listapro = '';
						$wp++;
					} 
					$tmedida += $pro[$idproduto]['vol'];
					$tvalor += $pro[$idproduto]['val'];
					$listapro .= ', '.$pro[$idproduto]['idp'];
					break;
	
			}
		}
		if ($tmedida>0) {
			$afre[$wp]['valor'] = $tvalor;
			$afre[$wp]['medida'] = $tmedida;
			$afre[$wp]['listap'] = substr($listapro,2);
			$afre[$wp]['tipome'] = $rowt['tra_tipo'];
			$listapro = '';
		}

		printsaida('È o que importa');
		printsaida($afre);
		$totalloca = mysql_num_rows($qidf);

		$qidg = $obj_sql->Query("select * from ".TB_FRETEGRATIS." where fgr_tra_id like '%|".$chave."|%' and ((fgr_destino='".$cidade."' and fgr_uf='".$estado."' and fgr_tipo='1') or (fgr_destino like '%|".$estado."|%' and fgr_tipo='2') or (fgr_tipo='3')) ORDER BY fgr_tipo ASC limit 1");
		$fretegratis = '0';
		if ($obj_sql->Num_Rows($qidg)==1) {
			$rowg = $obj_sql->Fetch_Array($qidg);
			if ($valortotal>=$rowg['fgr_gratisacima']) {
				$fretegratis='1';
			}
		}


		//print('totalloca'.$totalloca);
		if ($totalloca>0) {
			$rowf = $obj_sql->Fetch_Array($qidf);
		}
		foreach ($afre as $chafre => $posif) {

			if ($totalloca>0) {
				$prazoentrega = $rowf['loc_prazo']+$maiorprazo;
				printsaida($rowf['loc_fretegratis'].'|'.$valortotal.'|'.$rowf['loc_gratisacima']);

				if ($fretegratis=='1') {
					$freteloja = 0;
				} else {
					$freteinicial = tabelafrete($rowf['loc_id'],$posif['medida'],$posif['valor']);
					printsaida('frete: '.$freteinicial);
					if ($rowf['loc_txnota']<>0) {
						$txsobrevalornota = $posif['valor'] * ($rowf['loc_txnota']/100);
						$freteinicial += $txsobrevalornota;
						printsaida('mais gris: '.$freteinicial);
					}
					if ($rowf['loc_vlnota']<>0) {
						$freteinicial += $rowf['loc_vlnota'];
						printsaida('mais valor fixo: '.$freteinicial);
					}
					if ($rowf['loc_txicms']<>0) {
						$freteinicial = $freteinicial / $rowf['loc_txicms'];
						printsaida('com icms: '.$freteinicial);
					}
					if ($rowf['loc_txfrete']<>0) {
						$txsobrevalorfrete = $freteinicial * ($rowf['loc_txfrete']/100);
						$freteinicial += $txsobrevalorfrete;
						printsaida('administracao: '.freteinicial);
					}
					printsaida('final: '.freteinicial);
					$freteloja = $freteinicial;

					$freteloja = $freteloja>0 ? $freteloja : $rowloja['loj_frete'];
				}
			} else {
				$prazoentrega = $rowloja['loj_prazo'] + $maiorprazo;
				$freteloja = $rowloja['loj_frete'];
			}
			if ($totalprazo<$prazoentrega) {
				$totalprazo = $prazoentrega;
			}
			$totalfrete += $freteloja;
			$observacoes .= $posif['listap'].' > '.$posif['tipome'].'='.$posif['medida'].' > $ '.$freteloja."<br>";
		}
		$observacoes .= 'Prazo = '.$totalprazo."<Br>--------------------------<br>";
	}
	$retornarray[1]['id'] = $rowt['tra_id'];
	$retornarray[1]['nome'] = "Transportadora";
	$retornarray[1]['prazo'] = $totalprazo;
	$retornarray[1]['valor'] = convertval($totalfrete,'guarani');
	$retornarray[1]['obs'] = $observacoes;
	$retornarray[1]['aviso'] = $rowt['tra_restricao'];

	return $retornarray;
}


function sortarray($arent,$tipo,$apro,$calculo) {
	global $tipodamedidadousort,$arraydeprodutossort;
	$tipodamedidadousort = $tipo;
	$arraydeprodutossort = $apro;
	$calculocubico = $calculo;
	usort($arent,"cmd");
	return $arent;
}

function cmd($a,$b) {
	global $tipodamedidadousort,$arraydeprodutossort,$calculocubico;
	switch ($tipodamedidadousort) {
		case "peso" :
			$valor_a = $arraydeprodutossort[$a]['pes'];
			$valor_b = $arraydeprodutossort[$b]['pes'];
			break;

		case "cubico" :
			$valor_a = calculacubico($arraydeprodutossort[$a]['vol'],$calculocubico);
			$valor_b = calculacubico($arraydeprodutossort[$b]['vol'],$calculocubico);
			break;

		case "maior" :
			$valor_a = calculacubico($arraydeprodutossort[$a]['vol'],$calculocubico) > $arraydeprodutossort[$a]['pes'] ? calculacubico($arraydeprodutossort[$a]['vol'],$calculocubico) : $arraydeprodutossort[$a]['pes'];
			$valor_b = calculacubico($arraydeprodutossort[$b]['vol'],$calculocubico) > $arraydeprodutossort[$b]['pes'] ? calculacubico($arraydeprodutossort[$b]['vol'],$calculocubico) : $arraydeprodutossort[$b]['pes'];
			break;

		case "volume" :
			$valor_a = $arraydeprodutossort[$a]['vol'];
			$valor_b = $arraydeprodutossort[$b]['vol'];
			break;
	
	}
	if ($valor_a == $valor_b) {
		return 0;
    }
    return ($valor_a < $valor_b) ? -1 : 1;
}

function ehmaior($transp,$parray,$produ) {
	global $obj_sql;

	$peso += $parray[$produ]['pes'];
	$volume += $parray[$produ]['vol'];
	$cheio = false;
	for ($x=1 ; $x<=count($parray); $x++) {
		if ($parray[$x]['tra']==$transp) {
			$peso += $parray[$x]['pes'];
			$volume += $parray[$x]['vol'];
		}
	}
	printsaida('tra: '.$transp.' peso total: '.$peso.' volume total: '.$volume);
	$rowtra = $obj_sql->Get_Array("select * from ".TB_TRANSPORTADORA." where tra_id='$transp'");
	switch ($rowtra['tra_tipo']) {
		case "peso" :
			if ($peso>$rowtra['tra_limite']) {
				$cheio = true;
			}
			printsaida(' tipo: peso');
			break;

		case "cubico" :
			$cubico = calculacubico($volume,$rowtra['tra_calculo']);
			if ($cubico>$rowtra['tra_limite']) {
				$cheio = true;
			}
			printsaida(' tipo: cubico');
			break;

		case "maior" :
			$cubico = calculacubico($volume,$rowtra['tra_calculo']);
			if ($cubico>$peso) {
				$valor = $cubico;
			} else {
				$valor = $peso;
			}
			if ($valor>$rowtra['tra_limite']) {
				$cheio = true;
			}
			printsaida(' tipo: maior');
			break;

		case "volume" :
			if ($volume>$rowtra['tra_limite']) {
				$cheio = true;
			}
			printsaida(' tipo: volume');
			break;
	}
	printsaida(' cheio: '.($cheio ? 'sim' : 'nao'));
	return $cheio;
}
function printsaida($saida) {
	global $psaida;
	if ($psaida) {
		print("<pre>");
		if (is_array($saida)) {
			var_dump($saida);
		} else {
			print($saida."\n");
		}
		print("</pre>");
	}
}


function tabelafrete($idloc,$peso,$valornota) {
    global $obj_sql;
	$qidCad = mysql_query("SELECT * FROM ".TB_TABELAFRETE." WHERE pva_loc_id='".$idloc."' ORDER BY pva_peso ASC");
	$valor = 0;
	while ($rowCad = mysql_fetch_array($qidCad)) {
		if ($rowCad['pva_peso']>=$peso) {
			if ($rowCad['pva_tipo']=='1') {
				$valor = $rowCad['pva_valor'];
			}

			if ($rowCad['pva_tipo']=='2') {
				$pcnota = $valornota * ($rowCad['pva_percent']/100); 
				$valor = $pcnota > $rowCad['pva_valor'] ? $pcnota : $rowCad['pva_valor'];
			}

			if ($rowCad['pva_tipo']=='3') {
				$pcnota = $valornota * ($rowCad['pva_percent']/100); 
				$valor = $rowCad['pva_valor'] + $pcnota;
			}

			if ($rowCad['pva_tipo']=='4') {
				$valorpeso = $rowCad['pva_valor'] * $peso; 
				$pcnota = $valornota * ($rowCad['pva_percent']/100); 
				$valor = $valorpeso + $pcnota;
			}
			if ($rowCad['pva_tipo']=='5') {
				$rowfreteini = $obj_sql->Get_Array("SELECT * FROM ".TB_TABELAFRETE." WHERE pva_loc_id='".$idloc."' and pva_tipo not in (4,5) order by pva_peso desc limit 1");

				$valorpeso = ($rowCad['pva_valor'] * ($peso-$rowfreteini['pva_peso']))+$rowfreteini['pva_valor']; 
				$pcnota = $valornota * ($rowCad['pva_percent']/100); 
				$valor = $valorpeso + $pcnota;
			}

			return $valor;
		}
	}
}

function retcubicopro($pro_id) {
	global $obj_sql;
	$total = $obj_sql->Get("select pro_altura*pro_comprimento*pro_largura as total from ".TB_PRODUTO." where pro_id='$pro_id'");
	return $total;
}

function pnome($nome) {
	$temp = explode(" ",$nome);
	return $temp[0];
}


function retreferencia($idfor,$idpro) {
	global $obj_sql;
	$for_nome = $obj_sql->Get("select for_nome from ".TB_FORNECEDOR." where for_id='$idfor'");
	$temp = explode(" ",$for_nome);
	if (count($temp)>=2) {
		$refini = substr($temp[0],0,1);
		$refini .= substr($temp[1],0,1);
	} else {
		$refini = substr($for_nome,0,2);
	}
	$refini = strtoupper($refini);
	return $refini.zerofill($idpro,5).$idfor.'-'.calmod11($idpro.$idfor);
}

function encontrapai($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai from ".TB_CATEGORIA." where cat_id='$catid'");
	$valor = $row['cat_id'];
	if ($row['cat_idpai']<>0) {
		$valor = encontrapai($row['cat_idpai']);
	}
	return $valor;
}

function caminhocat($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai,cat_nome from ".TB_CATEGORIA." where cat_id='$catid'");
	$valor = $row['cat_id'];
	if ($row['cat_idpai']<>0) {
		$oi = caminhocat($row['cat_idpai']);
		$valor = $oi[0];
		$texto = $oi[1];
	}
	$novotexto = $texto.' > '.$row['cat_nome'];
	return array($valor,$novotexto);
}

function caminhocatnome($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai,cat_nome from ".TB_CATEGORIA." where cat_id='$catid'");
	$valor = $row['cat_id'];
	$texto = '';
	if ($row['cat_idpai']<>0) {
		$texto = caminhocatnome($row['cat_idpai']);
	}
	$novotexto = $texto.'|'.$row['cat_nome'];
	return $novotexto;
}
function caminhocatnomeid($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai,cat_nome from ".TB_CATEGORIA." where cat_id='$catid'");
	$valor = $row['cat_id'];
	if ($row['cat_idpai']<>0) {
		$texto = caminhocatnomeid($row['cat_idpai']);
	}
	$novotexto = $texto.'|'.$valor.'-'.$row['cat_nome'];
	return $novotexto;
}

function caminhocatnomelink($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai,cat_nome from ".TB_CATEGORIA." where cat_id='$catid'");
	$valor = $row['cat_id'];
	if ($row['cat_idpai']<>0) {
		$texto = caminhocatnome($row['cat_idpai']);
	}
	$novotexto = $texto.'|'.$row['cat_nome'];
	return $novotexto;
}


function caminhocatcod($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai from ".TB_CATEGORIA." where cat_id='$catid'");
	$valor = $row['cat_id'];
	if ($row['cat_idpai']<>0) {
		$texto = caminhocatcod($row['cat_idpai']);
	}
	$novotexto = $texto.'|'.$row['cat_id'];
	return $novotexto;
}

function caminhocatcodgoogle($catid) {
	global $obj_sql;
	$row = $obj_sql->Get_Array("select cat_id,cat_idpai,gca_id from ".TB_CATEGORIA." where cat_id='$catid'");
	if ($row['cat_idpai']<>0) {
		$texto = caminhocatcodgoogle($row['cat_idpai']);
	}
	$novotexto = $texto.'|'.$row['gca_id'];
	return $novotexto;
}

function listacatesql($catid) {
	if ($catid==-1) {
		$catid = 0;
	}
	$saida = '"'.$catid.'"';
	$dados = recategoria($catid,0);
	foreach ($dados as $chave => $valor) {
		$saida .= ',"'.$valor['cat_id'].'"';
	}
	return $saida;
}

function listacatesqlespecial($catid) {
	if ($catid==-1) {
		$catid = 0;
	}
	$saida = '"'.$catid.'"';
	$dados = recategoria($catid,0);
	$maximo = 0;
	foreach ($dados as $chave => $valor) {
		$maximo = $maximo < $valor['cat_nivel'] ? $valor['cat_nivel'] : $maximo;
		$saida .= ',"'.$valor['cat_id'].'"';
	}
	return array("itens" => $saida, "maximo" => $maximo);
}


function recategoria($idpai,$nxent) {
	$qid = mysql_query("SELECT * FROM ".TB_CATEGORIA." where cat_idpai='$idpai' and cat_del<>'1' order by cat_id asc");
	$retorno = array();
	$nxent ++;
	$nivel = $nxent;
	while ($row = mysql_fetch_array($qid)) {
		$retorno[] = array("cat_id" => $row['cat_id'],"cat_nivel" => $nxent,"cat_nome" => $row['cat_nome'],"cat_del"=>$row['cat_del'], "cat_mostra" => "1");

		$retorno = array_merge($retorno,recategoria($row['cat_id'],$nxent));
		$nxent = $nivel;
	}
	return $retorno;
}

function recategoriatodos($idpai,$nxent) {
	$qid = mysql_query("SELECT * FROM ".TB_CATEGORIA." where cat_idpai='$idpai' order by cat_id asc");
	$retorno = array();
	$nxent ++;
	$nivel = $nxent;
	while ($row = mysql_fetch_array($qid)) {
		$retorno[] = array("cat_id" => $row['cat_id'],"cat_nivel" => $nxent,"cat_nome" => $row['cat_nome'], "cat_cara_1" => $row['cat_cara_1'], "cat_cara_2" => $row['cat_cara_2'],"cat_del"=>$row['cat_del'], "cat_mostra" => "1","cat_fixo" => $row['cat_fixo']);

		$retorno = array_merge($retorno,recategoriatodos($row['cat_id'],$nxent));
		$nxent = $nivel;
	}
	return $retorno;
}

function retornacatspro($pro_id) {
	global $obj_sql;
	$qidcc = $obj_sql->Query("select cat_id from ".TB_PRODUTO_CATEGORIA." where pro_id='$pro_id'");
	$arraysaida = array();
	while ($rowcc = $obj_sql->Fetch_Array($qidcc)) {
		$arraysaida[] = $rowcc['cat_id'];
	}
	return $arraysaida;
}

function listacateinc($catid) {
	if ($catid==-1) {
		$catid = 0;
	}
	$saida = array($catid);
	$dados = recategoria($catid,0);
	foreach ($dados as $chave => $valor) {
		$saida[] = $valor['cat_id'];
	}
	return $saida;
}


function gerarTid($codafilia,$codpgto) {
	if (strlen($codafilia)<>10) {
		return false;
	}
	if (strlen($codpgto)<>4) {
		return false;
	}
	$lastano = substr(date("Y"),3,1);
	$shopid = substr($codafilia,4,5);
	$juliana = zerofill(date("z")+1,3);
	$hora = date("His");
	$decimo = substr(microtime(),2,1);

	return $shopid.$lastano.$juliana.$hora.$decimo.$codpgto;
}

function retajuda($idpai,$nxent,$param='') {
	$qid = mysql_query("SELECT * FROM ".TB_TOPICOS." where top_idpai='$idpai' order by top_nome asc");
	$retorno = array();
	$nxent ++;
	$nivel = $nxent;
	while ($row = mysql_fetch_array($qid)) {

		$retorno[] = array("top_id" => $row['top_id'],"top_nivel" => $nxent,"top_nome" => $row['top_nome'], "top_mostra" => "1", "aju_id" => $retajuda);
		$retorno = array_merge($retorno,retajuda($row['top_id'],$nxent));
		$nxent = $nivel;
		$retajuda=NULL;
	}
	return $retorno;
}


function retparamebusca() {
	$saida = '';
//	var_dump($_POST);
	foreach ($_GET as $chave => $valor) {
		if (substr($chave,0,3)=='qy_' && $valor<>'') {
			$saida .= '<strong>'.substr($chave,3,strlen($chave)-3).'</strong>: '.$valor.', ';
		}
	}
	foreach ($_POST as $chave => $valor) {
		if (substr($chave,0,3)=='qy_' && $valor<>'') {
			$saida .= '<strong>'.substr($chave,3,strlen($chave)-3).'</strong>: '.$valor.', ';
		}
	}
	if ($saida<>'') {
		$saida = '  '.substr($saida,0,-2);
	}
	return $saida;
}


function parcelas($valor,$minimo,$parcelas,$totparcela=1) {
	$parcelamento['tparcelas'] = @floor($valor/$minimo)< 1 ? 1 : @floor($valor/$minimo);

	if($parcelamento['tparcelas'] >= $totparcela) {
		$parcelamento['fparcelas'] = $totparcela;
	} else {
		$parcelamento['fparcelas'] = $parcelamento['tparcelas'];
	}
	
	if ($parcelamento['tparcelas'] >= $parcelas) {
		$parcelamento['tparcelas'] = $parcelas;
	}
	if($parcelamento['tparcelas'] >= $parcelamento['fparcelas']) {
		$parcelamento['tparcelas'] = $parcelamento['fparcelas'];
	}

	$parcelamento['vparcelas'] = $parcelamento['tparcelas']>0 ? $valor/$parcelamento['tparcelas'] : $valor;
	

	return $parcelamento;
}

function desconto($preco,$valordesconto) {
	$total = ($preco-$valordesconto); 
	return $total;
}

function retusernome($username) {
  $qii = mysql_query("select usu_login,usu_nome from usuario where usu_login='$username'");
  $roi = mysql_fetch_array($qii);
  return $roi['usu_login'].' - '.$roi['usu_nome'];
}

function dolar($oque) {
	$qii = mysql_query("select * from geral order by ge_dolardata desc limit 1");
	$roi = mysql_fetch_array($qii);
	if($oque=='data') {
		return retdata($roi['ge_dolardata']);
	} else if($oque=='valor') {
		return $roi['ge_dolar'];
	}
}

function findsta ($texto) {
  if (strpos($texto,'|'.$_SESSION["USER"]["usu_login"].'-')===false) {
	  return false;
  } else {
	  return true;
  }
}

function retornaopc($tipo,$valor1,$valor2) {
	global $convidade;
	$saida = '';
		if (trim($valor1)<>'') {
			if (trim($valor1)<>trim($valor1) && trim($valor2)<>'') {
				$saida = $valor1;
				$saida .= ' a ';
				$saida .= $valor2;
			} else {
				$saida = $valor1;
			}
		}

	return $saida;
}

function vinculo($campo,$valor,$base) {
	$qid = mysql_query("select ".$campo." from ".$base." where ".$campo."='".$valor."' limit 1");
	if (mysql_num_rows($qid)>0) {
		return false;
	} else {
		return true;
	}
}
function tiraASPA($var) { return eregi_replace ("(\"|\')", "", $var); }

function tiraEsp($s) { 
	return preg_replace("/[^0-9a-zA-Z\| -]/", "",$s);
}

function apenasletrasnumeros($s) { 
	return preg_replace("/[^0-9a-zA-Z -]/", "",$s);
}
function apenasletrasnumerosx($s) { 
	return preg_replace("/[^0-9a-zA-Z]/", "",$s);
}

function apenasnumero($s) {
	return preg_replace("/[^0-9]/", "",$s);
}
function letranumero($str) {
    return tiraEsp(strtr($str,"‡·‚„ÁÈÍÌÛÙı¸˙¿¡¬√«… Õ”‘’‹⁄","aaaaceeiooouuAAAACEEIOOOUU"));
}
function letranumlimpomin($str) {
	return apenasletrasnumerosx(lower(letranumero($str)));
}

function linktexto($str) { 
    return str_replace(array("%7C","+"),array("/","-"),urlencode(tiraEsp(ucwords(strtr($str,"-‡·‚„ÁÈÍÌÛÙı¸˙¿¡¬√«… Õ”‘’‹⁄"," aaaaceeiooouuAAAACEEIOOOUU"))))); 
}
function upper($str) { 
    return strtoupper(strtr($str,"‡·‚„ÁÈÍÌÛÙı¸˙","¿¡¬√«… Õ”‘’‹⁄")); 
}
function lower($str) { 
    return strtolower(strtr($str,"¿¡¬√«… Õ”‘’‹⁄","‡·‚„ÁÈÍÌÛÙı¸˙")); 
}

function validaemail($eMailAddress) {
	if (filter_var($eMailAddress, FILTER_VALIDATE_EMAIL)){
        return true;
    }
	return false;
}

function gerasenha() {
  $base = "abcdefghijklmnopqrstuvxywz0123456789";
  $rets = "";
  srand((double)microtime()*1000000); 
  for ($w=1;$w<=8;$w++) {
    $rets .= substr($base,rand(0,35),1);
  }
  return $rets;
}
function validaCPF($cpf){
	$soma = 0;
	for ($i = 0; $i < 9; $i++)
	{
		$soma += $cpf[$i]*(10-$i);
	}
        if ($soma == 0) return false;
	$soma = 11 - ($soma % 11);
	if ($soma > 9) $soma = 0;
	if ($cpf[9] != $soma)
	{
		return false;
	}

	$soma *= 2;
	for ($i = 0; $i < 9; $i++)
	{
		$soma += $cpf[$i]*(11-$i);
	}
	$soma = 11 - ($soma % 11);
	if ($soma > 9) $soma = 0;
	if ($cpf[10] != $soma)
	{
		return false;
	}
        return true;
}

function calmod11($num) {
	$base= 9;
	$fator = 2;
	$soma = "";
	for ($i = strlen($num); $i > 0; $i--) {
		$numeros[$i] = substr($num,$i-1,1);
		$parcial[$i] = $numeros[$i] * $fator;
		$soma    += $parcial[$i];
		if ($fator == $base) $fator = 1;
		$fator++;
	}
	$resto = $soma % 11;
	$digito = 11 - $resto;
	if (($digito == 1) or ($digito == 11) or ($digito == 10)){
		$digito = 1;
	}
	return $digito;
}

function validaCNPJ($cnpj)
{
	$soma = 0;
	for ($i = 0; $i < 12; $i++)
	{
		$soma += $cnpj[11-$i]*(2+($i % 8));
	}
        if ($soma == 0) return false;
        $soma = 11 - ($soma % 11);
	if ($soma > 9) $soma = 0;
	if ($cnpj[12] != $soma)
	{
		return false;
	}

	$soma *= 2;
	for ($i = 0; $i < 12; $i++)
	{
		$soma += $cnpj[11-$i]*(2+(($i+1) % 8));
	}
	$soma = 11 - ($soma % 11);
	if ($soma > 9) $soma = 0;
	if ($cnpj[13] != $soma)
	{
		return false;
	}
	return true;
}

function corrigeBarra($entrada) {
	if (substr($entrada,-1)=='/') {
		$entrada = substr($entrada,0,-1);
	}
	return $entrada;
}

function setdefault(&$var, $default="") {
	if (! isset($var)) {
		$var = $default;
	}
	return true;
}

function datashow($data,$sep) {
  $strp=explode(' ',$data);
  $stri=explode('-',$strp[0]);
  return $stri[2].$sep.$stri[1];
}

function retdata($data) {
	$stri=explode(' ',$data);
	$strd = explode("-",$stri[0]);
	if (count($strd)>=3 && $strd[0].$strd[1].$strd[2]<>'00000000') {
		return $strd[2].'/'.$strd[1].'/'.$strd[0];
	} else {
		return "";
	}
}

function rethora($data) {
	$stri=explode(' ',$data);
	return substr($stri[1],0,5);
}

function retdata2($data) {
  $stri=explode('/',$data);
  if (trim($stri[2])<>'' && trim($stri[1])<>'' && trim($stri[01])<>'') {
	  return $stri[2].'-'.$stri[1].'-'.$stri[0];
  } else {
	  return "";
  }
}

function validadata($data){
	$data = explode("/",$data);
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];

	return @checkdate($m,$d,$y);
}

function validadata2($data){
	$data = explode("-",$data);
	$d = $data[2];
	$m = $data[1];
	$y = $data[0];

	return @checkdate($m,$d,$y);
}

function retdatahora($data) {
	if ($data=='0000-00-00 00:00:00') {
		return '';
	} else {
		$stri = explode(' ',$data);
		$strd = explode("-",$stri[0]);
		return $strd[2].'/'.$strd[1].'/'.$strd[0].' - '.$stri[1];
	}
}

function retdatahorafc($data) {
	if ($data=='0000-00-00 00:00:00') {
		return '';
	} else {
		$stri = explode(' ',$data);
		$strd = explode("-",$stri[0]);
		return $strd[2].'/'.$strd[1].'/'.$strd[0].' '.$stri[1];
	}
}


function retdatahora2($data) {
	if ($data=='0000-00-00 00:00:00') {
		return '';
	} else {
		$stri = explode(' ',$data);
		$strd = explode("/",$stri[0]);
		return $strd[2].'-'.$strd[1].'-'.$strd[0].' '.$stri[1];
	}
}

function saimes($mex) {
 $mes[1]='Jan';
 $mes[2]='Fev';
 $mes[3]='Mar';
 $mes[4]='Abr';
 $mes[5]='Mai';
 $mes[6]='Jun';
 $mes[7]='Jul';
 $mes[8]='Ago';
 $mes[9]='Set';
 $mes[10]='Out';
 $mes[11]='Nov';
 $mes[12]='Dez';
 return $mes[$mex];  
}
function saisem($dse) {
  $sem[0] = "Dom";
  $sem[1] = "Seg";
  $sem[2] = "Ter";
  $sem[3] = "Qua";
  $sem[4] = "Qui";
  $sem[5] = "Sex";
  $sem[6] = "Sab";
  return $sem[$dse];
}
function retdatapx($data) {
  $sub=explode(' ',$data);
  $stri=explode('-',$sub[0]);
  $strh=explode(":",$sub[1]);
  $data = mktime(0,0,0,$stri[1],$stri[2],$stri[0]);
  $hoje = mktime(0,0,0,date("m"),date("d"),date("Y"));
  $ontem = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
  $amanha = mktime(0,0,0,date("m"),date("d")+1,date("Y"));

  if ($data==$hoje) {
	  $saida = "Hoje";
  } else if ($data==$ontem) {
	  $saida = "Ontem";
  } else if ($data==$amanha) {
	  $saida = "Amanh„";
  } else {
	  $saida = saisem(date("w",$data))." ".date("j",$data)." ".saimes(date("n",$data));
  }

  return $saida;
}
function retmktime($data) {
  $sub=explode(' ',$data);
  $stri=explode('-',$sub[0]);
  $strh=explode(":",$sub[1]);
  return mktime($strh[0],$strh[1],$strh[2],$stri[1],$stri[2],$stri[0]);
}

function datamaisdia($data,$dia) {
  $sub=explode(' ',$data);
  $stri=explode('-',$sub[0]);
  $data = mktime(0,0,0,$stri[1],$stri[2]+$dia,$stri[0]);
  return date("d/m/Y",$data);
}

function retdatap($data) {
  $sub=explode(' ',$data);
  $stri=explode('-',$sub[0]);
  $strh=explode(":",$sub[1]);
  $data = mktime(0,0,0,$stri[1],$stri[2],$stri[0]);
  $hoje = mktime(0,0,0,date("m"),date("d"),date("Y"));
  $ontem = mktime(0,0,0,date("m"),date("d")-1,date("Y"));
  $amanha = mktime(0,0,0,date("m"),date("d")+1,date("Y"));

  if ($data==$hoje) {
	  $saida = "Hoje";
  } else if ($data==$ontem) {
	  $saida = "Ontem";
  } else if ($data==$amanha) {
	  $saida = "Amanh„";
  } else {
	  $saida = saisem(date("w",$data))." ".date("j",$data)." ".saimes(date("n",$data));
  }

  return $saida." ‡s ".$strh[0].'h'.$strh[1];
}

function is_logged() {
	return isset($_SESSION["USER"]["usu_id"]);
}

function logged($irpara='/') {
  if (!isset($_SESSION['USER']['usu_id'])) {
    header("Location: /login?go=".tiraerrado($irpara));
    die;
  }
  return true;
}

function pagamento() {
  if (!isset($_SESSION["USER"]["usu_id"]) || $_SESSION["PAYMENT"]<>'1') {
    header("Location: /login?go=pagamento");
    die;
  }
  if ($_SESSION['CART']->itemcount()<1) {
	$_SESSION["PAYMENT"] = '';
    header("Location: /meu-carrinho");
    die;
  }
  return true;
}

function orcamento() {
  if (!isset($_SESSION["USER"]["usu_id"]) || $_SESSION["PAYMENT"]<>'1') {
    header("Location: /login?go=orcamento");
    die;
  }
  if ($_SESSION['CART']->itemcount()<1) {
	$_SESSION["PAYMENT"] = '';
    header("Location: /meu-carrinho");
    die;
  }
  return true;
}

function retfiltro($entrada,$procu) {
  if (strpos($entrada,$procu)===false) {
	  return false;
  } else {
	  return true;
  }
}


function retmes($posicao) {
 $mes['01']='Janeiro';
 $mes['02']='Fevereiro';
 $mes['03']='MarÁo';
 $mes['04']='Abril';
 $mes['05']='Maio';
 $mes['06']='Junho';
 $mes['07']='Julho';
 $mes['08']='Agosto';
 $mes['09']='Setembro';
 $mes['10']='Outubro';
 $mes['11']='Novembro';
 $mes['12']='Dezembro';
 return $mes[$posicao];
}

function diahoje () {
	$mesn = date("m");
	$dia = date("d");
	$ano = date("Y");
	$sem = date("w");
	$sema[0] = "Domigo";
	$sema[1] = "Segunda-feira";
	$sema[2] = "TerÁa-feira";
	$sema[3] = "Quarta-feira";
	$sema[4] = "Quinta-feira";
	$sema[5] = "Sexta-feira";
	$sema[6] = "S·bado";
	return saisem($sem).', '.$dia.' de '.retmes($mesn).' de '.$ano;
}
function retdataextenso($data) {
	$valor = retmktime($data.' 00:00:00');
	$mesn = date("m",$valor);
	$dia = date("d",$valor);
	$ano = date("Y",$valor);
	$sem = date("w",$valor);
	$sema[0] = "Domigo";
	$sema[1] = "Segunda-feira";
	$sema[2] = "TerÁa-feira";
	$sema[3] = "Quarta-feira";
	$sema[4] = "Quinta-feira";
	$sema[5] = "Sexta-feira";
	$sema[6] = "S·bado";
	return $sema[$sem].', '.$dia.' de '.retmes($mesn).' de '.$ano;
}


function tiraerrado($valor) {
	return str_replace("&","%26",$valor);
}

function verify_login($username, $password) {
	global $CFG;
	$qid = mysql_query("SELECT * FROM cadastros WHERE cad_email = '$username' AND cad_senha = '".$password."' AND cad_ativo='1'");
	return mysql_fetch_array($qid);
}


function zerofill($valo,$ncara) {
  return @str_repeat("0",$ncara-strlen(trim($valo))).trim($valo);
}

function zerofinal($valo,$ncara) {
  return trim($valo).@str_repeat("0",$ncara-strlen(trim($valo)));
}
function textofill($valo,$ncara) {
  return trim($valo).@str_repeat(" ",$ncara-strlen(trim($valo)));
}

function textofillini($valo,$ncara) {
  return @str_repeat(" ",$ncara-strlen(trim($valo))).trim($valo);
}

function tiraHTML($variavel) { 
	$saida = ereg_replace("<([^>]+)>", "", $variavel);
	return($saida);
}

function retpermi($procu) {
  if ($_SESSION["ADMIN"]["use_power"]=='1') {
	  return true;
  }
  if (strpos($_SESSION["ADMIN"]["use_permissao"],$procu)===false) {
	  return false;
  } else {
	  return true;
  }
}
function retpermi3($entrada,$procu) {
  if ($_SESSION["ADMIN"]["use_power"]=='1') {
	  return true;
  }
  if (strpos($entrada,$procu)===false) {
	  return false;
  } else {
	  return true;
  }
}
function retpermi4($entrada,$procu) {
  if (strpos($entrada,$procu)===false) {
	  return false;
  } else {
	  return true;
  }
}
function retpermi2($procu) {
  if ($_SESSION["ADMIN"]["use_power"]=='1') {
	  return true;
  }
  if (strpos($_SESSION["ADMIN"]["use_permissao"],$procu)===false) {
		include("_erro.php");
		include("_rodape.php");
		die;
  } else {
	  return true;
  }
}

function retpermipower() {
  if ($_SESSION["ADMIN"]["use_power"]=='1') {
	  return true;
  } else {
	  include("_erro.php");
	  include("_rodape.php");
	  die;
  }
}





function bserialize($data) {
	$second = '';
	foreach($data[2] as $key => $value) {
		$second .= '-'.$value;
	}
	$saida = $data[0].'|'.$data[1].'|'.substr($second,1);
    return $saida;
}

function bunserialize($serialized_data) {
	$saida = explode('|',$serialized_data);
	$saida[2] = explode('-',$saida[2]);
    return $saida;
}

function primeironome($nome) {
	$temp = explode(" ",$nome);
	return $temp[0];
}


function boa() {
	$hora = date("H");
	if($hora>=01 && $hora<=12) { $saida = 'Bom dia'; }
	else if($hora>12 && $hora <=18) { $saida = 'Boa tarde'; }
	else if($hora>18 && $hora <=24) { $saida = 'Boa noite'; }
	return $saida;
}
function readmail($username) {
	$qid = mysql_query("select usu_emailuser, usu_emailsenha from usuario where usu_login='$username'");
	$row = mysql_fetch_array($qid);
	if ($row['usu_emailuser']<>'' && $row['usu_emailsenha']<>'') {
		$server = explode("@",$row['usu_emailuser']);
		$server = "mail.".$server[1];
		$MAILSERVER="{".$server.":143/imap/notls}INBOX";
		$USER = $row['usu_emailuser'];
		$PW = $row['usu_emailsenha'];
		$mbox= @imap_open($MAILSERVER,$USER,$PW);
		$nmess = @imap_num_msg($mbox);
		imap_close($mbox);
	} else {
		$nmess = 0;
	}
	return $nmess;
}

function temevento() {
	$retorn = false;
	foreach($_SESSION['USER']['eventos'] as $key => $value) {
		if ($value>0) {
			$retorna = true;
			break;
		}
	}
	return $retorna;
}


function marcaopc($dados,$compara) {
	foreach ($compara as $key => $value) {
		if(strstr($dados,$value)) {
			$encontrou = 1;
		}
	}
	if($encontrou == 1) {
		return true;
	} else { 
		return false;
	} 
}

function prod_min($id,$nome,$valor=0) {
	if($id!='' && $nome!='') {
		$qidx = mysql_query("select * from produtos_fotos where fot_prod_id='$id' order by rand()");
		if (mysql_num_rows($qidx)>0) {
			$rowx = mysql_fetch_array($qidx);
			list($width, $height, $type, $attr) = getimagesize("arquivos/produtos/prod_".$rowx['fot_id']."_p.".$rowx['fot_ext']);
			$foto = '<img src="arquivos/produtos/prod_'.$rowx['fot_id'].'_p.'.$rowx['fot_ext'].'" width="'.$width.'" height="'.$height.'" />';
		} else {
			$foto = '<img src="/img/naodisponivelp.gif" width="100" height="100" />';
		}
		$saida = '<table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="95" align="center" valign="top">'.$foto.'</td>
              </tr>
              <tr>
                <td height="70" align="center" valign="top" style="padding:5px"><a href="produtos.php?act=view&id='.$id.'" class="lk_pro">'.$nome.'<br />
                  <font class="t_red">US$ '.number_format($valor,2,',','.').'</font></a></td>
              </tr>
              <tr>
                <td align="center"><a href="produtos.php?act=view&amp;id='.$id.'"><img src="/img/bot_detalhes.gif" width="54" height="18" border="0" /></a><a href="carrinho.php?act=add&amp;id='.$id.'"><img src="img/bot_comprar.gif" width="63" height="18" border="0" /></a></td>
              </tr>
          </table>';
		
	} else {
		$saida = 'ID em branco';
	}
	return $saida;
}


//******************* FUNCOES ADMIN *******************************************

function verify_logina($username, $password) {
	$qid = mysql_query("SELECT * FROM ".TB_USUARIO." WHERE use_login='".$username."' and use_senha='".md5($password)."' and use_del='0'");
	return mysql_fetch_array($qid);
}

function admin() {
  if (!isset($_SESSION["ADMIN"]["use_login"])) {
    header("Location: login.php");
    die;
  }
  return false;
}


function is_loggeda() {
	return isset($_SESSION["ADMIN"]["use_login"]);
}

function loggeda($irpara='index.php') {
  if (!isset($_SESSION['ADMIN']['use_login'])) {
    header("Location: login.php?go=".tiraerrado($irpara));
    die;
  }
  retpermi2($irpara);
  return false;
}

function busca_cep($cep) {
	global $CFG;
	if ($CFG->buscacep=='egondola') {
		$temp = __file_get_contents('http://www.egondola.com.br/cep/buscar.php?cep='.urlencode($cep).'&chave='.$CFG->chaveegondola);
		$resultado = (array)json_decode($temp);
		$resultado = array_map(utf8_decode, $resultado);

	} else if ($CFG->buscacep=='republica') {
		$resultado = __file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep).'&formato=query_string');
	} else if ($CFG->buscacep=='buscarcep') {
		$resultado = __file_get_contents('http://www.buscarcep.com.br/?cep='.urlencode($cep).'&formato=string&chave='.$CFG->chavebuscar);
	} else if ($CFG->buscacep=='byjg') {
		include_once("class.cepwebservice.php");
		$cepbyjg = new CepWebService();
		$info = $cepbyjg->setCep($cep)
						->setUser($CFG->byjg_usuario)
						->setPass($CFG->byjg_senha)
						->find();
		if (is_array($info) && count($info)>0) {
			$resultado['resultado'] = '1';
			$resultado['cidade'] = $info[2];
			$resultado['bairro'] = $info[1];
			$resultado['uf'] = upper($info[3]);
			$resultado['tipo_logradouro'] = '';
			$resultado['logradouro'] =$info[0];
		} else {
			$resultado = "&resultado=0&resultado_txt=Erro+ao+buscar+CEP"; 
		}
	}
	if (empty($resultado)) {
		$resultado = "&resultado=0&resultado_txt=Erro+ao+buscar+CEP"; 
	}
	if (!is_array($resultado)) {
		parse_str($resultado, $retorno);
	} else {
		$retorno = $resultado;
	}
	$retorno['cep']=$cep;

	return $retorno;
}

function apagarImagem($idimagem,$extensao,$prefixo,$diretorio) {

	if(file_exists($diretorio.$prefixo.'_'.$idimagem.'_p.'.$extensao)) 	{ unlink($diretorio.$prefixo.'_'.$idimagem.'_p.'.$extensao); }
	if(file_exists($diretorio.$prefixo.'_'.$idimagem.'_m.'.$extensao)) 	{ unlink($diretorio.$prefixo.'_'.$idimagem.'_m.'.$extensao); }
	if(file_exists($diretorio.$prefixo.'_'.$idimagem.'_g.'.$extensao)) 	{ unlink($diretorio.$prefixo.'_'.$idimagem.'_g.'.$extensao); }
}

function validarNumero($numero)	{

if (preg_match("/^\d+$/", $numero)) { return true; } 
else { return false; }

}


function __file_get_contents($paEndereco){

	$sessao_curl = curl_init();
	curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);
	
	curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

	//  CURLOPT_CONNECTTIMEOUT
	//  o tempo em segundos de espera para obter uma conex„o
	curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 10);

	//  CURLOPT_TIMEOUT
	//  o tempo m·ximo em segundos de espera para a execuÁ„o da requisiÁ„o (curl_exec)
	curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 40);

	//  CURLOPT_RETURNTRANSFER
	//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
	//  invÈs de imprimir o resultado na tela. Retorna FALSE se h· problemas na requisiÁ„o
	curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

	$resultado = curl_exec($sessao_curl);
	
	curl_close($sessao_curl);

	if ($resultado)
	{
		//print 'resultado'.$resultado;
		return $resultado;
	}
	else
	{
		print('--'.curl_error($sessao_curl).'---');
		return curl_error($sessao_curl);
	}
}

function httprequest($paEndereco, $paPost){

	$sessao_curl = curl_init();
	curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);
	
	curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

	//  CURLOPT_SSL_VERIFYPEER
	//  verifica a validade do certificado
	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
	//  CURLOPPT_SSL_VERIFYHOST
	//  verifica se a identidade do servidor bate com aquela informada no certificado
	//curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);

	//  CURLOPT_SSL_CAINFO
	//  informa a localizaÁ„o do certificado para verificaÁ„o com o peer
	curl_setopt($sessao_curl, CURLOPT_CAINFO, getcwd() . "/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
	curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 4);

	//  CURLOPT_CONNECTTIMEOUT
	//  o tempo em segundos de espera para obter uma conex„o
	curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 60);

	//  CURLOPT_TIMEOUT
	//  o tempo m·ximo em segundos de espera para a execuÁ„o da requisiÁ„o (curl_exec)
	curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 60);

	//  CURLOPT_RETURNTRANSFER
	//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
	//  invÈs de imprimir o resultado na tela. Retorna FALSE se h· problemas na requisiÁ„o
	curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($sessao_curl, CURLOPT_POST, true);
	curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost );

	$resultado = curl_exec($sessao_curl);
	
	curl_close($sessao_curl);

	if ($resultado)
	{
		//print 'resultado'.$resultado;
		return $resultado;
	}
	else
	{
		print('--'.curl_error($sessao_curl).'---');
		return curl_error($sessao_curl);
	}
}


function codigopro($interface,$posicao) {
	$codpro['pgto_visa']['v'] = '1';
	$codpro['pgto_visa']['l'] = '2';
	$codpro['pgto_visa']['a'] = '3';
	$codpro['pgto_mastercielo']['v'] = '4';
	$codpro['pgto_mastercielo']['l'] = '5';
	$codpro['pgto_mastercielo']['a'] = '6';
	$codpro['pgto_visanovo']['v'] = '1';
	$codpro['pgto_visanovo']['l'] = '2';
	$codpro['pgto_visanovo']['a'] = '3';
	$codpro['pgto_mastercielonovo']['v'] = '1';
	$codpro['pgto_mastercielonovo']['l'] = '2';
	$codpro['pgto_mastercielonovo']['a'] = '3';
	$codpro['pgto_elo']['v'] = '1';
	$codpro['pgto_elo']['l'] = '2';
	$codpro['pgto_elo']['a'] = '3';
	$codpro['pgto_dinersnovo']['v'] = '1';
	$codpro['pgto_dinersnovo']['l'] = '2';
	$codpro['pgto_dinersnovo']['a'] = '3';
	$codpro['pgto_amexnovo']['v'] = '1';
	$codpro['pgto_amexnovo']['l'] = '2';
	$codpro['pgto_amexnovo']['a'] = '3';
	$codpro['pgto_aura']['v'] = '1';
	$codpro['pgto_aura']['l'] = '2';
	$codpro['pgto_aura']['a'] = '3';
	
	if ($codpro[$interface][$posicao]<>'') {
		$saida = $codpro[$interface][$posicao];
	} else {
		$saida = "X";
	}
	return $saida;
}


function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
   
    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }
   
    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
   
    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
   
    // check if we have a number
    if ($version==null || $version=="") {$version="?";}
   
    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 

function retorna_array_palavras($qy) {
	$prep_simples = array("a", "ante", "apÛs", "atÈ", "com", "contra", "de", "desde", "em", "entre", "para", "per", "perante", "por", "sem", "sob", "sobre", "tr·s", "afora", "como", "conforme", "consoante", "durante", "exceto", "salvo", "segundo", "visto");
	
	$temp1 = letranumero($qy);
	$temp2 = explode (" ", $temp1);

	$saida = array_diff($temp2,$prep_simples);

	return $saida;
}

function is_valid_youtube($link) {
	if(preg_match('/youtube.com\\/watch\\?.*v=.*$/',$link)) {
		return true;
	} else {
		return false;
	}
}

function pega_id_youtube($link) {
	$endereco = $link.'&t=a';
	$expreg = '|v=(.*)&|si';
	$a = preg_match_all($expreg,$endereco,$saida,PREG_PATTERN_ORDER);
	$temp= explode("&",$saida[1][0]);
	$codigo = $temp[0];
	return $codigo;
}

function arranja_tamanhos($qidtam) {
	global $obj_sql;
	$saida = array();
	$x = 100;
	while ($rowtam = $obj_sql->Fetch_Array($qidtam)) {
		switch (strtolower($rowtam['opc_valor1'])) {
			case "p" : $saida[0] = 'P'; break;
			case "m" : $saida[1] = 'M'; break;
			case "g" : $saida[2] = 'G'; break;
			case "gg" : $saida[3] = 'GG'; break;
			case "ggg" : $saida[4] = 'GGG'; break;
			case "u" : $saida[5] = 'U'; break;
			case "1" : $saida[21] = '1'; break;
			case "2" : $saida[22] = '2'; break;
			case "3" : $saida[23] = '3'; break;
			case "4" : $saida[24] = '4'; break;
			case "5" : $saida[25] = '5'; break;
			case "6" : $saida[26] = '6'; break;
			case "7" : $saida[27] = '7'; break;
			case "8" : $saida[28] = '8'; break;
			case "9" : $saida[29] = '9'; break;
			case "10" : $saida[30] = '10'; break;
			case "11" : $saida[31] = '11'; break;
			case "12" : $saida[32] = '12'; break;
			case "13" : $saida[33] = '13'; break;
			case "14" : $saida[34] = '14'; break;
			case "15" : $saida[35] = '15'; break;
			case "16" : $saida[36] = '15'; break;
			case "17" : $saida[37] = '17'; break;
			case "18" : $saida[38] = '18'; break;
			case "19" : $saida[39] = '19'; break;
			case "20" : $saida[40] = '20'; break;
			case "21" : $saida[41] = '21'; break;
			case "22" : $saida[42] = '22'; break;
			case "23" : $saida[43] = '23'; break;
			case "24" : $saida[44] = '24'; break;
			case "25" : $saida[45] = '25'; break;
			case "26" : $saida[46] = '26'; break;
			case "27" : $saida[47] = '27'; break;
			case "28" : $saida[48] = '28'; break;
			case "29" : $saida[49] = '29'; break;
			case "30" : $saida[50] = '30'; break;
			case "31" : $saida[51] = '31'; break;
			case "32" : $saida[52] = '32'; break;
			case "33" : $saida[53] = '33'; break;
			case "34" : $saida[54] = '34'; break;
			case "35" : $saida[55] = '35'; break;
			case "36" : $saida[56] = '36'; break;
			case "37" : $saida[57] = '37'; break;
			case "38" : $saida[58] = '38'; break;
			case "39" : $saida[59] = '39'; break;
			case "40" : $saida[60] = '40'; break;
			case "41" : $saida[61] = '41'; break;
			case "42" : $saida[62] = '42'; break;
			case "43" : $saida[63] = '43'; break;
			case "44" : $saida[64] = '44'; break;
			case "45" : $saida[65] = '45'; break;
			case "46" : $saida[66] = '46'; break;
			case "47" : $saida[67] = '47'; break;
			case "48" : $saida[68] = '48'; break;
			case "49" : $saida[69] = '49'; break;
			case "50" : $saida[70] = '50'; break;
			case "51" : $saida[71] = '51'; break;
			case "52" : $saida[72] = '52'; break;
			case "53" : $saida[73] = '53'; break;
			case "54" : $saida[74] = '54'; break;
			case "55" : $saida[75] = '55'; break;
			default : $x++; $saida[$x] = strtoupper($rowtam['opc_valor1']); break;
		}
	}
	ksort($saida);
	return $saida;
}

function arranja_tamanhos_comid($qidtam) {
	global $obj_sql;
	$saida = array();
	$x = 100;
	while ($rowtam = $obj_sql->Fetch_Array($qidtam)) {
		switch (strtolower($rowtam['opc_valor1'])) {
			case "p" : $saida[0]['txt'] = 'P'; $saida[0]['dados'] = $rowtam; break;
			case "m" : $saida[1]['txt'] = 'M'; $saida[1]['dados'] = $rowtam; break;
			case "g" : $saida[2]['txt'] = 'G'; $saida[2]['dados'] = $rowtam; break;
			case "gg" : $saida[3]['txt'] = 'GG'; $saida[3]['dados'] = $rowtam; break;
			case "ggg" : $saida[4]['txt'] = 'GGG'; $saida[4]['dados'] = $rowtam; break;
			case "u" : $saida[5]['txt'] = 'U'; $saida[5]['dados'] = $rowtam; break;
			case "1" : $saida[21]['txt'] = '1'; $saida[21]['dados'] = $rowtam; break;
			case "2" : $saida[22]['txt'] = '2'; $saida[22]['dados'] = $rowtam; break;
			case "3" : $saida[23]['txt'] = '3'; $saida[23]['dados'] = $rowtam; break;
			case "3,5" : $saida[24]['txt'] = '3,5'; $saida[24]['dados'] = $rowtam; break;
			case "4" : $saida[25]['txt'] = '4'; $saida[25]['dados'] = $rowtam; break;
			case "4,5" : $saida[26]['txt'] = '4,5'; $saida[26]['dados'] = $rowtam; break;
			case "5" : $saida[27]['txt'] = '5'; $saida[27]['dados'] = $rowtam; break;
			case "5,5" : $saida[28]['txt'] = '5,5'; $saida[28]['dados'] = $rowtam; break;
			case "6" : $saida[29]['txt'] = '6'; $saida[29]['dados'] = $rowtam; break;
			case "6,5" : $saida[30]['txt'] = '6,5'; $saida[30]['dados'] = $rowtam; break;
			case "7" : $saida[31]['txt'] = '7'; $saida[31]['dados'] = $rowtam; break;
			case "7,5" : $saida[32]['txt'] = '7,5'; $saida[32]['dados'] = $rowtam; break;
			case "8" : $saida[33]['txt'] = '8'; $saida[33]['dados'] = $rowtam; break;
			case "8,5" : $saida[34]['txt'] = '8,5'; $saida[34]['dados'] = $rowtam; break;
			case "9" : $saida[35]['txt'] = '9'; $saida[35]['dados'] = $rowtam; break;
			case "9,5" : $saida[36]['txt'] = '9,5'; $saida[36]['dados'] = $rowtam; break;
			case "10" : $saida[37]['txt'] = '10'; $saida[37]['dados'] = $rowtam; break;
			case "10,5" : $saida[38]['txt'] = '10,5'; $saida[38]['dados'] = $rowtam; break;
			case "11" : $saida[39]['txt'] = '11'; $saida[39]['dados'] = $rowtam; break;
			case "11,5" : $saida[40]['txt'] = '11,5'; $saida[40]['dados'] = $rowtam; break;
			case "12" : $saida[41]['txt'] = '12'; $saida[41]['dados'] = $rowtam; break;
			case "12,5" : $saida[42]['txt'] = '12,5'; $saida[42]['dados'] = $rowtam; break;
			case "13" : $saida[43]['txt'] = '13'; $saida[43]['dados'] = $rowtam; break;
			case "13,5" : $saida[44]['txt'] = '13,5'; $saida[44]['dados'] = $rowtam; break;
			case "14" : $saida[45]['txt'] = '14'; $saida[45]['dados'] = $rowtam; break;
			case "14,5" : $saida[46]['txt'] = '14,5'; $saida[46]['dados'] = $rowtam; break;
			case "15" : $saida[47]['txt'] = '15'; $saida[47]['dados'] = $rowtam; break;
			case "15,5" : $saida[48]['txt'] = '15,5'; $saida[48]['dados'] = $rowtam; break;
			case "16" : $saida[49]['txt'] = '16'; $saida[49]['dados'] = $rowtam; break;
			case "16,5" : $saida[50]['txt'] = '16,5'; $saida[50]['dados'] = $rowtam; break;
			case "17" : $saida[51]['txt'] = '17'; $saida[51]['dados'] = $rowtam; break;
			case "17,5" : $saida[52]['txt'] = '17,5'; $saida[52]['dados'] = $rowtam; break;
			case "18" : $saida[53]['txt'] = '18'; $saida[53]['dados'] = $rowtam; break;
			case "19" : $saida[54]['txt'] = '19'; $saida[54]['dados'] = $rowtam; break;
			case "20" : $saida[55]['txt'] = '20'; $saida[55]['dados'] = $rowtam; break;
			case "21" : $saida[56]['txt'] = '21'; $saida[56]['dados'] = $rowtam; break;
			case "22" : $saida[57]['txt'] = '22'; $saida[57]['dados'] = $rowtam; break;
			case "23" : $saida[58]['txt'] = '23'; $saida[58]['dados'] = $rowtam; break;
			case "24" : $saida[59]['txt'] = '24'; $saida[59]['dados'] = $rowtam; break;
			case "25" : $saida[60]['txt'] = '25'; $saida[60]['dados'] = $rowtam; break;
			case "26" : $saida[61]['txt'] = '26'; $saida[61]['dados'] = $rowtam; break;
			case "27" : $saida[62]['txt'] = '27'; $saida[62]['dados'] = $rowtam; break;
			case "28" : $saida[63]['txt'] = '28'; $saida[63]['dados'] = $rowtam; break;
			case "29" : $saida[64]['txt'] = '29'; $saida[64]['dados'] = $rowtam; break;
			case "30" : $saida[65]['txt'] = '30'; $saida[65]['dados'] = $rowtam; break;
			case "31" : $saida[66]['txt'] = '31'; $saida[66]['dados'] = $rowtam; break;
			case "32" : $saida[67]['txt'] = '32'; $saida[67]['dados'] = $rowtam; break;
			case "33" : $saida[68]['txt'] = '33'; $saida[68]['dados'] = $rowtam; break;
			case "34" : $saida[69]['txt'] = '34'; $saida[69]['dados'] = $rowtam; break;
			case "35" : $saida[70]['txt'] = '35'; $saida[70]['dados'] = $rowtam; break;
			case "36" : $saida[71]['txt'] = '36'; $saida[71]['dados'] = $rowtam; break;
			case "37" : $saida[72]['txt'] = '37'; $saida[72]['dados'] = $rowtam; break;
			case "38" : $saida[73]['txt'] = '38'; $saida[73]['dados'] = $rowtam; break;
			case "39" : $saida[74]['txt'] = '39'; $saida[74]['dados'] = $rowtam; break;
			case "40" : $saida[75]['txt'] = '40'; $saida[75]['dados'] = $rowtam; break;
			case "41" : $saida[76]['txt'] = '41'; $saida[76]['dados'] = $rowtam; break;
			case "42" : $saida[77]['txt'] = '42'; $saida[77]['dados'] = $rowtam; break;
			case "43" : $saida[78]['txt'] = '43'; $saida[78]['dados'] = $rowtam; break;
			case "44" : $saida[79]['txt'] = '44'; $saida[79]['dados'] = $rowtam; break;
			case "45" : $saida[80]['txt'] = '45'; $saida[80]['dados'] = $rowtam; break;
			case "46" : $saida[81]['txt'] = '46'; $saida[81]['dados'] = $rowtam; break;
			case "47" : $saida[82]['txt'] = '47'; $saida[82]['dados'] = $rowtam; break;
			case "48" : $saida[83]['txt'] = '48'; $saida[83]['dados'] = $rowtam; break;
			case "49" : $saida[84]['txt'] = '49'; $saida[84]['dados'] = $rowtam; break;
			case "50" : $saida[85]['txt'] = '50'; $saida[85]['dados'] = $rowtam; break;
			case "51" : $saida[86]['txt'] = '51'; $saida[86]['dados'] = $rowtam; break;
			case "52" : $saida[87]['txt'] = '52'; $saida[87]['dados'] = $rowtam; break;
			case "53" : $saida[88]['txt'] = '53'; $saida[88]['dados'] = $rowtam; break;
			case "54" : $saida[89]['txt'] = '54'; $saida[89]['dados'] = $rowtam; break;
			case "55" : $saida[90]['txt'] = '55'; $saida[90]['dados'] = $rowtam; break;
			default : $x++; $saida[$x]['txt'] = strtoupper($rowtam['opc_valor1']); $saida[$x]['dados'] = $rowtam; break;
		}
	}
	ksort($saida);
	return $saida;
}

function urlencodetam($txt) {
	$saida = str_replace("/","_",$txt);
	$saida= urlencode($saida);
	return $saida;

}
function urldecodetam($txt) {
	$saida= urldecode($txt);
	$saida = str_replace("_","/",$saida);
	return $saida;

}

function newsletter_insert($nome='',$email,$nascimento='0000-00-00',$sexo='',$cidade='',$estado='',$telefone='') {
	global $obj_sql;
	if (trim($email)<>'') { 
		if ($obj_sql->Get("select count(let_email) from ".TB_NEWSLETTER." where let_email='$email'")>0) {
			$obj_sql->Query("update ".TB_NEWSLETTER." set let_nome='$nome', let_nascimento='$nascimento', let_telefone='$telefone', let_sexo='$sexo', let_cidade='$cidade', let_estado='$estado',let_status='1' where let_email='$email'");
		} else {
			if (trim($nome)=='') {
				$temp = explode("@",$email);
				$nome = $temp[0];
			}
			$obj_sql->Query("insert into ".TB_NEWSLETTER." (let_data,let_nome,let_email,let_nascimento,let_sexo,let_telefone,let_cidade,let_estado,let_status) values ('".date("Y-m-d H:i:s")."','$nome','$email','$nascimento','$sexo','$telefone','$cidade','$estado','1')");
		}
		return true;
	} else {
		return false;
	}
}


function retcategorela($pro_id) {
	global $obj_sql, $CFG;
	$qid = $obj_sql->Query("select * from ".TB_PRODUTO_CATEGORIA." where pro_id='$pro_id'");
	$array_saida = array();
	while ($row = $obj_sql->Fetch_Array($qid)) {
		$array_saida[$row['cat_id']] = '1';
	}
	return $array_saida;
}

function retlistacat($pro_id) {
	global $obj_sql, $CFG;
	$array_saida = array();

	$qid = $obj_sql->Query("select * from ".TB_PRODUTO_CATEGORIA." where pro_id='$pro_id'");
	while ($row = $obj_sql->Fetch_Array($qid)) {
		$array_saida[] = '&#8226; '.substr(str_replace("|", " > ", caminhocatnome($row['cat_id'])),3);//.($row['cat_del']=='1' ? ' <span style="color:#FF0000">&#8226;</span>' : '');
	}
	return $array_saida;

}

function arranja_array_categoria($array) {
	$array_saida = array();
	foreach ($array as $value) {
		$array_saida[$value] = '1';
	}
	return $array_saida;
}

			/*
<span class="price-of">R$329,90</span>
                    <span class="price-main">R$<strong>290</strong>,00</span>
                    <span class="price-parc">ou em <strong>6x</strong> de <strong>R$ 48,33</strong> sem juros</span>                       
                    <span class="price-off">Economize 15%</span>
					convertval($valor_final,'dolar',$_SESSION['MOEDA'],'1')
*/
function retornatxtpreco($valor, $desconto, $estoque, $proid) {
	global $obj_sql,$formapgto,$formapgtovista;

	$tmpid = explode(".",$proid);
	$row = $obj_sql->Get_Array("select a.*, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo,sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
			left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id 
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
								where a.pro_id='".$tmpid[0]."' and a.pro_situacao='1' and a.pro_del<>'1'");

	if ($valor>0) {

		if($row['pro_descper']>0){
			$row['pro_desconto'] = $valor * ($row['pro_descper']/100);
		}
		$desconto =	$desconto + $row['pro_desconto'];
		$valor_final = desconto($valor,$desconto);
		
		if ($formapgtovista['fpg_descontoavista']>0 || $formapgtovista['fpg_descontoporcento']>0) {
			if ($formapgtovista['fpg_descontoporcento']>0) {
				$descontoavistap += ($valor_final*$formapgtovista['fpg_descontoporcento'])/100;
			} else {
				$descontoavistap += $formapgtovista['fpg_descontoavista'];
			}
		}
		if ($row['pro_descontoavista']>0 && $row['pro_preco']>0 && $row['pro_estoque'] > 0) {
			$descontoavistap += $row['pro_descontoavista'];
		}
		$valorparasomar = convertval($valor_final,MOEDABASE,$_SESSION['MOEDA']);
		if ($desconto>0) {
			$preco .= '<span class="price-of">'.convertval($valor,MOEDABASE,$_SESSION['MOEDA'],'1').'</span>';
		}
		$preco .= '<span class="price-main"><strong>'.convertval($valor_final,MOEDABASE,$_SESSION['MOEDA'],'1').'</strong> / '.$row['pro_unid'].'</span><input name="valprodpri" type="hidden" id="valprodpri" value="'.$valorparasomar.'" />';

		$parcelamento = parcelas($valor_final,$formapgto['fpg_valminparc'],$formapgto['fpg_semjuros'],$formapgto['fpg_numaxparc']);
		if($parcelamento['tparcelas'] > 1) {
			//$preco .= '<span class="price-parc">ou em <strong>'.$parcelamento['tparcelas'].'x</strong> de <strong>'.convertval($parcelamento['vparcelas'],'dolar',$_SESSION['MOEDA'],'1').'</strong> sem juros</span>';
		}
		if ($descontoavistap>0) {
			//$preco .= '<h3><small>no boleto</small> <strong>R$'.number_format($valor_final-$descontoavistap,2,",",".").'</strong></h3>';
		}
		if ($desconto>0) {
			$percent = round(($desconto/$row['pro_preco'])*100,0);
			$preco .= '<span class="price-off">Economice '.$percent.'%</span>';
		}
		if ($_SESSION['MOEDA']=='guarani') {
			$preco .= '<span class="price-parc"><strong>'.convertval($valor_final,MOEDABASE,'dolar','1').'</strong></span>';
		}
		if ($_SESSION['MOEDA']=='real') {
			$preco .= '<span class="price-parc"><strong>'.convertval($valor_final,MOEDABASE,'dolar','1').'<Br>'.convertval($valor_final,MOEDABASE,'guarani','1').'</strong></span>';
		}
		if ($_SESSION['MOEDA']=='dolar') {
			$preco .= '<span class="price-parc"><strong>'.convertval($valor_final,MOEDABASE,'guarani','1').'</strong></span>';
		}

		$formcontato = 'normal';
		if($estoque <= 0) {
			$formcontato = 'indisponivel';
		}
	} else {
		$preco .= '<h2>Consulte</h2>';
		$formcontato = 'consulte';
	}
	if ($formcontato<>'normal') {
		$preco .= '<Br><h1>Consulte</h1><p>Consulte ahora con nuestros consultores la disponibilidad de este producto.</p><p><a href="_wappcall.php?consulte&proid='.$row['pro_id'].'" target="_blank" class="btn btn-whatsapp" ><i class="fa fa-whatsapp"></i> llame al consultor ahora</a>';
	}

	return array("codigo" => $formcontato, "txt" => $preco);
}

function gerabarcode($valor){
global $CFG;
$fino = 1 ;
$largo = 3 ;
$altura = 50 ;

  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
  for($f1=9;$f1>=0;$f1--){ 
    for($f2=9;$f2>=0;$f2--){  
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i=1;$i<6;$i++){ 
        $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1);
      }
      $barcodes[$f] = $texto;
    }
  }


//Desenho da barra


//Guarda inicial
?><img src=<?=$CFG->wwwpath?>/boleto/imagens/p.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
src=<?=$CFG->wwwpath?>/boleto/imagens/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
src=<?=$CFG->wwwpath?>/boleto/imagens/p.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
src=<?=$CFG->wwwpath?>/boleto/imagens/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
<?
$texto = $valor ;
if((strlen($texto) % 2) <> 0){
	$texto = "0" . $texto;
}

// Draw dos dados
while (strlen($texto) > 0) {
  $i = round(esquerdabarcode($texto,2));
  $texto = direitabarcode($texto,strlen($texto)-2);
  $f = $barcodes[$i];
  for($i=1;$i<11;$i+=2){
    if (substr($f,($i-1),1) == "0") {
      $f1 = $fino ;
    }else{
      $f1 = $largo ;
    }
?>
    src=<?=$CFG->wwwpath?>/boleto/imagens/p.gif width=<?=$f1?> height=<?=$altura?> border=0><img 
<?
    if (substr($f,$i,1) == "0") {
      $f2 = $fino ;
    }else{
      $f2 = $largo ;
    }
?>
    src=<?=$CFG->wwwpath?>/boleto/imagens/b.gif width=<?=$f2?> height=<?=$altura?> border=0><img 
<?
  }
}

// Draw guarda final
?>
src=<?=$CFG->wwwpath?>/boleto/imagens/p.gif width=<?=$largo?> height=<?=$altura?> border=0><img 
src=<?=$CFG->wwwpath?>/boleto/imagens/b.gif width=<?=$fino?> height=<?=$altura?> border=0><img 
src=<?=$CFG->wwwpath?>/boleto/imagens/p.gif width=<?=1?> height=<?=$altura?> border=0> 
  <?
} //Fim da funÁ„o

function esquerdabarcode($entra,$comp){
	return substr($entra,0,$comp);
}

function direitabarcode($entra,$comp){
	return substr($entra,strlen($entra)-$comp,$comp);
}

function atualiza_estoque_produto_principal($pro_id) {
	global $obj_sql;
	if ($obj_sql->Get("select count(opc_id) from ".TB_PRODUTO_OPCAO." where opc_pro_id='$pro_id' and opc_del<>'1'")>0) {
		$total = $obj_sql->Get("select sum(opc_estoque) from ".TB_PRODUTO_OPCAO." where opc_pro_id='$pro_id' and opc_del<>'1'");
		$totalres = $obj_sql->Get("select sum(opc_reserva) from ".TB_PRODUTO_OPCAO." where opc_pro_id='$pro_id' and opc_del<>'1'");
		$obj_sql->Query("update ".TB_PRODUTO." set pro_estoque='$total', pro_reserva='$totalres' where pro_id='$pro_id'");
	}
	return true;
}

function pegaVideoYoutube($endereco) {
    $regex = "#youtu(be.com|.b)(/embed/|/v/|/watch\\?v=|e/|/watch(.+)v=)(.{11})#";

    preg_match_all($regex, $endereco, $matches);
    if (!empty($matches[4])) {
	$codigos_unicos = array();
	$quantidade_videos = count($matches[4]);
	foreach ($matches[4] as $code) {
	    if (!in_array($code, $codigos_unicos))
		array_push($codigos_unicos, $code);
	}
	return $codigos_unicos[0];
    }else {
	return false;
    }
}

function convertval($valor, $de, $para=MOEDABASE, $pre='0', $cota_gua=0, $cota_real=0) {
	global $rowloja;
	$cota_gua = $cota_gua>0 ? $cota_gua : $rowloja['loj_cota_gua_dolar'];
	$cota_real = $cota_real>0 ? $cota_real : $rowloja['loj_cota_real_dolar'];
	$cota_realgua = $cota_gua / $cota_real;
	if ($de=='guarani' && $para=='dolar') {
		$saida = $valor/$cota_gua;
		$premoeda = 'US$ '.number_format($saida,2,'.',',');
	}
	if ($de=='dolar' && $para=='guarani') {
		$saida = $valor*$cota_gua;
		$premoeda = 'G$ '.number_format($saida,0,',','.');
	}

	if ($de=='real' && $para=='dolar') {
		$saida = $valor/$cota_real;
		$premoeda = 'US$ '.number_format($saida,2,'.',',');
	}
	if ($de=='real' && $para=='guarani') {
		$saida = $valor*$cota_realgua;
		$premoeda = 'G$ '.number_format($saida,0,',','.');
	}
	if ($de=='dolar' && $para=='real') {
		$saida = $valor*$cota_real;
		$premoeda = 'R$ '.number_format($saida,2,',','.');
	}
	if ($de=='dolar' && $para=='dolar') {
		$saida = $valor;
		$premoeda = 'US$ '.number_format($saida,2,'.',',');
	}
	if ($de=='guarani' && $para=='guarani') {
		$saida = $valor;
		$premoeda = 'G$ '.number_format($saida,0,',','.');
	}
	if ($de=='real' && $para=='real') {
		$saida = $valor;
		$premoeda = 'R$ '.number_format($saida,2,',','.');
	}
	if ($de=='guarani' && $para=='real') {
		$saida = ($valor/$cota_gua)*$cota_real;
		$premoeda = 'R$ '.number_format($saida,2,'.',',');
	}
	return $pre=='0' ? $saida : $premoeda;
}

function sendbancard($url,$data,$metodo='POST') {
	$ch = curl_init($url);
	if ($metodo<>'POST') {
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $metodo);
	}
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	
	$result = curl_exec($ch);

	if ($result) {
		curl_close($ch);		
		return $result;
	} else {
		print('--'.curl_error($ch).'---');
		return $result;
	}
}


function sendrequest($paEndereco, $paPost){

	$sessao_curl = curl_init();
	curl_setopt($sessao_curl, CURLOPT_URL, $paEndereco);
	
	curl_setopt($sessao_curl, CURLOPT_FAILONERROR, true);

	//  CURLOPT_SSL_VERIFYPEER
	//  verifica a validade do certificado
//	curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYPEER, true);
	//  CURLOPPT_SSL_VERIFYHOST
	//  verifica se a identidade do servidor bate com aquela informada no certificado
	//curl_setopt($sessao_curl, CURLOPT_SSL_VERIFYHOST, 2);

	//  CURLOPT_SSL_CAINFO
	//  informa a localizaÁ„o do certificado para verificaÁ„o com o peer
	//curl_setopt($sessao_curl, CURLOPT_CAINFO, getcwd() . "/ssl/VeriSignClass3PublicPrimaryCertificationAuthority-G5.crt");
	//curl_setopt($sessao_curl, CURLOPT_SSLVERSION, 4);

	//  CURLOPT_CONNECTTIMEOUT
	//  o tempo em segundos de espera para obter uma conex„o
	curl_setopt($sessao_curl, CURLOPT_CONNECTTIMEOUT, 60);

	//  CURLOPT_TIMEOUT
	//  o tempo m·ximo em segundos de espera para a execuÁ„o da requisiÁ„o (curl_exec)
	curl_setopt($sessao_curl, CURLOPT_TIMEOUT, 60);

	//  CURLOPT_RETURNTRANSFER
	//  TRUE para curl_exec retornar uma string de resultado em caso de sucesso, ao
	//  invÈs de imprimir o resultado na tela. Retorna FALSE se h· problemas na requisiÁ„o
	curl_setopt($sessao_curl, CURLOPT_RETURNTRANSFER, true);

	curl_setopt($sessao_curl, CURLOPT_POST, true);
	curl_setopt($sessao_curl, CURLOPT_POSTFIELDS, $paPost );

	$resultado = curl_exec($sessao_curl);
	
	curl_close($sessao_curl);

	if ($resultado)
	{
		//print 'resultado'.$resultado;
		return $resultado;
	}
	else
	{
		//print('--'.curl_error($sessao_curl).'---');
		return curl_error($sessao_curl);
	}
}


function inseri_pedido_cliente_megabit($cad,$ped,$ite) {
	global $obj_sql;

	$dados = unserialize(MEGABIT_ACESSO);

	$obj_sqlm = new Sql($dados);


	//CADASTRO DO CLIENTE

	$campos = array();				$valores = array();
	$campos[]	= 'email';	$valores[]	= $cad['usu_email'];
	$campos[]	= 'nome';	$valores[]	= $cad['usu_nome'];
	$campos[]	= 'senha';	$valores[]	= $cad['usu_senha'];
	$campos[]	= 'data_nasc';	$valores[]	= $cad['usu_nascimento'];
	$campos[]	= 'sexo';		$valores[]	= $cad['usu_sexo'];
	$campos[]	= 'cpfcnpj';	$valores[]	= $cad['usu_cpfcnpj'];
	$campos[]	= 'razao_social';		$valores[]	= $cad['usu_nome'];
	$campos[]	= 'inscricao_estadual';		$valores[]	= $cad['usu_rginscri'];
	$campos[]	= 'rg';		$valores[]	= $cad['usu_rginscri'];
	$campos[]	= 'telefone1';		$valores[]	= $cad['usu_foneres'];
	$campos[]	= 'telefone2';		$valores[]	= $cad['usu_fonecom'];
	$campos[]	= 'celular';		$valores[]	= $cad['usu_fonecel'];
	$campos[]	= 'cep';		$valores[]	= $cad['usu_cep'];
	$campos[]	= 'logradouro';		$valores[]	= $cad['usu_endereco'];
	$campos[]	= 'numero';		$valores[]	= $cad['usu_numero'];
	$campos[]	= 'complemento';		$valores[]	= $cad['usu_complemento'];
	$campos[]	= 'bairro';		$valores[]	= $cad['usu_bairro'];
	$campos[]	= 'cidade';		$valores[]	= $cad['usu_cidade'];
	$campos[]	= 'uf';		$valores[]	= $cad['usu_estado'];
	$campos[]	= 'tipopessoa';		$valores[]	= substr($cad['usu_tipop'],0,1);

	$megacad = $obj_sqlm->Get_Array("select * from cadastro where email='".$cad['usu_email']."'");
	if ($megacad['email']==$cad['usu_email']) {

		$alteracampos = array();
		if ($megacad['nome']<>$cad['usu_nome']) {$alteracampos[] = 'nome';}
		if ($megacad['senha']<>$cad['usu_senha']) {$alteracampos[] = 'senha';}
		if ($megacad['data_nasc']<>$cad['usu_nascimento']) {$alteracampos[] = 'data_nasc';}
		if ($megacad['sexo']<>$cad['usu_sexo']) {$alteracampos[] = 'sexo';}
		if ($megacad['cpfcnpj']<>$cad['usu_cpfcnpj']) {$alteracampos[] = 'cpfcnpj';}
		if ($megacad['razao_social']<>$cad['usu_nome']) {$alteracampos[] = 'razao_social';}
		if ($megacad['inscricao_estadual']<>$cad['usu_rginscri']) {$alteracampos[] = 'inscricao_estadual';}
		if ($megacad['rg']<>$cad['usu_rginscri']) {$alteracampos[] = 'rg';}
		if ($megacad['telefone1']<>$cad['usu_foneres']) {$alteracampos[] = 'telefone1';}
		if ($megacad['telefone2']<>$cad['usu_fonecom']) {$alteracampos[] = 'telefone2';}
		if ($megacad['celular']<>$cad['usu_fonecel']) {$alteracampos[] = 'celular';}
		if ($megacad['cep']<>$cad['usu_cep']) {$alteracampos[] = 'cep';}
		if ($megacad['logradouro']<>$cad['usu_endereco']) {$alteracampos[] = 'logradouro';}
		if ($megacad['numero']<>$cad['usu_numero']) {$alteracampos[] = 'numero';}
		if ($megacad['complemento']<>$cad['usu_complemento']) {$alteracampos[] = 'complemento';}
		if ($megacad['bairro']<>$cad['usu_bairro']) {$alteracampos[] = 'bairro';}
		if ($megacad['cidade']<>$cad['usu_cidade']) {$alteracampos[] = 'cidade';}
		if ($megacad['uf']<>$cad['usu_estado']) {$alteracampos[] = 'uf';}
		if ($megacad['tipopessoa']<>substr($cad['usu_tipop'],0,1)) {$alteracampos[] = 'tipopessoa';}

		foreach ($alteracampos as $value) {
			$obj_sqlm->Query("insert into alteracoes (tabela,campo,data,email) values ('cadastro','$value','".date('Y-m-d H:i:s')."','".$megacad['email']."')");
		}

		//altera dados do cadastro
		$campos['id']	= 'email';
		$msg		= $obj_sqlm->update($cad['usu_email'],$campos,$valores,"cadastro");

	} else {
		//inclui novo cadastro
		$msg 		= $obj_sqlm->insert($campos,$valores,"cadastro");
	}


	//CADASTRO PEDIDO
	$campos = array();				$valores = array();
	$campos[]	= 'id';		$valores[]	= $ped['id'];
	$campos[]	= 'email';	$valores[]	= $cad['usu_email'];
	$campos[]	= 'total';	$valores[]	= $ped['valtot'];
	$campos[]	= 'data';	$valores[]	= date("Y-m-d");
	$campos[]	= 'hora';	$valores[]	= date("H:i:s");
	$campos[]	= 'frete';	$valores[]	= $ped['frete'];
	$msg 		= $obj_sqlm->insert($campos,$valores,"pedido");

	$sequencial = 0;
	foreach ($ite as $prodid => $quant) {
		$sequencial++;
		list($pro_id,$opc_id) = explode('.',$prodid);
		$pro 	= $obj_sql->Get_Array("SELECT * FROM ".TB_PRODUTO." WHERE pro_id='$pro_id'");
		$ite_valor = desconto($pro['pro_preco'],$pro['pro_desconto']);
		$ite_peso = $pro['pro_peso'];
		$refe = $pro['pro_ref'];
		$ite_quant = $quant;
		if ($opc_id<>0) {
			$opc 	= $obj_sql->Get_Array("SELECT * FROM ".TB_PRODUTO_OPCAO." WHERE opc_pro_id='$pro_id' and opc_id='$opc_id'");
			if ($opc['opc_preco']>0) {
				$ite_valor = $opc['opc_preco'];
			}
			if ($opc['opc_peso']>0) {
				$ite_peso = $opc['opc_peso'];
			}
			$refe = $opc['opc_ref'];
		}

		$campos = array();				$valores = array();
		$campos[]	= 'id_produto';		$valores[]	= $refe;
		$campos[]	= 'preco';			$valores[]	= convertval($ite_valor,'dolar','guarani');
		$campos[]	= 'quantidade';		$valores[]	= $quant;
		$campos[]	= 'sequencial';		$valores[]	= $sequencial;
		$campos[]	= 'numeropedido';	$valores[]	= $ped['id'];
		$campos[]	= 'peso';			$valores[]	= round($ite_peso,2);
		$campos[]	= 'data';			$valores[]	= date("Y-m-d H:i:s");
		$msg 		= $obj_sqlm->insert($campos,$valores,"carrinho");
	}

	return true;
	
}

function inseri_pagamento_megabit($dados,$st='0') {

	$dadosbanco = unserialize(MEGABIT_ACESSO);

	$obj_sqlm = new Sql($dadosbanco);
	
	$listast = array(
		'0' => 'TransaÁ„o em Andamento',
		'1' => 'TransaÁ„o ConcluÌda',
		'2' => 'TransaÁ„o Cancelada'
	);

	$totpag = $obj_sqlm->Get("select count(id_pedido) from dadospagamento where id_pedido='".$dados['id_pedido']."'");
	
	if ($st=='0') {

		$totpro = $obj_sqlm->Get("select sum(quantidade) from carrinho where numeropedido='".$dados['id_pedido']."'");

		$campos = array();					$valores = array();
		$campos[]	= 'id_transacao';		$valores[]	= $dados['id_transacao'];
		$campos[]	= 'data_transacao';		$valores[]	= $dados['data_transacao'];
		$campos[]	= 'valor_original';		$valores[]	= $dados['valor_original'];
		$campos[]	= 'valor_loja';			$valores[]	= $dados['valor_loja'];
		$campos[]	= 'valor_total';		$valores[]	= $dados['valor_total'];
		$campos[]	= 'tipo_pagamento';		$valores[]	= $dados['tipo_pagamento'];
		$campos[]	= 'parcelas';			$valores[]	= $dados['parcelas'];
		$campos[]	= 'cod_status';			$valores[]	= $dados['cod_status'];
		$campos[]	= 'status';				$valores[]	= $listast[$dados['cod_status']];
		$campos[]	= 'frete';				$valores[]	= $dados['frete'];
		$campos[]	= 'tipo_frete';			$valores[]	= $dados['tipo_frete'];
		$campos[]	= 'id_pedido';			$valores[]	= $dados['id_pedido'];
		$campos[]	= 'qtde_produtos';		$valores[]	= $totpro;
		$campos[]	= 'sequencial';			$valores[]	= $totpag+1;
		$campos[]	= 'sincronizou';		$valores[]	= '';
		$msg 		= $obj_sqlm->insert($campos,$valores,"dadospagamento");
	} else {

		$rowpgto = $obj_sqlm->Get_Array("select * from dadospagamento where id_pedido='".$dados['id_pedido']."'");

		$campos = array();					$valores = array();
		$campos[]	= 'id_transacao';		$valores[]	= $rowpgto['id_transacao'];
		$campos[]	= 'data_transacao';		$valores[]	= date("Y-m-d H:i:s");
		$campos[]	= 'valor_original';		$valores[]	= $rowpgto['valor_original'];
		$campos[]	= 'valor_loja';			$valores[]	= $rowpgto['valor_loja'];
		$campos[]	= 'valor_total';		$valores[]	= $rowpgto['valor_total'];
		$campos[]	= 'tipo_pagamento';		$valores[]	= $rowpgto['tipo_pagamento'];
		$campos[]	= 'parcelas';			$valores[]	= $rowpgto['parcelas'];
		$campos[]	= 'cod_status';			$valores[]	= $st;
		$campos[]	= 'status';				$valores[]	= $listast[$st];
		$campos[]	= 'frete';				$valores[]	= $rowpgto['frete'];
		$campos[]	= 'tipo_frete';			$valores[]	= $rowpgto['tipo_frete'];
		$campos[]	= 'id_pedido';			$valores[]	= $rowpgto['id_pedido'];
		$campos[]	= 'qtde_produtos';		$valores[]	= $rowpgto['qtde_produtos'];
		$campos[]	= 'sequencial';			$valores[]	= $totpag+1;
		$campos[]	= 'sincronizou';		$valores[]	= '';
		$msg 		= $obj_sqlm->insert($campos,$valores,"dadospagamento");

	}

}

function rettranspfromobs($obs) {
	$linhas = explode("<br>",$obs);
	$tra = substr($linhas[1],4);
	return $tra;
}

function tiraslashes($v) {
	foreach ($v as $k => $val) {
		if (!is_array($val)) {
			$v[$k] = stripslashes($val);
		} 
	}
	return $v;
}

function sanitize($str) {
	return str_replace( array("'",'"'), array("&#039;","&quot;"), $str);
}

//Programar Blckfriday
function testaperiododata($dataini,$datafim) {

	if (retmktime(date("Y-m-d H:i:s")) >= retmktime($dataini) && retmktime(date("Y-m-d H:i:s")) <= retmktime($datafim)) {

		return true;
	} else {

		return false;

	}
}

function gera_randomico($id) {
	$val = rand(90000000,99999999);
	return $id.$val;
}


?>