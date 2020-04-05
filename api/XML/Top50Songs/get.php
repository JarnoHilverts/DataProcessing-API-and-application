<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/xml');

    //Count results of query for loop through data
    $num = $result->rowCount();

    //There is data from query
    if($num > 0) 
    {   
        $countCountry = 0;
        $countYears = 0;
        $newCountry = false;
         //New DOMdoc to output xml data 
        $doc = new DOMDocument('1');
        $doc->formatOutput = true;
        //Create new element in XML
        $root = $doc->createElement('countries');
        //Put XML element in de root element
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
                //Create new elements.
                $countryElement = $doc->createElement('country');
                $nameElement = $doc->createElement('name');
                
                //create data for in elements
                $countryName = $doc->createTextNode($country);

                //Put data in de elements
                $nameElement->appendChild($countryName);
                $countryElement->appendChild($nameElement);
                $root->appendChild($countryElement);
                $newCountry = false;
            }

            if($newCountry == false)
            {
                //Create new element
                $dataElement = $doc->createElement('data');
            }
            
            //Create new element
            $dataAttribute = $doc->createAttribute('rank');
            $titleElement = $doc->createElement('title');
            $artistElement = $doc->createElement('artist');
            $genreElement = $doc->createElement('genre');

            //Create new Attribute for element
            $dataAttribute->value = $rank;
            $dataElement->appendChild($dataAttribute);
            
            //create data for in elements
            $titleName = $doc->createTextNode($title);
            $artistName = $doc->createTextNode($artist);
            $genreName = $doc->createTextNode($genre);
            
            //Put data in de elements
            $titleElement->appendChild($titleName);
            $artistElement->appendChild($artistName);
            $genreElement->appendChild($genreName);

            //Put data in de elements
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
?>