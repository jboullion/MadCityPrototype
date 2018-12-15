<?php 
/**
 * A Class for useful functions
 */
class Utilities {
	//used for various timing purposes
	var $start;
	var $end;

	/**
	 * Debug function display cleaner information
	 * 
	 * @param mixed $data Any PHP variable you want to debug
	 */
	function print($data){
		echo '<pre class="jb-print">'.print_r($data, true).'</pre>';
	}

	/**
	 * Start a timer
	 */
	function startTimer(){
		$this->start = microtime(true);
	}

	/**
	 * End timer and return result
	 */
	function endTimer(){
		$this->end = microtime(true);
		return $this->end - $this->start;
	}
}