<?php

	// Every time we want to access $_SESSION, we have to call session_start()
	if(!session_start()) {
		header("Location: error.php");
		exit;
	}
	
	$loggedIn = empty($_SESSION['loggedin']) ? false : $_SESSION['loggedin'];
	if (!$loggedIn) {
		header("Location: login.php");
		exit;
	}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Picture Gallery</title>
        
        <link rel="stylesheet" href="app.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        
    </head>
    <body class="gallerybody" onload="loadPhotos()">
        
    <nav class="navbar bg-dark navbar-dark">
      <!-- Brand/logo -->
        <a class="navbar-brand" href="index.php">PhotoMuseum</a>
        <form class="genreForm">
            <div class="form-group middle">
                <select name="genreSelect" class="form-control" id="exampleFormControlSelect1">
                        <option disabled selected value> Select a genre...</option>
                      <option value="street">Street Photography</option>
                      <option value="landscape">Landscape Photography</option>
                      <option value="wildlife">Wildlife Photography</option>
                </select>
                <button id="button" type="button" value="send" class="btn btn-primary middle" onclick="setGenre()">Submit</button>
              </div>
        </form>
        <button class="btn btn-primary login-button" onclick="handleLogout()">Logout</button>

    </nav>
        
        
        <div class="wrapper">
          <div class="image box a"></div>
          <div class="image box b"></div>
          <div class="image box c"></div>
          <div class="image box d"></div>
          <div id="infodiv" class="box e"></div>
          <div class="image box f"></div>
          <div class="image box g"></div>
          <div class="image box h"></div>
          <div class="image box i"></div>
          <div class="image box j"></div>
          <div class="image box k"></div>
        </div>
        
        
        <script>
                        
            var genre = "";
            var hasLoaded = false;
            
            function setGenre() {
                var selection = document.getElementById( "exampleFormControlSelect1" );
                console.log(selection.options[selection.selectedIndex].value);
                genre = selection.options[selection.selectedIndex].value;
                loadPhotos();
            }
            
            function loadPhotos() {
                if (hasLoaded == false) {
                    genre = "<?php echo $_GET["genre"]; ?>";
                    hasLoaded = true;    
                }

                var pictures = document.getElementsByClassName("image");
                var xhttp = new XMLHttpRequest();
                xhttp.onload = function(){
                    if (xhttp.status == 200){
                        var response = xhttp.responseText;
                        
                        console.log(response);
                        

                        var i=0;
                        for(i=0; i < pictures.length; i++){
                            
                            var fileArray = response.split("\n");
                            
                            //fix this to relative location
                            if (genre == "landscape" || genre == "street" || genre == "wildlife") {
                                var image = '<img src="' + "http://ec2-18-223-98-154.us-east-2.compute.amazonaws.com/Cca374FinalProject/photos/" + genre + "/" +fileArray[i] + '" alt="' + "Picture" + '">';
                                pictures[i].innerHTML = image;
                            }
                        }
                        var descBox = document.getElementById("infodiv");
                        console.log(descBox);
//                        console.log(fileArray[10]);
                        descBox.innerHTML = '<h1>Description:</h1><p>' + fileArray[10] + '</p>';

                        
                    }
                }

                xhttp.open("GET", 'getPics.php?genre=' + genre, true);
                xhttp.send();
            }
            
            function handleLogout() {
                window.location.replace('logout.php');
            }
        </script>
    </body>
</html>