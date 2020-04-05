<?php
 header('Access-Control-Allow-Origin: *');
 header('Content-Type: application/json');

// Get row count
$num = $result->rowCount();


// Check if any posts
if($num > 0) 
{
  $currentCountry= null;
  $postSTD = new stdClass;
  $postSTD->countries = new stdClass();
  $countCountry = 0;
  $countYears = 0;
  $newCountry = false;

    for($i = 0; $i < $num; $i++)
    {
      $row = $result->fetch();
      extract($row);
      //var_dump($row);
        
      
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
        $postSTD->countries->country[$countCountry]= $postCountry = new stdClass;
        $postCountry->name = $country;
        $newCountry = false;
      
      }
  
      if($newCountry == false)
      {
        $postCountry->data[$countYears] = $data = new stdClass;
      }

      $data->suicides= $suicides;
      $data->population= $population;
      $data->year= $year;

      $currentCountry = $country;
      //echo json_encode($postSTD);
    }
    //$stmt->close();
  // Turn to JSON & output
  //var_dump($posts_arr);
  echo json_encode($postSTD);

} 
else 
{
  // No Posts
  echo json_encode(
    array('message' => 'No Posts Found')
  );
}