<?php
require_once("jCMS_cfg.php");

// если есть новая страница и данные корректны, создадим
if(preg_match ("/^[йцукенгшщзхъфывапролджэячсмитьбюЙЦУКЕНГШЩЗХЪФЫВАРОЛДЖЭЯЧСМИТЬБЮ\d_\-\.\!\?\" ]{1,140}$/", $_REQUEST['title'])) {
	$translit=rus2translit($_REQUEST['title']);
	file_put_contents( 'jCMS_pages.php' , '$A["'.$translit.'"]="'.$_REQUEST['title'].'";'."\n" , FILE_APPEND );
	echo "<p>Page created</p>";
	$id     =$translit; 
	$title  =$_REQUEST['title'];
	$file   ="$subFolder/$id.php";  
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
<?php 
  }
?>
<h3>Create page</h3>
<form action="jCMS_edit.php" method="post">
  <input placeholder="title" name="title" value="" />
  <input type="submit" />
</form>
<?php
foreach ($A as $k=>$v){
  echo "<a href='jCMS_edit.php?page=$k'>$v</a><br />";
  } 


function rus2translit($text){
	// Русский алфавит
	$rus_alphabet = array(
		'А', 'Б', 'В', 'Г', 'Д', 'Е', 'Ё', 'Ж', 'З', 'И', 'Й',
		'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф',
		'Х', 'Ц', 'Ч', 'Ш', 'Щ', 'Ъ', 'Ы', 'Ь', 'Э', 'Ю', 'Я',
		'а', 'б', 'в', 'г', 'д', 'е', 'ё', 'ж', 'з', 'и', 'й',
		'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф',
		'х', 'ц', 'ч', 'ш', 'щ', 'ъ', 'ы', 'ь', 'э', 'ю', 'я'
	);
	// Английская транслитерация
	$rus_alphabet_translit = array(
		'A', 'B', 'V', 'G', 'D', 'E', 'IO','ZH','Z', 'I', 'I',
		'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F',
		'H', 'C', 'CH','SH','SH', '', 'Y', '',  'E', 'IU','IA',
		'a', 'b', 'v', 'g', 'd', 'e', 'io','zh','z', 'i', 'i',
		'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
		'h', 'c', 'ch','sh','sh', '', 'y', '',  'e', 'iu','ia'
	);
	$s=str_replace($rus_alphabet, $rus_alphabet_translit, $text);
  $s=preg_replace("/[\!\?\"\>\<\'\`\~\,\@\#\$\%\^\:\;\&\*\(\)\{\}\[\]\+\-\=\r\n\t]+/","",$s);
  $s=preg_replace("/[ _]+/","_",$s);
	return $s;
}







?>

