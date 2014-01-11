<?php

require_once ("jCMS_pages.php");

// параметры которые надо менять для нового сайта
$pageURL='http://wanty.ru/index.php?page='; // адрес до любой страницы без ID
// пароля нет, зато закрыто по IP вот так в .htaccess
/*
<Files wp-login.php>
order deny,allow
deny from all
allow from 1.2.3.4
</Files>
*/

// параметры конфига которые можно не трогать при новой установке
$page=$_REQUEST['page']; // параметр page, название статьи в транслите
$text=stripslashes($_REQUEST['text']); // параметр text, статья
$subFolder='pages';

// определяем 3 главные переменные id, title и text
$id='404';
$title='Ничего не найдено';
$file="$subFolder/404.php";
foreach ($A as $k=>$v){
  if ($page==$k) {
    $id=$page;
    $title=$v;
    $file="$subFolder/$k.php";
    $fileTemp="$subFolder/{$id}_".time().".php";
    }
  }

// создаем меню
$menu='<ol>';
foreach ($A as $k=>$v)
  $menu.="<li><a href=\"$pageURL$k\">$v</a></li>";
$menu.='</ol>';

?>