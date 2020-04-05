<?php
  Class PostHappiness{
    private $conn;
    //Create public variables
    public $country;
    public $rank;
    public $score;
    public $GDPperCapita;
    public $socialSupport;
    public $healthLifeExperience;
    public $freedomToMakeChoices;


    public function __construct($db) 
    {
      $this->conn = $db;
    }

    //Read al data from database
    public function read() 
    {
        $query = 'SELECT `country`, `rank`, `score`, `GDP_per_capita` as GDPperCapita, `social_support` as socialSupport, `healthy_Life_expectancy` as healthLifeExperience, `freedom_to_make_life_choices` as freedomToMakeChoices FROM dataprocessing.hapinness';
        
     
        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        return $stmt;
    }

    //Read data with given parameters from database
    public function read_single() 
    {
      //check welke values zijn gezet bij de URL
      if(isset($this->country))
      {
       
        $query = 'SELECT `country`, `rank`, `score`, `GDP_per_capita` as GDPperCapita, `social_support` as socialSupport, `healthy_Life_expectancy` as healthLifeExperience, `freedom_to_make_life_choices` as freedomToMakeChoices FROM dataprocessing.hapinness WHERE country = :country';

        $stmt = $this->conn->prepare($query);
      
        $stmt->bindParam(':country', $this->country);

        $stmt->execute();
        return $stmt;
      }

      else
      {
        return 0;
      }
    }

    //Create data from given input.
    public function create() 
    {
      $query = 'INSERT INTO dataprocessing.hapinness SET country = :country, `rank` = :rank, `score`=:score, `GDP_per_capita` = :GPDperCapita, `social_support`= :socialSupport, `healthy_Life_expectancy`= :healthyLifeExpectancy, `freedom_to_make_life_choices` = :freedomToMakeChoices';

      $stmt = $this->conn->prepare($query);

      //Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));
      $this->score = htmlspecialchars(strip_tags($this->score));
      $this->GDPperCapita = htmlspecialchars(strip_tags($this->GDPperCapita));
      $this->socialSupport = htmlspecialchars(strip_tags($this->socialSupport));
      $this->healthLifeExperience = htmlspecialchars(strip_tags($this->healthLifeExperience));
      $this->freedomToMakeChoices = htmlspecialchars(strip_tags($this->freedomToMakeChoices));

      //Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);
      $stmt->bindParam(':score', $this->score);
      $stmt->bindParam(':GPDperCapita', $this->GDPperCapita);
      $stmt->bindParam(':socialSupport', $this->socialSupport);
      $stmt->bindParam(':healthyLifeExpectancy', $this->healthLifeExperience);
      $stmt->bindParam(':freedomToMakeChoices', $this->freedomToMakeChoices);
     
      if($stmt->execute()) 
      {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    //Delete given data from input
    public function delete() 
    {

      $query = 'DELETE FROM dataprocessing.hapinness WHERE country = :country' ;

      $stmt = $this->conn->prepare($query);

      $this->country = htmlspecialchars(strip_tags($this->country));

      $stmt->bindParam(':country', $this->country);

      if($stmt->execute()) 
      {
        return true;
      }
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    //Update given data from input
    public function update() 
    {
      $query = 'UPDATE dataprocessing.hapinness SET `Rank` = :rank, `Score` = :score, `GDP_per_capita` = :GPDperCapita, `social_support`= :socialSupport, `healthy_Life_expectancy`= :healthyLifeExpectancy, `freedom_to_make_life_choices` = :freedomToMakeChoices WHERE country = :country';

      $stmt = $this->conn->prepare($query);

      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));
      $this->score = htmlspecialchars(strip_tags($this->score));
      $this->GDPperCapita = htmlspecialchars(strip_tags($this->GDPperCapita));
      $this->socialSupport = htmlspecialchars(strip_tags($this->socialSupport));
      $this->healthLifeExperience = htmlspecialchars(strip_tags($this->healthLifeExperience));
      $this->freedomToMakeChoices = htmlspecialchars(strip_tags($this->freedomToMakeChoices));

      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);
      $stmt->bindParam(':score', $this->score);
      $stmt->bindParam(':GPDperCapita', $this->GDPperCapita);
      $stmt->bindParam(':socialSupport', $this->socialSupport);
      $stmt->bindParam(':healthyLifeExpectancy', $this->healthLifeExperience);
      $stmt->bindParam(':freedomToMakeChoices', $this->freedomToMakeChoices);

      if($stmt->execute())
      {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }
  }
?>