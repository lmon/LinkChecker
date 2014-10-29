<?php
/* Test Link Checker 
    Runs some tests for the LinkChecker class
    Usage: CLI: php Test_LinkChecker.php
    Lucas Monaco 9/26/13
*/
require './LinkChecker.php';

$link = new LinkChecker();

/* 
	Another option : Just get a list of valid links
	$link->openFile();
	$link->extractAndValidate();
 */

/* get full report of valid & invalid */
# does it construct
if(!$link){
	echo "Contructor False\n";	
	exit;
}

#can u open the file
if(!$link->openFile()){
	echo "openFile False\n";	
	exit;
}

if(!$link->extractHrefValues()){
	echo "extractHrefValues False\n";
	exit;	
}

if(!$link->validateLinks()){
	echo "validateLinks False\n";
	exit;	
}

print "\nThis is the end====\n";
?>
