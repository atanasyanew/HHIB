<?PHP 
    require_once "_Includes/initialize.php"; 
    include_layout_template('header.php'); 
    if ( isset($_SESSION['login']) && $_SESSION['login'] != '' ) {
        redirect_to("index.php");
    }   
?>





<?php 

if (isset($_POST['btnSubmit']) && isset($_POST['chkConfirm'])) {    
    
    if ( $ur->checkUsername($_POST['userName']) &&
         $_POST['userPassword1'] == $_POST['userPassword2'] &&
         $ur->checkRealName($_POST['userRealName']) &&
         $ur->checkEmail($_POST['userMail'])  ) { //test
        
        //reg or user exist
        if($ur->singUp()) {
        
            $warningMsg  = "<div class=\"w3-panel w3-margin w3-green\">";
            $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            $warningMsg .= "<h3>Успешно регистриране!</h3>";
            $warningMsg .= "<p><a href=\"./login.php\" title=\"Начало\"><span>Вход към системата</span></a></p>";
            $warningMsg .= "</div>"; 
            
        } else {
            
            //cant reg user exist 
            $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
            $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            $warningMsg .= "<h3>Неуспешна регистрация!</h3>";
            $warningMsg .= "<p>възможни причини: </p>";
            $warningMsg .= "<ul>";
            $warningMsg .= "<li>Съществуващо потребителско име.</li>";
            $warningMsg .= "<li>Несъвпадение на паролите.</li>";
            $warningMsg .= "<li>Грешен мейл адрес.</li>";
            $warningMsg .= "<li>Потребителското име, има неразрешени символи.</li>";
            $warningMsg .= "</ul>"; 
            $warningMsg .= "</div>"; 
        }
   
    } else { 
         
    //cant reg    
    $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $warningMsg .= "<h3>Неуспешна регистрация!</h3>";
    $warningMsg .= "<p>възможни причини: </p>";
    $warningMsg .= "<ul>";
    $warningMsg .= "<li>Съществуващо потребителско име.</li>";
    $warningMsg .= "<li>Несъвпадение на паролите.</li>";
    $warningMsg .= "<li>Грешен мейл адрес.</li>";
    $warningMsg .= "<li>Потребителското име, има неразрешени символи.</li>";
    $warningMsg .= "</ul>"; 
    $warningMsg .= "</div>"; 

    }

}  elseif (isset($_POST['btnSubmit']) && !isset($_POST['chkConfirm'])) {
     
    // no check box error msg  
    $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $warningMsg .= "<h3>Не сте потвърдили заявката!</h3>";
    $warningMsg .= "</div>";   
    
} 
   
?> 
 

<div class="w3-container w3-teal">
<h2>Регистрация на нов потребител</h2>
</div> <!-- HEADER -->

<div class="w3-panel w3-margin w3-blue">
    <span onclick="this.parentElement.style.display='none'" class="w3-closebtn">&times;</span>
    <h3>Информация!</h3>  
     <ul>
     <li>Попълването на ифромация във формата трябва да е на <b>ЛАТИНИЦА.</b></li> 
     <li>При регистриране, профила е без правомощия. Може да се свържете с администратор за добавяне на права.</li> 
     <li>Въведете истинското си име на латиница във формат: X. Xxxxx</li>
     </ul>
  </div> <!-- USER INFO -->

<?php if (isset($warningMsg)){echo $warningMsg;} //error msg if !checkbox ?> 

<div class="w3-content w3-padding-128" style="max-width:500px">
   
<div class="w3-card-4">
  <div class="w3-container w3-teal"><h2>Регистрация</h2></div>
    
<BR>   
  <form class="w3-container" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
    <p><input class="w3-input" name="userName" type="text" required  placeholder="Потребителско име (НА ЛАТИНИЦА)"></p>
    <p><input class="w3-input" name="userPassword1" type="password" required placeholder="Парола"></p>
    <p><input class="w3-input" name="userPassword2" type="password" required placeholder="Повторете паролата"></p>
    <p><input class="w3-input" name="userRealName"  type="text" required placeholder="Реално име, Пимер: X. Xxxx (НА ЛАТИНИЦА)"></p>
    <p><input class="w3-input" name="userMail" type="text" required placeholder="служебен мейл адрес"></p>  
      
    <p>
    <input class="w3-check-small" type="checkbox" name="chkConfirm">
    <label class="w3-validate w3-small">Потвърди</label>
    </p>
      
    <p>
    <button class="w3-btn w3-teal" value="true" name="btnSubmit">Регистрирай се</button>
    <a href="./login.php" class="w3-right"><i class="fa fa-sign-in" aria-hidden="true"></i> Върни се обратно</a>
    </p>    
  </form>
                
</div>         
</div>   <!-- REGISTER FORM -->     
    
 
<?PHP include_layout_template('footer.php'); ?> 
    
    
    
    