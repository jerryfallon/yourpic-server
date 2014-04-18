<?php
	class Uploader extends stdClass {

		function __construct() {
			$mb = 1048576;
			$this->maxFileSize = 20 * $mb;
			$this->saveDir = 'upload/';
			$this->allowedTypes = ['image/gif'=>true, 'image/jpeg'=>true, 'image/jpg'=>true, 'image/png'=>true];
		}

		public function uploadPhoto($file) {
			// Check if the file exists
			if(empty($file)) {
				die(json_encode(['error'=>'No file received']));
			}
			//echo('File exists; ');

			// Check if the file has an error
			if($file['error']) {
				die(json_encode(['error'=>'File error: ' . $file['error']]));
			}
			//echo('No file error; ');

			// Check if it's a valid file type
			if(empty($this->allowedTypes[$file['type']])) {
				die(json_encode(['error'=>'"' . $file['type'] . '" is not an allowed type']));
			}
			//echo('Allowed type (' . $file['type'] . '); ');

			// Check if it's under the max file size
			if($file['size'] > $this->maxFileSize) {
				die(json_encode(['error'=>$file['size'] . ' is above the max file size of ' . $this->maxFileSize]));
			}
			//echo('Under max file size (' . $file['size'] . '); ');

			// Check if the temp file exists
			if(!file_exists($file['tmp_name'])) {
				die(json_encode(['error'=>'Uploaded file not found']));
			}
			//echo('Temp file found on server; ');

			// ------- We're just letting the server overwrite the old file for now -------- //
			/*
			// Check if a file with this name already exists in the upload folder
			if(file_exists($saveDir . $file['name'])) {
				die(json_encode(['error'=>'File already exists on server']));
			}
			//echo('File does not already exist; ');
			*/

			// Move the file out of the temp directory
			if(!move_uploaded_file($file['tmp_name'], $this->saveDir . $file['name'])) {
				die(json_encode(['error'=>'Error moving file']));
			}
			//echo('Moved file successfully');

			die(json_encode(['success'=>true, 'path'=>$saveDir . $file['name']]));
		}
	}
?>
