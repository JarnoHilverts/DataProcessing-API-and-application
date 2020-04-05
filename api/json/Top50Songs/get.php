<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

   //count results of query for loop through data
  $num = $result->rowCount();

  //There is data from query
  if($num > 0) 
  {
    //Set current country to null
    $currentCountry = null;
     //Make new stdClass for json output
    $postSTD = new stdClass;
    $postSTD->countries = new stdClass();//New stdclass in other stdClass
    $countCountry = 0;
    $countRank = 0;
    $newCountry = false;
    
    //Another loop for auto gen stdClass
    for($i = 0; $i < $num; $i++)
    {
      $row = $result->fetch();
      extract($row);
      
      //If there is  an new coutry or is not set var country++ that's because we need to create a new stdClass 
      //For every new country and that is an arrray we use this value to indicate the array
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
        $postSTD->countries->country[$countCountry]= $postCountry = new stdClass; //New stdClass in countries
        $postCountry->name = $country;
        $newCountry = false;
      }
  
      //Make new stdClass in country for the data every rank
      if($newCountry == false)
      {
        $postCountry->data[$countRank] = $data = new stdClass;
      }

       //put data from every year in stdClass data
      $data->title = $title;
      $data->artist = $artist;
      $data->genre = $genre;
      $data->rank = $rank;

      $currentCountry = $country;
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