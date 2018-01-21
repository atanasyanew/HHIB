<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

  
<?php  
    //GENERAL STUFF FOR PAGE
    $editOffer = new Offers();
    $subject = $editOffer->find_row_by_id($_GET['subjectId']); 
    if (!$editOffer->affected_rows()==1){
        redirect_to('offers_overview.php');
    } else {        
    $editOffer->id=$_GET['subjectId'];
    }

    if (isset($_GET['submitCancel'])) {
        $pref = "offer_details.php?subjectId=".$_GET['subjectId'];
        redirect_to($pref); 
    } //CANCEL

    //UPDATE OFFER - for del
    /*
    if ($_GET['pageProcess']=="editSubject") {
    $titleMsg =  "Редактиране " .$subject['number']." REV.".$subject['rev']; 
    $page_process = $_GET['pageProcess'];    
    $rev = $subject['rev'];   
    $cr_date = (substr($subject['create_date'], 0, 10));
    $cr_time = (substr($subject['create_date'], 11, 5));   
         
    $sendBy = (empty($subject['send_by'])) ? $_SESSION['real_name'] : $subject['send_by'];
    $sendTo = (empty($subject['send_to'])) ? "ТД" : $subject['send_to'];
        
    if ($subject['send_date']==''){
       $date_send = strftime('%Y-%m-%d');
       $time_send = strftime('%H:%M');
    } else {   
    $date_send = (substr($subject['send_date'], 0, 10));
    $time_send = (substr($subject['send_date'], 11, 5)); 
    }    
    // SUBMIT
    if ( (isset($_GET['submitForm'])) && 
               ($_GET['checkboxConfirm'] == $_GET['subjectId']) &&
               ($_GET['pageProcess'] == "editSubject") ) {

        $hmsg = "Редактиране на ". $subject['number'] ." Rev." . $rev;
        session_history_msg($hmsg);
        //print_r($_SESSION); 
        $editOffer->update_offer_details();                   
}     
    } //UPDATE
    */

    if ($_GET['pageProcess']=="createRevision") {

        $titleMsg =  "Създаване ревизия на оферта № " . $subject['number']." на база на "." REV. ".$subject['rev'];
    
        $page_process = $_GET['pageProcess'];
    
        $editOffer->find_last_rev( $subject['number'] );  
    
        $rev = $editOffer->get_revision_value();  
    
        $cr_date = strftime('%Y-%m-%d'); 
    
        $cr_time = strftime('%H:%M');

        $date_send ="";
        
        $time_send ="";
        
        $sendBy = "";
        
        $sendTo = "";
        //SUBMIT REVISION
        if ( (isset($_GET['submitForm'])) && 
               ($_GET['checkboxConfirm']==$_GET['subjectId']) &&
               ($_GET['pageProcess']=="createRevision") ) {

            $hmsg = "създадена Rev.". $rev . " на база инфо. от Rev.". $subject['rev'];

            session_history_msg($hmsg);

            $editOffer->create_record();   

    }         
                      
} //CREATE REVISION PAGE STUFF
?>
  
<div class="w3-border w3-margin">
<div class="w3-container w3-border w3-center w3-teal">
  <h2><?php echo $titleMsg;?></h2>
</div>  <!-- Header -->                   
<FORM class="form-horizontal" METHOD='GET' ACTION=''> 
<div class="w3-hide">  
<p>Всичко в този div е скрито </p>    
<input type="hidden" name="subjectId" value="<?php print $subject['id'];?>">
<input type="hidden" name="pageProcess" value="<?php print $page_process ?>">
<input type="hidden" name="number" value="<?php print $subject['number'];?>">
<input type="hidden" name="rev" value="<?php print $rev;?>">
<input type="hidden" name="create_date" value="<?php print $cr_date;?>">    
<input type="hidden" name="create_time" value="<?php print $cr_time;?>">     
</div> <br>
     
<div class="form-group">
    <label class="col-sm-3 control-label">Номер<br>Number</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               disabled
               placeholder='XX-XX-XXX'
               name="number"
               value="<?php print $subject['number'];?>"></div>
        
        <div class="col-sm-1">
        <input class="form-control" 
               type="text" 
               name=""
               disabled
               value="Rev. "></div>
     
    
        <div class="col-sm-1">   
        <input class="form-control" 
               type="text" 
               name="rev"
               disabled
               value="<?php print $rev;?>"></div>
</div>           
      
<div class="form-group">
    <label class="col-sm-3 control-label">Дата на създаване<br>Create date</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="date" 
            <?php if ($_GET['pageProcess']!="createRevision"){print "disabled";} ?>  
               name="create_date"
               value="<?php print $cr_date;?>"></div>
    
    <div class="col-sm-2">
        <input class="form-control" 
               type="time" 
             <?php if ($_GET['pageProcess']!="createRevision"){print "disabled";} ?> 
               name="create_time"
               value="<?php print $cr_time;?>"></div>
    
    
    
</div>         
      
<div class="form-group">
    <label class="col-sm-3 control-label">Създадена от<br>Create by</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
           <?php if ($_GET['pageProcess']!="createRevision"){print "disabled";} ?>
               name="create_by"
               value="<?php print $subject['create_by'];?>"></div>
</div>  

      
<div class="form-group">
    <label class="col-sm-3 control-label">Коментар<br>Comment</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  placeholder="Коментара е за служебно ползване"
                  name="comment"></textarea></div>
</div>  <br>    
    
<div class="w3-container w3-border w3-center w3-teal">
<h6>

<INPUT class='w3-btn w3-teal' 
               type='Submit' 
               name='submitCancel' 
               value='Откажи'>
       
<INPUT class='w3-check' 
                        type='checkbox' 
                        name='checkboxConfirm' 
                        value='<?php echo $subject['id'];?>'>
<label>Потвърди</label>
    

<INPUT class='w3-btn w3-teal' 
                        type='Submit' 
                        name='submitForm'
                        VALUE='Запиши'>     
        
</h6>  
</div> 
    
</FORM>   <!-- form -->    
</div>    
       
<?PHP include_layout_template('footer.php'); ?> 