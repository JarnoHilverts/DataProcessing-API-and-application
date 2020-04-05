<?php
    //Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: xml/php');

    //Count results of query for loop through data
    $num = $result->rowCount();

    //There is data from query
    if($num > 0) 
    {   
        $countCountry = 0;
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
            }
            
            if(!isset($currentCountry) OR $currentCountry != $country)
            {
                //Create new elements.
                $countryElement = $doc->createElement('country');
                $nameElement = $doc->createElement('name');
                $rankElement = $doc->createElement('rank');
                $scoreElement = $doc->createElement('score');
                $GDPperCapitaElement = $doc->createElement('GDPperCapita');
                $socialSupportElement = $doc->createElement('socialSupport');
                $healthLifeExperienceElement = $doc->createElement('healthLifeExperience');
                $FreedomToMakeChoicesElement = $doc->createElement('FreedomToMakeChoices');

                //create data for in elements
                $countryName = $doc->createTextNode($country);
                $countryRank = $doc->createTextNode($rank);
                $countryScore = $doc->createTextNode($score);
                $countryGDPperCapita = $doc->createTextNode($GDPperCapita);
                $countrySocialSupport = $doc->createTextNode($socialSupport);
                $countryHealthLifeExperience = $doc->createTextNode($healthLifeExperience);
                $countryFreedomToMakeChoices = $doc->createTextNode($freedomToMakeChoices);

                //Put data in de elements
                $nameElement->appendChild($countryName);
                $rankElement->appendChild($countryRank);
                $scoreElement->appendChild($countryScore);
                $GDPperCapitaElement->appendChild($countryGDPperCapita);
                $socialSupportElement->appendChild($countrySocialSupport);
                $healthLifeExperienceElement->appendChild($countryHealthLifeExperience);
                $FreedomToMakeChoicesElement->appendChild($countryFreedomToMakeChoices);

                //Put elenemts in country element
                $countryElement->appendChild($nameElement);
                $countryElement->appendChild($rankElement);
                $countryElement->appendChild($scoreElement);
                $countryElement->appendChild($GDPperCapitaElement);
                $countryElement->appendChild($socialSupportElement);
                $countryElement->appendChild($healthLifeExperienceElement);
                $countryElement->appendChild($FreedomToMakeChoicesElement);

                $root->appendChild($countryElement);
            }
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