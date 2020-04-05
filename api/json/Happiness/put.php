<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  //get raw data input
  $data = json_decode(file_get_contents("php://input"));
  $jsonpage = file_get_contents('php://input');
  //get draft 07 to check validation in validate.php
  $jsonSchema = file_get_contents('../XML_JSON_bestanden/Happines_draft7.json');
  if (validate_json($jsonpage, $jsonSchema) == false)
  { 
      echo "De huide json is niet valid";
  }
  else
  {
    $post->country = $data->countries->country[0]->name;
    $post->rank = $data->countries->country[0]->rank;
    $post->score = $data->countries->country[0]->score;
    $post->GDPperCapita = $data->countries->country[0]->GDPperCapita;
    $post->socialSupport = $data->countries->country[0]->socialSupport;
    $post->healthLifeExperience = $data->countries->country[0]->healthLifeExperience;
    $post->freedomToMakeChoices = $data->countries->country[0]->FreedomToMakeChoices;

    // Update post
    if($post->update()) 
    {
      echo json_encode(
        array('message' => 'Post Updated')
      );
    } 
    else 
    {
      echo json_encode(
        array('message' => 'Post Not Updated')
      );
    }
  }
?>