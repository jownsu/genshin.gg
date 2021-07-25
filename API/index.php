<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Genshin Impact API</title>
</head>
<body>
    <header>
        <div class="container">
            <p class="logo"><img src="images/testimonial.svg" alt="logo"> Genshin Impact API</p>
        </div>
    </header>

    <section id="intro">
        <div class="container">
            <div class="intro-info">
                <h1>Get list of <span>Genshin Impact Data</span></h1>
                <p>
                    Need some datas to build your own <span>Genshin Impact</span> website?
                    Don't worry try this <span>Genshin Impact API</span> to get datas you need.
                    It includes all characters, weapons, artifacts and consumables 
                    informations and their icons. For characters, it has icons and portraits
                    available to fetch.
                </p>
            </div>

            <div class="intro-img">
                <img src="images/dev.svg" alt="dev illustration">
            </div>
        </div>
    </section>

    <section id="about">
        <div class="container">
            <div class="about-info">
                <h1><span>Genshin Impact API</span> for testing and developing personal website</h1>
                <p>
                    Contain all characters, weapons, artifacts and consumables data. Just use GET HTTP request on the link. 
                    Individual of one data can be fetch using respective name.
                </p>
            </div>

            <div class="about-features grid">
                <div>
                    <img src="images/setting.svg" alt="setting logo">
                    <p class="feature-title">REST API</p>
                    <p>Restful online API, publicly accessible via https get method.</p>
                </div>
                <div>
                    <img src="images/json.svg" alt="json logo">
                    <p class="feature-title">JSON DATA</p>
                    <p>Contain neccessary data required to build Genshin Impact Archive.</p>
                </div>
                <div>
                    <img src="images/clock.svg" alt="clock logo">
                    <p class="feature-title">24/7 UPTIME</p>
                    <p>Fast response time in your testing & developement phases.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="demo">
        <div class="container">

            <div>
                <h2>Introduction</h2>
                <p>
                    GET method is used to appends form data to the URL in name
                    or value pair. If you use GET, the length of URL will remain
                    limited. It helps users to submit the bookmark the result. GET
                    is better for the data which does not require any security or
                    having images or word documents.<br><br>
                    In this API, there are 4 sets of data you can fetch. Characters, Weapons, Artifacts and Consumables. You can get all names by entering it as first paramater
                </p>
                <!-- https://genshin-archive.000webhostapp.com/api/characters -->
                <a href="http://localhost/projects/genshin.gg/api/characters" target="_blank"><span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/characters</a>
                <h2>Response</h2>
                <img src="images/response1.png" alt="response img">
            </div>

            <div>
                <h2>Get Single Data</h2>
                <p>
                    To get single data, after choosing from main sets of data (characters, weapons, artifacts and consumables). You need to input the name of your choice as the second parameter.
                </p>
                <!--  https://genshin-archive.000webhostapp.com/api/characters/albedo-->
                <a href="http://localhost/projects/genshin.gg/api/characters/albedo" target="_blank"><span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/characters/albedo</a>
                <h2>Response</h2>
                <img src="images/response2.png" alt="response img">
            </div>

            <div>
                <h2>Get Icon/Portrait</h2>
                <p>
                    To get the icon, just input icon as your third parameter. To get the portrait, just input portrait as third parameter. *Portraits is only available for characters. 
                </p>
                <!--  https://genshin-archive.000webhostapp.com/api/characters/albedo/portrait-->
                <a href="http://localhost/projects/genshin.gg/api/characters/albedo/portrait" target="_blank"><span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/character/albedo/portrait</a>
                <h2>Response</h2>
                <img src="images/response3.png" alt="response img">
            </div>

        </div>
    </section>

    <section id="gets">
        <div class="container">
            <h2>Entire JSON API</h2>
            <div class="get grid">
                <!-- https://genshin-archive.000webhostapp.com/api/characters
            https://genshin-archive.000webhostapp.com/api/characters/albedo
        https://genshin-archive.000webhostapp.com/api/characters/albedo/icon 
    https://genshin-archive.000webhostapp.com/api/characters/albedo/portrait-->
                <a href="http://localhost/projects/genshin.gg/api/characters" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/characters</a>
                <a href="http://localhost/projects/genshin.gg/api/characters/albedo" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/characters/&lt;name&gt;</a>
                <a href="http://localhost/projects/genshin.gg/api/characters/albedo/icon" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/characters/&lt;name&gt;/icon</a>
                <a href="http://localhost/projects/genshin.gg/api/characters/albedo/portrait" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/characters/&lt;name&gt;/portrait</a>

                <!--  https://genshin-archive.000webhostapp.com/api/weapons
            https://genshin-archive.000webhostapp.com/api/weapons/alley%20hunter
        https://genshin-archive.000webhostapp.com/api/weapons/alley%20hunter/icon-->
                <a href="http://localhost/projects/genshin.gg/api/weapons" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/weapons</a>
                <a href="http://localhost/projects/genshin.gg/api/weapons/alley%20hunter" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/weapons/&lt;name&gt;</a>
                <a href="http://localhost/projects/genshin.gg/api/weapons/alley%20hunter/icon" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/weapons/&lt;name&gt;/icon</a>
                
                <!-- https://genshin-archive.000webhostapp.com/api/artifacts 
            https://genshin-archive.000webhostapp.com/api/artifacts/adventurer
        https://genshin-archive.000webhostapp.com/api/artifacts/adventurer/icon-->
                <a href="http://localhost/projects/genshin.gg/api/artifacts" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/artifacts</a>
                <a href="http://localhost/projects/genshin.gg/api/artifacts/adventurer" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/artifacts/&lt;name&gt;</a>
                <a href="http://localhost/projects/genshin.gg/api/artifacts/adventurer/icon" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/artifacts/&lt;name&gt;/icon</a>
                
                <!--  https://genshin-archive.000webhostapp.com/api/consumables
            https://genshin-archive.000webhostapp.com/api/consumables/a%20buoyant%20breeze
        https://genshin-archive.000webhostapp.com/api/consumables/a%20buoyant%20breeze/icon-->
                <a href="http://localhost/projects/genshin.gg/api/consumables/" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/consumables</a>
                <a href="http://localhost/projects/genshin.gg/api/consumables/a%20buoyant%20breeze" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/consumables&lt;name&gt;</a>
                <a href="http://localhost/projects/genshin.gg/api/consumables/a%20buoyant%20breeze/icon" target="_blank"> <span class="demo-api-btn">GET</span>  https://genshin-archive.000webhostapp.com/api/consumables&lt;name&gt;/icon</a>
            
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2021 Genshin Impact API - Jownsu</p>
        </div>
    </footer>

    
</body>
</html>