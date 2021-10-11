<?php
	session_start();

	function ErrorMessage(){
	    if(isset($_SESSION['ErrorMessage'])){
	        $output = '<div class = "alert alert-danger" style = "text-align: center; font-size:16px;" role = "alert">';
	        $output .= htmlentities($_SESSION['ErrorMessage']);
	        $output .= '</div>';
	        $_SESSION['ErrorMessage'] = null;
	        return $output;
	    }

	}



	function SuccessMessage(){
	    if(isset($_SESSION['SuccessMessage'])){
	        $output = '<div class = "alert alert-success" style = "text-align: center; font-size:16px;" role = "alert">';
	        $output .= htmlentities($_SESSION['SuccessMessage']);
	        $output .= '</div>';
	        $_SESSION['SuccessMessage'] = null;
	        return $output;
	    }

	}


	function WarningMessage(){
	    if(isset($_SESSION['WarningMessage'])){
	        $output = '<div class = "alert alert-warning" style = "text-align: center; font-size:16px;" role = "alert">';
	        $output .= htmlentities($_SESSION['WarningMessage']);
	        $output .= '</div>';
	        $_SESSION['WarningMessage'] = null;
	        return $output;
	    }

	}


?>