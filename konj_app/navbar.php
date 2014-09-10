<?php
ob_start();

echo '
   <div class="navbar metro-navbar navbar-fixed-top">
      <div class="navbar-inner">
         <div class="container">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
               <span class="icon-bar"></span>
            </button>
            <h1 class="brand"><a href="index.html">KONJ</a> <small>racing</small></h1>
            <div class="nav-collapse collapse">
               <ul class="nav">
                  <li class="' . get_active_tab("race") . '">
                     <a href="index">Trke</a>
                  </li>
                  <li class="' . get_active_tab("league") . '">
                     <a href="league">Lige</a>
                  </li>
                  <li class="' . get_active_tab("participant") . '">
                     <a href="participant">Natjecatelji</a>
                  </li>';
                  
if(isset($_SESSION['user']))
echo '<li class="' . get_active_tab("timer") . '">
     <a href="timer">Timer</a>
    </li>
    <li class="' . get_active_tab("preferences") . '">
     <a href="preferences">Preferences</a>
    </li>
    <li class="' . get_active_tab("admin") . '">
     <a href="admin">Admin</a>
    </li>';
                
echo '</ul></div>';

if(isset($_SESSION['user']))
{  
    echo '<div align=right style="margin-right:auto;">
        <b>' . $_SESSION['user'] .'</b>
        <form action="timer" method="post">
            <fieldset>
                <button type="submit" class="btn" name="logout">Logout</button>
            </fieldset>
        </form>
        </div>';
    
    if (isset($_POST['logout']))
    {
    	destroySession();
        header("Location: index");
        exit();
    }
}
else
{
    echo'
    <div align=right style="margin-right:auto;">

         <div class="input-prepend">
             <span class="add-on">@</span>
             <input class="span2" id="prependedInput" type="text" placeholder="Username" maxlength="16" name="user" value="">
         </div>
         <div class="input-prepend">
             <span class="add-on">*</span>
             <input type="password" placeholder="Password" maxlength="30" name="pass" value="" />
         </div>         
         <input type="submit" value="Login" id="login"/>

    </div>';
}
         
echo'</div></div></div>';

?>

<script language="javascript" type="text/javascript">
$('#login').click(function(e){
    login();
});
$('input[name="user"]').keypress(function(event) {
    if ( event.which == 13 ) {
        login();
    }
});
$('input[name="pass"]').keypress(function() {
    if ( event.which == 13 ) {
        login();
    }
});

function login ()
{
    if($('input[name="user"]').val().trim() == '' || $('input[name="pass"]').val().trim() == '')
        return;
        
    var ajaxRequest; 
	
    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer Browsers
        try
        {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e) 
        {
            try
            {
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (e)
            {
                alert("Your browser broke!");
                return false;
            }
        }
    }

    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var ajaxDisplay = document.getElementById('ajaxDiv');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
        }
    }

    $('#doc-container').hide();
    $('#loading_spinner').show();

    //ajaxRequest.open("GET", "login.php", false);
    //ajaxRequest.send(null);
    
    $.ajax({
        type: 'POST',
        url: 'login.php',
        async: false,
        data: { 
            'user': $('input[name="user"]').val(), 
            'pass': $('input[name="pass"]').val() 
        },
        success: function(msg){
            //alert('wow' + msg);
            //window.location.reload(true);
            location.href = "index";
        }
    });
    
    $('#loading_spinner').hide();
    $('#doc-container').show();
    //$('#news').remove();
}
</script>