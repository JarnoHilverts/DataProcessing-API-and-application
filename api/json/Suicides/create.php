<?php
// Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  //get raw data input
  $data = json_decode(file_get_contents("php://input"));
  $jsonpage = file_get_contents('php://input');
  //get draft 07 to check validation in validate.php
  $jsonSchema = file_get_contents('../XML_JSON_bestanden/Suicide_template_draft7.json');
  if (validate_json($jsonpage, $jsonSchema) == false)
  { 
      echo "De huide json is niet valid";
  }
  else
  {
    $post->country = $data->countries->country[0]->name;
    $post->year = $data->countries->country[0]->data[0]->year;
    $post->suicides = $data->countries->country[0]->data[0]->suicides;
    $post->population = $data->countries->country[0]->data[0]->population;

    // Create post
    if($post->create()) 
    {
      echo json_encode(
        array('message' => 'Post Created')
      );
    } else 
    {
      echo json_encode(
        array('message' => 'Post Not Created')
      );
    }
  }
?>