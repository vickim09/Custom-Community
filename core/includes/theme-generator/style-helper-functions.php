<?php
/**
* This function removes comments, spaces and line breaks
* @param string $buffer
* @return stripped $buffer
*/
function compress($buffer) {
    // cut out the comments
    $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);
    // remove the spaces, line breaks, etc.
    $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '   '), '', $buffer);
    return $buffer;
}

/**
* This function creates static file
* @param string $content
* @param string $filename
* @param boolean $flag
*/
function create_static_css_file($content, $filepath, $mode = 'w+'){
    if($handle = fopen($filepath, $mode)){
		if(is_writable($filepath)){
			fwrite($handle, $content);
			fclose($handle);
			return true;
		}
		else{
			//TODO: error handler
			return false;
		}
    }else{
		//TODO: error handler (user notification)
		return false;
    }
}

/**
* This function removes static css files
* @param string or array of string values filename
*/
function cc_remove_static_css_files($filenames){
    if(is_array($filenames)){
		$names_arr = $filenames;
    }elseif(is_string($filenames)){
		$names_arr[] = $filenames;
    }else{
		return false;
    }
	
    foreach( $names_arr as $val ){
		if(file_exists($val)){
			unlink($val);
		}
    }
}

/**
* This function creates new directory
* @param string $dirpath
*/
function cc_mkdir($dirpath){
    if(!file_exists($dirpath)){
		if(mkdir($dirpath, 0777)){
			return true;
		}else{
			return false;
			//TODO: error handler (user notification)
		}
    }
    return true;
}

/**
* This function overwrites option by it's name
* @param string $new_value
* @param string $opt_name
* @param string $option_key
*/
function cc_overwrite_option($new_value, $opt_name, $inner_key = ''){
    if(!empty($inner_key)){
		$opt_val = get_option($opt_name);
		if(array_key_exists($inner_key, $opt_val)){
			$opt_val[$inner_key] = $new_value;
		}
	}else{
		$opt_val = $new_value;
	}

	if(update_option($opt_name, $opt_val)){
		return true;
    }else{
		return false;
    }
}