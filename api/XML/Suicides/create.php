<?php
// Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/xml');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Get raw posted data
  $data = simplexml_load_file("php://input");
  $xmlpage = file_get_contents('php://input');

  $xmlSchema = '../XML_JSON_bestanden/Suicide_template_xsd.xsd';
  //var_dump($xml);
  if (validate_xml($xmlpage, $xmlSchema) == false)
  {
      echo "De huide XML is niet valid";
  }
  else
  {
    $post->country = $data->country[0]->name;
    $post->year = $data->country[0]->data[0]['year'];
    $post->suicides = $data->country[0]->data[0]->suicides;
    $post->population = $data->country[0]->data[0]->population;

    $doc = new DOMDocument('1');
    $doc->formatOutput = true;
    $root = $doc->createElement('message');
    $root = $doc->appendChild($root);
    //Create post
    if($post->create()) 
    {
      $message = $doc->createTextNode('Post created');
      $root->appendChild($message);
      echo $doc->saveXML();
    } 
    else 
    {
      $message = $doc->createTextNode('Post not created');
      $root->appendChild($message);
      echo $doc->saveXML();
    }
  }
?>