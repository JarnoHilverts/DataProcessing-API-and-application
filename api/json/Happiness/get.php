<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$num = $result->rowCount();
//var_dump($result);

if($num > 0) 
{
  $currentCountry= null;
  $postSTD = new stdClass;
  $postSTD->countries = new stdClass();
  $countCountry = 0;
 
    for($i = 0; $i < $num; $i++)
    {
      $row = $result->fetch();
      extract($row);
      //var_dump($row);
        
      if(isset($currentCountry) AND $currentCountry != $country)
      {
        $countCountry++;
      }
      if(!isset($currentCountry) OR $currentCountry != $country)
      {
        $postSTD->countries->country[$countCountry]= $postCountry = new stdClass;
        $postCountry->name = $country;
        $postCountry->rank = $rank;
        $postCountry->score = $score;
        $postCountry->GDPperCapita = $GDPperCapita;
        $postCountry->socialSupport = $socialSupport;
        $postCountry->healthLifeExperience = $healthLifeExperience;
        $postCountry->FreedomToMakeChoices = $freedomToMakeChoices;
      }

      $currentCountry = $country;
      //echo json_encode($postSTD);
    }
   
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