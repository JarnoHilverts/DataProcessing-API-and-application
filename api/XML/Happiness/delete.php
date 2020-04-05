<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/xml');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  // Get raw posted data
  $data = simplexml_load_file("php://input");
  $xmlpage = file_get_contents('php://input');
  
  $xmlSchema = '../XML_JSON_bestanden/Happines_xsd.xsd';

  if (validate_xml($xmlpage, $xmlSchema) == false) 
  {
      print 'De huide XML is niet valid';
  }
  else
  {
    // Set ID to update
    $post->country = $data->country[0]->name;
    

    // Delete post
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