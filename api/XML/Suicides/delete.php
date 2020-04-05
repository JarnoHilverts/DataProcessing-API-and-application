<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/xml');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  //Get raw data input
  $data = simplexml_load_file("php://input");
  $xmlpage = file_get_contents('php://input');
  //Get xsd to check validation in validate.php
  $xmlSchema = '../XML_JSON_bestanden/Suicide_template_xsd.xsd';
  if (validate_xml($xmlpage, $xmlSchema) == false)
  {
      echo "De huide XML is niet valid";
  }
  else
  {
    $post->country = $data->country[0]->name;
    $post->year = $data->country[0]->data[0]['year'];

    // Delete post
    //New DOMdoc to output xml data 
    if($post->delete()) 
    {
      $doc = new DOMDocument('1');
      $doc->formatOutput = true;
      $root = $doc->createElement('message');
      $root = $doc->appendChild($root);
      $message = $doc->createTextNode('Post deleted');
      $root->appendChild($message);
      echo $doc->saveXML();
    } 
    else 
    {
      $doc = new DOMDocument('1');
      $doc->formatOutput = true;
      $root = $doc->createElement('message');
      $root = $doc->appendChild($root);
      $message = $doc->createTextNode('Post not deleted');
      $root->appendChild($message);
      echo $doc->saveXML();
    }
  }
?>