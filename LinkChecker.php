<?php
/*
 * open a local file for reading
 * pull out all href values
 * validate all values against a definition of a valid URL
 * output results 
 * usage: 
$link = new LinkChecker();
$link->openFile();
$link->extractHrefValues()
$link->validateLinks()

 */
    class LinkChecker {
    	 
		private $rawhtml;
		private $linkvalues;
		private $passes = 0;
		private $fails = 0;
		private $filename = 'story-markup.html';
		
		function __construct(){
			return true;
		}
		/*
		* openFile
		*/
		public function openFile(){ 
			return ($this->rawhtml = @file_get_contents($this->filename)  );
		}
		
		/*
		* extractHrefValues
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
		*/
		public function validateLinks(){			
			if(count($this->linkvalues)){
				foreach($this->linkvalues as $link){
					# 2 kinds of valid links
					# 1 External (http|https|ftp|mailto) , requires " :// "
					# 2 internal (begin with a / or ./ or ../ or with a alpahnumeric )
					( preg_match('/(^(http|https|ftp|mailto):\/\/)|^(#|..\/|\/|.\/)/si', $link) ? $this->passes++ : $this->fails++ ); 				
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