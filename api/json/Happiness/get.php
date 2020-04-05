<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //count results of query for loop through data
  $num = $result->rowCount();

  //There is data from query
  if($num > 0) 
  {
    //set current country to null
    $currentCountry= null;
    //make new stdClass for json output
    $postSTD = new stdClass;
    $postSTD->countries = new stdClass();
    $countCountry = 0;
  
      //another loop for auto gen stdClass
      for($i = 0; $i < $num; $i++)
      {
        $row = $result->fetch();
        extract($row);

        //if there is  an new coutry or is not set var country++ that's because we need to create a new stdClass 
        //for every new country and that is an arrray we use this value to indicate the array
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
      }

    // Turn to JSON & output
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