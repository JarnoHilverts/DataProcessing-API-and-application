<?php

    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/xml');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

    // Get raw posted data
    $data = simplexml_load_file("php://input");
    $xmlpage = file_get_contents("php://input");

    $xmlSchema = '../XML_JSON_bestanden/Happines_xsd.xsd';
    //var_dump($xml);
    if (validate_xml($xmlpage, $xmlSchema) == false)
    {
        echo "De huide XML is niet valid";
    }
    else
    {
      $post->country = $data->country[0]->name;
      $post->rank = $data->country[0]->rank;
      $post->score = $data->country[0]->score;
      $post->GDPperCapita = $data->country[0]->GDPperCapita;
      $post->socialSupport = $data->country[0]->socialSupport;
      $post->healthLifeExperience = $data->country[0]->healthLifeExperience;
      $post->freedomToMakeChoices = $data->country[0]->FreedomToMakeChoices;

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