<?php
/* Test Link Checker 
   Class to catalogue valid & broken links on a local file
   
   Will
 * open a local file for reading
 * pull out all href values
 * validate all values against a definition of a valid URL
 * output results 
 * usage: 
	$link = new LinkChecker();
	$link->openFile();
	$link->extractHrefValues()
	$link->validateLinks()
 *
 */
    class LinkChecker {
    	 
		private $rawhtml;
		private $linkvalues;
		private $passes = 0;
		private $fails = 0;
		private $filename = 'story-markup-large.html'; // run on story-markup-large to see it work on 104000 links
		
		function __construct(){
			return true;
		}
		/*
		* openFile
		* no frills: did not add file presence or permissions validation
		* assigns value to rawhtml
		* returns true / false
		*/
		public function openFile(){ 
			return ($this->rawhtml = @file_get_contents($this->filename)  );
		}
		/*
		* extractAndValidate
		* to be used as an alt to extractHrefValues
		* assumes a few things about a valid link:
			# 2 kinds of valid links
			# -1 External (http|https|ftp|mailto) , requires " :// "
			# -2 internal (begin with a / or ./ or ../ or # or with a alpahnumeric )
		* assigns value to linkvalues
		* requires rawhtml
		* returns true / false					
		*/
		public function extractAndValidate(){
			if(isset($this->rawhtml)){
			    preg_match_all('/<a [^>]*href\s*=\s*[\"\']?((((http|https|ftp|mailto):\/\/)|#|\/|..\/|.\/)?[^"\'>]*)[\"\'][^>]*?>/si', $this->rawhtml, $this->linkvalues);			
			    if(count($this->linkvalues)){
				   print_r($this->linkvalues[1]);
			    }
				return true;
			}
			return false;
		}	

		
		/*
		* extractHrefValues
		* assigns value to linkvalues
		* requires rawhtml
		* returns true / false
		*/
		public function extractHrefValues(){
			if(isset($this->rawhtml)){
			    preg_match_all('/<a [^>]*href\s*=\s*[\"\']?([^"\'>]*)[\"\'][^>]*?>/si', $this->rawhtml, $this->linkvalues);			
			    if(count($this->linkvalues)){
				   $this->linkvalues = $this->linkvalues[1];
			    }
				return true;
			}
			return false;
		}	
		
		/*
		* validateLinks
		* assumes a few things about a valid link:
			# 2 kinds of valid links
			# -1 External (http|https|ftp|mailto) , requires " :// "
			# -2 internal (begin with a / or ./ or ../ or # or with a alpahnumeric )
		* assigns value to linkvalues, passes, fails
		* requires linkvalues
		*/
		public function validateLinks(){			
			if(count($this->linkvalues)){
				foreach($this->linkvalues as $link){
					# 2 kinds of valid links
					# 1 External (http|https|ftp|mailto) , requires " :// "
					# 2 internal (begin with a / or ./ or ../ or with a alpahnumeric )
					if( preg_match('/(^(http|https|ftp|mailto):\/\/)|^(#|..\/|\/|.\/)/si', $link)){
						$this->passes++ ;
						echo "Pass: ";
					}else{
						$this->fails++;
						echo "Fail: ";
					} ; 				
					echo "$link \n";
				}
				$this->summary();
				return true;
			}
			return false;
		}

		/*
		* summary
		*/
		private function summary(){
			echo "Total Links: ".count($this->linkvalues)."\n";
			echo "Total Passes: ".$this->passes."\n";
			echo "Total Fails: ".$this->fails."\n";		
		} 
    }
?>