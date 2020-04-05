<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  $num = $result->rowCount();

  if($num > 0) 
  {
    $currentCountry = null;
    $postSTD = new stdClass;
    $postSTD->countries = new stdClass();
    $countCountry = 0;
    $countRank = 0;
    $newCountry = false;
   
    for($i = 0; $i < $num; $i++)
    {
      $row = $result->fetch();
      extract($row);
      
      if(isset($currentCountry) AND $currentCountry != $country)
      {
        $countCountry++;
        $countRank = 0;
        $newCountry = true;
      }
      elseif(isset($currentCountry) == $country)
      {
        $countRank++;
        $newCountry = false;
      }
      
      if(!isset($currentCountry) OR $currentCountry != $country)
      {
        $postSTD->countries->country[$countCountry]= $postCountry = new stdClass;
        $postCountry->name = $country;
        $newCountry = false;
      }
  
      if($newCountry == false)
      {
        $postCountry->data[$countRank] = $data = new stdClass;
      }

      $data->title = $title;
      $data->artist = $artist;
      $data->genre = $genre;
      $data->rank = $rank;

      $currentCountry = $country;
      //echo json_encode($postSTD);
      }
      
    echo json_encode($postSTD);
    

  } 
  else 
  {
    // No Posts
    echo json_encode(
      array('message' => 'No Posts Found')
    );
  }
?>