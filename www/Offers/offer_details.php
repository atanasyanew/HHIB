<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>
<?php  //GENERAL STUFF FOR PAGE
    $offers = new Offers();
    $subject = $offers->find_row_by_id($_GET['subjectId']); 

    if (!$offers->affected_rows()==1){
        redirect_to('offers_overview.php');    
    } else {    
        
    $offers->id=$_GET['subjectId']; 
    $getAllRevs = $offers->find_all_revs( $subject['number'] ); 
    $countRevs =  $offers->num_rows( $getAllRevs )-1; 
    $offers->find_last_rev( $subject['number'] ); 
    //QR    
    $host= gethostname();
    $ip = gethostbyname($host);
    $urlOfThisPage = "http://".$ip.$_SERVER['REQUEST_URI']; 
    $QRcode = "<img src=\"https://chart.googleapis.com/chart?chf=bg,s,ffffff&amp;cht=qr&amp;chs=120x120&amp;chl=".$urlOfThisPage."&amp;chld=|0\" alt=\"QR code\">";
    //REF FOR MENU    
   
    $page_ref_rev = "offers_form_edit.php?subjectId={$subject['id']}&pageProcess=createRevision";       
        
    //mail stuff    
    $user = new User();   
    //define some email additional information    
    $newTextLine = "%0D%0A";
    $subjectText = " " . $subject['number'] . " Rev. " . $subject['rev'];
    $bodyText  = "Offer Number: " . $subject['number'] . " Rev. " . $subject['rev'] . $newTextLine;
    $bodyText .= "Date Created: " . $subject['create_date'] . $newTextLine;
    $bodyText .= "Prepared by: " . $subject['create_by'] . $newTextLine;
    $bodyText .= "More Info: " . $urlOfThisPage . $newTextLine;        
    //Main email 
    $offersMainEmailFile = $user->offersMainEmailFile;
    $offersMainEmail = $user->checkAndReturnMainMailFile ($offersMainEmailFile);
    $offersMainEmailTest = $user->sendMailOutlook($offersMainEmailFile, (int)0, $subjectText, $bodyText);     
    //approve emails    
    $offersApproveEmailFile = $user->offersApproveEmailFile;       
    $offersApproveEmailArray = $user->checkAndReturnApproveOffersFile ($offersApproveEmailFile);     
        
    //FILE MANAGER define dirs
    $file = new FileManagement();
    //define dirs
    $file->specify_dirs('OFFERS', $subject['number'], $subject['rev']);
    $file->check_dir(); //make dir
    $dirArray = $file->get_files_array(); //loop files    
        
} //CHECK
  
    if (isset($_POST['submit_delete']) && isset($_POST['checkbox_delete']) ) {
    if ($offers->delete()){
    $path =  FILES_DB . DS . $file->upload_dir;
    $file->destroy($path);    
    redirect_to('offers_overview.php');
    }
} //delete process

    if (isset($_GET['deleteFile']) && 
        isset($_GET['deleteFileChk']) && 
        $_GET['deleteFile'] == $_GET['deleteFileChk'] ) {

      if ($file->delete_file($_GET['deleteFile'])) {
                $deleteMsg = "изтри: " . $_GET['deleteFile'];
                $offers->update_history($deleteMsg);
                redirect_to("offer_details.php?subjectId={$offers->id}");  
      }
     } elseif ( isset($_GET['deleteFile']) ) {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте потвърдили заявката (Файлове)!</h3>";
    $checkbocMsg .= "</div>"; 
        
    } //DELETE FILE

    if (isset($_POST['fileUploadSubmit'])) { 
        
          if ($file->attach_file($_FILES['fileToUpload1'])) {  
                 $deleteMsg = "качи: " . $file->filename;
                 $file->save_file();
                 $offers->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload2'])) {  
                 $deleteMsg = "качи: " . $file->filename;
                 $file->save_file();
                 $offers->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload3'])) {  
                 $deleteMsg = "качи: " . $file->filename;
                 $file->save_file();
                 $offers->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload4'])) {  
                 $deleteMsg = "качи: " . $file->filename;
                 $file->save_file();
                 $offers->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload5'])) {  
                 $deleteMsg = "качи: " . $file->filename;
                 $file->save_file();
                 $offers->update_history($deleteMsg); 
                }
     
          redirect_to("offer_details.php?subjectId={$offers->id}");   
        
    //$messageError = join("<br />", $file->errors);
    //echo $messageError;
        
    } else {
    $messageError = join("<br />", $file->errors);
    echo $messageError;
    } //UPLOAD FILES

    //APPROVE SECTION 
    if ( isset($_GET['btnApprove']) ) {
        
        if (isset($_GET['chkApprove']) or 
            isset($_GET['chkCancel']) or
            isset($_GET['chkUnlock']) or
            isset($_GET['chkDeletePossition']) ) {
            
            //echo "approved";
            $offers->updateAprroveField($_GET['approveKey']); 
        } else {
            
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте потвърдили заявката!</h3>";
    $checkbocMsg .= "</div>";     
            
        }
    }

    //PREPARE APPROVE TABLE, Loop through approve cell to get key
    $arrayApprove = unserialize($subject['approve']); 
    $approveKey = (int)0;
    while ( $arrayApprove[$approveKey]['approveStatus'] == 'Одобрена' or
            $arrayApprove[$approveKey]['approveStatus'] == 'Изработена') {
        if ($approveKey == (int)count($arrayApprove)-1) { break; } //prevent errors.
        $approveKey++;
    }

    //form display stuff
    if ($arrayApprove[$approveKey]['approveStatus'] == "За Изработване" ) {
        
    $approveButtonText = "<div class=\"{$ss->userPermissions('0111')}\"><input type=\"checkbox\" name=\"chkApprove\" value=\"chkApprove\"> ";    
    $approveButtonText .= "<b>Потвърди: </b> \"Изработена\" ";
    $approveButtonText .= "<b>На Етап: </b>" . $arrayApprove[$approveKey]['stageNumber'] . ". ";
    $approveButtonText .= $arrayApprove[$approveKey]['stageTitle'];
    $approveButtonText .= " <b>Изпълнил: </b>" . $_SESSION['real_name'] . "</div>";   
        
   } 
    elseif ($arrayApprove[$approveKey]['approveStatus'] == "За Одобрение" xor
            $arrayApprove[$approveKey]['approveStatus'] == "Отказано Одобрение") {
        
    $approveButtonText  = "<div class=\"{$ss->userPermissions('1000')}\"><input type=\"checkbox\" name=\"chkApprove\" value=\"chkApprove\"> ";   
    $approveButtonText .= "<b>Потвърди: </b> \"Одобрена\" ";
    $approveButtonText .= "<b>На Етап: </b>" . $arrayApprove[$approveKey]['stageNumber'] . ". ";
    $approveButtonText .= $arrayApprove[$approveKey]['stageTitle'];
    $approveButtonText .= " <b>Изпълнил: </b>" . $_SESSION['real_name'] . "</div>"; 
     
    $approveButtonText2  = "<div class=\"{$ss->userPermissions('1000')}\"><input type=\"checkbox\" name=\"chkCancel\" value=\"chkCancel\"> ";    
    $approveButtonText2 .= "<b>Oткажи потвърждаването на Етап: </b> ";
    $approveButtonText2 .= $arrayApprove[$approveKey]['stageNumber'] . ". ";
    $approveButtonText2 .= $arrayApprove[$approveKey]['stageTitle'];
    $approveButtonText2 .= " <b>Отказал: </b>" . $_SESSION['real_name'] . "</div>";     
          
    } else {
       
    $approveButtonText  = "<b>ВСИЧКИ ЕТАПИ СА ОДОБРЕНИ.</b>";
       
   }
     
    //hide buttons and stuff according to status
    $lockFilesOnApproveStatus = $ss->lockButtonAccordingStatus($arrayApprove[2]['approveStatus']);
    $lockFilesOnApproveStatus .= $ss->lockButtonAccordingStatus($arrayApprove[3]['approveStatus']);
    $lockFilesOnApproveStatus .= $ss->lockButtonAccordingStatus($arrayApprove[4]['approveStatus']);

    //echo "status rdy:".$lockPPOnApproveStatus;
    //echo "<pre>";    
    //print_r($arrayApprove);     
    //echo "</pre>";  

    //INSERT COMMENT
    if (isset($_GET['sbmComment']) && !$_GET['comment'] == "") {
        $offers->updateComment($_GET['comment']);

    } elseif (isset($_GET['sbmComment']) && $_GET['comment'] == "") {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте въвели коментар!</h3>";
    $checkbocMsg .= "</div>";      
    }

    //FILE MANAGER OTHER offers
    $fileOthers = new FileManagement();
    //define dirs
    $OthersfolderName = $subject['number']."-Others";
    $fileOthers->specify_dirsPO('OFFERS', $subject['number'], $OthersfolderName);
    $fileOthers->check_dir(); //make dir
    $dirArrayOthers = $fileOthers->get_files_array(); //loop files

    if (isset($_GET['deleteFileOthers']) && 
        isset($_GET['deleteFileOthersChk']) && 
        $_GET['deleteFileOthers'] == $_GET['deleteFileOthersChk'] ) {

            if ($fileOthers->delete_file($_GET['deleteFileOthers'])) {
                      $deleteMsg = "изтри (Други): " . $_GET['deleteFileOthers'];
                      $offers->update_history($deleteMsg);
                      redirect_to("offer_details.php?subjectId={$offers->id}");
            } 
        
     } elseif ( isset($_GET['deleteFileOthers']) ) {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте потвърдили заявката (Други Файлове)!</h3>";
    $checkbocMsg .= "</div>"; 
        
    }//DELETE FILE

    if (isset($_POST['fileUploadSubmitOthers'])) { 
        
          if ($fileOthers->attach_file($_FILES['fileToUploadOthers1'])) {  
                 $deleteMsg = "качи (Други): " . $fileOthers->filename;
                 $fileOthers->save_file();
                 $offers->update_history($deleteMsg); 
                }
          if ($fileOthers->attach_file($_FILES['fileToUploadOthers2'])) {  
                 $deleteMsg = "качи (Други): " . $fileOthers->filename;
                 $fileOthers->save_file();
                 $offers->update_history($deleteMsg); 
                }
          redirect_to("offer_details.php?subjectId={$offers->id}");   

    } else {
    $messageError = join("<br />", $fileOthers->errors);
    echo $messageError;
    } //UPLOAD FILES
?> 

<div class="w3-border w3-margin">
    

<div class="w3-container w3-teal">
<h2> ОФЕРТА № <?php echo $subject['number']." REV.".$subject['rev'];?></h2>
</div>
   
<div class="w3-container w3-teal"> 
<FORM METHOD='POST' action=''>  
    
<ul class="w3-navbar w3-teal">   
  
<li><a class='w3-btn w3-teal <?php echo $ss->userPermissions('1100'); ?>' 
       href="<?php echo $offersMainEmailTest; ?>"target="_top"><i class="fa fa-envelope-o" aria-hidden="true"></i> Изпрати</a></li>

    
<li><a class='w3-btn w3-teal<?php echo $ss->userPermissions('1100'); ?>' href="<?php echo $page_ref_rev; ?>">Създай ревизия</a></li>    
       
<li class='w3-right<?php print $ss->userPermissions('1001'); ?>'><INPUT class='w3-btn w3-teal' 
                                 type='Submit' 
                                 name='submit_delete'  
                                 VALUE='Изтрии'></li>   
        
<li class='w3-right<?php print $ss->userPermissions('1001'); ?>'><INPUT class='w3-check' 
                                type='checkbox' 
                                name='checkbox_delete' 
                                value='<?php echo $subject['id'];?>'>
                                <?php echo "Rev." . $subject['rev'];?></li> 
    
</ul> 
</FORM>   
</div>    
 
<!-- REVISION MENU -->
<div class="w3-container w3-teal">
<ul class="w3-navbar w3-teal">  
<?php //find all revissions and generate REV menu. 
    
    while($revs_fetch = $offers->fetch_assoc($getAllRevs)) {  
             
        $page_ref_by_id  = "<li><a class='w3-btn w3-teal'"; 
        $page_ref_by_id .= "href='offer_details.php?subjectId={$revs_fetch['id']}'>";
        $page_ref_by_id .= "REV.{$revs_fetch['rev']}</a></li>";        
        print $page_ref_by_id;  
        
}   
        $printCountRevs  = "<li class='w3-right'>";
        $printCountRevs .= "<a  class='w3-btn w3-teal'>";
        $printCountRevs .="Брой рев. : " . $countRevs . "</a></li>";
        print $printCountRevs;      
?>    
</ul>  
</div>
    
</div> <!-- HEADER & MENU -->  
<?php if (isset($checkbocMsg)){echo $checkbocMsg;} //error msg if !checkbox ?> 
  
<div class="w3-row-padding w3-margin">    
<div class="w3-twothird"> 
         
<div class="w3-container w3-border w3-teal">
                    <h6>Обща информация за Офертата</h6>
</div>
           
<div class="w3-section">
<table class="w3-table w3-hoverable w3-bordered w3-border">     
<?php 
//print "<table class=\"w3-table w3-hoverable w3-border\"";
print "<tr>";  
print "<td class=\"w3-right-align\" width=\"25%\">" . "<b>Номер</b><br><i>Number</i>" . "</td>";
print "<td>" . $subject['number'] . " Rev." . $subject['rev'] . "</td>";
print "</tr>"; 
 
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"25%\">" . "<b/>Дата на създаване</b><br><i>Date Created</i>" . "</td>";
print "<td>" . $subject['create_date'] . "</td>";    
print "</tr>";     
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"25%\">" . "<b>Създадена от</b><br><i>Created by</i>" . "</td>";
print "<td>" . $subject['create_by'] . "</td>";    
print "</tr>";
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"25%\">" . "<b>Завършена на:</b><br><i>Approved Date</i>" . "</td>";
    
if ( $arrayApprove[4]['approveStatus'] == "Одобрена" ) {
     $approvedDate = $arrayApprove[4]['approvedDate']; 
} else {$approvedDate = "";};
print "<td>" . $approvedDate . "</td>";    
print "</tr>";    

print "</table>"; 

?>  
</div>                

</div>    <!-- OFFER PAGE -->
<div class="w3-third"> 
<div class="w3-container w3-teal"> 
                     <h6>Други</h6>    
</div>
                <div class="w3-section w3-border">
                <ul><?php echo  $QRcode; ?></ul> 
                </div>
    
</div>   <!-- OTHERS PAGE -->
</div> <!-- MAIN PAGE --> 
     
<div class="w3-row-padding w3-margin">  
<div class="w3-container w3-border w3-teal"><h6>Етапи на одобрение</h6></div>
    
<form class="" method="GET" action="">    
<div class="w3-section">
<?php
//apply permissions    
$chkUnlock = $ss->userPermissions('1000'); // make unlock checkbox only for admins  
$chkDeletePos = $ss->userPermissions('1000');   
?>    
<table class="w3-table w3-border w3-hoverable w3-small">
    <thead>
        <tr class="w3-light-grey">
          <th>Статутс</th>  
          <th>№</th>
          <th>Етап</th>    
          <th>Изпълнил</th>
          <th>Дата</th> 
          <th>Коментар</th>
          <th><i class="fa fa-envelope-o" aria-hidden="true"></i></th>
          <th class="<?php echo $chkDeletePos ?>"><i class="fa fa-ban" aria-hidden="true"></i></th>  
          <th class="<?php echo $chkUnlock ?>"><i class="fa fa-unlock" aria-hidden="true"></i></th>
        </tr>
    </thead>  
<?php  
 
$newTextLine = "%0D%0A";
$approveEmailSubject = " " . $subject['number'] . " Rev. " . $subject['rev'];
$approveEmailBody = "Offer Number: " . $subject['number'] . " Rev. " . $subject['rev'] . $newTextLine;
$approveEmailBody .= "Date Created: " . $subject['create_date'] . $newTextLine;
$approveEmailBody .= "Created by: " . $subject['create_by'] . $newTextLine;
$approveEmailBody .= "More Info: " . $urlOfThisPage . $newTextLine;       
    
    
    
for ($row = 0; $row < count($arrayApprove); $row++) {   
    
//mail stuff   
$ApproveEmail = $user->sendMailOutlook($offersApproveEmailFile, $row, $approveEmailSubject, $approveEmailBody); 
$sendApproveEmail = "<p class=\"\"><a href=\"{$ApproveEmail}\" target=\"_top\">";
$sendApproveEmail .=  "<i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i></a></p>";       
    
    echo "<tr class=\"". approveColor($arrayApprove[$row]['approveStatus']) . "\">";  
        echo "<td><b>" . $arrayApprove[$row]['approveStatus'] . "</b></td>";
        echo "<td>"    . $arrayApprove[$row]['stageNumber'] . "</td>";
        echo "<td>"    . $arrayApprove[$row]['stageTitle'] . "</td>";
        echo "<td>"    . $arrayApprove[$row]['approvedBy'] . "</td>";
        echo "<td>"    . $arrayApprove[$row]['approvedDate'] . "</td>";
        echo "<td>"    . $arrayApprove[$row]['approveComment'] . "</td>";

//EMAILS <TD>    
if ($arrayApprove[$row]['approveStatus'] == "Одобрена" or $arrayApprove[$row]['approveStatus'] == "Изработена") {
        echo "<td>"    . $sendApproveEmail . "</td>";
} else { 
        echo "<td>"  . "<i class=\"fa fa-envelope-o\" aria-hidden=\"true\"></i>" . "</td>";}
    
 //DELETE POS <TD>   
if ($row==0 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") or 
    $row==1 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") or 
    $row==2 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") or
    $row==3 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") ) {
        
        echo "<td class=\"{$chkDeletePos}\">";            
        echo "<input class=\"w3-check-small\" type=\"checkbox\" name=\"chkDeletePossition\" value=\"{$row}\"> ";
        echo "<i class=\"fa fa-ban\" aria-hidden=\"true\">";
        echo "</td>";    
} else { 
        echo "<td class=\"{$chkDeletePos}\">"  . "" . "</td>";} 
        
    
        echo "<td class=\"{$chkUnlock}\">";
        echo "<input class=\"w3-check-small\" type=\"checkbox\" name=\"chkUnlock\" value=\"{$row}\"> ";
        echo "<i class=\"fa fa-unlock\" aria-hidden=\"true\">";
        echo "</td>";  
    echo "</tr>";
} 
?>   
</table></div> <!-- approve table including form elements -->
    
<div class="w3-section w3-border"> 
    
<div class="w3-margin w3-small"> 
    
<p><?php echo $approveButtonText; 
         echo "<br>"; 
        if (isset($approveButtonText2)) {echo $approveButtonText2;} ?>
</p>
    
<p>
<input type="hidden" name="subjectId" value="<?php echo $subject['id'];?>">
<input type="hidden" name="approveKey" value="<?php echo $approveKey;?>">
</p> 
           
<p>
<input type="text" class="w3-input w3-border" name="textApprove" placeholder="Въведи коментар, ако е необходимо">
</p>
    
<p>
        <input type="submit" name="btnApprove" class="btn btn-default" value="Запиши"> 
</p>
    
</div>
    
</div>
        
</form>
</div> <!-- APPROVE -->     

<div class="w3-row-padding w3-margin">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-teal">
  
<h6>Файлове, <?php echo $subject['number']."-REV.".$subject['rev']?>
    
<a class="w3-right" target="_blank"
   href="<?php echo "http://".$ip.DS.$file->dbFolder.DS.$file->upload_dir.DS;?>">  
<i class="fa fa-folder-o" aria-hidden="true"></i>
    </a></h6>
    
</div> 
    
<div class="w3-section"> 
    
<table class="w3-table-all w3-hoverable w3-small">
    <thead>
      <tr class="w3-dark-grey">
        <th>Име на файла</th>
        <th>Размер на файла</th>
        <th>Последна промяна </th>
        <th>Действие</th> 
      </tr>
    </thead>  
<form method="get" action="offer_details.php" > 
<p class="w3-hide"><input type="hidden" name="subjectId" value="<?php echo $offers->id;?>"</p>
<?php
 // loop through the array of files and print them all
$indexCount	= count($dirArray);
for($index=0; $index < $indexCount; $index++) {
    if (substr("$dirArray[$index]", 0, 1) != ".") {  // don't list hidden files
        
$file_name = str_replace(" ", "%20",$file->downloadUrl.$dirArray[$index]);
$fileDate = (date("Y/m/d h:i ", filemtime($file->full_dir.$dirArray[$index])));     
$file_size = $file->size_as_text($file->full_dir.$dirArray[$index]); 
          
$deleteFile = "<div class=\"form-inline ".$ss->userPermissions('1001') . $lockFilesOnApproveStatus . "\">";    
$deleteFile .= "<div class=\"checkbox\">";
$deleteFile .= "<input type=\"checkbox\" "; 
$deleteFile .= "name=\"deleteFileChk\" value=\"{$dirArray[$index]}\">";
$deleteFile .= "</div>";
$deleteFile .= "<button type=\"submit\" class=\"btn btn-default btn-xs w3-right\" ";
$deleteFile .= "name=\"deleteFile\" value=\"{$dirArray[$index]}\">";
$deleteFile .= "<i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"></i></button>";     
$deleteFile .= "</div>";        
            
print "<tr>";        
print "<td><a href=\"{$file_name}\" download>{$dirArray[$index]}</a></td>";      
print "<td>" . $file_size . "</td>";  
print "<td>" . $fileDate . "</td>";             
print "<td>" . $deleteFile . "</td>";      
print "</tr>";
	}
}   

?>    
</form>        
</table>
</div>     
</div> <!-- files table -->

<div class="w3-third <?php print $ss->userPermissions('1110').$lockFilesOnApproveStatus; ?>">
    
<div class="w3-container w3-border w3-teal"><h6>Качване на файлове</h6></div>
  
<div class="w3-section">      
<form class="w3-container w3-padding w3-border w3-small" 
      method="POST" 
      action="offer_details.php?subjectId=<?php print $subject['id'];?>"
      enctype="multipart/form-data">
            
    <input type="hidden" name="MAX_FILE_SIZE" value="150000000">                   
                  
    <p><input type="file" class="" name="fileToUpload1"></p>
    <p><input type="file" class="" name="fileToUpload2"></p>               
    <p><input type="file" class="" name="fileToUpload3"></p>   
    <p><input type="file" class="" name="fileToUpload4"></p>
    <p><input type="file" class="" name="fileToUpload5"></p>         
  
<p> max 150mb/file
<button type="submit"  name="fileUploadSubmit" class="w3-right">
<i class="fa fa-upload fa-2x" aria-hidden="true"></i></button></p>                 
</form>   
</div>  
</div> <!-- files upload -->
    
</div> <!-- FILES -->
    
<div class="w3-row-padding w3-margin">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-brown">
       
<h6>Други Файлове, <?php echo $subject['number']?>   
<a class="w3-right" target="_blank"
   href="<?php echo "http://".$ip.DS.$fileOthers->dbFolder.DS.$fileOthers->upload_dir.DS;?>">  
<i class="fa fa-folder-o" aria-hidden="true"></i>
</a></h6>
      
</div> 
<div class="w3-section"> 

    
<table class="w3-table-all w3-hoverable w3-small">
    <thead>
      <tr class="w3-light-grey">
        <th>Име на файла</th>
        <th>Размер на файла</th>
        <th>Последна промяна </th>
        <th>Действие</th> 
      </tr>
    </thead>  
     
<form method="get" action="offer_details.php" > 
<p class="w3-hide"><input type="hidden" name="subjectId" value="<?php echo $offers->id;?>"</p>
 
    
<?php
 // loop through the array of files and print them all
$indexCountOthers	= count($dirArrayOthers);
for($indexOthers=0; $indexOthers < $indexCountOthers; $indexOthers++) {
    if (substr("$dirArrayOthers[$indexOthers]", 0, 1) != ".") {  // don't list hidden files
        
$file_nameOthers = str_replace(" ", "%20",$fileOthers->downloadUrl.$dirArrayOthers[$indexOthers]);
$fileDateOthers = (date("Y/m/d h:i ", filemtime($fileOthers->full_dir.$dirArrayOthers[$indexOthers])));     
$file_sizeOthers = $fileOthers->size_as_text($fileOthers->full_dir.$dirArrayOthers[$indexOthers]);  

$deleteFileOthers = "<div class=\"form-inline {$ss->userPermissions('1001')}\">";    
$deleteFileOthers .= "<div class=\"checkbox\">";
$deleteFileOthers .= "<input type=\"checkbox\" "; 
$deleteFileOthers .= "name=\"deleteFileOthersChk\" value=\"{$dirArrayOthers[$indexOthers]}\">";
$deleteFileOthers .= "</div>";
$deleteFileOthers .= "<button type=\"submit\" class=\"btn btn-default btn-xs w3-right\" ";
$deleteFileOthers .= "name=\"deleteFileOthers\" value=\"{$dirArrayOthers[$indexOthers]}\">";
$deleteFileOthers .= "<i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"></i></button>";     
$deleteFileOthers .= "</div>";          

print "<tr>";        
print "<td><a href=\"{$file_nameOthers}\" download>{$dirArrayOthers[$indexOthers]}</a></td>";      
print "<td>" . $file_sizeOthers . "</td>";  
print "<td>" . $fileDateOthers . "</td>";             
print "<td> " . $deleteFileOthers . "</td>";        
print "</tr>";
	}
}   

?>    
</form>         
</table>
</div>     
</div> <!-- files table -->
<div class="w3-third <?php echo $ss->userPermissions('1110')  ?>">
<div class="w3-container w3-border w3-brown"><h6>Качване на файлове</h6></div>
  
<div class="w3-section">      
<form class="w3-container w3-padding w3-border w3-small" 
      method="POST" 
      action="offer_details.php?subjectId=<?php echo $subject['id'];?>"
      enctype="multipart/form-data">
            
    <input type="hidden" name="MAX_FILE_SIZE" value="150000000">                   
                  
    <p><input type="file" class="" name="fileToUploadOthers1"></p>
    <p><input type="file" class="" name="fileToUploadOthers2"></p>                     
  
<p> max 150mb/file
    <button type="submit"  name="fileUploadSubmitOthers" class="w3-right">
<i class="fa fa-upload fa-2x" aria-hidden="true"></i></button></p>                 
</form>   
</div>  
</div> <!-- files upload --> 
</div> <!-- FILES OTHERS-->   
    
<div class="w3-row-padding w3-margin">    
<div class="w3-half">
                <div class="w3-container w3-teal">
                    <h6>История на действията</h6>
                </div>
    
                 <div class="w3-section w3-border">
                    <ul class="w3-ul w3-margin w3-ul w3-small"><?php echo nl2br($subject['history']); ?></ul> 
                </div>      
</div>  
<div class="w3-half">
                <div class="w3-container w3-teal">
                <h6>Коментари</h6>
                </div>
    
<div class="w3-section w3-border <?php echo $ss->userPermissions('0111');?>">    
<form class="w3-container w3-margin" method="GET" action="">   
<input type="hidden" name="subjectId" value="<?php echo $subject['id'];?>">
   
<p><textarea rows="2" placeholder="Въведи коментар..." name="comment" class="w3-input w3-border-0"></textarea></p>   
<p><input class="btn btn-default w3-right" value="Запиши" name="sbmComment" type="submit"></p>
    
</form>
</div>     
    
<div class="w3-section w3-border">
    <ul class="w3-ul w3-margin w3-ul w3-small"><?php echo nl2br($subject['comment']); ?></ul> 
</div>   
    
</div>        
</div> <!-- HISTORY AND COMMENT PAGE -->    
       
 

<?PHP include_layout_template('footer.php'); ?>     
     
     
     

     