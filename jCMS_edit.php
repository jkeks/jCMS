<?php
require_once("jCMS_cfg.php");

if
  ( // если есть новая страница и данные корректны, создадим
  preg_match ("/^[a-zA-Z0-9_\-]{1,140}$/", $_REQUEST['translit']) && 
  preg_match ("/^[^\"\']{1,140}$/", $_REQUEST['title'])
  ) {
    file_put_contents( 'jCMS_pages.php' , '$A["'.$_REQUEST['translit'].'"]="'.$_REQUEST['title'].'";'."\n" , FILE_APPEND );
    echo "<p>Page created</p>";
    $id     =$_REQUEST['translit']; 
    $title  =$_REQUEST['title'];
    $file   ="$subFolder/$id.php";  
    }
  else
    { // если что-то прислали, но корявое, то ошибка
    if ($_REQUEST['title']!='' || $_REQUEST['translit']!=''){ echo "<p>Page not created.</p>"; }
    }


//если приехал новый текст
if ($id!='' && $id!='404' && $text!=''){
  // сделать бэкап
  if (file_exists($file))
    rename ($file, $fileTemp);
  // записать новую статью
  file_put_contents($file,$text);
  }
if ($id!='' && $id!='404'){
  $textFromFile='';
  if (file_exists($file))
    $textFromFile=file_get_contents($file);
?>
<h3>Edit: <a href="<?=$pageURL?><?=$id?>"><?=$title?></a></h3>
<form action="jCMS_edit.php" method="post">
  <textarea style="width:100%;height:85%" name="text"><?=$textFromFile?></textarea>
  <input type="hidden" name="page" value="<?=$id?>" /> 
  <input type="submit" style="width:100%;height:9%;font-size:70px;" />
</form>
<h3>Create page</h3>
<form action="jCMS_edit.php" method="post">
  <input placeholder="title"    name="title"    value="" /><br />
  <input placeholder="translit" name="translit" value="" />
  <input type="submit" />
</form>
<?php 
  }
  
foreach ($A as $k=>$v){
  echo "<a href='jCMS_edit.php?page=$k'>$v</a><br />";
  } 




?>

