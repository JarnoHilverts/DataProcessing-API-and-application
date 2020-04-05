<?php
Class PostTop50Songs{
    private $conn;

    public $rank;
    public $country;
    public $title;
    public $artist;
    public $genre;

    public function __construct($db) 
    {
      $this->conn = $db;
    }

    public function read() 
    {
      $query = 'SELECT `rank`, `country`, `title`, `artist`, `genre` FROM dataprocessing.top50songs';
      
    
      $stmt = $this->conn->prepare($query);

      $stmt->execute();
      return $stmt;
    }

    public function read_single() 
    {
      //check welke values zijn gezet bij de URL
      if(isset($this->country) && isset($this->rank))
      {
       
        $query = 'SELECT `rank`, `country`, `title`, `artist`, `genre` FROM dataprocessing.top50songs WHERE country = :country AND `rank` = :rank ';

       
        $stmt = $this->conn->prepare($query);
      
        $stmt->bindParam(':country' , $this->country);
        $stmt->bindParam(':rank', $this->rank);

      
        $stmt->execute();
        return $stmt;
      }

      elseif(isset($this->country))
      {
        $query = 'SELECT `rank`, `country`, `title`, `artist`, `genre` FROM dataprocessing.top50songs WHERE country = :country ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':country', $this->country );

        $stmt->execute();
        return $stmt;
      }

      elseif(isset($this->rank))
      {
        $query = 'SELECT `rank`, `title`, `artist`, `genre`,`country` FROM dataprocessing.top50songs WHERE `rank` = :rank ';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':rank', $this->rank );

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
      $query = 'INSERT INTO dataprocessing.top50songs SET country = :country, `rank` = :rank, `title` = :title, `artist` = :artist, `genre`= :genre';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->artist = htmlspecialchars(strip_tags($this->artist));
      $this->genre = htmlspecialchars(strip_tags($this->genre));

      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':artist', $this->artist);
      $stmt->bindParam(':genre', $this->genre);

     
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

      $query = 'DELETE FROM dataprocessing.top50songs WHERE country = :country AND `rank`=:rank';

      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));

      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);

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
      $query = 'UPDATE dataprocessing.top50songs SET title = :title, `artist` = :artist, `genre`= :genre WHERE `country` = :country AND `rank` = :rank';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->country = htmlspecialchars(strip_tags($this->country));
      $this->rank = htmlspecialchars(strip_tags($this->rank));
      $this->title = htmlspecialchars(strip_tags($this->title));
      $this->artist = htmlspecialchars(strip_tags($this->artist));
      $this->genre = htmlspecialchars(strip_tags($this->genre));

      // Bind data
      $stmt->bindParam(':country', $this->country);
      $stmt->bindParam(':rank', $this->rank);
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':artist', $this->artist);
      $stmt->bindParam(':genre', $this->genre);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
}