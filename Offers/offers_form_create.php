<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

<?php //CANCEL BUTTON, REDIRECT TO BACK
if (isset($_GET['submit_cancel'])) {
    $pref = "offers_overview.php";
    redirect_to($pref); 
}  
?>

<div class="w3-border w3-margin w3-center">
 
<div class="w3-container w3-teal">
<h2> СЪЗДАВАНЕ НА ОФЕРТА</h2>
</div>
     
</div>   <!-- HEADER --> 

<?php  
if (isset($_GET['submit_form']) && isset($_GET['checkbox_confirm'])){
$createOffer = new Offers();  
     
if (!$createOffer->check_for_number($_GET['number'])==0) {   
$createOffer->find_last_rev( $_GET['number'] );  
$revLink = 'offer_details.php?subjectId='.$createOffer->lastRevId;   
print "<div class=\"w3-panel w3-margin w3-red\">";
print "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
print "<h3>Съществуваща оферта!</h3>";
print "<p>Линк към Оферта № <a href=\"".$revLink."\">".$_GET['number']."</a></p>";
print "</div>";   
}
 else {
     session_history_msg("създадена");
     $createOffer->create_record();
      }     
    
}
?>
    
<div class="w3-border w3-margin">               
        
<FORM class="form-horizontal" METHOD='GET' ACTION=''>
    
<div class="w3-hide">  
<p>Всичко в този div е скрито </p>      
<input type="hidden" name="rev" value="0">       
</div>
     
<br>
     
<div class="form-group">
    <label class="col-sm-3 control-label">Номер<br>Number</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               placeholder='XX-XX-XXX'
               name="number"
               MAXLENGTH='15'
               required
               value=""></div>
        
        <div class="col-sm-1">
        <input class="form-control" 
               type="text" 
               name=""
               disabled
               value="Rev. 0"></div>  
</div>                 
      
<div class="form-group">
    <label class="col-sm-3 control-label">Дата на създаване<br>Create date</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="date" 
               name="create_date"
               value="<?php echo strftime('%Y-%m-%d')?>"></div>
    
        <div class="col-sm-2">
        <input class="form-control" 
               type="time" 
               name="create_time"
               value="<?php echo strftime('%H:%M')?>"></div> 
</div>         
      
<div class="form-group">
    <label class="col-sm-3 control-label">Създадена от<br>Create by</label>
        <div class="col-sm-7">
        <input class="form-control" 
               type="text" 
               name="create_by"
               value="<?php echo $_SESSION['real_name'];?>"></div>
</div>  
      
<div class="form-group">
    <label class="col-sm-3 control-label">Коментар<br>Comment</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  placeholder="Коментара е за служебно ползване"
                  name="comment"></textarea></div>
</div>   
  
<br>     
    
<div class="w3-container w3-border w3-center w3-teal">
<h6>
    <a class='w3-btn w3-teal' href="/HHIB/Offers/offers_overview.php" >Откажи</a> 
    <INPUT class='w3-check' 
                            type='checkbox' 
                            name='checkbox_confirm' 
                            value=''>
    <label>Потвърди</label>

    <INPUT class='w3-btn w3-teal' 
                            type='Submit' 
                            name='submit_form'
                            VALUE='Запиши'>          
    </h6>  
</div> 
      
</FORM>   
</div> <!-- form --> 

<?PHP include_layout_template('footer.php'); ?>