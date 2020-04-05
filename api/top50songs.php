<?php
    include '../config/Database.php';
    include '../models/Top50Songs/Top50Songs_query.php';
    include '../api/validate.php';
    $uriArray = explode('.php/', $_SERVER["REQUEST_URI"]);
    $fileInfo = explode('?', $uriArray[1] );
    
    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case 'GET':
            if(!isset($_GET['country']) && !isset($_GET['rank']))
            {   
                $post = createNewClass();
                $result = $post->read();

                if($fileInfo[0] == "json")
                {
                    include 'json/Top50Songs/get.php';
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Top50Songs/get.php';
                }
            }
            elseif(isset($_GET['country']) OR isset($_GET['rank']))
            {
                $post = createNewClass();
                $post->country = isset($_GET['country']) ? $_GET['country'] : null;
                $post->year = isset($_GET['rank']) ? $_GET['rank'] : null;

                $result = $post->read_single();
                
                if($fileInfo[0] == "json")
                {
                    include 'json/Top50Songs/get.php';
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Top50Songs/get.php';
                }
            }
            break;
        case 'POST':  
            $post = createNewClass();
            if($fileInfo[0] == "json")
            {
                include 'json/Top50Songs/create.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Top50Songs/create.php';
            }
            break;
        case 'PUT':
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {
                include 'json/Top50Songs/put.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Top50Songs/put.php';
            }
            break;
        case 'DELETE':
            $post = createNewClass();
            if($fileInfo[0] == "json")
            {
                include 'json/Top50Songs/delete.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Top50Songs/delete.php';
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