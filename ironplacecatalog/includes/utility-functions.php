<?php

	function IronGgetValueFromWpAdminSettings($name,$defaultValue){
		$value = (!empty(get_option($name))) ? strip_tags(get_option($name)) : $defaultValue;
		return $value;
	}

?>