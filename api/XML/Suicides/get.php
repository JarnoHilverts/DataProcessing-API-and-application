<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/xml');

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
        //$countryName = $doc->createTextNode("test");
        //$countryName = $countryElement->appendChild($countryName);
        //var_dump($row);
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
        
        $dateAttribute = $doc->createAttribute('year');
        $suicidesElement = $doc->createElement('suicides');
        $populationElement = $doc->createElement('population');
        $dateAttribute->value = $year;
        $dataElement->appendChild($dateAttribute);
        
        $suicideValue = $doc->createTextNode($suicides);
       
        $populationValue = $doc->createTextNode($population);
        $suicidesElement->appendChild($suicideValue);
        $populationElement->appendChild($populationValue);
        $dataElement->appendChild($suicidesElement);
        $dataElement->appendChild($populationElement);
        

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