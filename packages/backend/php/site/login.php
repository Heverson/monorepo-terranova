<?
$seguro = '1';
include("_setup.php");
$TAG_title = 'Identificação';
$passo = '2';

$go = !isset($_GET['go']) && !isset($_POST['go']) ? '/' : (isset($_GET['go']) ? $_GET['go'] : $_POST['go']);

$_SESSION['PAYMENT']='';
$_SESSION['TRANSPCAD'] = array();
if (isset($_GET['logout'])) {
	$_SESSION['USER'] = array();
}

if ($go=='pagamento') {
	$passos='1';
	if (is_logged()) {
		$_SESSION['PAYMENT'] = '1';
		header("Location: ".$go);
		die;
	}	
}

if ($go=='orcamento') {
	$passos='1';
	if (is_logged()) {
		$_SESSION['PAYMENT'] = '1';
		header("Location: ".$go);
		die;
	}
}

if (isset($_POST['botcad'])) {
	$retorno = $obj_sql->Get_Array("SELECT * FROM ".TB_CIDADESPY." WHERE cpy_cidade ='".$_POST['cidad']."'");
    if (isset($retorno['cpy_id'])) {
		$_SESSION['TRANSPCAD'] = array("email" => $_POST['usu_email'], "go" => $go, "cidade" => $retorno['cpy_cidade'],"zona" => $retorno['cpy_zona']);
		header("Location: /novo-cadastro");
		die;
    } else {
        $erro[] = "Para la ciudad informado no será posible proceder con el registro.";
    }
	$errolog = implode("<br>",$erro);

}

if (isset($_POST['botlogin'])) {
	$erro = array();
	if ($_POST['username']=='') {$erro[] = 'Llena tu e-mail';}
	if ($_POST['password']=='') {$erro[] = 'Llena tu contraseña';}
	if (count($erro)==0) {
		$row = $obj_sql->Get_Array("SELECT * FROM ".TB_CADASTRO." WHERE usu_email = '".$_POST['username']."' AND usu_senha = '".md5($_POST['password'])."' AND usu_situacao='1' and usu_del<>'1'");
		if ($row['usu_id']<>'') {
			$_SESSION['USER'] = $row;
			if ($go=='pagamento'){
				$_SESSION['PAYMENT'] = '1';
			}

			header("Location: ".$go);
			die;
		} else {
			$erro[] = 'Usuario o contraseña incorrectos';
		}
	}
	$errolog = implode("<br>",$erro);
}
if (isset($_POST['botpedido'])) {
	$erro = array();
	$numero = substr($_POST['npedido'],0,-1);
	$dv = substr($_POST['npedido'],-1,1);
	
	if ($_POST['npedido']=='') {$erro[] = 'Rellene el número de pedido';}
	if ($dv<>calmod11($numero)) {$erro[] = 'Número de pedido incorrecta';}
	if (count($erro)==0) {
		$row = $obj_sql->Get_Array("SELECT * FROM ".TB_PEDIDO." WHERE ped_id = ".$numero." and ped_del<>'1'");
		if ($row['ped_id']<>'') {
			header("Location: /visualizapedido/".md5($row['ped_id']));
			die;
		} else {
			$erro[] = 'Número de pedido incorrecta';
		}
	}
	$erroped = implode("<br>",$erro);
}
include("header-pgto.php");
?>

    <div class="container">
      <div class="header-content">
        <div class="row">
          <div class="col-md-12">
            <h1 class="title">Identificación</h1>
          </div>
        </div>
      </div>
    </div>
    
    <section class="container">
      <div class="body-content">
      <? if (isset($erroped)) { ?>
                <div class="alert alert-error"><?=$erroped?></div>
                <? } ?>
				<? if (isset($errolog)) { ?>
                <div class="alert alert-error"><?=$errolog?></div>
                <? } ?>
                
        <div class="row">
          <div class="col-md-12">
            <div class="section-login">
              <div class="row">
              <div class="col-sm-12">
                  <div class="box-login-social">
                    Iniciar sesión con Facebook:<br><br>
                    <a href="javascript:void(0)" onClick="getLoginFb();"><img src="img/login_fb.png" class="img-responsive btn-fb-login" alt=""></a>
                  </div>
                </div>

                <div class="col-sm-12 box-or" align=""> OU </div>
                <div class="col-sm-6">
                  <div class="box-login">
                    <h2>Ya tengo Registro</h2>
					          <form id="formLogin" name="formLogin" method="post" action="/login">
                    <div class="form-inline">
                      <p><label>Correo:</label> <input type="text" name="username" id="username" value="<?=$_POST['username']?>" ></p>
                      <p><label>Contraseña:</label> <input name="password" type="password" id="password" ></p>
                      <a class="left underline" href="/recuperar-senha">Olvidé mi contraseña</a>
                    </div>  
                    <input name="go" type="hidden" id="go" value="<?=$go?>" />
                    <input name="botlogin" type="hidden" id="botlogin" value="1" />   
                    </form>             

                    <a href="javascript:void(0)" onClick="$('#formLogin').submit()" class="btn">Seguir</a>
                  </div>
                </div>

                <div class="col-sm-6">
                  <div class="box-login">
                    <h2>Quiero Registrarme</h2>
					           <form id="formCad" name="formCad" method="post" action="/login"> 
                    <div class="form-inline">
                      <p><label>Correo:</label> <input name="usu_email" id="usu_email" type="text" value="<?=$_POST['usu_email']?>"></p>
                      <p><label>Ciudad:</label> <input name="cidad" type="text" id="cidad" value="<?=$_SESSION['CIDAD']['cidade']?>"></p>
                    </div> 
                    <input name="go" type="hidden" id="go" value="<?=$go?>" />
                    <input name="botcad" type="hidden" id="botcad" value="x1" />
                    </form>                 
                    
                    <a href="javascript:void(0)" onClick="if (enviaparacadastro()) {$('#formCad').submit();} else {return false;}" class="btn">Seguir Registro</a>
                  </div>                
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>  

    <!-- SENHA -->
    <div id="fancy-senha" style="width:100%; min-width:500px; display: none; padding:20px;">
      <h1>Olvidé mi contraseña</h1>
      <p>Rellene su correo abajo. Recibirás una nueva contraseña</p>

      <div class="form-inline">
        <p><input type="text" placeholder="Correo"></p>
        <a href="#" class="btn">Seguir</a><br><br>
      </div>
    </div>       

<script>

  window.fbAsyncInit = function() {
    FB.init({
      appId      : '610811056028227',
      xfbml      : true,
	   cookie     : true,
      version    : 'v3.2'
    });
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
	 
	 
  function getLoginFb() {
	FB.login(function(response) {
		avisoPost();
		if (response.authResponse) {
			salvaSessaoFacebook();
		} else {
		 	alert("El inicio de sesión no se ha completado correctamente. Por favor, inténtelo de nuevo.");
			fechaAvisoPost();
		}
	},{scope: 'public_profile,email'});
  }
  




  function salvaSessaoFacebook() {
    FB.api('/me', {fields: 'age_range,locale,name,email,gender,link,last_name'}, function(response) {
		
		response.urlgo = '<?=$go?>';
		
		$.ajax({
			type: "POST",
			async: "false",
			url: '_loginfb.php',
			data: response,
			success: function(r) {
				retorno = $.parseJSON(r);
				if (retorno.status=='1') {
					document.location.href=retorno.redirurl;
				} else if (retorno.status=='0') {
					alert(retorno.msg);
					fechaAvisoPost();
				}
			}
		});
		
	
    });
  }
	 
	 
</script>
<? include("footer-pgto.php"); ?>