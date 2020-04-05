<?php
Class PostSuicides{
    private $conn;

    public $country;
    public $year;
    public $suicides;
    public $population;

    public function __construct($db) 
    {
      $this->conn = $db;
    }

    public function read() 
    {
        $query = 'SELECT `country`, `year`, `suicides`, `population` FROM dataprocessing.suicides';
        
     
        $stmt = $this->conn->prepare($query);
  
        $stmt->execute();
        return $stmt;
    }

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

    public function create() 
    {
      // Create query
      $query = 'INSERT INTO dataprocessing.suicides SET country = :country, `year` = :year, suicides = :suicides, `population` = :population';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->year = htmlspecialchars(strip_tags($this->year));
      $this->suicides = htmlspecialchars(strip_tags($this->suicides));
      $this->population = htmlspecialchars(strip_tags($this->population));

      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':year', $this->year);
      $stmt->bindParam(':suicides', $this->suicides);
      $stmt->bindParam(':population', $this->population);

     
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

      $query = 'DELETE FROM dataprocessing.suicides WHERE country = :country AND `year`= :year' ;

      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->year = htmlspecialchars(strip_tags($this->year));

      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':year', $this->year);

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
      $query = 'UPDATE dataprocessing.suicides SET suicides = :suicides, `population` = :population WHERE country = :country AND `year` = :year';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->year = htmlspecialchars(strip_tags($this->year));
      $this->suicides = htmlspecialchars(strip_tags($this->suicides));
      $this->population = htmlspecialchars(strip_tags($this->population));
      

      // Bind data
      $stmt->bindParam(':suicides', $this->suicides);
      $stmt->bindParam(':population', $this->population);
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':year', $this->year);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
}