<?php
	function RedirectTo($newlocation){
		header('location:' . $newlocation);
		exit();
	}
?>