<?php
require_once("header.php");
//setlocale(LC_ALL, 'uk_UA.CP1251', 'uk_UA.CP1251');
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');
//setlocale(LC_ALL, 'ru_RU.UTF-8', 'rus_RUS.UTF-8', 'Russian_Russia.UTF-8');

//setlocale(LC_ALL, 'ru_RU.UTF-8');

//setlocale(LC_TIME,"russian.65001");
//setlocale (LC_ALL, array ('ru_RU.utf-8', 'rus_RUS.utf-8')); //uk_UA.UTF-8
//setlocale(LC_ALL, 'ru_RU.UTF-8', "en_US.UTF-8");
//setlocale(LC_ALL, 'uk_UA.UTF-8');
//setlocale(LC_ALL, 'uk_UA.UTF-8');
//setlocale(LC_ALL, 'ru_RU.UTF-8', 'Russian_Russia.65001');

//$c=mysqli_connect("localhost","root","","buhgalter");
//$c=mysqli_connect("localhost","root","","dentist");
//$c=mysqli_connect("localhost","root","","buh_kirik");





$c=mysqli_connect("localhost","root","","buh_kirik_1251");
//��� ����� ������ � ���� ���� ����� ������� � �������� ������������ ������
 $dirname = "Y:/VYPYSKA/";
 if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }

  /*
//������� �������� ��������� ���� ���� 2007-03-20 � ���� 070320
  function change_date($date_val)
  {
  $arrdata_reestr=explode ('-',$date_val);
 $ayy_mm_dd=array_reverse($arrdata_reestr);
 $ayy_mm_dd=array_reverse($ayy_mm_dd); 
  $yy_mm_dd = implode('', $ayy_mm_dd);
 $yy_mm_dd=substr_replace($yy_mm_dd, '', 0, 2);
  return $yy_mm_dd;
  }
  */
  //������� �������� ��������� ���� ���� 31.01.2018 � ���� 180131
  function change_date($date_val)
  {
  $arrdata_reestr=explode ('.',$date_val);
 $ayy_mm_dd=array_reverse($arrdata_reestr);
  $yy_mm_dd = implode('', $ayy_mm_dd);
 $yy_mm_dd=substr_replace($yy_mm_dd, '', 0, 2);
  return $yy_mm_dd;
  }
  //����������� ��� ���. ���� ��� �� �������� ���������� FALSE
  function parse_inn($inn){    

	    //$id must contain 10 digits

	    if (empty($inn) || !preg_match('/^\d{10}$/',$inn)) return false;	     

	    $months = array('������', '�������', '�����', '������', '���', '����', '����', '�������', '��������', '�������', '������', '�������');	 

	    $result = array();

	    $result['inn'] = $inn;

	    $result['sex'] = (substr($inn, 8, 1) % 2) ? 'm' : 'f';      


	    $split = str_split($inn);

	
	    $summ = $split[0]*(-1) + $split[1]*5 + $split[2]*7 + $split[3]*9 + $split[4]*4 + $split[5]*6 + $split[6]*10 + $split[7]*5 + $split[8]*7;

	    $result['control'] = (int)($summ - (11 * (int)($summ/11)));      


	    $result['status'] = ($result['control'] == (int)$split[9]) ? true : false;

	 
	    $inn = substr($inn, 0, 5);

	    $normal_date = date('d.m.Y', strtotime('01/01/1900 + ' . $inn . ' days - 1 days'));

	    list($result['day'], $result['month'], $result['year']) = explode('.', $normal_date);

	    $result['str_month'] = $months[$result['month'] - 1];

        //    return $result["status"];
            //���������� ������ INN (true or false)
            return $result["status"];
           
             
           //  return $result; //���������� ������ array(8) { ["inn"]=> float(2453913974) ["sex"]=> string(1) "m" ["control"]=> int(4) ["status"]=> bool(true) ["year"]=> string(4) "1967" ["month"]=> string(2) "03" ["day"]=> string(2) "09" ["str_month"]=> string(10) "�����" } 

	}
        
   //������� ������ "���������� �������" ������� ��� � ��� � ����� �������� � ������� privatbank
        function update_INN_FIO($nazn_platezha, $id)
        {
            global $c;
              //��������� ���������� ������� � ������� �������, ����� ������ ������ ���������� ��������� �� ������ ������� 
    //$nazn_platezha=  strtoupper($nazn_platezha);
    //�������� ";" �� " "
    $nazn_platezha=str_replace(";", " ", $nazn_platezha);
  //  echo $row['naznach_platezha']; echo "<br>";
  //������ ���
 $pattern_inn='/[1-9]{1}[0-9]{9}/';  
 //������ ��� �������� ������ ������������ ��� �������� �.�. ��� �������� �. ��� �������� ��.
 //$patten_fio="/[�-߲��I'`]{3,}\s[�-߲��I'`]{4,}\s[�-߲��I'`]{5,}|[�-߲��I'`]{3,}\s[�-߲��I'`]{1}\.[�-߲��I'`]{1}\.|[�-߲��I'`]{3,}\s[�-߲��I'`]{1}\.|[�-߲��I'`]{3,}\s[�-߲��I'`]{2}\./i";
 $patten_fio="/[�-߲��I'`]{3,}\s[�-߲��I'`]{2,}\s[�-߲��I'`]{8,}|[�-߲��I'`]{3,}\s[�-߲��I'`]{1}\.[�-߲��I'`]{1}\./i";

$catch1=preg_match($pattern_inn, $nazn_platezha, $matches_inn);
$matches_inn[0]=trim($matches_inn[0]);

preg_match($patten_fio, $nazn_platezha, $matches_fio); 
  echo "inn";  echo $matches_inn[0]; echo "<br>";
  echo "fio= ";  echo $matches_fio[0]; echo "<br>";

 // $matches_fio[0]=str_replace("`", "/`",  $matches_fio[0]);
       
        //� ��������� ��� �� ���������� �������� parse_inn():
  /*
     if (parse_inn($matches_inn[0]))
    {
         //���� ��� �������� ���������� ��� � ���� "egrpo" � ��� ���������� � ���� "name_kontragenta"
          $query_update="update privatbank set egrpo='$matches_inn[0]', name_kontragenta='$matches_fio[0]'  where ID=$id";   
   echo $query_update; echo " 1"; echo "<br>";
     mysqli_query($c,$query_update);         
        echo "��� ��������";
    }  else {
        //���� ��� �� �������� ���������� INVALID INN � ���� "egrpo" � ��� ���������� � ���� "name_kontragenta"
         $query_update="update privatbank set egrpo='INVALID INN', name_kontragenta='$matches_fio[0]'  where ID=$id";   
          echo $query_update; echo " 2"; echo "<br>";
         mysqli_query($c,$query_update);
    echo "��� �� ��������";
    }  
    */
     //��� ��� �� ��������� �� ���������� �.�. ��� ��� ����� ����� ������������� �������   ���������� ��� � ���� "egrpo" � ��� ���������� � ���� "name_kontragenta"
          $query_update="update privatbank set egrpo='$matches_inn[0]', name_kontragenta='$matches_fio[0]'  where ID=$id";   
   echo $query_update; echo " 1"; echo "<br>";
     mysqli_query($c,$query_update);     

        }
        
        
echo '<form name="collection_data" action = "index.php?process=1" method="post" enctype="multipart/form-data" onsubmit="return checkvalidForm ( )">';
     
echo '<br>';  
 echo "���� ��� ������� (.txt): ";
  echo '<input type="file" name="file_name" size="50" maxlength="50" value="" >'; //����� ���� value="C:\TMP\" ������
 echo '<br>';
 echo '<br>';
 echo '<br>';
 echo '<br>';
 
 echo "����������� �� �������� ���� LIQPAY: ";
  echo '<input type="file" name="file_LIQPAY" size="50" maxlength="50" value="" >'; //����� ���� value="C:\TMP\" ������
 echo '<br>';
 /*
 echo "����������� �� �������� ������ ���: ";
  echo '<input type="file" name="dnk" size="50" maxlength="50" value="" >'; //����� ���� value="C:\TMP\" ������
 echo '<br>';
  
  */
 echo '<tr>'; echo '<td>';echo '<input type="reset"  value="��������">'; echo '</td>'; 
  echo '<td>';echo '<input type="submit"  value="��������">'; echo '</td>'; echo '</tr>';
 
  echo '</form> ';
  
  if($_GET[process]==1)
  {
 //   setlocale(LC_ALL, 'ru_RU.UTF-8', 'rus_RUS.UTF-8', 'Russian_Russia.UTF-8');
        //��� ����� �������� � $file
$file_LIQPAY = basename($_FILES['file_LIQPAY']['name']);
$liqpay_status_file=preg_match('/LiqPay/', $file_LIQPAY); 
  if ($file_LIQPAY!='')
      {   
      if ($liqpay_status_file!=1)           
   {
       echo '<script type="text/javascript">alert("�������� ���� ���������� � ����� LiqPay \n ������������� ��������� � ����������� .txt !!!");</script>';
       //����������� �����
       echo '<script type="text/javascript">javascript:history.go(-1);</script>';
            die();
   } 

// ������ ���������� ����� LIQPAY
   

$content = file_get_contents($dirname."".$file_LIQPAY);

//$content = iconv('cp1251', 'utf-8', $content);
//������� �� �����  ";" ��� ����� ������
 $content=str_replace(";", " ", $content);
 //������� �� �����  '"' ��� ����� ������
 $content=str_replace('"', " ", $content);
//��������� ���� �� ������ �� �������� ������ \n
$string = explode("\n", $content); 
//�������  ������� LIQPAY
$query="truncate table liqpay";
mysqli_query($c,$query);
//�������� ��������� � $i=1;, ���������� �����, ������� ���������� � $i=0; ������
$i=1;
while ($string[$i])
{  
   $item = explode("\t", $string[$i]);  
   //����� ����������� ������ � ���������� ������ ������ ������ ��������� �� ���
  $item[16]=str_replace("'", "''", $item[16]);
  //������� ������� �������, ����� �� ���� ������ ��� ��������
 $item[16]=str_replace('"', "", $item[16]);
    $query = "INSERT INTO liqpay (id, description_pay) values ('$item[0]','$item[16]')";
   mysqli_query($c,$query);  
    
    $i++;
}
      }

       
  //��������� �������� ���� ������� ��� ����� ��������  � $file
$file = basename($_FILES['file_name']['name']);
if ($file!='')
{

//�������� ���������� �����
   $file_extension=strrchr($file, '.');     
    //��������� � ������ �������
   $file_extension=strtolower($file_extension);  
  //��������� ���������� ������  
   if ($file_extension!='.txt')           
   {
       echo '<script type="text/javascript">alert("����� ���������� ������ ��������� ����� � \n ������������� ��������� � ����������� .txt !");</script>';
       //����������� �����
       echo '<script type="text/javascript">javascript:history.go(-1);</script>';
            die();
   }  

// ������ ���������� �����

$content = file_get_contents($dirname."/".$file);
//$content = iconv('cp1251', 'utf-8', $content);
//������� �� �����  ";" ��� ����� ������
 //$content=str_replace(";", " ", $content);
 //�������� " �� *, ����� �� ���� ������� ��� �������� ����� � ����
 ////////$content=str_replace('"', "*", $content);
//��������� ���� �� ������ �� �������� ������ \n
$string = explode("\n", $content); 

   // $string[$i]=str_replace("\n", "", $string[$i]);
   
     
//var_dump($string);
//������� �������� �������
$query="truncate table privatbank";
mysqli_query($c,$query);



//�������� ��������� � $i=1;, ���������� �����, ������� ���������� � $i=0; ������
$i=0;
while ($string[$i])
{
    
   
    
   $item = explode("\t", $string[$i]);  
   //������������ � ���� ��� ����� ����� 180331
   // $item[0]=change_date($item[0]);
   // $item[6]=change_date($item[6]);
    //�� ���������� �������� ������ ������� "������� �������" � "������� ������" ����� ���������� �����
     $item[13]=trim($item[13], "\n");
      $item[13]=trim($item[13], "\r");
     // � ������������ ���� � ������ ������
   // $item[28]=change_date($item[28]);
    
    //$item[28]=str_replace("\n", "", $item[28]);
    //��� ��������� ����� ����������� ��������, ����� �� ���� ������ ��� ��������
     $item[6]=str_replace("'", "''", $item[6]);
     $item[8]=str_replace("'", "''", $item[8]);
    
 /*   
 $query = "INSERT INTO ukrgazbank (DATA_VYP, MFOBRecepient, PerAccountRecepient, EDRPOU_oderzhuvacha,NAME,NomerPlatDokumenta,DateFirstDocument,FPayment,MfoBankuVidpravn,RozrahRahVidpravn, OKPO_KOR, NazvaBankuPlatnyka, CUR_TAG, CurrencyID, CUR_RATE, AC_CUR_TAG,
AccountCurrencyCode, SumaPlatezhu, SUM_PD_EQ, PryznachPlatezhu, IN_RST_NO, IN_RST_EQ, OUT_RST_NO, OUT_RST_EQ, DB_SUM_NOM, CR_SUM_NOM, DB_SUM_EQ,
CR_SUM_EQ, VyhidnaData) 
   values ("$item[0]","$item[1]",'$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','$item[8]','$item[9]','$item[10]','$item[11]','$item[12]','$item[13]','$item[14]','$item[15]','$item[16]','$item[17]','$item[18]','$item[19]','$item[20]','$item[21]','$item[22]','$item[23]','$item[24]','$item[25]','$item[26]','$item[27]','$item[28]')";
 */ 
    $query = "INSERT INTO privatbank (nomer, data_provodki, time_provodki, suma, empty_field,currency,naznach_platezha,egrpo,name_kontragenta,bill_kontragenta,mfo_kontragenta,our_bill,name_our_bill,referens) 
             values ('$item[0]','$item[1]','$item[2]','$item[3]','$item[4]','$item[5]','$item[6]','$item[7]','$item[8]','$item[9]','$item[10]','$item[11]','$item[12]','$item[13]')";
 
  // echo $query; echo "<br>";
   
 
   mysqli_query($c,$query);
   
    
    $i++;
}

//die();
$result_total_line=0;
$all_lines=0;
//����� select ������ �������� ����������� �����
/*
$str_sql_zapr="select FileName, ID `PaymentID`,`MfoBankuVidpravn`, `RozrahRahVidpravn`, `MFOBRecepient` , `PerAccountRecepient` , `FPayment`, `SumaPlatezhu`
,`CostType`, `isSumCorrect`, `CurrencyID`, `NomerPlatDokumenta`, DateFirstDocument, `VyhidnaData`, `NazvaPlatnyka`,`NazvaBankuPlatnyka`, `PryznachPlatezhu`, `EDRPOU_oderzhuvacha`
, `KOD_RK`, `SubektNadannyaPoslug`, `KodRegionu`, `KodPoslugi`, `Wtype` FROM ukrgazbank";
*/
$str_sql_zapr="select id, naznach_platezha from privatbank"; 
$result = mysqli_query($c,$str_sql_zapr);
while($row = mysqli_fetch_array($result))
  {// echo $row['naznach_platezha'];
    

//������������ LIQPAY    
    $patten_LIQPAY="/LIQPAY ID\s[0-9]{9}/";
    $catch_LIQPAY=preg_match($patten_LIQPAY, $row['naznach_platezha'], $matches_LIQPAY);
    if ($catch_LIQPAY=="1")
    {
 //  ���������� liqpay_id
    $liqpay_id=trim($matches_LIQPAY[0],'LIQPAY ID ');
    $sql_to_liqpay="select description_pay from liqpay where id=$liqpay_id";
$result_liqpay = mysqli_query($c,$sql_to_liqpay);
while($item = mysqli_fetch_array($result_liqpay))
  {
//echo "LIQPAY   ";    echo $row['description_pay'];
    //��������� ��� � ��� ��� LIQPAY
  update_INN_FIO($item['description_pay'], $row['id']);
 
  
  }
    }else //���� �� LIQPAY �� ������������ ������� � ���
    {
        //������ ���
// $pattern_inn='/\;|\*&[1-9]{1}[0-9]{9}\;/';   
 $pattern_inn='/[1-9]{1}[0-9]{9}/';   
$catch_inn=preg_match($pattern_inn, $row['naznach_platezha'], $matches_inn);

echo $catch_inn; echo "<br>";
if ($catch_inn==1) //
    { 
    //� ���������� ������� ������� "," 
    //$row['naznach_platezha']=  str_replace(",", "", $row['naznach_platezha']);
    echo $row['naznach_platezha']; echo "<br>";
      //������ "���������� �������" � ��������� ��� � ���
    update_INN_FIO($row['naznach_platezha'], $row['id']);  
    }
    }
   
    echo "<br>";
        
    
    /*
   
    //��������� ���� FileName
    $query="update ukrgazbank set FileName='20180305.exp' where id=$row[PaymentID]";            
     mysqli_query($c,$query);
  
     
     //���������� ��� �� �� 'PryznachPlatezhu'
    
    // $pryz_platezhu="�������";
    // $pryz_platezhu = iconv('cp1251', 'utf-8', $pryz_platezhu);
     //�������� ���������� �� �������
     $pryz_platezhu=str_replace("I", "�", $row['PryznachPlatezhu']);
     $pryz_platezhu=str_replace("B", "�", $pryz_platezhu);
      $pryz_platezhu=str_replace("K", "�", $pryz_platezhu);
        $pryz_platezhu=str_replace("X", "�", $pryz_platezhu);
          $pryz_platezhu=str_replace("M", "�", $pryz_platezhu);
            $pryz_platezhu=str_replace("O", "�", $pryz_platezhu);
           
   
   // $pryz_platezhu=strtoupper($pryz_platezhu);
     
     //�������� I ���������� ��  �  ����������
    // $pryz_platezhu=str_replace("I", "�", $row['PryznachPlatezhu']);
    // echo $pryz_platezhu." ";  echo $row[PaymentID]." ";
 //$pattern1='/[�-��-�A-Za-z�]{2}[0]{1}[1-9]{5}/';   
 $pattern1='/[�-� �-� �]{2}[0-9]{6}/';   
 $pattern2 = '/[�-� �-� �]{2}[0-9]{5}/'; 
 //$pattern2 = '/[�-��-��]{2}|[�-��]{2}[0-9]{5}/'; 
 
$catch1=preg_match($pattern1, $pryz_platezhu, $matches1); 
//echo $catch1; echo "<br>";
if ($catch1==1)
{
 // echo  $matches1[0]; echo " X"; echo "<br>"; 
    $pos = strpos($pryz_platezhu, $matches1[0]);
$pos=$pos-2;
$length=strlen($matches1[0]);
$kod_rk=substr($pryz_platezhu, $pos, $length+2);
$bukvy_kod_rk=substr($kod_rk, 0, 4);
$cifry_kod=substr($kod_rk, 4, 8);
$cifry_kod=ltrim($cifry_kod, "0");
$kod_rk="".$bukvy_kod_rk.$cifry_kod;

//���������� �� ���� �� ��� ��������� ��� ������������ �������
$query_to_notar="select * from notar where kod_rk='$kod_rk'";
//echo $query_to_notar; echo "<br>";
 //echo $kod_rk." "; echo $row[PaymentID]; echo "<br>";

//echo $query_to_notar; die();
$result_from_notar = mysqli_query($c,$query_to_notar);
while($row_notar = mysqli_fetch_array($result_from_notar))
  {
   $string_name_notar=$row_notar['PRIVAT_NOTAR'].$row_notar['NAME'];
   $kod_rk_base=$row_notar['KOD_RK'];
  
   if ($kod_rk_base!="")
   {
       //���� ������� � ���� notar ������ ��������� $result_total_line 
       $result_total_line++;
   }
   
 //echo  $kod_rk_base; echo "<br>";

  }


//������� ������� ������ �� ����� ������
$string_name_notar=str_replace("\r", " ", $string_name_notar);
$string_name_notar=str_replace("\n", " ", $string_name_notar);
//��� ��������� ����� ����������� ��������, ����� �� ���� ������ SQL ������� ��� ��������
$string_name_notar=str_replace("'", "''", $string_name_notar);


    //���������� ��� ��
   $query="update ukrgazbank set kod_rk='$kod_rk_base', SubektNadannyaPoslug='$string_name_notar'  where ID=$row[PaymentID]";   
  // echo $query; echo "<br>";
     mysqli_query($c,$query);
     
  $kod_rk_base="";   
  $string_name_notar="";
  

    //echo $kod_rk; echo " 1"; echo "<br>"; 
    
  // echo  $matches1[0]; echo " 1"; echo "<br>"; 
}

$catch2=preg_match($pattern2, $pryz_platezhu, $matches2); 
//echo $matches2[0]; die();

if ($catch2==1 && $catch1==0)
{
    $pos = strpos($pryz_platezhu, $matches2[0]);
$pos=$pos-2;
$length=strlen($matches2[0]);
$kod_rk=substr($pryz_platezhu, $pos, $length+2);

  // echo  $matches2[0]; echo " 2"; echo "<br>";
//���������� �� ���� �� ��� ��������� ��� ������������ �������
$query_to_notar="select * from notar where kod_rk='$kod_rk'";

//echo $matches2[0]." "; echo $kod_rk." "; echo $row[PaymentID]; echo "<br>";
//echo $query_to_notar; die();
$result_from_notar = mysqli_query($c,$query_to_notar);
while($row_notar = mysqli_fetch_array($result_from_notar))
  {
   $string_name_notar=$row_notar['PRIVAT_NOTAR'].$row_notar['NAME'];
   $kod_rk_base=$row_notar['KOD_RK'];
   
    if ($kod_rk_base!="")
   {
       //���� ������� � ���� notar ������ ��������� $result_total_line 
       $result_total_line++;
   }
 
  }


//������� ������� ������ �� ����� ������
$string_name_notar=str_replace("\r", " ", $string_name_notar);
$string_name_notar=str_replace("\n", " ", $string_name_notar);
 //��� ��������� ����� ����������� ��������, ����� �� ���� ������ SQL ������� ��� ��������
$string_name_notar=str_replace("'", "''", $string_name_notar);

    //���������� ��� ��
   $query="update ukrgazbank set kod_rk='$kod_rk_base', SubektNadannyaPoslug='$string_name_notar'  where id=$row[PaymentID]";     
     mysqli_query($c,$query);
     
  $kod_rk_base="";   
  $string_name_notar="";

}
//����� �����
$all_lines++;

*/

  }
  
  //�������  ������� LIQPAY
//$query="truncate table liqpay";
//mysqli_query($c,$query);
  
 
  
 /* 
  $query=  "SELECT  nomer, data_provodki,suma, naznach_platezha, egrpo , name_kontragenta , bill_kontragenta, mfo_kontragenta FROM privatbank

INTO OUTFILE '/orders.csv' 
FIELDS TERMINATED BY ';'

LINES TERMINATED BY '\n'";
  //  ENCLOSED BY ".'"'."
   mysqli_query($c,$query);
  */
  
  
  
  $finish_file="�;���� ��������;�����;���������� �������;������;������������ �����������;���� �����������;��� �����������\n";
  // $finish_file="�\t���� ��������\t�����\t���������� �������\t������\t������������ �����������\t���� �����������\t��� �����������\n";
  //$finish_file='';
  $finish_query=  "SELECT  * FROM privatbank";
  $result = mysqli_query($c,$finish_query);
while($row = mysqli_fetch_array($result))
  {   
   //������� �� "���������� �������" ";"
   // $row[naznach_platezha]=str_replace(";", " ",  $row[naznach_platezha]);
//$finish_file=$finish_file.$row[nomer]."\t".$row[data_provodki]."\t".$row[suma]."\t".$row[naznach_platezha]."\t".$row[egrpo]."\t".
   //     $row[name_kontragenta]."\t".$row[bill_kontragenta]."\t".$row[mfo_kontragenta]."\n";
$finish_file=$finish_file.$row[nomer].";".$row[data_provodki].";".$row[suma].";".$row[naznach_platezha].";".$row[egrpo].";".
        $row[name_kontragenta].";".$row[bill_kontragenta].";".$row[mfo_kontragenta]."\n";
//$finish_file=$finish_file.'"'.$row[nomer].'"'.";".'"'.$row[data_provodki].'"'.";".'"'.$row[suma].'"'.";".'"'.$row[naznach_platezha].'"'.";".'"'.$row[egrpo].'"'.";".'"'
  //      .$row[name_kontragenta].'"'.";".'"'.$row[bill_kontragenta].'"'.";".'"'.$row[mfo_kontragenta].'"'."\n";
//$row[].";".
    // echo $row[MfoBankuVidpravn]; echo ";";echo $row[RozrahRahVidpravn];echo "\n";
  }
  
 // $finish_file=iconv('utf-8', 'cp1251', $finish_file);
  //echo $finish_file;
  
  
   //�������� ���������� ����� � ".txt" �� ".csv "
   $file=str_replace(".txt", ".csv ", $file);
 
  //Write file result
 $file= $dirname.$file;
  file_put_contents($file, $finish_file);
  
  echo "<br>";
echo "��������� $result_total_line ����� � $all_lines �����";
echo "<br>";
echo "����� ������� ��� :)";  
}
 // Commit transaction
mysqli_commit($c);
  // ����������� �� ���� ������ 
 mysqli_close($c);

  }
  
 

?>
        </body>
</html>