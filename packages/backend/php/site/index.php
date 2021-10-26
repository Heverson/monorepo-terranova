<?
include("_setup.php");
$pgindex = '1';
include("header.php");
?>

  <?//Essa é uma condição para agendar um bloco de código. Para determinar o período altere as configurações no _setup.php?>
  <? if (testaperiododata(DATABLKINI,DATABLKFIM)) {?>
  <div class="hover"></div>

  <div id="popup" class="onload">
    <div class="close">X</div>

    <div class="pop-img" style="z-index: 99999999999;">
      <img class="img-responsive" src="img/christmas-off.png" alt="">
    </div>
  </div>

  <? } else { ?>
  <?}?>

 <? /* <section class="features">
    <?
    $qidba = $obj_sql->Query("SELECT * FROM ".TB_BANNERS." WHERE (ban_local=0 ".$sqlbanner.") and ban_posicao='infoh' and ban_situacao='1' and ban_del<>'1' and ban_dataini<='".date("Y-m-d H:i:s")."' and ban_datafim>='".date("Y-m-d H:i:s")."' order by rand() limit 3");
    if ($obj_sql->Num_Rows($qidba)) {
    ?>     
    <div class="container">
      <div class="row">
        <? while ($rowba = $obj_sql->Fetch_Array($qidba)) { ?>
        <div class="col-sm-4">
        <? if ($rowba['ban_link']<>'') { ?>
        <a href="<?=$rowba['ban_link']?>" target="<?=$rowba['ban_target']?>"><? } ?><img src="/files/banx_<?=$rowba['ban_id']?>.<?=$rowba['ban_ext']?>" class="img-responsive img-center" /><? if ($rowba['ban_link']<>'') { ?></a><? } ?>
        </div>
        <? } ?>
      </div>
    </div>
    <? } ?>
  </section> */?>   
<?
     $qidx = $obj_sql->Query("select * from ".TB_TV." where tvf_del<>'1' and tvf_local='inicial' and tvf_situacao='1' and tvf_dataini<='".date("Y-m-d H:i:s")."' and tvf_datafim>='".date("Y-m-d H:i:s")."' order by tvf_ordem desc");
		 if ($obj_sql->Num_Rows($qidx)>0) {
			 ?>
 
  <section class="slider-mobile visible-xs-block">
    <div class="owl-carousel owl-main-mobile">
    <?
    while ($rowx = $obj_sql->Fetch_Array($qidx)) { 
		?>
      <div class="item">
      <a href="<?=$rowx['tvf_link']?>" target="<?=$rowx['tvf_target']?>"><img src="/files/tvfm_<?=$rowx['tvf_id']?>.<?=$rowx['tvf_extm']?>" class="img-responsive img-center" /></a>
      </div> 
      <? } ?>
    </div>
  </section>
  <? } ?>

  <section class="slider-main">
    <?
     if ($obj_sql->Num_Rows($qidx)>0) {
       ?>    
    <section class="owl-carousel owl-carouselind hidden-xs">
      <?
			 mysql_data_seek($qidx,0);
       while ($rowx = $obj_sql->Fetch_Array($qidx)) { 
         ?>  
      <div class="item">
        <a href="<?=$rowx['tvf_link']?>" target="<?=$rowx['tvf_target']?>"><img src="/files/tvf_<?=$rowx['tvf_id']?>.<?=$rowx['tvf_ext']?>" class="img-responsive img-center" /></a>
      </div>
      <? } ?> 
    </section>
    <? } ?>   
  </section>

  <section class="feat-home">
         <section class="highlights">
           <div class="container-fluid">
             <div class="row">
             <?
              $qidba = $obj_sql->Query("SELECT * FROM ".TB_BANNERS." WHERE (ban_local=0 ".$sqlbanner.") and ban_posicao='meio' and ban_situacao='1' and ban_del<>'1' and ban_dataini<='".date("Y-m-d H:i:s")."' and ban_datafim>='".date("Y-m-d H:i:s")."' order by rand() limit 1");
              while ($rowba = $obj_sql->Fetch_Array($qidba)) { 
             ?>
             <div class="col-sm-12">                    
               <div class="highlights-item">
               <? if ($rowba['ban_link']<>'') { ?><a href="<?=$rowba['ban_link']?>" target="<?=$rowba['ban_target']?>"><? } ?><img src="/files/banx_<?=$rowba['ban_id']?>.<?=$rowba['ban_ext']?>" class="img-responsive img-center" /><? if ($rowba['ban_link']<>'') { ?></a><? } ?>
               </div>                                        
             </div>
             <? } ?>
             </div>
           </div>
         </section>      
  </section>
  
  <section class="blog-home">
    <div class="container">
      <?
        $qidblog = $obj_sql->Query("select * from ".TB_BLOG_POST." order by blp_data desc, blp_id desc limit 3");
        if ($obj_sql->Num_Rows($qidblog)>0) {
      ?>
      <div class="row">
        <div class="col-sm-12">
          <h1 class="center">&Uacute;ltimas del Blog</h1>
        </div>
        <br>
        <?
          while ($rowblog = $obj_sql->Fetch_Array($qidblog)) {
          $rowf = $obj_sql->Get_Array("select * from ".TB_BLOG_FOTOS." where blp_id='".$rowblog['blp_id']."' order by bfo_principal desc limit 1");
        ?>
        <div class="col-sm-4">
          <a href="<?=linkblogview($rowblog['blp_id'],$rowblog['blp_titulo'])?>">
            <div class="highlights-item">
              <? if (file_exists("files/blp_".$rowf['bfo_id']."_g.".$rowf['bfo_ext'])) { ?>
              <div class="highlights-txt">
                <h2><?=$rowblog['blp_titulo']?></h2>
              </div>
              <img src="/files/blp_<?=$rowf['bfo_id']?>_g.<?=$rowf['bfo_ext']?>" class="img-responsive">
                <? } else { ?>
              <div class="highlights-txt" style="bottom: inherit;">
                <h2><?=$rowblog['blp_titulo']?></h2>
              </div>
              <? }?>
            </div>
          </a>
        </div>
        <? } ?>
      </div>
      <? } ?>
      <br>
      <br>
      <div class="row">
        <div class="col-sm-12" align="center">
          <a href="blog" class="btn">m&aacute;s del blog</a>
        </div>
      </div>
    </div>   
  </section>
  
  <?/*
	<?
	 $qidm = $obj_sql->Query("select * from ".TB_FORNECEDOR." where for_del<>'1' and for_extc<>''");
	 if ($obj_sql->Num_Rows($qidm)>0) {
	?>
  <section class="marcas">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="owl-carousel owl-marcas">
          <?
			  		while($rowm = $obj_sql->Fetch_Array($qidm)) { ?>
            <div class="item">
            <a href="<?=linkcat(0,NULL,NULL,$rowm['for_id'])?>"><img src="/files/forc_<?=$rowm['for_id']?>.<?=$rowm['for_extc']?>" class="img-center img-responsive" alt=""></a>
            </div>
            <? } ?>
                                                                                                
          </div>
        </div>
      </div>
    </div>
  </section>
  <? } ?>
  */?>

  <section class="produtos-tabs">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="center">Los Mejores Productos</h1>

          <ul class="tabs-produtos">
          <?
					$qualtab = '';
                    $qidl = $obj_sql->Query("select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                    inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
                    inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
                    left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
                    where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>0 order by a.pro_lancamento desc limit 8");
                    if ($obj_sql->Num_Rows($qidl)>0) {
											$qualtab = 'lanca';
                  ?>
            <li class="active" rel="tab1">Lanzamientos</li>
            <? } ?>
            <?
                    $qidv = $obj_sql->Query("select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                    inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
                    inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
                    left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id 
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
                    where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>0 order by a.pro_maisvendidos desc limit 8");
                    if ($obj_sql->Num_Rows($qidv)>0) {
											$qualtab = $qualtab=='' ? 'vendido' : $qualtab;
                  ?>
            <li <?=$qualtab=='vendido' ? 'class="active"' : '' ?> rel="tab2">M&aacute;s Vendidos</li>
            <? } ?>
            <?
                    $qidb = $obj_sql->Query("select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                    inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
                    inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
                    left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
                    where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>0 order by a.pro_visto desc limit 8");
                    if ($obj_sql->Num_Rows($qidb)>0) {
											$qualtab = $qualtab=='' ? 'visto' : $qualtab;
                  ?>
            <li <?=$qualtab=='visto' ? 'class="active"' : '' ?> rel="tab3">M&aacute;s Buscados</li>
            <? } ?>
          </ul>

          <div class="tab_container">
          <? if ($obj_sql->Num_Rows($qidl)>0) { ?>
            <h3 class="d_active tab_drawer_heading-produtos" rel="tab1">Lanzamientos</h3>
            <div id="tab1" class="tab_content-produtos">
              <div class="row">
                    <?
                    while ($row = $obj_sql->Fetch_Array($qidl)) {
                      $qidf = $obj_sql->Query("select * from ".TB_PRODFOTOS." where fot_pro_id='".$row['pro_id']."' order by fot_principal desc limit 1");
                      if ($rowf = $obj_sql->Fetch_Array($qidf)) {
                        $imagem = "/files/pro_".$rowf['fot_id']."_m.".$rowf['fot_ext'];
                      } else {
                        $imagem = "/img/noimg_p.jpg";
                      }
                    ?>
                    <div class="col-sm-6 col-md-3" style="margin-top: 30px;">
                      <? include("produto-item.php") ?>
                    </div>
                    <? } ?> 
              </div>
            </div>     
					<? } ?>
          <? if ($obj_sql->Num_Rows($qidv)>0) { ?>
            <h3 class="tab_drawer_heading-produtos" rel="tab2">M&aacute;s Vendidos</h3>
            <div id="tab2" class="tab_content-produtos">
              <div class="row">
                    <?
                    while ($row = $obj_sql->Fetch_Array($qidv)) {
                      $qidf = $obj_sql->Query("select * from ".TB_PRODFOTOS." where fot_pro_id='".$row['pro_id']."' order by fot_principal desc limit 1");
                      if ($rowf = $obj_sql->Fetch_Array($qidf)) {
                        $imagem = "/files/pro_".$rowf['fot_id']."_m.".$rowf['fot_ext'];
                      } else {
                        $imagem = "/img/noimg_p.jpg";
                      }
                    ?>
                    <div class="col-sm-6 col-md-3" style="margin-top: 30px;">
                      <? include("produto-item.php") ?>
                    </div>
                    <? } ?> 
              </div>
            </div>  
            <? } ?>
					<? if ($obj_sql->Num_Rows($qidb)>0) { ?>
            <h3 class="tab_drawer_heading-produtos" rel="tab3">M&aacute;s Buscados</h3>
            <div id="tab3" class="tab_content-produtos">
              <div class="row">
                    <?
                    while ($row = $obj_sql->Fetch_Array($qidb)) {
                      $qidf = $obj_sql->Query("select * from ".TB_PRODFOTOS." where fot_pro_id='".$row['pro_id']."' order by fot_principal desc limit 1");
                      if ($rowf = $obj_sql->Fetch_Array($qidf)) {
                        $imagem = "/files/pro_".$rowf['fot_id']."_m.".$rowf['fot_ext'];
                      } else {
                        $imagem = "/img/noimg_p.jpg";
                      }
                    ?>
                    <div class="col-sm-6 col-md-3" style="margin-top: 30px;">
                      <? include("produto-item.php") ?>
                    </div>
                    <? } ?> 
              </div>
            </div> 
            <? } ?>                            
          </div>          
        </div>
        </div>
        <Br style="clear:both">
        <Br>
        <div class="row" >
        <div class="col-sm-12" style="text-align:center">
        <a href="/lancamentos" class="btn">Ver todos</a>
        </div>
        </div>
      </div>
    </div>
  </section>

  
	<?
	$qidm = $obj_sql->Query("select * from ".TB_FORNECEDOR." where for_del<>'1' and for_extdp<>'' and for_destaque='1'");
	if ($obj_sql->Num_Rows($qidm)>0) {

		while($rowm = $obj_sql->Fetch_Array($qidm)) { ?>

  <section class="produtos-marca" style="background-image: url(/files/fordp_<?=$rowm['for_id']?>.<?=$rowm['for_extdp']?>)">
    <div class="box">
    	<? if ($rowm['for_extd1']<>'') { ?>
      <div class="item">
      	<? if ($rowm['for_linkd1']<>'') { ?><a href="<?=$rowm['for_linkd1']?>"><? } ?><img src="/files/ford1_<?=$rowm['for_id']?>.<?=$rowm['for_extd1']?>" class="img-center img-responsive" alt=""><? if ($rowm['for_linkd1']<>'') { ?></a><? } ?>
      </div>
      <? } ?>
    	<? if ($rowm['for_extd2']<>'') { ?>
      <div class="item">
      	<? if ($rowm['for_linkd2']<>'') { ?><a href="<?=$rowm['for_linkd2']?>"><? } ?><img src="/files/ford2_<?=$rowm['for_id']?>.<?=$rowm['for_extd2']?>" class="img-center img-responsive" alt=""><? if ($rowm['for_linkd2']<>'') { ?></a><? } ?>
      </div>
      <? } ?>
    	<? if ($rowm['for_extd3']<>'') { ?>
      <div class="item">
      	<? if ($rowm['for_linkd3']<>'') { ?><a href="<?=$rowm['for_linkd3']?>"><? } ?><img src="/files/ford3_<?=$rowm['for_id']?>.<?=$rowm['for_extd3']?>" class="img-center img-responsive" alt=""><? if ($rowm['for_linkd3']<>'') { ?></a><? } ?>
      </div>
      <? } ?>
    	<? if ($rowm['for_extd4']<>'') { ?>
      <div class="item">
      	<? if ($rowm['for_linkd4']<>'') { ?><a href="<?=$rowm['for_linkd4']?>"><? } ?><img src="/files/ford4_<?=$rowm['for_id']?>.<?=$rowm['for_extd4']?>" class="img-center img-responsive" alt=""><? if ($rowm['for_linkd4']<>'') { ?></a><? } ?>
      </div>
      <? } ?>                  
    </div>
  </section>
  <? } 
	} ?>

  
  <section class="produtos-categoria">
    <div class="container">
      <?
      $qidm = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_fixo='1' order by cat_ordem asc");
      while ($rowm = $obj_sql->Fetch_Array($qidm)) { 

      $listacatmenu = listacatesql($rowm['cat_id']);	
      $qid = $obj_sql->Query("select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a 
      inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
      inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
      left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
      where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>a.pro_reserva and h.cat_id in (".$listacatmenu.") order by rand() limit 8");

      if ($obj_sql->Num_Rows($qid)>0) {
      ?>     
      <div class="row">
        <div class="col-sm-12">
          <h1 class="border"><?=$rowm['cat_nome']?></h1>
        </div>
      </div>
      <div class="row">
      <? if ($rowm['cat_ext2']<>'' && file_exists("files/cati2_".$rowm['cat_id'].".".$rowm['cat_ext2'])) { ?>
        <div class="col-sm-3 hidden-xs">
          <a href="<?=linkcat($rowm['cat_id'])?>"><img src="files/cati2_<?=$rowm['cat_id']?>.<?=$rowm['cat_ext2']?>" class="img-responsive img-center" alt=""></a>
        </div>

        <div class="col-sm-9">
          <div class="owl-carousel owl-carouselind-3">  
        <? } else { ?>
        <div class="col-sm-12">
          <div class="owl-carousel owl-carouselind-4">  
        <? } ?>
            <?
             while ($row = $obj_sql->Fetch_Array($qid)) {
              $qidf = $obj_sql->Query("select * from ".TB_PRODFOTOS." where fot_pro_id='".$row['pro_id']."' order by fot_principal desc limit 2");
              if ($rowf = $obj_sql->Fetch_Array($qidf)) {
                $imagem = "/files/pro_".$rowf['fot_id']."_m.".$rowf['fot_ext'];
              } else {
                $imagem = "/img/noimg_p.jpg";
              }
            ?> 
            <div class="item">
              <?php include("produto-item.php") ?>                  
            </div>              
            <? } ?>                                                                      
          </div>      
        </div>
      </div>
      
      <br>
      <br>

      <? } } ?>
    </div>
  </section>
  
  <?
  $qidvid = $obj_sql->Query("select * from ".TB_VIDEOS." order by vid_id desc limit 2");
  if ($obj_sql->Num_Rows($qidvid)>0) { 
	?>
  <section class="videos">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <h1 class="center">V&iacute;deos</h1>
        </div>
      </div>
      <div class="row">
      <? while ($rowvid = $obj_sql->Fetch_Array($qidvid)) { ?>
        <div class="col-sm-6">
          <div class="videoWrapper">
            <iframe width="560" height="315" src="https://www.youtube.com/embed/<?=pega_id_youtube(trim($rowvid['vid_link']))?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
          </div>                    
        </div>
        <? } ?>
      
      </div>
      <div class="row">
        <div class="col-sm-12" align="center">
          <br>
          <br>
          <a href="https://www.youtube.com/channel/UC50vs3w5PFUqVdvUaJAFMfg" target="_blank" class="btn">Nuestro canal en YouTube</a> 
        </div>
      </div>      
    </div>
  </section>
  <? } ?>

	<?
	$qidcur = $obj_sql->Query("select * from ".TB_CURSOS." where cur_data>='".date('Y-m-d')."' order by cur_data asc limit 6");
	if ($obj_sql->Num_Rows($qidcur)>0) {
		?>
  <section class="cursos">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="box">
            <h1>Calendario de Cursos <small>Segu&iacute; todos los cursos que ser&aacute;n realizados en el Centro T&eacute;cnico del Shopping Terra Nova</small></h1>

            <div class="agenda">
            <?
							$dtatual = '';
							$xxx = 0;
							while ($rowcur = $obj_sql->Fetch_Array($qidcur)) {
								$xxx++;
								$temp = explode("-",$rowcur['cur_data']);
								
								if ($dtatual<>$rowcur['cur_data']) {
									$dtatual=$rowcur['cur_data'];
									if ($xxx<>1) {
						?>
            </ul>                  
                </div>                
              </div>
              <? } ?>
              
              <div class="item">
                <div class="data">
                  <strong><?=$temp[2]?></strong> <?=saimes(intval($temp[1]))?>
                </div>
                <div class="desc">
                  <ul class="list-agenda">
                  <? } ?>
                    <li><a href="curso_<?=$rowcur['cur_id']?>/<?=linktexto($rowcur['cur_titulo'])?>"><?=$rowcur['cur_titulo']?></a></li>                 
              <? } ?>
              </ul>                  
                </div>                
              </div>
            
            </div>

            <br>

            <a href="cursos" class="btn">Todos los Cursos</a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <? } ?>
  
<?php 
  include("footer.php"); 
?>