<?php
    //includes
    include '../config/Database.php';
    include '../models/Top50Songs/Top50Songs_query.php';
    include '../api/validate.php';

    //Get left of URL with xml/json and parameters
    $uriArray = explode('.php/', $_SERVER["REQUEST_URI"]);
    
    //Get json or xml
    $fileInfo = explode('?', $uriArray[1] );
    
    //Check kind of request
    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case 'GET':
            if(!isset($_GET['country']) && !isset($_GET['rank']))   // if there are no parametes set
            {   
                $post = createNewClass();    //create connection and the class for the funtion
                $result = $post->read();

                if($fileInfo[0] == "json")
                {
                    include 'json/Top50Songs/get.php';      //Include json get for getting data from database
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Top50Songs/get.php';       //Include xml get for getting data from database
                }
            }
            elseif(isset($_GET['country']) OR isset($_GET['rank']))
            {
                $post = createNewClass();    //create connection and the class for the funtion
                $post->country = isset($_GET['country']) ? $_GET['country'] : null; //Get parameter country from url
                $post->year = isset($_GET['rank']) ? $_GET['rank'] : null;  //Get parameter rank from url

                $result = $post->read_single();
                
                if($fileInfo[0] == "json")
                {
                    include 'json/Top50Songs/get.php';      //Include json get for getting data from database
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Top50Songs/get.php';       //Include xml get for getting data from database
                }
            }
            break;
        case 'POST':  
            $post = createNewClass();    //create connection and the class for the funtion
            if($fileInfo[0] == "json")
            {
                include 'json/Top50Songs/create.php';       //Include json create for creating data in database
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Top50Songs/create.php';         //Include xml create for creating data in database
            }
            break;
        case 'PUT':
            $post = createNewClass();    //create connection and the class for the funtion

            if($fileInfo[0] == "json")
            {
                include 'json/Top50Songs/put.php';      //Include json put to update data in database
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Top50Songs/put.php';        //Include xml put to update data in database
            }
            break;
        case 'DELETE':
            $post = createNewClass();    //create connection and the class for the funtion
            if($fileInfo[0] == "json")
            {
                include 'json/Top50Songs/delete.php';   //Include json delete data from database
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Top50Songs/delete.php';    //Include xml delete data from database
            }
            break;
    }

    function createNewClass()
    {
        $database = new Database();
        $db = $database->connect();

        $post = new PostTop50Songs($db);
        return $post;
    }
    
?>