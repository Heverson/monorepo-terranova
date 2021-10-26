<?
if ( !isset($pgindex) && !isset($nobanner) && isset($set) ) {
	if ($set>0) {
		$listain = str_replace("|",",",substr(caminhocatcod($set),1));
		$sqlbanner = " or (ban_local=2 and ban_cat_id in (".$listain.")) " ;
	} else {
		$sqlbanner = " or ban_local=3 ";
	}
} else {
	$sqlbanner = " or ban_local=1 ";
}
$TAG_title = $TAG_title<>'' ? $TAG_title. ' - '.$rowloja['loj_titulo'] : $rowloja['loj_titulo'];
$TAG_description = $TAG_description<>'' ? $TAG_description : $rowloja['loj_descricao'];
$TAG_keywords = $TAG_keywords<>'' ? $TAG_keywords : $rowloja['loj_keywords'];
?>
<!doctype html>
<html>
<head>
<meta charset="iso-8859-1">
<meta name="title" content="<?=$TAG_title?>"/>
<meta name="description" content="<?=$TAG_description?>"/>
<meta name="keywords" content="<?=$TAG_keywords?>"/>
<meta name="language" content="pt-br"/>
<meta name="author" content="Egondola"/>
<meta name="robots" content="ALL"/>
<meta name="doc-class" content="completed"/>
<meta name="distribution" content="Global"/>
<meta property="og:title" content="<?=$TAG_title?>">
<meta property="og:description" content="<?=$TAG_description?>">
<? if (isset($imgface)) {?>
<meta property="og:image" content="<?=$imgface?>">
<? } ?>
<base href="<?=$CFG->wwwpath?>" />
<title>
<?=$TAG_title?>
</title>
<? if (isset($redirtopo)) { ?>
  <META HTTP-EQUIV="Refresh" CONTENT="1; URL=<?=$redirtopo?>">
  <? } ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="apple-touch-icon" sizes="16x16" href="img/favicon/16x16.png">
<link rel="apple-touch-icon" sizes="24x24" href="img/favicon/24x24.png">
<link rel="apple-touch-icon" sizes="32x32" href="img/favicon/32x32.png">
<link rel="apple-touch-icon" sizes="48x48" href="img/favicon/48x48.png">
<link rel="apple-touch-icon" sizes="64x64" href="img/favicon/64x64.png">
<link rel="icon" type="image/png" sizes="16x16" href="img/favicon/16x16.png">
<link rel="icon" type="image/png" sizes="24x24" href="img/favicon/24x24.png">
<link rel="icon" type="image/png" sizes="32x32" href="img/favicon/32x32.png">
<link rel="icon" type="image/png" sizes="48x48" href="img/favicon/48x48.png">
<link rel="icon" type="image/png" sizes="64x64" href="img/favicon/64x64.png">
<link href="https://fonts.googleapis.com/css?family=Overpass:100,400,700,800" rel="stylesheet">
<link href="css/reset.css" rel="stylesheet" />
<link href="css/bootstrap.min.css" rel="stylesheet" />
<link href="css/bootstrap.modal.css" rel="stylesheet" />
<link href="css/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
<link href="css/ionicons.css" rel="stylesheet" />
<link href="css/styles.css?ver=2" rel="stylesheet" />
<link href="css/menuzord.css" rel="stylesheet" />
<link href="css/mega-dropdown-master.css" rel="stylesheet" />
<link href="css/main-nav.css" rel="stylesheet" />
<link href="css/responsiveslides.css" rel="stylesheet" />
<link href="css/owl.carousel.css" rel="stylesheet" />
<link href="css/jquery.fancybox.css?v=2.1.5" rel="stylesmega-dropdown-master.css" media="screen" />
<link href="css/accordion.responsive.css" rel="stylesheet" />
<link href="css/easyzoom.css" rel="stylesheet" />
<link href="css/overlay.css" rel="stylesheet" />
<link href="css/autocomplete.css" rel="stylesheet" />
<link rel="stylesheet" href="css/whatsapp-button.css">
<link rel="stylesheet" href="css/whatsapp-modal.css">

<script src="js/modernizr.js"></script>
<script src="js/jquery.min.js"></script>
<!-- <script src="js/jquery-2.1.1.js"></script> -->
<script src="js/jquery.mask.min.js"></script>
<script src="js/jquery.overlay.js"></script>
<script src="js/jquery.autocomplete.min.js"></script>
<script src="js/menuzord.min.js"></script>
<script src="js/jquery.menu-aim.js"></script>
<script src="js/jquery.megadropdown.js"></script>
<script src="js/jquery.instagramFeed.min.js"></script> 
<script src="js/__functions.js"></script>
<script>
    $(document).ready(function() {
    	$('#cidad').autocomplete({
    		serviceUrl: '/_buscacidadepy.php'
    		//onSelect: function (suggestion) {
    		//	alert('You selected: ' + suggestion.value + ', ' + suggestion.data);
    		//}
    	});
  		$('#qytopo').autocomplete({
  			serviceUrl: '/_busca_autocomplete.php',
  			onSelect: function (suggestion) {
  				document.location.href = suggestion.url;
  			},
  			formatResult: function (suggestion, currentValue) {
  				var img = '<div class="fotoimg"><img src="' + suggestion.img + '"></div>';
  				var txt = '<div class="titulo">' + suggestion.value.replace(new RegExp(currentValue, "gi"), "<strong>" + currentValue.toUpperCase() + "</strong>") + '</div>';
  				var cat = "<span>" + suggestion.categoria + "</span>";
  				return img + txt + cat;
  			}
  		});

		});
    </script>

<!--[if IE 8]>
      <link href="css/ie8.css" rel="stylesheet" type="text/css" />
  <![endif]-->

</head>

<body>
	
  <div class="nav-mobile">
    <a href="/"><img src="img/logo.png" height="30" alt=""></a>

    <div class="menu-conta">
      <? if (is_logged()) { ?>
      <div class="mobile-logged">
        <a href="/painel-de-controle/minha-conta">Mi Registro</a>&nbsp;&nbsp;
        <a href="/painel-de-controle/meus-pedidos">Mis Pedidos</a>&nbsp;&nbsp;
        <a href="login?logout" class="right"><i class="fa fa-sign-out fa-lg" title="Logout"></i>
      </div>
      <? } else { ?>
      <a href="login" title="Minha Conta"><i class="fa fa-user"></i></a>
      <? } ?>
    </div>
    <div class="menu-cart">
      <a href="meu-carrinho" title="Carrinho"><i class="fa fa-shopping-cart"></i></a>
    </div>
    <div class="menu-btn">
        <a class="btn-open" href="javascript:void(0)" title="Menu de Navegação"></a>
    </div>

    <div class="overlay">
      <div class="menu">
        <img src="img/logo.png" class="logo-inside" alt="">

        <div class="accordion">
          <h1 class="accordion--toggle">Shopping Terra Nova</h1>
          <div class="accordion--body">
            <ul class="list-hamb-menu">
              <li><a href="la-empresa">La Empresa</a></li>
              <li><a href="blog">Blog</a></li>
              <li><a href="estacionamiento">Estacionamiento</a></li>
            </ul>
          </div>
        </div>

        <div class="accordion">
          <h1 class="accordion--toggle">Marcas</h1>
          <?
					$qidm = $obj_sql->Query("select * from ".TB_FORNECEDOR." where for_del<>'1' and for_destaquetopo='1' order by for_ordem desc");
					if ($obj_sql->Num_Rows($qidm)>0) {
						?>
          <div class="accordion--body">
            <ul class="list-hamb-menu2">
              <?
			  while($rowm = $obj_sql->Fetch_Array($qidm)) { ?>
              <li><a href="<?=linkcat(0,NULL,NULL,$rowm['for_id'])?>"><?=$rowm['for_nome']?></a></li>
              <? } ?>
               <li><a href="/marcas" class="btn">Ver todos</a></li>
            </ul>
          </div>
          <? } ?>
        </div>

        <div class="accordion">
          <h1 class="accordion--toggle">Departamentos</h1>
          <?
          $qidm = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='0' order by cat_ordem asc");
					if ($obj_sql->Num_Rows($qidm)>0) {
						?>
          <div class="accordion--body">
            <ul class="list-hamb-menu2">
<?
				while($rowm = $obj_sql->Fetch_Array($qidm)) { ?>
              <li><a href="<?=linkcat($rowm['cat_id'])?>"><?=$rowm['cat_nome']?></a></li>
              <? } ?>
            </ul>
          </div>
          <? } ?>
        </div>

        <div class="accordion">
          <h1 class="accordion--toggle--no"><a href="best-sellers">Best Sellers</a></h1>
        </div>

        <div class="accordion">
          <h1 class="accordion--toggle--no"><a href="cursos">Nuestros Cursos</a></h1>
        </div>

        <div class="accordion">
          <h1 class="accordion--toggle--no"><a href="contacto">Atenci&oacute;n al Cliente</a></h1>
        </div>

        <? /* if(PROMOABA=='1'):?>      
        <div class="accordion">
          <h1 class="accordion--toggle--no"><a href="promociones" style="color: #03a84e;"><?=$rowloja['pmo_titulo']<>'' ? $rowloja['pmo_titulo'] : "Outlet"?></a></h1>
        </div>
		<?php endif; */ ?>
		
		<?
        $qidpmo = $obj_sql->Query("select * from ".TB_PROMOCAO." where pmo_status='1' and pmo_ativamenu='1' and pmo_dataini<='".date("Y-m-d H:i:s")."' and pmo_datafim>='".date("Y-m-d H:i:s")."' and pmo_link<>''");
		while($rowpmo = $obj_sql->Fetch_Array($qidpmo)) {
		?>
		<div class="accordion">
          <h1 class="accordion--toggle--no"><a href="lista/<?=$rowpmo['pmo_link']?>" style="color: #03a84e;"><?=$rowpmo['pmo_titulo']?></a></h1>
        </div>
		<? } ?>


        <div class="accordion">
          <h1 class="accordion--toggle--no">
            <form method="get" name="formbusca" id="formbusca" action="/busca">
              <input type="text" placeholder="¿Que buscas?" name="qy" value="<?php echo $qy;?>">
              <button><i class="fa fa-search fa-lg"></i></button>
            </form>
          </h1>
        </div>

        <div class="accordion">
          <h1 class="accordion--toggle--no">
            <? if ($rowloja['loj_facebook']<>'') { ?>
            <a href="<?=$rowloja['loj_facebook']?>" target="_blank">
              <span class="fa-stack fa-lg">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
              </span>
            </a>
            <? } ?>

            <? if ($rowloja['loj_instagram']<>'') { ?>
            <a href="<?=$rowloja['loj_instagram']?>" target="_blank">
              <span class="fa-stack fa-lg">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
              </span>
            </a>
            <? } ?>

            <? if ($rowloja['loj_youtube']<>'') { ?>
            <a href="<?=$rowloja['loj_youtube']?>" target="_blank">
              <span class="fa-stack fa-lg">
                <i class="fa fa-circle fa-stack-2x"></i>
                <i class="fa fa-youtube fa-stack-1x fa-inverse"></i>
              </span>
            </a>
            <? } ?>
          </h1>
        </div>
      </div>
    </div>
</div>

<header class="header-desk">
	<div class="header-bar">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-6 col-md-5">
					<ul class="list-header-bar esquerda">
						<li><a href="la-empresa">La Empresa</a></li>
						<li><a href="blog">Blog</a></li>
						<li><a href="contacto">Atenci&oacute;n al Cliente</a></li>
						<li><a href="estacionamiento">Estacionamiento</a></li>
					</ul>
				</div>
				<div class="col-sm-6 col-md-7">
					<ul class="list-header-bar direita">
						<li><i class="fa fa-whatsapp fa-lg" aria-hidden="true"></i>
							<strong>
								<a href="http://api.whatsapp.com/send?l=es&phone=<?=$rowloja['loj_fone']?>" target="_blank"><?=$rowloja['loj_fone']?></a> /
								<a href="http://api.whatsapp.com/send?l=es&phone=<?=$rowloja['loj_whatsapp']?>" target="_blank"><?=$rowloja['loj_whatsapp']?></a>
							</strong></li>
						<li>
							<? if ($rowloja['loj_facebook']<>'') { ?>
							<a href="<?=$rowloja['loj_facebook']?>"><i class="fa fa-facebook fa-lg" aria-hidden="true"></i></a>&nbsp;&nbsp;&nbsp;
							<? } ?>
							<? if ($rowloja['loj_instagram']<>'') { ?>
							<a href="<?=$rowloja['loj_instagram']?>"><i class="fa fa-instagram fa-lg" aria-hidden="true"></i></a>
							<? } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div id="navz" class="header-main" data-spy="affix" data-offset-top="500">
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-12">

					<header class="main-nav">

						<div class="logo-wrapper">
							<img src="img/logo.png" class="img-responsive" alt="">						
						</div>
						
						<div class="cd-dropdown-wrapper ">
							<a class="cd-dropdown-trigger" href="javascript:void(0)">Departamentos</a>
							<nav class="cd-dropdown">
								<h2>Shopping Terra Nova</h2>
								<a href="javascript:void(0)" class="cd-close">Cerrar</a>
								<ul class="cd-dropdown-content">
								
									<?
									$qidm = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='0' and cat_fixo<>'1' order by cat_ordem asc");
									while ($rowm = $obj_sql->Fetch_Array($qidm)) {
									
									
										$qidc = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='".$rowm['cat_id']."' order by cat_ordem asc");
										$totsubc = $obj_sql->Num_Rows($qidc);

									?>
									<li <?=$totsubc>0 ? 'class="has-children"' : '' ?>>
										<a href="<?=linkcat($rowm['cat_id'])?>"><?=$rowm['cat_nome']?></a>
										
										<? if ($totsubc>0) { ?>
					
										<ul class="cd-secondary-dropdown is-hidden">
											<li class="go-back"><a href="javascript:void(0)">Menu</a></li>
											<li class="see-all"><a href="<?=linkcat($rowm['cat_id'])?>">Ver todos productos de <?=$rowm['cat_nome']?></a></li>
											<?
											while ($rowc = $obj_sql->Fetch_Array($qidc)) {
												
												$qido = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='".$rowc['cat_id']."' order by cat_ordem asc");
												$totsubo = $obj_sql->Num_Rows($qido);
										
											?>
											<li <?=$totsubo>0 ? 'class="has-children"' : '' ?>>
												<a href="<?=linkcat($rowc['cat_id'])?>"><?=$rowc['cat_nome']?></a>
												
												<? if ($totsubo>0) { ?>
												<ul class="is-hidden">
													<li class="go-back"><a href="javascript:void(0)"><?=$rowc['cat_nome']?></a></li>
													<? /*<li class="see-all"><a href="<?=linkcat($rowc['cat_id'])?>">Ver todos productos de <?=$rowc['cat_nome']?></a></li> */ ?>
													<?
													while ($rowo = $obj_sql->Fetch_Array($qido)) {
														
														$qidt = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='".$rowo['cat_id']."' order by cat_ordem asc");
														$totsubt = $obj_sql->Num_Rows($qidt);
												
													?>
													
													<li <?=$totsubt>0 ? 'class="has-children"' : '' ?>>
														<a href="<?=$totsubt>0 ? 'javascript:void(0)' : linkcat($rowo['cat_id'])  ?>"><?=$rowo['cat_nome']?></a>
														<? if ($totsubt>0) { ?>
														<ul class="is-hidden">
															<li class="go-back"><a href="javascript:void(0)"><?=$rowo['cat_nome']?></a></li>
															<li class="see-all"><a href="<?=linkcat($rowo['cat_id'])?>">Ver todos productos de <?=$rowo['cat_nome']?></a></li>
															<?
															while ($rowt = $obj_sql->Fetch_Array($qidt)) {
															?>
															<li><a href="<?=linkcat($rowt['cat_id'])?>"><?=$rowt['cat_nome']?></a></li>
															<? } ?>
														</ul>
														<? } ?>
													</li>
													<? } ?>
												</ul>
												<? } ?>
											</li>
											<? } ?>
										</ul> <!-- .cd-secondary-dropdown -->
										<? } ?>
										
									</li> <!-- .has-children -->
									<? } ?>
					
									
								</ul> <!-- .cd-dropdown-content -->
							</nav> <!-- .cd-dropdown -->
						</div> <!-- .cd-dropdown-wrapper -->

						<div id="menuzord" class="menuzord">
							<ul class="menuzord-menu">
								<li><a href="/">Home</a></li>
								<li><a href="javascript:;">Marcas</a>
								
								<?
									$qidm = $obj_sql->Query("select * from ".TB_FORNECEDOR." where for_del<>'1' and for_ext<>'' and for_destaquetopo='1' order by for_ordem desc");
									if ($obj_sql->Num_Rows($qidm)>0):
								?>
		
								<div class="megamenu megamenu-half-width">
									<div class="megamenu-row megamenu-content">
										<div class="row">
											<div class="col-sm-12">
												<ul class="list-marcas">
													<? while($rowm = $obj_sql->Fetch_Array($qidm)):?>
													<li>
														<a href="<?=linkcat(0,NULL,NULL,$rowm['for_id'])?>">
															<img src="/files/for_<?=$rowm['for_id']?>.<?=$rowm['for_ext']?>" class="img-responsive img-center" alt="">
														</a>
													</li>
													<? endwhile; ?>
												</ul>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-12" style="text-align:center">
												<a href="/marcas" class="btn">Ver mas</a>
											</div>
										</div>
									</div>
								</div>
								
								<? endif; ?>
		
								</li>
		
								<? /*<li>
									<a href="javascript:;" class="">Departamentos</a>
									<div class="megamenu">
										<div class="megamenu-row megamenu-content">
											<div class="row">
												<div class="col-md-4 col-sm-12">
													<?
													$qidm = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='0' order by cat_ordem asc");
													$totalc = $obj_sql->Num_Rows($qidm);
													$nporcol = ceil($totalc/3);
													$x = 0;
													while ($rowm = $obj_sql->Fetch_Array($qidm)):
													$x++;
													?>
													<h2><a href="<?=linkcat($rowm['cat_id'])?>"><?=$rowm['cat_nome']?></a></h2>
													<? /*
														<ul class="list-line-departamentos">
														<?
														$qidc = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_idpai='".$rowm['cat_id']."' order by cat_ordem asc limit 6");
														$totsubc = $obj_sql->Num_Rows($qidc);
														if ($totsubc>0) {
														$xx = 0;
														while ($rowc = $obj_sql->Fetch_Array($qidc)) {
														$xx++;
														if ($xx>=6) {
														?>
														<li><a href="<?=linkcat($rowm['cat_id'])?>">+ Veja todos</a></li>
														<? } else { ?>
														<li><a href="<?=linkcat($rowc['cat_id'])?>"><?=$rowc['cat_nome']?></a></li>
														<? } ?>
														<? } ?>
														<? } ?>
													</ul>
													*/ ?>
													<? /* if ($x%$nporcol==0):?>
												</div>
												<div class="col-md-4 col-sm-12">
													<? endif; ?>
													<? endwhile; ?>
												</div>
											</div>
										</div>
									</div>
								</li> */?>
								<li><a href="best-sellers" class="feat">Best Sellers</a></li>
								<li><a href="cursos" class="feat">Nuestros Cursos</a></li>
								
								<? /* if(PROMOABA=='1') {?>      
								<li><a href="promociones" style="color: #03a84e;"><?=$rowloja['pmo_titulo']<>'' ? $rowloja['pmo_titulo'] : "Outlet"?></a></li>
								<? } */ ?> 

								<?
								$qidpmo = $obj_sql->Query("select * from ".TB_PROMOCAO." where pmo_status='1' and pmo_ativamenu='1' and pmo_dataini<='".date("Y-m-d H:i:s")."' and pmo_datafim>='".date("Y-m-d H:i:s")."' and pmo_link<>''");
								while($rowpmo = $obj_sql->Fetch_Array($qidpmo)) {
								?>
								<li><a href="lista/<?=$rowpmo['pmo_link']?>" style="color: #03a84e;"><?=$rowpmo['pmo_titulo']?></a></li>
								<? } ?>

								<?
					     		$qidm = $obj_sql->Query("select * from ".TB_CATEGORIA." where cat_del<>'1' and cat_fixo='1' order by cat_ordem asc");
								while($rowm = $obj_sql->Fetch_Array($qidm)) { ?>
								  <li><a href="<?=linkcat($rowm['cat_id'])?>" style="color: #03a84e;"><?=$rowm['cat_nome']?></a></li>
								<? } ?>

							</ul>
		
							<ul class="menuzord-menu menuzord-right">
								<li>
									<a href="login"><i class="fa fa-user"></i></a>
									<div class="megamenu megamenu-quarter-width">
										<div class="megamenu-row megamenu-content">
											<div class="row">
												<div class="col-sm-12">
													<? if (is_logged()) { ?>
													Hola, <strong><?=pnome($_SESSION['USER']['usu_nome'])?></strong><a href="login?logout" class="right"><i class="fa fa-sign-out fa-lg" title="Logout"></i></a>
													<br>
													<hr>
													<ul class="side-cat-list">
															<li><a href="/painel-de-controle/meus-pedidos">Todos los Pedidos</a></li>
															<li><a href="/painel-de-controle/alterar-senha">Cambiar Contrase&ntilde;a</a></li>
															<li><a href="/painel-de-controle/alterar-email">Cambiar E-mail / Login</a></li>
															<li><a href="/painel-de-controle/minha-conta">Mi Registro</a></li>
															<li><a href="/painel-de-controle/meus-enderecos">Mi Direcci&oacute;n</a></li>
													</ul>
													<? } else { ?>
													<div align="center"><a href="login">Has tu login o registrate</a></div>
													<? } ?>
												</div>
											</div>
										</div>
									</div>
								</li>
		
								<li>
									<a href="meu-carrinho">
										<i class="fa fa-shopping-cart"></i>
									</a>
									<div class="megamenu megamenu-half-width">
										<div class="megamenu-row megamenu-content">
											<div class="row">
												<div class="col-sm-12">
													<? include("_lista_carrinho.php") ?>
												</div>
											</div>
										</div>
									</div>
								</li>
		
								<li>
									<form action="/busca" method="get" class="search-mobile">
										<input class="search-field-mobile" name="qy" value="<?=$qy?>" type="text" placeholder="¿Que buscas?" />
										<button class="search-submit-mobile"><i class="fa fa-search"></i></button>
									</form>
		
									<form method="get" class="search-form" action="/busca">
										<label for="search-field"><span class="screen-reader-text"></span></label>
										<input class="search-field" id="qytopo" type="text" name="qy" value="<?=$qy?>" aria-required="false" autocomplete="off" placeholder="¿Que buscas?" />
										<button class="search-submit"><span class="screen-reader-text">¿Que buscas?</span><i class="fa fa-search"></i></button>
									</form>
								</li>
							</ul>
						</div> <!-- #menuzord -->

					</header>
				</div>
			</div>
		</div>
	</div>
</header>