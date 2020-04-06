var suicidesArr = [];   //Suicide Array for the suicides per 1000000 people
var happinessArr = [];  //Hapinness Array for the happiness scores from every country
var everyGenreArr = []; //Genre array for everey genre a country has in his top 50 songs
var url = window.location.href; //Get URL for the path of the API CAN NOT INCLUDE index.php.
var colorArray = ["#3366cc","#dc3912","#ff9900","#109618","#990099",    //Colors for the pie
"#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#994499","#22aa99",
"#aaaa11","#6633cc","#e67300","#8b0707","#651067","#329262","#5574a6",
"#3b3eac","#b77322","#16d620","#b91383","#f4359e","#9c5935","#a9c413",
"#2a778d","#668d1c","#bea413","#0c5922","#743411"];

//Button funtion for generate all stuff for the chart
$("#showGrafiek").click(function ()
{
    var fileType = $('input[name="fileTypeGrafiek"]:checked').val();    //Get fileType for later use in get request
    getSuicides(fileType);                                              //Function to get data from suicides table
});

//Button funtion for generate all stuff for the pie chart
$("#showPie").click(function ()
{
    var fileType = $('input[name="fileTypePie"]:checked').val();        //Get fileType for later use in get request
     //check if the country to find is filled in
    if(!$('input[name="country"]').val())
    {
        alert("Vul een land in");
    }
    else
    {
        var chosenCountry = $('input[name="country"]').val();           //Get country name for later use in get request  
        getTop50Songs(fileType, chosenCountry);                         //Function to get data from top50songs table
    }
});

//Button funtion to get the request the user want
$("#ownRequest").click(function ()
{
    //check if user have put any code in texterea
    if(!$('#code').val() == '')
    {
        var typeRequest = $('#request').val();                          //Get type of request
        var table = $('#table').val();                                  //Get table to request
        var fileType = $('input[name="fileTypeRequest"]:checked').val();//Get fileType for request
        //If file type is json then the etxteara must be cleared from spaces because the code is not json with xml is this not needed
        if(fileType == "json")
        {
            var input = $('#code').val().replace( /\s/g, "" );      
        }
        else
        {
            var input = $('#code').val();
        }
        getRequest(typeRequest, table, fileType, input);                //Do request on the chosen table in the right fileType
    }
    else
    {
        alert("Vul code in vooradt er een request kan worden kan gedaan")
    }
    
});

//Function gets all suicides from table and calculate this to suicides per 1000000 people
function getSuicides(fileType)
{
    var suicides = new XMLHttpRequest();                                //new request
    suicides.open( "GET" , url +"/api/suicides.php/"+ fileType ,true)   //set request
    suicides.responseType = fileType;                                   //set response type
    suicides.send();                                                    //send request
    
    suicides.onload = function()                                        //function if the send is succesful
    {
        suicidesArr = [];                                               //clear Array
        let suicidesObj = suicides.response;                            //set response
        //check fileTpye
        if(fileType == "xml")           
        {
            let parser = new DOMParser();
            var xml = parser.parseFromString(suicidesObj.replace(/\<\?xml.+\?\>/g, ''), 'application/xml'); //Clear first line of XML the version. Because with version is this not working
            var rowCountry = xml.getElementsByTagName("country").length;                                    //Get lenght of XML for the right loop

            for(i = 0; i < rowCountry; i++)
            {
                dataCount = xml.getElementsByTagName("country")[i].getElementsByTagName("data").length;     //Get lenght of data element in XML for the right push in array
                //push the suidices per 100000 people in array
                suicidesArr.push({
                    //country name
                    x: xml.getElementsByTagName("country")[i].getElementsByTagName("name")[0].childNodes[0].nodeValue, 
                    //number of suicides per 100000 people
                    value: "" + Math.round(1 / (xml.getElementsByTagName("country")[i].getElementsByTagName("data")[dataCount-1].getElementsByTagName("population")[0].childNodes[0].nodeValue / xml.getElementsByTagName("country")[i].getElementsByTagName("data")[dataCount-1].getElementsByTagName("suicides")[0].childNodes[0].nodeValue) * 100000)+""
                });
            }
        }
        else if(fileType == "json")
        {
            var rowCountry = Object.keys(suicidesObj.countries.country).length;                             //Get lenght of XML for the right loop
            for(i = 0; i < rowCountry; i++)
            {       
                dataCount = Object.keys(suicidesObj.countries.country[i].data).length                        //Get lenght of data element in josn for the right push in array
                suicidesArr.push({
                    //country name
                    x: suicidesObj.countries.country[i].name,
                      //number of suicides per 100000 people
                    value: "" + Math.round(1 / (suicidesObj.countries.country[i].data[dataCount-1].population /suicidesObj.countries.country[i].data[dataCount-1].suicides) * 100000)+""
                }
                );
            }  
        }
        else
        {

        }
        getHappiness(fileType) //After this funtion we also need the happiness scores, that is this function
    }
}

//Function to get the happiness scores from the API. And push in array, but only if the country exist in the suicides array
function getHappiness(fileType)
{
    var happiness = new XMLHttpRequest();                               //new request
    happiness.open( "GET" , url+ "api/happiness.php/" + fileType ,true) //set request
    happiness.responseType = fileType;                                  //set response type
    happiness.send();                                                   //send request

    happiness.onload = function()                                       //function if the send is succesful
    {
        happinessArr = [];                                              //Clear array
        let happinessObj = happiness.response;                          //Set response
        if(fileType == "xml")
        {
            let parser = new DOMParser();
            xml = parser.parseFromString(happinessObj.replace(/\<\?xml.+\?\>/g, ''), 'application/xml');    //Clear first line of XML the version. Because with version is this not working
            var rowCountry = xml.getElementsByTagName("country").length;                                    //Get lenght of XML for the right loop

            for(var i = 0; i < rowCountry; i++)
            {
                var country = xml.getElementsByTagName("country")[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;   //Get value of the name element in country
                contains = false;
                //check if the country exist in the suicides array
                for(var x = 0; x < suicidesArr.length; x++) {
                    if (Object.values(suicidesArr[x]).indexOf(country) > -1) 
                    {
                        contains = true;
                    }
                }
                //If the array exist the country then we need to push this country to the happiness array
                if(contains == true)
                {
                    happinessArr.push({
                        //push name of country
                        x: xml.getElementsByTagName("country")[i].getElementsByTagName("name")[0].childNodes[0].nodeValue,
                        //push happiness score
                        value: "" + xml.getElementsByTagName("country")[i].getElementsByTagName("score")[0].childNodes[0].nodeValue + ""}
                    );
                }
            }
        }
        else if(fileType == "json")
        {
            var rowCountry = Object.keys(happinessObj.countries.country).length;    //Get lenght of json for the right loop

            for(i = 0; i < rowCountry; i++)
            {
                var country = happinessObj.countries.country[i].name;               //Get value of the name element in country
                contains = false;
                //check if the country exist in the suicides array
                for(var x = 0; x < suicidesArr.length; x++) 
                {
                    if (Object.values(suicidesArr[x]).indexOf(country) > -1) 
                    {
                        contains = true;
                    }
                }
                //If the array exist the country then we need to push this country to the happiness array
                if(contains == true)
                {
                    happinessArr.push({
                        //push name of country
                        x: happinessObj.countries.country[i].name,
                        //push happiness score
                        value: "" + happinessObj.countries.country[i].score + ""}
                    );
                }
            }
        }
        else
        {

        }
        //All data is conpleted from the table. Can create chart
        grafiekShow();      
    }
}

//Function to get the top 50 songs of county that is chosen
function getTop50Songs(fileType, chosenCountry)
{
    var top50songs = new XMLHttpRequest();                                                              //new request          
    top50songs.open( "GET" , url+ "api/top50songs.php/" + fileType + "?country=" + chosenCountry, true) //set request
    top50songs.responseType = fileType;                                                                 //set fileType
    top50songs.send();                                                                                  //send request

    top50songs.onload = function()                                                                      //function if the send is succesful
    {
        let top50songsObj = top50songs.response;                                                        //set response
        everyGenreArr = [];                                                                             //Clear array
        var genreArr = [];                                                                              //Clear array
        if(fileType == "xml")
        {
            let parser = new DOMParser();
            xml = parser.parseFromString(top50songsObj.replace(/\<\?xml.+\?\>/g, ''), 'application/xml');   //Clear first line of XML the version. Because with version is this not working
            if(xml.getElementsByTagName("message").length >  0)                                             //Check if there are any country with that name
            {
                alert(xml.getElementsByTagName("message")[0].childNodes[0].nodeValue + " Probeer een ander land!");
            }
            else
            {
                var rowRank = xml.getElementsByTagName("country")[0].getElementsByTagName("data").length;   //Get lenght of XML for the right loop
                for(i = 0; i < rowRank; i++)
                {   
                    //get name of genre
                    var genre = xml.getElementsByTagName("country")[0].getElementsByTagName("data")[i].getElementsByTagName("genre")[0].childNodes[0].nodeValue
                    genreArr.push(
                        //push in array no matter what is in this array
                        genre
                    );
                }
                //All the genre + duplicated are in the array we need to countr every genre
                getGenreValue();
            }
        }
        else if(fileType == "json")
        {   
            if(top50songsObj.hasOwnProperty("message"))                                     //Check if there are any country with that name
            {
                alert(top50songsObj.message);
            }
            else
            {
                var rowRank = Object.keys(top50songsObj.countries.country[0].data).length;  //Get lenght of json for the right loop
                for(i = 0; i < rowRank; i++)
                {
                    //get name of genre
                    var genre = top50songsObj.countries.country[0].data[i].genre;
                    genreArr.push(
                        //push in array no matter what is in this array
                        genre
                    );
                }
                //All the genre + duplicated are in the array we need to countr every genre
                getGenreValue();
            }
        }
        else
        {

        }
        //Function to countr every genre in the genreArr
        function getGenreValue()
        {
            genreArr.sort();                    //Sort array for the right count
            var currentGenre = null;            
            var cnt = 0;
            colorcount = 0;      
            //loop through array of genres               
            for (x = 0; x <= genreArr.length; x++) 
            {   
                if (genreArr[x] != currentGenre)    //check if the genreArr is niet gelijk aan currrent genre
                {
                    
                    if (cnt > 0) 
                    {   
                        //array push for the genre + count of that genre
                        everyGenreArr.push(
                        {
                            
                            x: currentGenre,                //push genre
                            value: "" + cnt + "",           //push count
                            fill: colorArray[colorcount]    //push color for the chart to show
                        });
                        colorcount++
                    }
                    currentGenre = genreArr[x];
                    cnt = 1;
                } 
                else 
                {
                    cnt++;
                }
            }
            //All genres are counted now the pie chart can be shown
            pieShow();
        }

    }
}

//Funtion to send the request that is chosen
function getRequest(typeRequest, table, fileType, input)
{
    var request = new XMLHttpRequest();                                         //new request
    request.open( typeRequest , url+ "api/"+ table + ".php/" + fileType ,true)  //set request
    request.onload = function()                                                 //if the request is send then this
    {
        var message = request.response;                                         //get response
        if (request.readyState == 4 && request.status == "200")                 //check if respons is oke message user the details
        {
            alert(message);
        } 
        else 
        {
            alert(message);
        }
    }
    request.send(input);                                                        //send the request with the input from textarea
}

//Draws bar chart
function grafiekShow()
{
    //clear the last seen chart
    document.getElementById("grafiek").innerHTML = "";
    link();
    var json = 
    {
        // chart settings
        "chart": {
            // chart type
            "type": "column",

            "title": "Countries",
            // chart data
            "markers": {
            },
            "series": [{"name": "Suicides per 100000 inwoners",
            "data": suicidesArr}
            ,{"name": "Happiness score", "data": happinessArr
            
            }],
            // chart container
            "container": "grafiek"
        }
    };
    console.log(json);
    // get JSON data
    var chart = anychart.fromJson(json);
    chart.legend(true);


    // draw chart
    chart.draw();
};

//Draws pie Chart
function pieShow()
{   //This timeout is for the request to get data this rtakes some time
    setTimeout(function () 
    {
        //clear the last seen chart
        document.getElementById("pie").innerHTML = "";
        link();
        // JSON data
        var json = 
        {
            // chart settings
            "chart": {
            // chart type
            "type": "pie",
            "title": "Music genres",
            // chart data
            "data": 
                everyGenreArr
            ,
            // chart container
            "container": "pie"
            }
        };

        // get JSON data
        var chart = anychart.fromJson(json);

        // draw chart
        chart.draw();
    }, 1000);
    
};

//Functie for the styling of the charts this code is copy from the site https://docs.anychart.com/
function link()
{
    function ac_add_to_head(el)
    {
        var head = document.getElementsByTagName('div')[0];
        head.insertBefore(el,head.firstChild);
    }
    function ac_add_link(haha)
    {
        var el = document.createElement('link');
        el.rel='stylesheet';el.type='text/css';el.media='all';el.href=haha;
        ac_add_to_head(el);
    }
    function ac_add_style(css)
    {
        var ac_style = document.createElement('style');
        if (ac_style.styleSheet) ac_style.styleSheet.cssText = css;
        else ac_style.appendChild(document.createTextNode(css));
        ac_add_to_head(ac_style);
    }
    ac_add_link('https://cdn.anychart.com/releases/8.7.1/css/anychart-ui.min.css?hcode=a0c21fc77e1449cc86299c5faa067dc4');
    ac_add_style(document.getElementById("ac_style_samples-wd-data-from-json-04").innerHTML);
    ac_add_style(".anychart-embed-samples-wd-data-from-json-04{width 1200px;height:450px;}");
}