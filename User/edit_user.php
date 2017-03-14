<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
//second check for this page
if ($_SESSION['user_permission']!=(int)'1111') { redirect_to('user_profile.php'); } 

?>

<?php 
    //GENERAL STUFF
    $user = new User();

    $subject = $user->find_row_by_id($_GET['subjectId']); 

    if (!$user->affected_rows()==1){
        redirect_to('user_profile.php');    
    
    } else {  
    $user->id=$_GET['subjectId'];              
}
?>

<?php 
//delete user
if (isset($_POST['btnSubmitDeleteUser']) && isset($_POST['chkConfirmDeleteUser'])){
   
     $user->delete();
        
     $warningMsg  = "<div class=\"w3-panel w3-margin w3-green\">";
     $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
     $warningMsg .= "<h3>Успешно изтрит потребител!</h3>";
     $warningMsg .= "<h4><a href=\"/HHIB/User/user_profile.php\" title=\"Начало\"><span>Върни се обратно</span></a></h4>";
     $warningMsg .= "</div>";

} elseif (isset($_POST['btnSubmitDeleteUser']) && !isset($_POST['chkConfirmDeleteUser'])) {
    
    $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $warningMsg .= "<h3>Не сте потвърдили заявката!</h3>";
    $warningMsg .= "</div>"; 
} 

// update user
if (isset($_POST['btnSubmit']) && isset($_POST['chkConfirm'])) {    
    
    if ( $user->checkUsername($_POST['userName']) &&
         $_POST['userPassword'] != '' &&
         $user->checkRealName($_POST['userRealName']) &&
         $user->checkEmail($_POST['userMail'])  ) { //test
        
        //reg or user exist
        if($user->editUser()) {
        
            
            $warningMsg  = "<div class=\"w3-panel w3-margin w3-green\">";
            $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            $warningMsg .= "<h3>Успешнa примяна!</h3>";
            $warningMsg .= "<h4><a href=\"/HHIB/User/edit_user.php?subjectId={$user->id}\" title=\"Начало\"><span>Натисни тук за да перзареди и обнови информацията в текущата страница</span></a></h4>";
            $warningMsg .= "</div>"; 
   
        } else {
            
            //cant reg user exist 
            $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
            $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            $warningMsg .= "<h3>Неуспешна промяна!</h3>";
            $warningMsg .= "<p>възможни причини: </p>";
            $warningMsg .= "<ul>";
            $warningMsg .= "<li>Съществуващо потребителско име.</li>";
            $warningMsg .= "<li>Грешен мейл адрес.</li>";
            $warningMsg .= "<li>Потребителското име, има неразрешени символи.</li>";
            $warningMsg .= "</ul>"; 
            $warningMsg .= "</div>"; 
        }
   
    
    } else { 
         
    //cant reg    
    $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $warningMsg .= "<h3>Неуспешна промяна!</h3>";
    $warningMsg .= "<p>възможни причини: </p>";
    $warningMsg .= "<ul>";
    $warningMsg .= "<li>Съществуващо потребителско име.</li>";
    $warningMsg .= "<li>Грешен мейл адрес.</li>";
    $warningMsg .= "<li>Потребителското име, има неразрешени символи.</li>";
    $warningMsg .= "</ul>"; 
    $warningMsg .= "</div>"; 

    }


} elseif (isset($_POST['btnSubmit']) && !isset($_POST['chkConfirm'])) {
     
    // no check box error msg  
    $warningMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $warningMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $warningMsg .= "<h3>Не сте потвърдили заявката!</h3>";
    $warningMsg .= "</div>";   
    
} 
?> 


<div class="w3-container w3-teal w3-margin">
<h2>Редактиране на потребителски профил: <?php echo $subject['user_name'];?></h2>
</div> <!-- header -->  


<div class="w3-panel w3-margin w3-blue">
    <span onclick="this.parentElement.style.display='none'" class="w3-closebtn">&times;</span>
    <h3>Информация!</h3>  
     <ul>
     <li>Попълването на ифромация във формата трябва да е на <b>ЛАТИНИЦА.</b></li> 
     </ul>
  </div> <!-- USER INFO -->

<?php if (isset($warningMsg)){echo $warningMsg;} //error msg if !checkbox ?> 

<div class="w3-content w3-padding-32" style="max-width:500px">
   
<div class="w3-card-4">
  <div class="w3-container w3-teal"><h3>Редактиране на потребител с ID - <?php echo $subject['id']; ?></h3></div>
    
<BR>   
  <form class="w3-container" 
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?subjectId=".$subject['id']; ?>" method="POST">
    <p><input class="w3-input" name="userName" type="text" required  
             readonly
              value="<?php echo $subject['user_name'];?>"></p>
      
    <p class="w3-hide"><input class="w3-input" name="userPassword" type="text" required 
              placeholder="Парола"
              value="<?php echo $subject['user_password'];?>"></p>
      
    <p><input class="w3-input" name="userRealName"  type="text" required 
              placeholder="Реално име, Пимер: X. Xxxx (НА ЛАТИНИЦА)"
              value="<?php echo $subject['real_name'];?>"></p>
      
    <p><input class="w3-input" name="userMail" type="text" required 
              placeholder="служебен мейл адрес"
              value="<?php echo $subject['user_email'];?>"></p>  
      
     <p><input class="w3-input" name="userType" type="number" required 
              placeholder="ниво на достъп"
              value="<?php echo $subject['user_type'];?>"></p>  
      
     <p>
     <input class="w3-check-small" type="checkbox" name="chkConfirm">
     <label class="w3-validate w3-small">Потвърди</label>    
     </p>
      
        <p>
        <button class="w3-btn w3-teal" value="true" name="btnSubmit">Запиши</button>
        <a href="/HHIB/User/user_profile.php" class="w3-right">
            <i class="fa fa-sign-in" aria-hidden="true"></i>Върни се обратно</a>
        </p>
         
      
  </form>
                
</div>         
</div>   <!-- EDIT FORM -->       
    
<div class="w3-content w3-padding-32" style="max-width:500px">
   
<div class="w3-card-4">
  <div class="w3-container w3-red"><h3>Изтриване на потребител с ID - <?php echo $subject['id']; ?></h3></div>
    
<BR>   
  <form class="w3-container" 
        action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"])."?subjectId=".$subject['id']; ?>" method="POST">
  
      
     <p>Потребителско име:<b> <?php echo $subject['user_name'];?></b></p>
     <p class="w3-hide">Парола:<b> <?php echo $subject['user_password'];?></b></p> 
     <p>Име:<b> <?php echo $subject['real_name'];?></b></p> 
     <p>Е-Поща:<b> <?php echo $subject['user_email'];?></b></p>  
     <p>Ниво на достъп:<b> <?php echo $subject['user_type'];?></b></p> 
      
     <p>
     <input class="w3-check-small" type="checkbox" name="chkConfirmDeleteUser">
     <label class="w3-validate w3-small">Потвърди изтриването</label>    
     </p>
      
      <p>
      <button class="w3-btn w3-red" value="true" name="btnSubmitDeleteUser">Изтрий</button>
      <a href="/HHIB/User/user_profile.php" class="w3-right">
      <i class="fa fa-sign-in" aria-hidden="true"></i>Върни се обратно</a>
      </p>
         
      
  </form>
                
</div>         
</div>   <!-- DELETE USER FORM -->        
         
    
<?PHP include_layout_template('footer.php'); ?>     