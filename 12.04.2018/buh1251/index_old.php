<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251">
</head>
<?php
setlocale(LC_ALL, "russian");
//setlocale(LC_ALL, 'ru_RU.CP1251');
//setlocale(LC_ALL, "ru_RU");
//setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
  $pryz_platezhu="Йцукенг";
    // $pryz_platezhu = iconv('cp1251', 'utf-8', $pryz_platezhu);
     //$pryz_platezhu=str_replace(" ", "", $row['PryznachPlatezhu']);
    $pryz_platezhu=strtoupper($pryz_platezhu);
     echo $pryz_platezhu; echo "<br>";die();

?>
</html>