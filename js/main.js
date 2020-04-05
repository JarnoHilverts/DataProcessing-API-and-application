var suicidesArr = [];
var happinessArr = [];
var everyGenreArr = [];
var url = window.location.href;
var colorArray = ["#3366cc","#dc3912","#ff9900","#109618","#990099",
"#0099c6","#dd4477","#66aa00","#b82e2e","#316395","#994499","#22aa99",
"#aaaa11","#6633cc","#e67300","#8b0707","#651067","#329262","#5574a6",
"#3b3eac","#b77322","#16d620","#b91383","#f4359e","#9c5935","#a9c413",
"#2a778d","#668d1c","#bea413","#0c5922","#743411"];


$("#showGrafiek").click(function ()
{
    var fileType = $('input[name="fileTypeGrafiek"]:checked').val();
    getSuicides(fileType);
});

$("#showPie").click(function ()
{
    var fileType = $('input[name="fileTypePie"]:checked').val();
    if(!$('input[name="country"]').val())
    {
        alert("Vul een land in");
    }
    else
    {
        var chosenCountry = $('input[name="country"]').val();
        getTop50Songs(fileType, chosenCountry);
    }
});

$("#ownRequest").click(function ()
{
    if(!$('#code').val() == '')
    {
        var typeRequest = $('#request').val();
        var table = $('#table').val();
        var fileType = $('input[name="fileTypeRequest"]:checked').val();
        if(fileType == "json")
        {
            var input = $('#code').val().replace( /\s/g, "" );
        }
        else
        {
            var input = $('#code').val();
        }
        getRequest(typeRequest, table, fileType, input);
    }
    else
    {
        alert("Vul code in vooradt er een request kan worden kan gedaan")
    }
    
});

function getSuicides(fileType)
{
    var suicides = new XMLHttpRequest();
    suicides.open( "GET" , url +"/api/suicides.php/"+ fileType ,true)
    suicides.responseType = fileType;
    suicides.send();
    
    suicides.onload = function()
    {
        suicidesArr = [];
        let suicidesObj = suicides.response;
        if(fileType == "xml")
        {
            let parser = new DOMParser();
            var xml = parser.parseFromString(suicidesObj.replace(/\<\?xml.+\?\>/g, ''), 'application/xml');
            var rowCountry = xml.getElementsByTagName("country").length;

            for(i = 0; i < rowCountry; i++)
            {
                dataCount = xml.getElementsByTagName("country")[i].getElementsByTagName("data").length;
                suicidesArr.push({
                    x: xml.getElementsByTagName("country")[i].getElementsByTagName("name")[0].childNodes[0].nodeValue,
                    value: "" + Math.round(1 / (xml.getElementsByTagName("country")[i].getElementsByTagName("data")[dataCount-1].getElementsByTagName("population")[0].childNodes[0].nodeValue / xml.getElementsByTagName("country")[i].getElementsByTagName("data")[dataCount-1].getElementsByTagName("suicides")[0].childNodes[0].nodeValue) * 100000)+""
                });
            }
        }
        else if(fileType == "json")
        {
            var rowCountry = Object.keys(suicidesObj.countries.country).length;
            for(i = 0; i < rowCountry; i++)
            {
                dataCount = Object.keys(suicidesObj.countries.country[i].data).length
                suicidesArr.push({
                    x: suicidesObj.countries.country[i].name,
                    value: "" + Math.round(1 / (suicidesObj.countries.country[i].data[dataCount-1].population /suicidesObj.countries.country[i].data[dataCount-1].suicides) * 100000)+""
                }
                );
            }  
        }
        else
        {

        }
        console.log(suicidesArr);
        getHappiness(fileType)

    }
}

function getHappiness(fileType)
{
    var happiness = new XMLHttpRequest();
    happiness.open( "GET" , url+ "api/happiness.php/" + fileType ,true)
    happiness.responseType = fileType;
    happiness.send();

    happiness.onload = function()
    {
        happinessArr = [];
        let happinessObj = happiness.response;
        if(fileType == "xml")
        {
            let parser = new DOMParser();
            xml = parser.parseFromString(happinessObj.replace(/\<\?xml.+\?\>/g, ''), 'application/xml');
            var rowCountry = xml.getElementsByTagName("country").length;

            for(var i = 0; i < rowCountry; i++)
            {
                var country = xml.getElementsByTagName("country")[i].getElementsByTagName("name")[0].childNodes[0].nodeValue;
                contains = false;

                for(var x = 0; x < suicidesArr.length; x++) {
                    if (Object.values(suicidesArr[x]).indexOf(country) > -1) 
                    {
                        contains = true;
                    }
                }
                if(contains == true)
                {
                    happinessArr.push({
                        x: xml.getElementsByTagName("country")[i].getElementsByTagName("name")[0].childNodes[0].nodeValue,
                        value: "" + xml.getElementsByTagName("country")[i].getElementsByTagName("score")[0].childNodes[0].nodeValue + ""}
                    );
                }
            }
        }
        else if(fileType == "json")
        {
            var rowCountry = Object.keys(happinessObj.countries.country).length;

            for(i = 0; i < rowCountry; i++)
            {
                var country = happinessObj.countries.country[i].name;
                contains = false;
                for(var x = 0; x < suicidesArr.length; x++) 
                {
                    if (Object.values(suicidesArr[x]).indexOf(country) > -1) 
                    {
                        contains = true;
                    }
                }
                if(contains == true)
                {
                    happinessArr.push({
                        x: happinessObj.countries.country[i].name,
                        value: "" + happinessObj.countries.country[i].score + ""}
                    );
                }
            }
        }
        else
        {

        }
        grafiekShow();
    }
}

function getTop50Songs(fileType, chosenCountry)
{
    var top50songs = new XMLHttpRequest();
    top50songs.open( "GET" , url+ "api/top50songs.php/" + fileType + "?country=" + chosenCountry, true)
    top50songs.responseType = fileType;
    top50songs.send();

    top50songs.onload = function()
    {
        let top50songsObj = top50songs.response;
        everyGenreArr = [];
        var genreArr = [];
        if(fileType == "xml")
        {
            let parser = new DOMParser();
            xml = parser.parseFromString(top50songsObj.replace(/\<\?xml.+\?\>/g, ''), 'application/xml');   
            if(xml.getElementsByTagName("message").length >  0)
            {
                alert(xml.getElementsByTagName("message")[0].childNodes[0].nodeValue + " Probeer een ander land!");
            }
            else
            {
                var rowRank = xml.getElementsByTagName("country")[0].getElementsByTagName("data").length;
                for(i = 0; i < rowRank; i++)
                {   
                    var genre = xml.getElementsByTagName("country")[0].getElementsByTagName("data")[i].getElementsByTagName("genre")[0].childNodes[0].nodeValue
                    genreArr.push(
                        genre
                    );
                }
                getGenreValue();
            }
        }
        else if(fileType == "json")
        {   
            if(top50songsObj.hasOwnProperty("message"))
            {
                alert(top50songsObj.message);
            }
            else
            {
                var rowRank = Object.keys(top50songsObj.countries.country[0].data).length;
                for(i = 0; i < rowRank; i++)
                {
                    var genre = top50songsObj.countries.country[0].data[i].genre;
                   
                    genreArr.push(
                    genre
                    );
                }
                getGenreValue();
            }
        }
        else
        {

        }

        function getGenreValue()
        {
            genreArr.sort();
            console.log(genreArr);
            var currentGenre = null;
            var cnt = 0;
            colorcount = 0;
            for (x = 0; x < genreArr.length; x++) {
            if (genreArr[x] != currentGenre) {
                if (cnt > 0) {
                    everyGenreArr.push(
                    {
                        x: currentGenre,
                        value: "" + cnt + "",
                        fill: colorArray[colorcount]
                    });
                    colorcount++
                }
                currentGenre = genreArr[x];
                cnt = 1;
            } 
            else {
                    cnt++;
                }
            }
            console.log(everyGenreArr);
            pieShow();
        }

    }
}

function getRequest(typeRequest, table, fileType, input)
{

    var request = new XMLHttpRequest();
    request.open( typeRequest , url+ "api/"+ table + ".php/" + fileType ,true)
    request.onload = function()
    {
        var message = request.response;
        if (request.readyState == 4 && request.status == "200") 
        {
            alert(message);
        } 
        else 
        {
            alert(users);
        }
    }

    console.log(input)
    request.send(input);
}

function grafiekShow()
{
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
            "text": "test"
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

function pieShow()
{
    //console.log(window.location.href);
    setTimeout(function () 
    {
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
        //document.getElementById("cirkel").innerHTML = "";
        chart.draw();
    }, 1000);
    
};

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