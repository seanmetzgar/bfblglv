<?php
	function Argv2Request($argv) {
	    /*
	      When $_REQUEST is empty and $argv is defined,
	      interpret $argv[1]...$argv[n] as key => value pairs
	      and load them into the $_REQUEST array

	      This allows the php command line to subsitute for GET/POST values, e.g.
	      php script.php animal=fish color=red number=1 has_car=true has_star=false
	     */


	    if ($argv !== NULL && sizeof($_REQUEST) == 0) {
	        $argv0 = array_shift($argv); // first arg is different and is not needed

	        foreach ($argv as $pair) {
	            list ($k, $v) = split("=", $pair);
	            $_REQUEST[$k] = $v;
	        }
	    }
	}