<?php
class AppController extends Controller {
    var $helpers = array('Javascript', 'Html', 'Form', 'Session');
    function beforeFilter() {
	}
	
	
	function __generate_file_name($dir, $filename)
	{
		$cnt = 1;
		$info = pathinfo($filename);
		$tmp = $dir . DS . $filename;
		while(is_file($tmp))
		{
			$tmp = $dir . DS . $info['filename'] . $cnt++ . '.' . $info['extension'];
			if ($cnt > 100) break;
		}
		return $tmp;


	}
}
?>
