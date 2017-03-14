<?PHP 
    require_once "_Includes/initialize.php"; 
    include_layout_template('header.php'); 
    if ( isset($_SESSION['login']) && $_SESSION['login'] != '' ) {
        redirect_to("index.php");
    }   
?>

<div class="w3-container w3-teal">
<h2>Вход</h2>
</div>

<?php 
    $u_name     = "";       
    $u_password = "";   

   if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $user = new User();
    $u_name     = "{$_POST['u_name']}";    
    $u_password = "{$_POST['u_password']}";   
    $user->login($u_name, $u_password);
}
?> 
      
<div class="w3-content w3-padding-128" style="max-width:500px">
   
<div class="w3-card-4">
  <div class="w3-container w3-teal">
    <h2>Влезте в системата</h2>
  </div>
            <BR>   
  <form class="w3-container" action="" method="post">
    <p><input class="w3-input" name="u_name" type="text" required placeholder="Потребителско име"></p>
    <p><input class="w3-input" name="u_password" type="password" required placeholder="Парола"></p>
    <p><button class="w3-btn w3-teal" value="true" name="u_login">Влез</button>
       <a href="/HHIB/singup.php" class="w3-right"><i class="fa fa-user-plus" aria-hidden="true"></i> Регистрация</a>
      </p>
  </form>
                
</div>  
         
</div>       
        
<?PHP include_layout_template('footer.php'); ?> 