<!DOCTYPE html>
<html lang="en">
<head>
  <title>OPEN AI</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

  <div class="container">
   <div class="col-sm-4">
    <h1>OPEN AI</h1>
    <h3>Generate Image from text</h3>

    <?php

    if(isset($_POST["prompt"])) {

      $curl = curl_init();



      curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.openai.com/v1/images/generations',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
          "prompt": "'.$_POST['prompt'].'",
          "n": 1,
          "size": "1024x1024"
        }',
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json',
          'Authorization: Bearer $YOUR_API_KEYS'
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);

      $imageinfo=json_decode($response);

      
      foreach ($imageinfo->data as $key => $value) {
        echo 'Result for '.$_POST['prompt'].': <img src="'.$value->url.'" width="400px"/>';
      }


    }
    ?>




    <form method="POST">
      <div class="form-group">
        <label for="comment">Prompt:</label>
        <!-- <textarea class="form-control" rows="5" id="prompt" name="prompt"></textarea> -->
        <input type="text" name="prompt" class="form-control">
      </div>
      <input type="submit" class="btn btn-primary" value="Send" />
    </form>
  </div>
</div>

</body>
</html>
