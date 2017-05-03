<?php

	include("excelwriter.inc.php");
	
	$excel=new ExcelWriter("products.xls");
	
	if($excel==false)	
		echo $excel->error;
		
		
	$excel->writeRow();
	$excel->writeCol("Имя");
	$excel->writeCol("Фамилия");
	$excel->writeCol("Адрес");
	$excel->writeCol("Возраст");
		
	//$myArr=array("Name","Last Name","Address","Age");
	//$excel->writeLine($myArr);

	$myArr=array("Sriram","Pandit","23 mayur vihar",224);
	$excel->writeLine($myArr);
	
	$excel->writeRow();
	$excel->writeCol("Manoj");
	$excel->writeCol("Tiwari");
	$excel->writeCol("80 Preet Vihar");
	$excel->writeCol(224);
	
	$excel->writeRow();
	$excel->writeCol("Harish");
	$excel->writeCol("Chauhan");
	$excel->writeCol("115 Shyam Park Main");
	$excel->writeCol(222);

	$myArr=array("Tapan","Chauhan","1st Floor Vasundhra",225);
	$excel->writeLine($myArr);
	
	$excel->close();
	echo "data is write into myXls.xls Successfully.";
?>