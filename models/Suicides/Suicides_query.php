<?php
Class PostSuicides{
    private $conn;
    //Create public variables
    public $country;
    public $year;
    public $suicides;
    public $population;

    public function __construct($db) 
    {
      $this->conn = $db;
    }

    //Read al data from database
    public function read() 
    {
        $query = 'SELECT `country`, `year`, `suicides`, `population` FROM dataprocessing.suicides';
        
     
        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        return $stmt;
    }

    //Read data with given parameters from database
    public function read_single() 
    {
      //check welke values zijn gezet bij de URL
      if(isset($this->country) && isset($this->year))
      {
       
        $query = 'SELECT `country`, `year`, `suicides`, `population` FROM dataprocessing.suicides WHERE country = :country AND `year` = :year ';

       
        $stmt = $this->conn->prepare($query);
      
        $stmt->bindParam(':country' , $this->country);
        $stmt->bindParam(':year', $this->year);

      
        $stmt->execute();
        return $stmt;
      }

      elseif(isset($this->country))
      {
        $query = 'SELECT `country`, `year`, `suicides`, `population` FROM dataprocessing.suicides WHERE country = :country ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':country', $this->country );

        $stmt->execute();
        return $stmt;
      }

      elseif(isset($this->year))
      {
        $query = 'SELECT `country`, `year`, `suicides`, `population` FROM dataprocessing.suicides WHERE `year` = :year ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':year', $this->year );

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
      $query = 'INSERT INTO dataprocessing.suicides SET country = :country, `year` = :year, suicides = :suicides, `population` = :population';

      $stmt = $this->conn->prepare($query);

      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->year = htmlspecialchars(strip_tags($this->year));
      $this->suicides = htmlspecialchars(strip_tags($this->suicides));
      $this->population = htmlspecialchars(strip_tags($this->population));

      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':year', $this->year);
      $stmt->bindParam(':suicides', $this->suicides);
      $stmt->bindParam(':population', $this->population);

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

      $query = 'DELETE FROM dataprocessing.suicides WHERE country = :country AND `year`= :year' ;

      $stmt = $this->conn->prepare($query);

      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->year = htmlspecialchars(strip_tags($this->year));

      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':year', $this->year);

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
      $query = 'UPDATE dataprocessing.suicides SET suicides = :suicides, `population` = :population WHERE country = :country AND `year` = :year';

      $stmt = $this->conn->prepare($query);

      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->year = htmlspecialchars(strip_tags($this->year));
      $this->suicides = htmlspecialchars(strip_tags($this->suicides));
      $this->population = htmlspecialchars(strip_tags($this->population));
      
      $stmt->bindParam(':suicides', $this->suicides);
      $stmt->bindParam(':population', $this->population);
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':year', $this->year);

      if($stmt->execute()) {
        return true;
      }

      printf("Error: %s.\n", $stmt->error);

      return false;
    }
}