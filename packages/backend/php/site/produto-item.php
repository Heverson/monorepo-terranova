<?
  $cwx++;
  if ((isset($row['pmo_perc']) && $row['pmo_perc']>0) || (isset($row['pmo_perca']) && $row['pmo_perca']>0)) {
    $row['pro_desconto'] += isset($row['pmo_perc']) && $row['pmo_perc']>0 ? $row['pro_preco']*($row['pmo_perc']/100) : 0;
  }
  ?>
                <div class="prod-item">
                  <div class="prod-off">
                    <? if ($row['pro_oferta']=='1') { ?>
                    <div><img src="img/promo.png" width="40" height="40"></div>
                    <? } ?>
                    <? if ($row['pro_descper']>0) { ?>
										<div class="prod-off-value">-<?=round($row['pro_descper'])?>%</div>
               		  <? } ?>
                  	<? if ($row['pro_desconto']>0) { ?>
										<div class="prod-off-value">-<?=round(($row['pro_desconto']/$row['pro_preco'])*100,0)?>%</div>
               		  <? } ?>
                    <? if ($row['pro_lancamento']=='1') { ?>
                    <div class="prod-feat">Lanzamiento</div>
                    <? } ?>
                  </div>
                  
                  <a href="<?=linkpro($row['pro_id'])?>">
                    <img src="<?=$imagem?>" alt="<?=tiraASPA($row['pro_nome'])?>" class="thumb img-responsive">
                  </a>
                  <br>
                  <h1><a href="<?=linkpro($row['pro_id'])?>"><?=$row['pro_nome']?></a></h1>
                  
                  <? include("_valor.php") ?>
                  
                  <?
        				  $rowcat = $obj_sql->Get_Array("select a.cat_nome, a.cat_id from ".TB_PRODUTO_CATEGORIA." b inner join ".TB_CATEGORIA." a on a.cat_id=b.cat_id where b.pro_id='".$row['pro_id']."' limit 1");
        				  ?>
                  <span class="more-cats">
                    <a href="<?=linkcat($rowcat['cat_id'])?>">+ <?=$rowcat['cat_nome']?></a><br>
                    <a href="<?=linkcat($rowcat['cat_id'],NULL,NULL,$row['pro_for_id'])?>">+ <?=$row['for_nome']?></a>
                  </span>
                </div>
				
				

                <div class="comprar">
                  <div class="row">
                    <div class="col-sm-12">
					<? if ($txtbtn=='Comprar') { ?>
                      <input type="button" value="-" class="qtyminus" field="itenped_<?=$cwx?><?=$row['pro_id']?>_0" />
                    <input type="text" name="itenped[<?=$row['pro_id']?>.0]" data-codigo="<?=$row['pro_id']?>.0" id="itenped_<?=$cwx?><?=$row['pro_id']?>_0" value="1" class="qty" umv="<?=$row['pro_qtgrupovenda']?>" readonly />
                    <input type="button" value="+" class="qtyplus" field="itenped_<?=$cwx?><?=$row['pro_id']?>_0" /><br>

					  <a href="javascript:;" onClick="enviarCarrinho('<?=$row['pro_id']?>.0',$('#itenped_<?=$cwx?><?=$row['pro_id']?>_0').val())" class="btn"><i class="fa fa-shopping-cart"></i> AGREGAR AL CARRITO</a>                  
					<? } else { ?>
						<a href="<?=linkpro($row['pro_id'])?>" class="btn"><?=$txtbtn?></a> 
					<? } ?>
                    </div>                
                  </div>                    
                </div>                