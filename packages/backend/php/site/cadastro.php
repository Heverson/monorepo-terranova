<? 
$seguro = '1';
include("_setup.php");
$passo = '3';
$go = !isset($_GET['go']) && !isset($_POST['go']) ? '/' : (isset($_GET['go']) ? $_GET['go'] : $_POST['go']);
$valid = !isset($_POST['valid']) ? NULL : $_POST['valid'];

if (isset($_SESSION['TRANSPCAD']['email'])) {
	$_POST['usu_email'] = $_SESSION['TRANSPCAD']['email'];
	$_POST['usu_cidade'] = $_SESSION['TRANSPCAD']['cidade'];
	$_POST['usu_estado'] = $_SESSION['TRANSPCAD']['zona'];
	$go = $_SESSION['TRANSPCAD']['go'];
	$valid = '1';
}

if (isset($_SESSION['USERFB']['email'])) {
	$_POST['usu_email'] = $_SESSION['USERFB']['email'];
	$_POST['usu_nome'] = $_SESSION['USERFB']['nome'];
	$go = $_SESSION['USERFB']['go'];
	$valid = '1';
}

if (!isset($_SESSION['TRANSPCAD']['email']) && $valid<>'1') {
	header("Location: /login");
	die;
}
$_SESSION['TRANSPCAD']= array();

if ($_POST['act'] == 'post' && $valid=='1' && $_SESSION['cadok']<>'1') {
  $_POST['usu_email'] = trim($_POST['usu_email']);
	$erro = array();
	if ($_POST['usu_nome']=='') 	{$erro[] = "<b>Nombre:</b> texto obligatorio.";}
	if ($_POST['usu_cpfcnpj']=='') 	{$erro[] = "<b>Cédula de identidad:</b> texto obligatorio.";}
	if ($obj_sql->Get("select count(usu_id) from ".TB_CADASTRO." where usu_cpfcnpj='".$_POST['usu_cpfcnpj']."' and usu_del<>'1'")>0) {$erro[] = "<b>Cédula de identidad ya registrado.</b>";}
  if ($_POST['usu_sexo']=='') {$erro[] = "<b>Sexo:</b> texto obligatorio.";}
	if ($_POST['usu_nascimento']=='' || !validadata2($_POST['usu_nascimento'])) {$erro[] = "<b>Fecha de Nacimiento:</b> texto obligatorio.";}
		
	if (trim($_POST['usu_fonecel'])==''){
		$erro[] = "<b>Teléfono:</b> texto obligatorio.";
	}		
			
	if ($_POST['usu_email']=='') {$erro[] = "<b>E-mail:</b> texto obligatorio.";}
	if ($_POST['usu_email']<>'' && !validaemail($_POST['usu_email'])) {$erro[] = "<b>Email:</b> inválido.";}
	if ($obj_sql->Get("SELECT COUNT(usu_email) FROM ".TB_CADASTRO." WHERE usu_email='".$_POST['usu_email']."' and usu_del<>'1'")>0){$erro[] = "<b>Email:</b> ya registrado.";}
	if ($_POST['usu_senha']=='') {$erro[] = "<b>Contraseña:</b> texto obligatorio.";}
	if ($_POST['usu_senha']<>'' && $_POST['usu_senha']<>$_POST['usu_confsenha']) {$erro[] = "<b>Contraseña:</b> Las contraseñas no coinciden";}


	//Endereco
	//if ($_POST['usu_cep']=='') {$erro[] = "<b>Código postal:</b> texto obligatorio.";}
  if ($_POST['usu_endereco']=='') {$erro[] = "<b>Dirección:</b> texto obligatorio.";}

  if ($_POST['usu_cidade']=='')	{$erro[] = "<b>Ciudad:</b> texto obligatorio.";} else {

    $retorno = $obj_sql->Get_Array("SELECT * FROM ".TB_CIDADESPY." WHERE cpy_cidade ='".$_POST['usu_cidade']."'");
    if (!isset($retorno['cpy_zona'])) {
      $erro[] = "Para la ciudad informado no será posible proceder con el registro.";
    }
  }
			
	if (count($erro)==0)	{
		

					
		$campos[]	= 'usu_nome';		$valores[]	= $_POST['usu_nome'];
		$campos[]	= 'usu_cpfcnpj';	$valores[]	= $_POST['usu_cpfcnpj'];
				
		$campos[]	= 'usu_sexo';		$valores[]	= $_POST['usu_sexo'];
		$campos[]	= 'usu_nascimento';	$valores[]	= $_POST['usu_nascimento'];
				
		$campos[]	= 'usu_cep';		$valores[]	= $_POST['usu_cep'];
		$campos[]	= 'usu_endereco';	$valores[]	= $_POST['usu_endereco'];
		$campos[]	= 'usu_cidade';		$valores[]	= $_POST['usu_cidade'];
		$campos[]	= 'usu_estado';		$valores[]	= $retorno['cpy_zona'];
		$campos[]	= 'usu_fonecel';	$valores[]	= $_POST['usu_fonecel'];
					
		$campos[]	= 'usu_promocional';	$valores[]	= $_POST['usu_promocional']=='1' ? '1' : '0';
		$campos[]	= 'usu_email';		$valores[]	= $_POST['usu_email'];
		$campos[]	= 'usu_situacao';	$valores[]	= '1';
		$campos[]	= 'usu_pcompra';	$valores[]	= '0';
		$campos[]	= 'usu_senha';		$valores[]	= md5($_POST['usu_senha']);
		$campos[]	= 'usu_del';		$valores[]	= 0;

		$campos[]	= 'usu_facebookid';		$valores[]	= $_POST['usu_facebookid'];
							
		$campos[]	= 'usu_datacad';		$valores[]	= date("Y-m-d");
		$msg 		= $obj_sql->insert($campos,$valores,TB_CADASTRO);
		$idtemp = mysql_insert_id();				
		$_SESSION['cadok'] = '1';
		$_SESSION['USER'] = $obj_sql->Get_Array("SELECT * FROM ".TB_CADASTRO." WHERE usu_id = '$idtemp'");
		$_SESSION['PAYMENT'] = '1';
		$_SESSION['USERFB'] = array();
		
		if ($_POST['usu_promocional']=='1') {
			newsletter_insert($_POST['usu_nome'],$_POST['usu_email'],retdata2($_POST['usu_nascimento']),$_POST['usu_sexo'],$_POST['usu_cidade'],$retorno['cpy_zona'],$_POST['usu_fonecel']);
		}
		
		//implementação nova, anula o if que mostrava a mensagem de retorno
		//header("Location: ".$go);
		//die;
		
	}
} 
if ($_POST['act'] <> 'post') {
	$_SESSION['cadok']='0';
	if (isset($_SESSION['USERFB']['facebookid'])) {
		$_POST['usu_nome'] = $_SESSION['USERFB']['nome'];
		$_POST['usu_email'] = $_SESSION['USERFB']['email'];
		$_POST['usu_facebookid'] = $_SESSION['USERFB']['facebookid'];
	}
}
include("header-pgto.php");
?>  
   
    <section class="container">
      <? if ($_SESSION['cadok']=='1') { ?>    
      <div class="body-content">
        <div class="row">
          <div class="col-md-12">
            <h1>Reg&iacute;strate</h1>
          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-12">
            <form name="formCadastro" id="formCadastro" class="form" method="post" action="<?=$go?>">
           
            <h2>Su inscripci&oacute;n se ha realizado correctamente!</h2>
            
            <div style="text-align:center; margin: 30px 0">
             <input name="Submit" type="submit" class="btn" value="Continuar">
            </div>
            </form>
          </div>
        </div>
      </div>							
		  <? } else { ?>    
      <div class="body-content">
        <div class="row">
          <div class="col-md-12">
            <h1>Reg&iacute;strate</h1>
          </div>
        </div>

        <br>

        <div class="row">
          <div class="col-md-12">
            <? if (count($erro)>0) { ?>
            <div class="alert alert-error"><strong>Los errores se encontraron en el registro:</strong><br>
            <?=implode("<br>",$erro)?></div>
            <? } ?>

            <form name="formCadastro" id="formCadastro" class="form" method="post" action="/novo-cadastro">         
            <div class="box-cadastro">
            <div class="right obs">* Obs.: Campos obrigatorios</div>                           
            <h2>Datos Personales</h2>

            <div class="form-inline">
            <div class="row">
            <div class="col-sm-6 col-md-6">
            <p>
            <label id="tdnome">
            Nombre Completo
            *:</label>
            <input name="usu_nome" type="text" id="usu_nome"  value="<?=$_POST['usu_nome']?>" />
            </p>

            <p>
            <label id="tdcpf">Cédula de identidad o RUC*:</label>
            <input name="usu_cpfcnpj" type="text"  id="usu_cpfcnpj" value="<?=$_POST['usu_cpfcnpj']?>" onKeyPress="return apenasNumero(this,event)" />
            </p>

            <p id="trdata" <?= $_POST['usu_tipop']=='juridica' ? 'style="display:none"' : '' ?> >
            <label>Fecha de Nacimiento *:</label>
            <input name="usu_nascimento" type="date" class="size-ss" id="usu_nascimento"  value="<?=$_POST['usu_nascimento']?>" maxlength="10" />
            </p>
            </div>
            <div class="col-sm-6 col-md-6">
            <p id="trsexo" <?= $_POST['usu_tipop']=='juridica' ? 'style="display:none"' : '' ?> >
            <label>Sexo *:</label>
            <input type="radio" name="usu_sexo" id="usu_sexo_m" value="M" <?=$_POST['usu_sexo']=='M' || $_POST['usu_sexo']<>'F' ? 'checked="checked"' : '' ?> style="width:5%" /> 
            <span class="left" >Masculino</span><input type="radio" name="usu_sexo" id="usu_sexo_f" value="F" <?=$_POST['usu_sexo']=='F' ? 'checked="checked"' : '' ?> style="width:5%"  />
            <span class="left" >Femenino</span>
            </p>

            <p>
            <label>Teléfono *:</label>
            <input name="usu_fonecel" type="text" id="usu_fonecel" class="mask-celular" value="<?=$_POST['usu_fonecel']?>" />
            </p>                                        
            </div>

            </div>
            </div>
            <br>
            <div class="form-inline">
            <div class="row">
            

            <div class="col-sm-6 col-md-6">
            <h2>Direcci&oacute;n de Entrega</h2> 
            <p>
            <label>Direcci&oacute;n *:</label>
            <input name="usu_endereco" type="text" class="size-m" id="usu_endereco" value="<?=$_POST['usu_endereco']?>" />
            </p>

            <p>
            <label>C&oacute;digo postal *:</label> <input name="usu_cep" id="usu_cep" type="text" class="size-ss" onKeyPress="return apenasNumero(this,event)" value="<?=$_POST['usu_cep']?>" maxlength="9" />
            </p>

            <p>
            <label>Ciudad:</label>
            <input name="usu_cidade" type="text" class="size-m" id="cidad" value="<?=$_POST['usu_cidade']?>" />
            </p>                   
            </div>
            <div class="col-sm-6 col-md-6">
            <h2>Identificaci&oacute;n</h2>
            <p>
            <label>Email *:</label>
            <input name="usu_email" type="text" class="size-m" id="usu_email" value="<?=$_POST['usu_email']?>" />
            </p>

            <p>
            <label>Contrase&ntilde;a *:</label>
            <input name="usu_senha" type="password" class="size-s" id="usu_senha"  value="<?=$_POST['usu_senha']?>" />
            </p>

            <p>
            <label>Repetir contrase&ntilde;a *:</label>
            <input name="usu_confsenha" type="password" class="size-s" id="usu_confsenha"  />
            </p>

            <p><label>&nbsp;</label><input name="usu_promocional" type="checkbox" id="usu_promocional" value="1" checked="checked" style="width:5%" />

            &iquest;Quieres recibir ofertas y promociones en mi e-mail</p>                   
            </div>
            </div>
            </div> 

            <br>

            </div>  
            <input name="act" type="hidden" id="act" value="post" />
            <input name="valid" type="hidden" id="valid" value="1" />
            <input name="usu_estado" type="hidden" id="usu_estado" value="<?=$_POST['usu_estado']?>" />
            <input name="go" type="hidden" id="go" value="<?=$go?>" />
             <input name="usu_facebookid" type="hidden" id="usu_facebookid" value="<?=$_POST['usu_facebookid']?>" />
            </form>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" align="center">
            <a href="javascript:void(0)" onClick="avisoPost();$('#formCadastro').submit();" class="btn">Finalizar Registro</a>
          </div>      
        </div>
      </div>
       <? } ?>
    </section>    

<? include("footer-pgto.php"); ?>