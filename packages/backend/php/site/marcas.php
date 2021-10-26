<?
include("_setup.php");
$TAG_title = 'Marcas';
include("header.php");

?> 

   
    <div class="container">    
      <div class="body-content">
        <div class="row">
          <div class="col-sm-12">
            <h1> Marcas</h1>            
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12">
            <?
            $cate = '';
						$qidm = $obj_sql->Query("select * from ".TB_FORNECEDOR." where for_del<>'1' and for_ext<>'' and for_categoria<>'' order by for_categoria asc, for_ordem desc");
            while($rowm = $obj_sql->Fetch_Array($qidm)) { 
              if ($cate<>$rowm['for_categoria']) {
                if ($cate<>'') {print('</ul>');}
                $cate=$rowm['for_categoria'];
                ?>
                <h2 style="clear: both;"><?=substr($rowm['for_categoria'],2)?></h2>
                <ul class="list-marcas">
                <?
              }
            ?>
                            <li><a href="<?=linkcat(0,NULL,NULL,$rowm['for_id'])?>"><img src="/files/for_<?=$rowm['for_id']?>.<?=$rowm['for_ext']?>" class="img-responsive img-center" alt=""></a></li>
                          <? } ?>
                          </ul>           
          </div>
        </div>  
      </div>
    </div>   
    
<?php 
  include("footer.php"); 
?>