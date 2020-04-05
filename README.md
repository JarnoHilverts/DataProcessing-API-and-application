# Data Processing
  Voor data processing moest een RESTful API worden gemaakt met daarbij een werkende applicatie.
  Er moest gebruik worden gemaakt van 3 datasets. Bij deze API is gekozen voor data over:  
  - Happiness 
  - Suicides
  - Top 50 songs  
  
  Al deze data wordt per land bijgehouden.
 
## Werking API
  De API kan 4 requesten verwerken. GET, POST, PUT en DELETE.   
  Deze requesten zijn via de linkapi/(filename).php/(json or xml)  
  Bijoorbeeld: api/happiness.php/json.   
  Hiernaast moet er ook worden aangegeven om welk request het gaat.
  
  Filenames die kunnen worden gebruikt zijn:
  - happiness.php
  - suicides.php
  - top50songs.php
  
  GET:  
  Bij GET requesten kunnen er per file nog parameters worden meegegeven om specifiekere data op te halen.
  Elke dataset kan werken met de parameter country. Daarnaast kan suicides gebruik maken van de parameter year en top50song van de parameter rank.
  
  Deze parameters worden meegegeven achter het respose type met een ? en dan de parameter met de string of int die moet worden opgehaald.  
  Bijvoorbeeld: api/happiness.php/json?country=United States
  
  POST, PUT en DELETE:
  Bij deze requesten moet er json om xml worden meegestuurd naar de API.  
  Deze data wordt gevalideerd aan de hand van een xsd of draft7 schema.
  
  Valide json en xml is terug tevinden in [DataProcessing-API-and-application](XML_JSON_bestanden)
  
## Instalatie
Bij het installeren van deze API en applicatie is niet meer nodig dan xampp.  
De Git hoeft alleen worden gecloned in de xampp map htdocs.

