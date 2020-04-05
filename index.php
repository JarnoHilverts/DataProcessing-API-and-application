<!DOCTYPE html>
<html lang="en">
    <head>
    <link rel="stylesheet" type="text/css" href="CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-base.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-exports.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
    <script src="https://cdn.anychart.com/releases/8.7.1/js/anychart-ui.min.js?hcode=a0c21fc77e1449cc86299c5faa067dc4"></script>
    <script src="https://cdn.anychart.com/releases/8.7.1/themes/dark_blue.js"></script>
    </head>
    <body>
    

        <div class = "container">
        <div id="anychart-embed-samples-wd-data-from-json-04" class="anychart-embed anychart-embed-samples-wd-data-from-json-04">
            <div id="ac_style_samples-wd-data-from-json-04" style="display:none;">
                 #grafiek, #pie {
                    width: 100%;
                    height: 100%;
                    postition: absolute;
                }
            </div>
                <h1>Data Processing</h1>
                <div class = "text">
                    <p>Op deze pagina kan gebruik worden gemaakt van een Restfull API.
                        Met deze api kan data worden verkregen over 3 onderwerpen.
                        Deze onderwerpen zijn: Happiness van verschillende landen, 
                        de suicides van deze landen en de top 50 aan songs wat het meest is geluisterd in deze landen.

                        Met de verschillende opties op deze pagina kunnen 4 requesten worden gedaan naar de API.
                        GET, POST, PUT en DELETE. deze requesten kunnen met 2 verschillende types data werken namelijk XML en Json.
                    </p>
                </div>
                <div class = "img">
                    <img src="img/api-2x.png" alt="logo"/>
                </div>
                <div class = "text">
                    <p>
                        Hieronder kan een GET request worden gedaan naar landen voor de suicides en happiness. Deze worden in een staaf grafiek weergegeven.
                        Er is keuze uit de 2 data types. XML en Json.
                    </p>    
                    <input type = "radio" name = "fileTypeGrafiek" id = "XMLGrafiek" value = "xml" checked> XML
                    <input type = "radio" name = "fileTypeGrafiek" id = "JSONGrafiek" value ="json"> Json
                    <input type = "submit" class = "button" value = "Show Grafiek" id = "showGrafiek">
                </div>
                <div class = "img">
                    <img src="img/Grafiek.PNG" alt="grafiek"/>
                </div>
                <div class = "staafgrafiek">
                    <div id = "grafiek"></div>
                </div>
                <div id = "grafiek"></div>
                <div class = "text">
                    <p>
                    Hieronder kan van 1 specifiek land de top 50 song worden weer gegeven per genre. 
                    Vul hieronder 1 van de landen in die in de staafgrafiek hierbover te zien is.
                    Selecteer daarna wel type GET request het moet zijn.
                    </p>  
                    <input type = "text" name = "country" placeholder="Country" id = "country">  
                    <input type = "radio" name = "fileTypePie" id = "XMLPie" value = "xml" checked> XML
                    <input type = "radio" name = "fileTypePie" id = "JSONPie" value ="json"> Json
                    <input type = "submit" class = "button" value = "Show Pie" id = "showPie">
                </div>
                <div class = "img">
                    <img src="img/Pie.PNG" alt="Pei"/>
                </div>
                <div class = "staafgrafiek">
                    <div id = "pie"></div>
                </div>
                <div class = "text">
                    <p>
                    Hieronder kan gekozen worden wat voor request er wordt gedaan. Daardoor kan er data worden geupload, geupdate of gedelete uit de database van de API.
                    In het invoer veld kan de data in het gekozen data type worden neergezet om deze data bij te werken.
                    </p>    
                    <select id = "request">
                        <option value="POST">POST</option>
                        <option value="PUT">PUT</option>
                        <option value="DELETE">DELETE</option>
                    </select>
                    <select id = "table">
                        <option value="happiness">Happiness</option>
                        <option value="suicides">Suicides</option>
                        <option value="top50songs">Top 50 Songs</option>
                    </select>
                    <input type = "radio" name = "fileTypeRequest" id = "XML" value = "xml" checked> XML
                    <input type = "radio" name = "fileTypeRequest" id = "JSONPie" value ="json"> Json <br>
                    <textarea placeholder="Code" id = "code"></textarea><br>
                    <input type = "submit" class = "button" value = "Send Request" id = "ownRequest">
                </div>
            
        </div>
            </div>
    </body>
    <script src="js/main.js"></script>
    
</html>