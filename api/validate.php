<?php
    function validate_xml($xmldata, $xmlSchema)
    {
        libxml_use_internal_errors(true);
        $xml = new DOMDocument();
        $xml->loadXML($xmldata);
        //var_dump($xml);
        if (!$xml->schemaValidate($xmlSchema)) {
            return false;
        }
        else
        {
            return true;
        }
    }

    function validate_json($jsondata, $jsonschema)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://assertible.com/json',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => '{
                "schema": '.$jsonschema.',
                "json": '.$jsondata.'
              }'
        ]);

        ob_start();
        curl_exec($curl);
        $result = ob_get_contents();
        ob_end_clean();

        curl_close($curl);

        $result = get_object_vars(json_decode($result));

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