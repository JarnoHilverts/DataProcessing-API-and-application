<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  $jsonpage = file_get_contents('php://input');
  $jsonSchema = file_get_contents('../XML_JSON_bestanden/Top50CountrySongs_draft7.json');
  if (validate_json($jsonpage, $jsonSchema) == false)
  { 
      echo "De huide json is niet valid";
  }
  else
  {
    $post->country = $data->countries->country[0]->name;
    $post->rank = $data->countries->country[0]->data[0]->rank;
    $post->title = $data->countries->country[0]->data[0]->title;
    $post->artist = $data->countries->country[0]->data[0]->artist;
    $post->genre = $data->countries->country[0]->data[0]->genre;

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