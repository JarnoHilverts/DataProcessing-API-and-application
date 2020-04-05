<?php
    //Validate XML
    function validate_xml($xmldata, $xmlSchema)
    {
        //Persmission to check for errors is XML
        libxml_use_internal_errors(true);
        $xml = new DOMDocument();
        $xml->loadXML($xmldata);

        //check if XML is valid with xsd schema
        if (!$xml->schemaValidate($xmlSchema)) {
            return false;
        }
        else
        {
            return true;
        }
    }

    //Validate Json
    function validate_json($jsondata, $jsonschema)
    {
        //create new request to online page
        $curl = curl_init();

        //Create request for validation with curl
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://assertible.com/json',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => '{
                "schema": '.$jsonschema.',
                "json": '.$jsondata.'
              }'
        ]);
        //turns on output buffering    
        ob_start();
        curl_exec($curl); //ececute request
        $result = ob_get_contents(); //get output
        ob_end_clean(); //Turns of output buffering and cleans the buffer

        curl_close($curl); //close request

        $result = get_object_vars(json_decode($result));  //Gets the properties of result

        //Check if the output of the request is valid
        if(isset($result["valid"]) && $result["valid"] == TRUE)
        {
            return true;
        }
        else
        {
            return false; 
        }
    }
?>