<?php
require './LinkChecker.php';

$link = new LinkChecker();

# does it construct
if($link){
	echo "Contructor True\n";
}else{
	echo "Contructor False\n";	
	exit;
}

#can u open the file
if($link->openFile()){
		echo "openFile True\n";
}else{
	echo "openFile False\n";	
	exit;
}

if($link->extractHrefValues()){
		echo "extractHrefValues True\n";
}else{
	echo "extractHrefValues False\n";
	exit;	
}

if($link->validateLinks()){
		echo "validateLinks True\n";
}else{
	echo "validateLinks False\n";
	exit;	
}



?>
