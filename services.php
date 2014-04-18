<?php

	include 'Uploader.php';
	$uploader = new Uploader();
	$uploader->uploadPhoto($_FILES['file']);

?>