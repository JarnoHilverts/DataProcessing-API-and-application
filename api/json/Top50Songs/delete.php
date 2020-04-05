<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  $jsonpage = file_get_contents('php://input');
  //Get draft 07 to check validation in validate.php
  $jsonSchema = file_get_contents('../XML_JSON_bestanden/Top50CountrySongs_draft7.json');
  if (validate_json($jsonpage, $jsonSchema) == false)
  { 
      echo "De huide json is niet valid";
  }
  else
  {
    $post->country = $data->countries->country[0]->name;
    $post->rank = $data->countries->country[0]->data[0]->rank;

    // Delete post
    if($post->delete()) 
    {
      echo json_encode(
        array('message' => 'Post Deleted')
      );
    } 
    else 
    {
      echo json_encode(
        array('message' => 'Post Not Deleted')
      );
    }
  }