<?php 
	if($_POST){
		$params = $_POST['params'];
		$data = std_class_object_to_array((json_decode(file_get_contents($_POST['url'].$params))));
		echo json_encode($data['data']['info'])
	}
	
	function std_class_object_to_array($stdclassobject)
	{
		$_array = is_object($stdclassobject) ? get_object_vars($stdclassobject) : $stdclassobject;
	
		foreach ($_array as $key => $value) {
			$value = (is_array($value) || is_object($value)) ? std_class_object_to_array($value) : $value;
			$array[$key] = $value;
		}
	
		return $array;
	}
?>