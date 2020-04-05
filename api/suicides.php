<?php
    include '../config/Database.php';
    include '../models/Suicides/Suicides_query.php';
    include '../api/validate.php';
    $uriArray = explode('.php/', $_SERVER["REQUEST_URI"]);
    $fileInfo = explode('?', $uriArray[1] );
    
    switch ($_SERVER['REQUEST_METHOD']) 
    {
        case 'GET':
            if(!isset($_GET['country']) && !isset($_GET['year']))
            {   
                $post = createNewClass();
                $result = $post->read();

                if($fileInfo[0] == "json")
                {
                    include 'json/Suicides/get.php';
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Suicides/get.php';
                }
            }
            elseif(isset($_GET['country']) OR isset($_GET['year']))
            {
                $post = createNewClass();
                $post->country = isset($_GET['country']) ? $_GET['country'] : null;
                $post->year = isset($_GET['year']) ? $_GET['year'] : null;

                $result = $post->read_single();
                
                if($fileInfo[0] == "json")
                {
                    include 'json/Suicides/get.php';
                }
                elseif($fileInfo[0] == "xml")
                {
                    include 'XML/Suicides/get.php';
                }
            }
            break;
        case 'POST':  
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {
                include 'json/Suicides/create.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Suicides/create.php';
            }
            break;
        case 'PUT':
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {
                include 'json/Suicides/put.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Suicides/put.php';
            }
            break;
        case 'DELETE':
            $post = createNewClass();

            if($fileInfo[0] == "json")
            {
                include 'json/Suicides/delete.php';
            }
            elseif($fileInfo[0] == "xml")
            {
                include 'XML/Suicides/delete.php';
            }
            break;
    }

    function createNewClass()
    {
        $database = new Database();
        $db = $database->connect();

        $post = new PostSuicides($db);
        return $post;
    }
?>