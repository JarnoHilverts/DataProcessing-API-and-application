<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: xml/php');

  // Get row count
$num = $result->rowCount();
//var_dump($result);

// Check if any posts
if($num > 0) 
{   
    $countCountry = 0;
    $countYears = 0;
    $newCountry = false;

    $doc = new DOMDocument('1');
    $doc->formatOutput = true;
    $root = $doc->createElement('countries');
    $root = $doc->appendChild($root);
    for($i = 0; $i < $num; $i++)
    {
        $row = $result->fetch();
        extract($row);

        if(isset($currentCountry) AND $currentCountry != $country)
        {
            $countCountry++;
            $countYears = 0;
            $newCountry = true;
        }
        elseif(isset($currentCountry) == $country)
        {
            $countYears++;
            $newCountry = false;
        }
        
        if(!isset($currentCountry) OR $currentCountry != $country)
        {
            $countryElement = $doc->createElement('country');
            $nameElement = $doc->createElement('name');
            $countryName = $doc->createTextNode($country);
            $nameElement->appendChild($countryName);
            $countryElement->appendChild($nameElement);
            $root->appendChild($countryElement);
            $newCountry = false;
            //echo $doc->saveXML() ."\n";
        }

        if($newCountry == false)
        {
            $dataElement = $doc->createElement('data');
        }
        
        $dataAttribute = $doc->createAttribute('rank');
        $titleElement = $doc->createElement('title');
        $artistElement = $doc->createElement('artist');
        $genreElement = $doc->createElement('genre');

        $dataAttribute->value = $rank;
        $dataElement->appendChild($dataAttribute);
        
        $titleName = $doc->createTextNode($title);
        $artistName = $doc->createTextNode($artist);
        $genreName = $doc->createTextNode($genre);
        
        $titleElement->appendChild($titleName);
        $artistElement->appendChild($artistName);
        $genreElement->appendChild($genreName);

        $dataElement->appendChild($titleElement);
        $dataElement->appendChild($artistElement);
        $dataElement->appendChild($genreElement);
        
        $countryElement->appendChild($dataElement);

        $currentCountry = $country;
    }
    
    echo $doc->saveXML();
} 
else 
{
    $doc = new DOMDocument('1');
    $doc->formatOutput = true;
    $root = $doc->createElement('message');
    $root = $doc->appendChild($root);
    $message = $doc->createTextNode('No post found');
    $root->appendChild($message);
    echo $doc->saveXML();
}