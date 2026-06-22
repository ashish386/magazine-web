<?php 
namespace App\Libraries;

    class ImageProcess
    {
        
    public function uploadFile($file,$path){
        
            if ($file && $file->isValid() && ! $file->hasMoved())
            {
                $newName = $file->getRandomName(); 
                $file->move(ROOTPATH . 'public/uploads/'.$path, $newName); 
                return $newName;
            }
            return '';
    }

    public function saveBase64ImageToFile($base64Image,$path)
        {


//            if (empty($base64Image)) {
//                return $this->response->setStatusCode(400)->setBody('No image data provided.');
//            }
//            // Extract image data and type
//            $data = explode(',', $base64Image);
//            $encodedImage = count($data) > 1 ? $data[1] : $data[0];
//
//            echo $mimeType = explode(';', $data[0])[0];
//             $extension = str_replace('data:image/', '', $mimeType);die;
//
//            // Decode the Base64 string
//             $decodedImage = base64_decode($encodedImage); 
//
//            // Define file path and name
//            $uploadPath = 'public/uploads/'.$path;
//            if (!is_dir($uploadPath)) {
//                mkdir($uploadPath, 0777, true);
//            }
//
//            $fileName = uniqid() . '.' . $extension; 
//            $filePath = $uploadPath. '/'. $fileName;
//
//            // Save the image
//            if (file_put_contents($filePath, $decodedImage)) {
//                return  $fileName;
//            } else {
//                return '';
//            }
        
        
            
            if (empty($base64Image)) {
                return $this->response->setStatusCode(400)->setBody('No image data provided.');
            }
        
                // Remove "data:image/png;base64," part if exists
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $match)) {
                $imageType = $match[1]; // png, jpg, jpeg
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
            } 

            $data = base64_decode($base64Image);

            // Define file path and name
            $uploadPath = 'public/uploads/'.$path;
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }
           
            // Create filename
            $fileName = uniqid() . '.' . $imageType;
            $filePath = $uploadPath. '/'. $fileName;
            
            // Save file
            
            if (file_put_contents($filePath, $data)) {
                return  $fileName;
            } else {
                return '';
            }
        }
}