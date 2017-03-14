<?PHP 
require_once "../_Includes/initialize.php";
include_layout_template('header.php');
?>

<div class="w3-border w3-margin">

<div class="w3-container w3-teal"><h2>Изход от системата</h2></div> 
    
</div> <!-- header -->  

<?php
session_unset(); 
session_destroy(); 
?>
 
<?PHP
if (!isset($_SESSION['login'])) {
 
print "<div class=\"w3-panel w3-margin w3-green\">";
print "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
print "<h3>Излезе успешно!</h3>";
print "<p><a href=\"/HHIB/login.php\" title=\"Начало\"><span>Върни се обратно</span></a></p>";
print "</div>";  

} else {
    
print "<div class=\"w3-panel w3-margin w3-red\">";
print "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
print "<h3>Възникна грешка, неможа да напуснеш системата</h3>";
print "</div>";

}    
?>
     
 
<?PHP include_layout_template('footer.php'); ?> 