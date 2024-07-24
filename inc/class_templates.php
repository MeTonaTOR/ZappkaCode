<?php
	$templates = "";
	class templates {
		function get($title, $eslashes=1, $htmlcomments=1) {
			$template = @file_get_contents("./templates/".$title.".tpl");

			$output = "<!-- START: {$title} -->";
			$output .= str_replace("\\'", "'", addslashes($template));
			$output .= "<!-- END: {$title} -->";
			return $output;
		}
	}

	$templates = new templates($templates);