<?php
// Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/xml');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  //Get raw data input
  $data = simplexml_load_file("php://input");
  $xmlpage = file_get_contents("php://input");
  //Get xsd to check validation in validate.php
  $xmlSchema = '../XML_JSON_bestanden/Top50CountrySongs_xsd.xsd';
  if (validate_xml($xmlpage, $xmlSchema) == false)
  {
      echo "De huide XML is niet valid";
  }
  else
  {
    $post->country = $data->country[0]->name;
    $post->rank = $data->country[0]->data[0]['rank'];
    $post->title = $data->country[0]->data[0]->title;
    $post->artist = $data->country[0]->data[0]->artist;
    $post->genre = $data->country[0]->data[0]->genre;

    //New DOMdoc to output xml data 
    $doc = new DOMDocument('1');
    $doc->formatOutput = true;
    $root = $doc->createElement('message');
    $root = $doc->appendChild($root);
    
    // Create post
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