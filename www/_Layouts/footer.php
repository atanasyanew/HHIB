<?php //require_once "/_Includes/initialize.php"; ?>
  
<br>
<br>

<footer class="w3-container w3-padding-24 w3-theme-d2 w3-center w3-border-top">
  <h5>
      <a href="http://www.hhi-co.bg" title="HHIB" target="_blank">
      &copy; <?php echo date("Y", time()); ?> Hyundai Heavy Industries CO. Bulgaria</a>
  </h5>
    
  <p>Developed A. Yanev</p>
</footer>

</BODY> 


</HTML>   

<?php if( isset($database) ) { $database->close_connection(); } ?>

