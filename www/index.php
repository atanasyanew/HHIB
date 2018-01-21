<?php 
require "_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

<div class="w3-border w3-margin">
    <div class="w3-container w3-teal">
        <h2>Начало</h2>  
    </div>   
</div>   <!-- header --> 


<div class="w3-margin">  
    
<div class="w3-container w3-center">
    <h2>Уеб-базирано приложение за управление</h2>     
    
    <P>
    <?php  
        
        $File = "counter.txt"; 
        //This is the text file we keep our count in, that we just made  
        $handle = fopen($File, 'r+') ; 
        //Here we set the file, and the permissions to read plus write  
        $data = fread($handle, 512) ;  
        //Actully get the count from the file   
        $count = $data + 1; 
        //Add the new visitor to the count  
        print "Посетител № ".$count; 
        //Prints the count on the page  
        fseek($handle, 0) ;  
        //Puts the pointer back to the begining of the file  
        fwrite($handle, $count) ;  
        //saves the new count to the file  
        fclose($handle) ; 
        //closes the file  
    ?>
    </P> 
    
</div>  

    
</div>



<div class="w3-margin w3-center">
<!--    
<iframe src="https://docs.google.com/forms/d/e/1FAIpQLSd8RH8EbI2odhEnLkXJ7jKbkwi-9c2u9SMMID0AxPQHZF0OoQ/viewform?embedded=true" width="760" height="1800" frameborder="0" marginheight="0" marginwidth="0">Зарежда се…</iframe>  
-->
    
    
 <!--    
<div class="w3-container w3-border">      
<h2 class="w3-text-red">СИСТЕМНО СЪОБЩЕНИЕ!</h2>  
<div class="w3-article">  
<p>коментар</p>
</div>
</div>    
 -->   
    
<br>  
</div> 




<?PHP include_layout_template('footer.php'); ?>