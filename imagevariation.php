<?php
if(isset($_POST["submit"])) {

  $target_dir = "images/";
  $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
  $uploadOk = 1;
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image

  $check = getimagesize($_FILES["gambar"]["tmp_name"]);
  if($check !== false) {
    
    if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/images/variations',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => array('image'=> new CURLFILE($target_file),'n' => '1','size' => '1024x1024'),
        CURLOPT_HTTPHEADER => array(
          'Authorization: Bearer $YOUR_API_KEYS'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $imageinfo=json_decode($response);

      echo 'Before: <img src="'.$target_file.'" width="400px"/>';

      // print_r($_POST);

      foreach ($imageinfo->data as $key => $value) {
        echo 'After: <img src="'.$value->url.'" width="400px"/>';
      }

    }

  } else {
    echo "File is not an image.";

  }
}



?>

<h1>Open AI Image Variation</h1>
<form method="post" enctype="multipart/form-data">
  <label>Select Image File:</label>
  <input type="file" name="gambar">
  <input type="hidden" name="n" value="1">
  <input type="hidden" name="size" value="1024x1024">
  <input type="submit" name="submit" value="Upload">
</form>
