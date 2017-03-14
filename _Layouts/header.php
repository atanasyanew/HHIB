<?php
session_start();
?>

<!DOCTYPE HTML>
<HTML xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
<!-- 
online libs:
    1. icons (font-awesome)
    2. bootstrap
    3. w3-css
    4. jquery

<link rel="stylesheet" 
href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<link rel="stylesheet" 
href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">  

<link rel="stylesheet"
href="http://www.w3schools.com/lib/w3.css">  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 

--> 
    
    <link rel="stylesheet" href="/_CSS/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/_CSS/bootstrap/css/bootstrap.min.css" >
    <link rel="stylesheet" href="/_CSS/W3CSS/w3.css">
    <script type="text/javascript" src="/HHIB/_Includes/jquery.min.js"></script> 
     
    
<title>HHIB</title>  
<link rel="shortcut icon" href="/_IMG/logo_2.svg"/>
</head>    
    
<ul class="w3-navbar w3-hover-none"> 
<li> <a class="w3-hover-none" href="/index.php"><img id="logo" src="/HHIB/_IMG/logo.svg" alt="HHIB" /></a></li>
<li> <H5 class="w3-text-dark-grey">TC Web management</H5></li>    
</ul> <!-- logo stuff -->
    
    
<?php  //Maintenance      

/*   
echo "<div class='w3-container w3-indigo w3-padding-64'>";

echo "<pre>";   
print_r($_SESSION); //test kakuv array vzima   
echo "</pre>";   
  
echo "<pre>";
print_r(get_declared_classes());
echo "</pre>";
 
echo "<pre>";      
$host = gethostname();
$ip = gethostbyname($host);
$actual_link = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];
    
echo 'SITE_ROOT: ' .  SITE_ROOT . "<br/>";
echo 'LIB_PATH: '  . LIB_PATH  . "<br/>"; 
echo "SERVER_ADDR: " . $_SERVER['SERVER_ADDR'] . "<br/>"; 
echo "gethostname(): " .  $host . "<br/>";
echo "gethostbyname(host): " .  $ip . "<br/>";
echo "actual_link: " . $actual_link  . "<br/>";
echo "</pre>";    
    
echo "</div>";  
*/  
    
?>
    
    
<BODY> 

<HEADER>  
<?PHP  
    if (isset($_SESSION['login']) && $_SESSION['login'] != '') {
        include ("navigation.php");
    }
?>       
</HEADER> 



        
        
        
        
  
    
  
    


   

    
    
    
         
        
        