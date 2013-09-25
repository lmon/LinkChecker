<?php
/*
 * open a file for reading
 * pull out all href values
 * validate all calues
 * output results 
 * 
 */
    class LinkChecker {
    	
		private $filename;
		private $rawhtml;
		private $linkvalues;
		private $passes = 0;
		private $fails = 0;
		
		function __construct(){
			return true;
		}
		
		public function openFile(){
			$this->filename = 'story-markup.html'; 
			if($this->rawhtml = file_get_contents($this->filename)){
				return true;	
			}
			return false;
		}
		
		public function extractHrefValues(){
			if(isset($this->rawhtml)){
			    $url   = preg_match_all('/<a [^>]*href\s*=\s*[\"\']?([^"\'>]*)[\"\'][^>]*?>/si', $this->rawhtml, $this->linkvalues);			
			    if(count($this->linkvalues)){
				   $this->linkvalues = $this->linkvalues[1];
			    }
				return true;
			}
			return false;
		}	
		
		public function validateLinks(){			
			if(count($this->linkvalues)){
				foreach($this->linkvalues as $k=>$link){
					# 2 kinds of valid links
					# 1 External (http|https|ftp|mailto) , requires " :// "
					# 2 internal (begin with a / or ./ or ../ or with a alpahnumeric )
					if( preg_match('/(^(http|https|ftp|mailto):\/\/)|^(#|..\/|\/|.\/)/si', $link)){
						print "PASS ";
						$this->passes++;		
					}else{
						print "FAIL ";
						$this->fails++; 
					}				
					print $k." ".$link ."\n";
				}
				$this->summary();
				return true;
			}
			return false;
		}
		private function summary(){
			print "Total Links: ".count($this->linkvalues)."\n";
			print "Total Passes: ".$this->passes."\n";
			print "Total Fails: ".$this->fails."\n";			
		} 
    }
?>