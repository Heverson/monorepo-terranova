<?php
include('../_config.php');
include('../_setup.php');
require_once("../class.sql.php");

/*
ini_set('display_errors', 1); 
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);
*/
extract($_GET);



if(!empty($action)){

    switch ($action){
        case 'session':
            getSession($login,$password);
            break;

        case 'products':
            getProducts($type);
            break;

        case 'banners':
            getBanners();
            break;

        case 'categories':
            getCategories();
            break;

        case 'mail':
            sendMail();
            break;

        case 'brands':
            getBrands();
            break;
    }

}

function getSession($login, $password){
    $obj_sql = new Sql();
    
    $query_sql = "SELECT * from usuario WHERE use_login = '".$login."' OR use_email = '".$login."' AND  use_senha = '".md5($password)."'";
    $qidm = $obj_sql->Query($query_sql);
    $authenticated = [];
    $status = '404';
    if ($obj_sql->Num_Rows($qidm)>0) {
        while($rowm = $obj_sql->Fetch_Array($qidm)) { 
            array_push($authenticated, $rowm);
        }
        $status = '200';
    }

    $result = array('status'=> $status, 'authenticated' => $authenticated);
    echo json_encode($result);
    exit;
}

function getProducts($type){
   
    $obj_sql = new Sql();

    if($type === 'best'){
        $query_sql = "select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                    inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
                    inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
                    left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
                    where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>0 order by a.pro_visto desc limit 8";
    }
    if($type === 'news'){
        $query_sql = "select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                    inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
                    inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
                    left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
                    where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>0 order by a.pro_lancamento desc limit 8";
    }
    if($type === 'moresale'){
        $query_sql = "select distinct a.*, c.for_nome, c.for_ext, spr.pmo_perc, spr.pmo_perca, spr.pmo_titulo, sps.pms_titulo, sps.pms_id from ".TB_PRODUTO." a
                    inner join ".TB_FORNECEDOR." c on a.pro_for_id=c.for_id
                    inner join ".TB_PRODUTO_CATEGORIA." h on h.pro_id=a.pro_id
                    left join (select pr.pro_id, pr.pmo_perc, pr.pmo_perca, po.pmo_titulo, po.pmo_id from ".TB_PROMOCAO_PRODUTO." pr inner join ".TB_PROMOCAO." po on pr.pmo_id = po.pmo_id and po.pmo_status='1' and po.pmo_dataini<='".date("Y-m-d H:i:s")."' and po.pmo_datafim>='".date("Y-m-d H:i:s")."' group by pr.pro_id) as spr on a.pro_id=spr.pro_id 
			left join ( select pp.pro_id, px.pms_titulo, px.pms_id from ".TB_PROMOGRES_PRODUTO." pp inner join (select ps.pms_id, ps.pms_titulo from ".TB_PROMOGRES." ps where ps.pms_status='1' and ps.pms_dataini<='".date("Y-m-d H:i:s")."' and ps.pms_datafim>='".date("Y-m-d H:i:s")."' order by ps.pms_prioridade desc limit 1) as px on pp.pms_id=px.pms_id ) as sps on a.pro_id=sps.pro_id 
                    where a.pro_del<>'1' and a.pro_situacao='1' and a.pro_reserva>=0 and a.pro_estoque>0 order by a.pro_maisvendidos desc limit 8";
    }

    $qidm = $obj_sql->Query($query_sql);
    $data = [];
    $status = '404';
    var_dump($obj_sql->Num_Rows($qidm));
    echo "ver \n";
    if ($obj_sql->Num_Rows($qidm)>0) {
        while($row = $obj_sql->Fetch_Array($qidm)) { 
            // recupera a foto
            $qidf = $obj_sql->Query("select * from ".TB_PRODFOTOS." where fot_pro_id='".$row['pro_id']."' order by fot_principal desc limit 1");
            if ($row = $obj_sql->Fetch_Array($qidf)) {
              $imagem = $CFG->wwwpath."/files/pro_".$rowf['fot_id']."_m.".$rowf['fot_ext'];
            } else {
              $imagem = $CFG->wwwpath."/img/noimg_p.jpg";
            }
            var_dump($row);
           
        }
        $status = '200';

        echo $query_sql;
        exit;
        foreach($data as $key => $value){
            $dataFormatted[$key]['pro_id'] = $value['pro_id'];
            $dataFormatted[$key]['pro_nome'] = utf8_encode($value['pro_nome']);
            $dataFormatted[$key]['pro_descricao'] = utf8_encode($value['pro_descricao']);
            $dataFormatted[$key]['pro_preco'] = utf8_encode($value['pro_preco']);
            $dataFormatted[$key]['pro_desconto'] = utf8_encode($value['pro_desconto']);
            $dataFormatted[$key]['pro_descper'] = utf8_encode($value['pro_descper']);
            $dataFormatted[$key]['for_nome'] = utf8_encode($value['for_nome']);
            $dataFormatted[$key]['for_ext'] = utf8_encode($value['for_ext']);
            $dataFormatted[$key]['imagem'] = utf8_encode($value['imagem']);
        }
    }
    


    $result = array('status'=> $status, 'data' => $dataFormatted, 'type' => $type);
    echo json_encode($result);
    exit;
}

function getCategories(){
    $obj_sql = new Sql();
    $query_sql = "select * from categoria where cat_del<>'1' and cat_idpai='0' order by cat_ordem asc";
    $qidm = $obj_sql->Query($query_sql);
    $data = [];
    $status = '404';
    
    $dataFormatted = [];

    if ($obj_sql->Num_Rows($qidm)>0) {
        
        while($rowm = $obj_sql->Fetch_Array($qidm)) { 
            array_push($data, $rowm);
        }

        $status = '200';
        
        foreach($data as $key => $value){
            $dataFormatted[$key]['cat_id'] = $value['cat_id'];
            $dataFormatted[$key]['cat_idpai'] = $value['cat_idpai'];
            $dataFormatted[$key]['cat_nome'] = utf8_encode($value['cat_nome']);
        }

    }
    $result = array('status'=> $status, 'data' => $dataFormatted);
    //echo json_last_error_msg(); // Print out the error if any
    echo json_encode($result);

    exit;
}

function getBanners(){
    $obj_sql = new Sql();
    $query_sql = "select * from tvcommerce where tvf_del<>'1' and tvf_local='inicial' and tvf_situacao='1' and tvf_dataini<='".date("Y-m-d H:i:s")."' and tvf_datafim>='".date("Y-m-d H:i:s")."' order by tvf_ordem desc";
    $qidm = $obj_sql->Query($query_sql);
    $data = [];
    $status = '404';
    
    if ($obj_sql->Num_Rows($qidm)>0) {
        while($rowm = $obj_sql->Fetch_Array($qidm)) { 
            array_push($data, $rowm);
        }
        $status = '200';
        $dataFormatted = [];
        foreach ($data as $key => $value) {
            $dataFormatted[$key]['link'] = $value['tvf_link'];
            $dataFormatted[$key]['imgUrl'] = 'https://shoppingterranova.com.py/files/tvfm_'.$value['tvf_id'].$value['tvf_extm'];
        }
    }
    

    $result = array('status'=> $status, 'data' => $dataFormatted);
    echo json_encode($result);
    exit;
}

function sendMail(){
    $obj_sql = new Sql();
    $query_sql = "select * from fornecedor where for_del<>'1' and for_destaquetopo='1' order by for_ordem desc";
    $qidm = $obj_sql->Query($query_sql);
    $data = [];
    $status = '404';

    if ($obj_sql->Num_Rows($qidm)>0) {
        while($rowm = $obj_sql->Fetch_Array($qidm)) { 
            array_push($data, $rowm);
        }
        $status = '200';
        
         $dataFormatted[$key]['link'] = $value['tvf_link'];
    }
    $result = array('status'=> $status, 'data' => $data);
    echo json_encode($result);
    exit;
}

function getBrands(){
    $obj_sql = new Sql();
    $query_sql = "select * from fornecedor where for_del<>'1' and for_destaquetopo='1' order by for_ordem desc";
    $qidm = $obj_sql->Query($query_sql);
    $data = [];
    $status = '404';
    
    if ($obj_sql->Num_Rows($qidm)>0) {
        while($rowm = $obj_sql->Fetch_Array($qidm)) { 
            array_push($data, $rowm);
        }  
        $status = '200';
        $dataFormatted = [];
        foreach ($data as $key => $value) {
            $dataFormatted[$key]['for_id'] = $value['for_id'];
            $dataFormatted[$key]['for_ext'] = $value['for_ext'];
            $dataFormatted[$key]['img'] = utf8_encode("/files/for_".$value['for_id'].$value['for_ext']."");
        }
    }
    
    $result = array('status'=> $status, 'data' => $dataFormatted);
    echo json_encode($result);
    exit;
}
?>