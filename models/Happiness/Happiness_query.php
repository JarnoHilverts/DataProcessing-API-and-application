<?php
Class PostHappiness{
    private $conn;

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

    public function read() 
    {
        $query = 'SELECT `country`, `rank`, `score`, `GDP_per_capita` as GDPperCapita, `social_support` as socialSupport, `healthy_Life_expectancy` as healthLifeExperience, `freedom_to_make_life_choices` as freedomToMakeChoices FROM dataprocessing.hapinness';
        
     
        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        return $stmt;
    }

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

    public function create() 
    {
      // Create query
      $query = 'INSERT INTO dataprocessing.hapinness SET country = :country, `rank` = :rank, `score`=:score, `GDP_per_capita` = :GPDperCapita, `social_support`= :socialSupport, `healthy_Life_expectancy`= :healthyLifeExpectancy, `freedom_to_make_life_choices` = :freedomToMakeChoices';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));
      $this->score = htmlspecialchars(strip_tags($this->score));
      $this->GDPperCapita = htmlspecialchars(strip_tags($this->GDPperCapita));
      $this->socialSupport = htmlspecialchars(strip_tags($this->socialSupport));
      $this->healthLifeExperience = htmlspecialchars(strip_tags($this->healthLifeExperience));
      $this->freedomToMakeChoices = htmlspecialchars(strip_tags($this->freedomToMakeChoices));
      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);
      $stmt->bindParam(':score', $this->score);
      $stmt->bindParam(':GPDperCapita', $this->GDPperCapita);
      $stmt->bindParam(':socialSupport', $this->socialSupport);
      $stmt->bindParam(':healthyLifeExpectancy', $this->healthLifeExperience);
      $stmt->bindParam(':freedomToMakeChoices', $this->freedomToMakeChoices);
     
      // Execute query
      if($stmt->execute()) 
      {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function delete() 
    {

      $query = 'DELETE FROM dataprocessing.hapinness WHERE country = :country' ;

      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      // Bind data
      $stmt->bindParam(':country', $this->country);

      // Execute query
      if($stmt->execute()) 
      {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function update() 
    {
      // Create query
      $query = 'UPDATE dataprocessing.hapinness SET `Rank` = :rank, `Score` = :score, `GDP_per_capita` = :GPDperCapita, `social_support`= :socialSupport, `healthy_Life_expectancy`= :healthyLifeExpectancy, `freedom_to_make_life_choices` = :freedomToMakeChoices WHERE country = :country';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));
      $this->score = htmlspecialchars(strip_tags($this->score));
      $this->GDPperCapita = htmlspecialchars(strip_tags($this->GDPperCapita));
      $this->socialSupport = htmlspecialchars(strip_tags($this->socialSupport));
      $this->healthLifeExperience = htmlspecialchars(strip_tags($this->healthLifeExperience));
      $this->freedomToMakeChoices = htmlspecialchars(strip_tags($this->freedomToMakeChoices));

      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);
      $stmt->bindParam(':score', $this->score);
      $stmt->bindParam(':GPDperCapita', $this->GDPperCapita);
      $stmt->bindParam(':socialSupport', $this->socialSupport);
      $stmt->bindParam(':healthyLifeExpectancy', $this->healthLifeExperience);
      $stmt->bindParam(':freedomToMakeChoices', $this->freedomToMakeChoices);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
}