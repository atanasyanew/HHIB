<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

<?php //general stuff
$user = new User();
$newPassword = "";     
$oldPassword = "";
?>

<?php 

// ORDER MAIN MAIL
$ordersMainEmailFile = $user->ordersMainEmailFile;
$ordersMainEmail = $user->checkAndReturnMainMailFile ($ordersMainEmailFile);
$ordersMainEmailTest = $user->sendMailOutlook($ordersMainEmailFile, (int)0, " RS-16-xxx....", " order information");
if( isset($_GET['sbmEditMainEmailOrder']) && isset($_GET['chkEditMainEmailOrder']) ){
    
    $file = $ordersMainEmailFile;
    $to  = $_GET['orderMailTo'];
    $cc  =  $_GET['orderMailCcc'];
    $bcc = $_GET['orderMailBcc'];
    $subject = $_GET['orderMailSubject'];
    $bodytext = $_GET['orderMailBodytext'];
    
    $user->editMainMailFile ($ordersMainEmailFile, $to, $cc, $bcc, $subject, $bodytext);
  
    redirect_to('user_profile.php');    
} 
// ORDER APPROVE MAIL
$ordersApproveEmailFile = $user->ordersApproveEmailFile; //define sc file         
$ordersApproveEmailArray = $user->checkAndReturnApproveOrdersFile ($ordersApproveEmailFile); //get file array
if( isset($_GET['sbmEditApproveEmailOrder']) && isset($_GET['chkEditApproveEmailOrder']) ){
    
   if ($user->editMailApproveOrdersFile($ordersApproveEmailFile)) {
       redirect_to('user_profile.php'); 
   } else { echo "ERROR"; };
} 


// OFFER MAIN EMAIL
$offersMainEmailFile = $user->offersMainEmailFile;
$offersMainEmail = $user->checkAndReturnMainMailFile ($offersMainEmailFile);
$offersMainEmailTest = $user->sendMailOutlook($offersMainEmailFile, (int)0, " RS-16-XX-XX-XXX ", " other info");
if( isset($_GET['sbmEditMainEmailOffer']) && isset($_GET['chkEditMainEmailOffer']) ){
    
    $file = $ordersMainEmailFile;
    $to  = $_GET['offerMailTo'];
    $cc  =  $_GET['offerMailCcc'];
    $bcc = $_GET['offerMailBcc'];
    $subject = $_GET['offerMailSubject'];
    $bodytext = $_GET['offerMailBodytext'];
    
    $user->editMainMailFile ($offersMainEmailFile, $to, $cc, $bcc, $subject, $bodytext);
    redirect_to('user_profile.php');    
} 

// OFFER APPROVE MAIL
$offerApproveEmailFile = $user->offersApproveEmailFile;       
$offersApproveEmailArray = $user->checkAndReturnApproveOffersFile ($offerApproveEmailFile); 
if( isset($_GET['sbmEditApproveEmailOffer']) && isset($_GET['chkEditApproveEmailOffer']) ){
    
   if ($user->editMailApproveOffersFile($offerApproveEmailFile)) {
       redirect_to('user_profile.php'); 
   } else { echo "ERROR"; };
} 

?>


<div class="w3-container w3-teal w3-margin">
<h2>Профил</h2>
</div> <!-- header -->  

<?php //system msg inside method that why code is here
if(isset($_POST['submitPassword'])){
    $newPassword  = "{$_POST['newPasssword']}";     
    $oldPassword  = "{$_POST['oldPasssword']}";
    $user->changePassword($newPassword, $oldPassword);       
} //change password
?>

<div class="w3-row-padding">  
    
<div class="w3-half"> 
                <div class="w3-container w3-teal">
                    <h6>Потребителска информация</h6>
                </div> <!-- zaglavie -->
    
                <div class="w3-section">
                    <table class="w3-table w3-hoverable w3-border">
                        
                    <thead>
                      <tr class="w3-light-grey">
                        <th> Потребителско име </th> 
                        <th> Име </th> 
                        <th> Ниво на достъп </th> 
                      </tr>
                    </thead>

                <tr>     
                    <td> <?php echo $_SESSION['login']; ?> </td>
                    <td> <?php echo $_SESSION['real_name']; ?> </td>
                    <td> <?php echo $_SESSION['user_permission']; ?> </td>
                </tr>                                    
</table>                 
</div>   <!-- table -->   
</div> 
    
<div class="w3-half"> 
                <div class="w3-container w3-teal">
                    <h6>Смяна на парола</h6>
                </div> <!-- zaglavie -->
    
                <div class="w3-section w3-border">
                     
                  <FORM class="" METHOD='POST' ACTION=''>
       
                <div class="form-group">
                        <div class="col-sm-4">
                        <input class="form-control" 
                               type="password" 
                               placeholder='Текуща парола'
                               name="oldPasssword"
                               value=""></div> </div>           

                <div class="form-group">
                        <div class="col-sm-4">
                        <input class="form-control" 
                               type="password" 
                               placeholder='нова парола'
                               name="newPasssword"
                               value=""></div> </div>      

                <div class="form-group">
                    <INPUT class='w3-btn w3-teal' 
                                            type='Submit' 
                                            name='submitPassword'
                                            VALUE='Запиши'> </div>   
    
                </FORM>      
                </div>   <!-- form -->
                  
</div>  
    
    
</div>  <!-- user info -->
    
<div class="w3-row-padding <?php print $ss->userPermissions('1000') ?>">  
    
    
<div class="w3-half"> 
    
        <div class="w3-container w3-teal">
            <h6>Е-Поща, настройки за ОФЕРТИ
            <button onclick="myFunction('offerEmailsInclude')" class="w3-btn w3-right w3-teal">
            <i class="fa fa-eye" aria-hidden="true"></i>
            </button>
            </h6>
        </div> <!-- zaglavie -->
    
        <div class="w3-section w3-accordion-content" id="offerEmailsInclude">
            
                  <h5>Опции за основния бутон:</h5>    
                  <form class="w3-container w3-padding w3-border" method="get" action="">
                  <p><label class="w3-label">TO</label>      
                  <textarea class="w3-input w3-border" 
                            name="offerMailTo"><?php echo $offersMainEmail[0]['to']; ?></textarea></p>
                   
                  <p><label class="w3-label">CCC</label>      
                  <textarea class="w3-input w3-border" 
                            name="offerMailCcc"><?php print $offersMainEmail[0]['cc'] ?></textarea></p>
                    
                  <p><label class="w3-label">BCC</label>      
                  <textarea class="w3-input w3-border" 
                            name="offerMailBcc"><?php print $offersMainEmail[0]['bcc'] ?></textarea></p>
                    
                  <p><label class="w3-label">SUBJECT</label>      
                  <textarea class="w3-input w3-border" 
                            name="offerMailSubject"><?php print $offersMainEmail[0]['subject'] ?></textarea></p>
                    
                  <p><label class="w3-label">BODYTEXT</label>      
                  <textarea class="w3-input w3-border" 
                            name="offerMailBodytext"><?php print $offersMainEmail[0]['bodytext'] ?></textarea></p>
                            
                  <p><input class="w3-check-small" type="checkbox" name="chkEditMainEmailOffer">
                  <label class="w3-validate w3-small">Потвърди</label></p>
                   
                  <p><button class="w3-btn w3-teal" value="true" name="sbmEditMainEmailOffer">Запиши</button>
                  <a class="w3-right" href="<?php echo $offersMainEmailTest; ?>" target="_top">
                  <i class="fa fa-envelope-o" aria-hidden="true"></i> TEST</a></p>   
                  </form>  
            
                <br><br>
            
<h5>Опции на е-поща, отнасящи се до нивото на одобрение:</h5>           
            
<?php                             
echo "<form class=\"\" method=\"GET\" action=\"\">";            

for ($row = 0; $row < count($offersApproveEmailArray); $row++) {      
       
//prepare some other stuff:
$offersApproveEmailTest = $user->sendMailOutlook($offerApproveEmailFile, $row, " RS-XX-XX-XX-XXX", " other info");
      
echo "<div class=\"w3-container w3-padding w3-border\">";   
echo "<h6 class=\"\">Опции за : ". $offersApproveEmailArray[$row]['approveTitle'];
echo "<p class=\"w3-right\"><a href=\"{$offersApproveEmailTest}\" target=\"_top\">";
echo "<i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i></a></p>";
echo "</h6>"; 
    
echo "<input class=\"w3-input w3-hide\" type=\"text\" readonly ";
echo "name=\"offerApproveMail01[{$row}]\" value=\"{$offersApproveEmailArray[$row]['approveTitle']}\">";
    
echo "<p><label class=\"w3-label\">TO</label>";      
echo "<textarea class=\"w3-input w3-border\" ";
echo "name=\"offerApproveMail02[{$row}]\">".$offersApproveEmailArray[$row]['to'];
echo "</textarea></p>";
                      
echo "<p><label class=\"w3-label\">CCC</label>";      
echo "<textarea class=\"w3-input w3-border\" ";
echo "name=\"offerApproveMail03[{$row}]\">".$offersApproveEmailArray[$row]['cc'];
echo "</textarea></p>";
                
echo "<p><label class=\"w3-label\">BCC</label>";     
echo "<textarea class=\"w3-input w3-border\" ";
echo " name=\"offerApproveMail04[{$row}]\">".$offersApproveEmailArray[$row]['bcc'];
echo "</textarea></p>";
             
echo "<p><label class=\"w3-label\">SUBJECT</label>";     
echo "<textarea class=\"w3-input w3-border\" "; 
echo "name=\"offerApproveMail05[{$row}]\">".$offersApproveEmailArray[$row]['subject'];
echo "</textarea></p>";
                   
echo "<p><label class=\"w3-label\">BODYTEXT</label>";      
echo "<textarea class=\"w3-input w3-border\" ";
echo "name=\"offerApproveMail06[{$row}]\">".$offersApproveEmailArray[$row]['bodytext'];
echo "</textarea></p>";

echo "</div>";
echo "<hr>";   
}
            
echo "<div class=\"w3-container w3-padding w3-border\">";              
echo "<p><input class=\"w3-check-small\" type=\"checkbox\" name=\"chkEditApproveEmailOffer\">";
echo "<label class=\"w3-validate w3-small\"> Потвърди промените</label>";         
echo "<button class=\"w3-btn w3-teal w3-right\" value=\"true\" name=\"sbmEditApproveEmailOffer\">Запиши</button></p>";  
echo "</div>";
echo  "</form>";    
            
?>                   
</div>  <!-- form MAIN EMAIL-->
    
    
    
    
</div> <!-- offers email options -->
    
<div class="w3-half"> 
    
        <div class="w3-container w3-teal">
            <h6>Е-Поща, настройки за Вътрешно-Фирмени Поръчки
            <button onclick="myFunction('orderEmailsInclude')" class="w3-btn w3-right w3-teal">
            <i class="fa fa-eye" aria-hidden="true"></i>
            </button>
            </h6>
        </div> <!-- zaglavie -->
    
        <div class="w3-section w3-accordion-content" id="orderEmailsInclude">
            
                  <h5>Опции за основния бутон:</h5>    
                  <form class="w3-container w3-padding w3-border" method="get" action="">
                  <p><label class="w3-label">TO</label>      
                  <textarea class="w3-input w3-border" 
                            name="orderMailTo"><?php echo $ordersMainEmail[0]['to']; ?></textarea></p>
                   
                  <p><label class="w3-label">CCC</label>      
                  <textarea class="w3-input w3-border" 
                            name="orderMailCcc"><?php print $ordersMainEmail[0]['cc'] ?></textarea></p>
                    
                  <p><label class="w3-label">BCC</label>      
                  <textarea class="w3-input w3-border" 
                            name="orderMailBcc"><?php print $ordersMainEmail[0]['bcc'] ?></textarea></p>
                    
                  <p><label class="w3-label">SUBJECT</label>      
                  <textarea class="w3-input w3-border" 
                            name="orderMailSubject"><?php print $ordersMainEmail[0]['subject'] ?></textarea></p>
                    
                  <p><label class="w3-label">BODYTEXT</label>      
                  <textarea class="w3-input w3-border" 
                            name="orderMailBodytext"><?php print $ordersMainEmail[0]['bodytext'] ?></textarea></p>
                            
                  <p><input class="w3-check-small" type="checkbox" name="chkEditMainEmailOrder">
                  <label class="w3-validate w3-small">Потвърди</label></p>
                   
                  <p><button class="w3-btn w3-teal" value="true" name="sbmEditMainEmailOrder">Запиши</button>
                  <a class="w3-right" href="<?php echo $ordersMainEmailTest; ?>" target="_top">
                  <i class="fa fa-envelope-o" aria-hidden="true"></i> TEST</a></p>   
                  </form>  
            
                <br><br>
            
<h5>Опции на е-поща, отнасящи се до нивото на одобрение:</h5>           
            
<?php                             
echo "<form class=\"\" method=\"GET\" action=\"\">";            

for ($row = 0; $row < count($ordersApproveEmailArray); $row++) {      
       
//prepare some other stuff:
$ordersApproveEmailTest = $user->sendMailOutlook($ordersApproveEmailFile, $row, " RS-16-xxx", " order information");
      
echo "<div class=\"w3-container w3-padding w3-border\">";   
echo "<h6 class=\"\">Опции за ниво на одобрение: ". $ordersApproveEmailArray[$row]['approveTitle'];
echo "<p class=\"w3-right\"><a href=\"{$ordersApproveEmailTest}\" target=\"_top\">";
echo "<i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i></a></p>";
echo "</h6>"; 
    
echo "<input class=\"w3-input w3-hide\" type=\"text\" readonly ";
echo "name=\"orderApproveMail01[{$row}]\" value=\"{$ordersApproveEmailArray[$row]['approveTitle']}\">";
    
echo "<p><label class=\"w3-label\">TO</label>";      
echo "<textarea class=\"w3-input w3-border\" ";
echo "name=\"orderApproveMail02[{$row}]\">".$ordersApproveEmailArray[$row]['to'];
echo "</textarea></p>";
                      
echo "<p><label class=\"w3-label\">CCC</label>";      
echo "<textarea class=\"w3-input w3-border\" ";
echo "name=\"orderApproveMail03[{$row}]\">".$ordersApproveEmailArray[$row]['cc'];
echo "</textarea></p>";
                
echo "<p><label class=\"w3-label\">BCC</label>";     
echo "<textarea class=\"w3-input w3-border\" ";
echo " name=\"orderApproveMail04[{$row}]\">".$ordersApproveEmailArray[$row]['bcc'];
echo "</textarea></p>";
             
echo "<p><label class=\"w3-label\">SUBJECT</label>";     
echo "<textarea class=\"w3-input w3-border\" "; 
echo "name=\"orderApproveMail05[{$row}]\">".$ordersApproveEmailArray[$row]['subject'];
echo "</textarea></p>";
                   
echo "<p><label class=\"w3-label\">BODYTEXT</label>";      
echo "<textarea class=\"w3-input w3-border\" ";
echo "name=\"orderApproveMail06[{$row}]\">".$ordersApproveEmailArray[$row]['bodytext'];
echo "</textarea></p>";

echo "</div>";
echo "<hr>";   
}
            
echo "<div class=\"w3-container w3-padding w3-border\">";              
echo "<p><input class=\"w3-check-small\" type=\"checkbox\" name=\"chkEditApproveEmailOrder\">";
echo "<label class=\"w3-validate w3-small\"> Потвърди промените</label>";         
echo "<button class=\"w3-btn w3-teal w3-right\" value=\"true\" name=\"sbmEditApproveEmailOrder\">Запиши</button></p>";  
echo "</div>";
echo  "</form>";    
            
?>                   
</div>  <!-- form MAIN EMAIL-->
    
    
    
    
    
</div>  <!-- order email options -->
 
    
</div>  <!-- mail options -->
 
<div class="w3-margin <?php print $ss->userPermissions('1000') ?>">    
    
<div class="w3-container w3-teal">
    
 <h6>Редактиране на потребители
     <button onclick="myFunction('userInclude')" class="w3-btn w3-right w3-teal">
     <i class="fa fa-eye" aria-hidden="true"></i></button>
    </h6>
    </div>             
    
<div id="userInclude" class="w3-section w3-accordion-content">
                     
<table class="w3-table w3-hoverable w3-border">
    <thead>
           <tr class="w3-light-grey">
             <th> Потребителско име </th> 
             <th> Име </th> 
             <th> Ниво на достъп </th> 
             <th> Мейл Адрес </th>
             <th> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> </th>
           </tr>          
    </thead>          
 <?php                                        
$result = $user->findAllUsers();  
  
while( $subject = $user->fetch_assoc($result) ) { 
       
$page_ref_by_id = "<a href='edit_user.php?subjectId={$subject['id']}'><i class=\"fa fa-pencil-square-o\" aria-hidden=\"true\"></i></a>";  
       
    echo "<tr>";     
        echo "<td nowrap>" . $subject['user_name'] . "</td>";
        echo "<td nowrap>" . $subject['real_name'] . "</td>";
        echo "<td nowrap>" . $subject['user_type'] . "</td>";
        echo "<td nowrap>" . $subject['user_email'] . "</td>";
        echo "<td nowrap>" . $page_ref_by_id . "</td>";
    echo "</tr>";  
}   
                                   
?>
    </table>    

  
 </div>
    
</div>  <!-- edit user -->    
    
    
    
    
    
<script>
function myFunction(id) {
    var x = document.getElementById(id);
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else {
        x.className = x.className.replace(" w3-show", "");
    }
}
</script> 
    
    
<?PHP include_layout_template('footer.php'); ?>     