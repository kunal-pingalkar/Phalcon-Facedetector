<?php

/**
 * @desc: This class to detect whether the uploaded image file is face image or not.
 */
class FacedetectorController extends FdetectorController
{
	/**
	 * This action will upload the file and detect the face image.
	 */
    public function detectAction()
    {
		// Check whether the file has been selected or not.
		if ($this->request->hasFiles() == true)
		{
			$config = include __DIR__ . "/../../app/config/config.php";
			$detector = $this->di->get('FdetectorController');
			$detector->indexAction($config->application->resourceDir."detection.dat");
			//Print the real file names and their sizes
            foreach ($this->request->getUploadedFiles() as $file)
            {
            		// Upload the file
            		$fileName = time()."_".$file->getName();
					move_uploaded_file($file->getTempName(), $config->application->uploadDir.$fileName);
					$selectFile = $config->application->uploadDir.$fileName;
					// check the file type.
					if($file->getType() == "image/jpeg"){
						$detector->faceDetectAction($selectFile);
					}elseif($file->getType() == "image/png"){
						$image =imagecreatefrompng($selectFile);
					}elseif($file->getType() == "image/gif"){
						$image =imagecreatefromgif($selectFile);
					}
					elseif($file->getType() == "image/bmp"){
						$image =imagecreatefrombmp($selectFile);
					}
					// Checked whether the image object is created or not.
					if(!empty($image)){
						$exploded = explode('.',$fileName);
	    				unset($exploded[count($exploded) - 1]);
						$imageNewName = implode(".",$exploded) . '.jpg';
						imagejpeg($image, $config->application->uploadDir.$imageNewName);
	 					imagedestroy($image);
						$detectImage = $config->application->uploadDir.$imageNewName;
						$detector->faceDetect($detectImage);	
						// Remove the unwanted images
						chmod($selectFile, 777);
						unlink($selectFile);
						$selectFile = $detectImage ;
					}
					// Check if the face is detected or not.
					if($detector->face['w'] > 0){
						// Remove the unwanted images.
						chmod($selectFile, 777);
						unlink($selectFile);
						echo "<div style='color:red;'>Human face is detected....!,<br /> Image has not been uploaded.</div>";	
					}else{
						echo "<div style='color:green;'>Human face is not detected....!,<br /> Image has been uploaded successfully.</div>";		
					}
					// Return to the inex controller
            		return $this->dispatcher->forward(array(
		                "controller" => "index",
		                "action" => "index"
		            ));
            }
		}
		else
		{
			// Error message if file is not been selected.
			$this->flash->error("<font color='red'>File has been not selected to detect the face.</font>");
			return $this->dispatcher->forward(array(
                "controller" => "index",
                "action" => "index"
            ));
		}
    }

}
