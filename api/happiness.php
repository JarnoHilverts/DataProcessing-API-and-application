<?php
    include '../config/Database.php';
    include '../models/Happiness/Happiness_query.php';
    include '../api/validate.php';
    $uriArray = explode('.php/', $_SERVER["REQUEST_URI"]);
    $fileInfo = explode('?', $uriArray[1] );
    
    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case 'GET':
            if(!isset($_GET['country']))
            {   
                $post = createNewClass();
                $result = $post->read();

                if($fileInfo[0] == "json")
                {
                    include 'json/Happiness/get.php';
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Happiness/get.php';
                }
            }
            elseif(isset($_GET['country']))
            {
                $post = createNewClass();
                $post->country = isset($_GET['country']) ? $_GET['country'] : null;
                $post->year = isset($_GET['year']) ? $_GET['year'] : null;

                $result = $post->read_single();
                
                if($fileInfo[0] == "json")
                {
                    include 'json/Happiness/get.php';
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Happiness/get.php';
                }
            }
            break;
        case 'POST':  
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {   
                include 'json/Happiness/create.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Happiness/create.php';
            }
            break;
        case 'PUT':
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {
                include 'json/Happiness/put.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Happiness/put.php';
            }
            break;
        case 'DELETE':
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {
                include 'json/Happiness/delete.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Happiness/delete.php';
            }
            break;
    }

    function createNewClass()
    {
        $database = new Database();
        $db = $database->connect();

        $post = new PostHappiness($db);
        return $post;
    }
?>