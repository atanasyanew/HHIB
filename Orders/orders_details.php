<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

<?php
    //GENERAL STUFF
    $orders = new Orders();
    $subject = $orders->find_row_by_id($_GET['order_id']); 
    if (!$orders->affected_rows()==1){
        redirect_to('orders_overview.php');    
    
    } else {  
    
    //info for page generate
    $orders->id=$_GET['order_id'];  
    $getAllRevs = $orders->find_all_revs( $subject['number'] );  
    $countRevs =  $orders->num_rows( $getAllRevs )-1;  
    $orders->find_last_rev( $subject['number'] );
        
    $orders->findPreRev($subject['number'], $subject['rev']);
    $preRev = $orders->fetchPreRev; 
        
    //QR  
    $host= gethostname();
    $ip = gethostbyname($host);
    $urlOfThisPage = "http://".$ip.$_SERVER['REQUEST_URI']; 
    $QRcode = "<img src=\"https://chart.googleapis.com/chart?chf=bg,s,ffffff&amp;cht=qr&amp;chs=70x70&amp;chl=".$urlOfThisPage."&amp;chld=|0\" alt=\"QR code\">";
        
    //refs for menus
    $page_ref_edit = "orders_form_ico.php?order_id={$subject['id']}&page_process=editOrder";
    $page_ref_rev = "orders_form_ico.php?order_id={$subject['id']}&page_process=createRevision";     
 
    //mail stuff    
    $user = new User();   
    //define some email additional information    
    $newTextLine = "%0D%0A";
    $subjectIco = " " . $subject['number'] . " Rev. " . $subject['rev'];
    $bodyIco  = "Order Number: " . $subject['number'] . " Rev. " . $subject['rev'] . $newTextLine;
    $bodyIco .= "Date Created: " . $subject['create_date'] . $newTextLine;
    $bodyIco .= "Prepared by: " . $subject['ico_preparedby'] . $newTextLine;
    $bodyIco .= "More Info: " . $urlOfThisPage . $newTextLine;        
    //Main email 
    $ordersMainEmailFile = $user->ordersMainEmailFile;
    $ordersMainEmail = $user->checkAndReturnMainMailFile ($ordersMainEmailFile);
    $ordersMainEmailTest = $user->sendMailOutlook($ordersMainEmailFile, (int)0, $subjectIco, $bodyIco);     
    //approve emails    
    $ordersApproveEmailFile = $user->ordersApproveEmailFile;       
    $ordersApproveEmailArray = $user->checkAndReturnApproveOrdersFile ($ordersApproveEmailFile);  
        
        
}

    //FILE MANAGER define dirs
    $file = new FileManagement();
    //define dirs
    $file->specify_dirs('ORDERS', $subject['number'], $subject['rev']);
    $file->check_dir(); //make dir
    $dirArray = $file->get_files_array(); //loop files

    //FILE MANAGER production orders
    $filePO = new FileManagement();
    //define dirs
    $POfolderName = $subject['number']."-ProductionOrder";
    $filePO->specify_dirsPO('ORDERS', $subject['number'], $POfolderName);
    $filePO->check_dir(); //make dir
    $dirArrayPO = $filePO->get_files_array(); //loop files
    if (isset($_GET['deleteFilePO']) && 
        isset($_GET['deleteFileChkPO']) && 
        $_GET['deleteFilePO'] == $_GET['deleteFileChkPO'] ) {

      if ($filePO->delete_file($_GET['deleteFilePO'])) {
                $deleteMsg = "изтри (ПП): " . $_GET['deleteFilePO'];
                $orders->update_history($deleteMsg);
                redirect_to("orders_details.php?order_id={$orders->id}");  
      }
        
     } elseif ( isset($_GET['deleteFilePO']) ) {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте потвърдили заявката (Файлове Производствена Поръчка)!</h3>";
    $checkbocMsg .= "</div>"; 
        
    } //DELETE FILE
    if (isset($_POST['fileUploadSubmitPO'])) { 
        
          if ($filePO->attach_file($_FILES['fileToUploadPO1'])) {  
                 $deleteMsg = "качи (ПП): " . $filePO->filename;
                 $filePO->save_file();
                 $orders->update_history($deleteMsg); 
                }
          if ($filePO->attach_file($_FILES['fileToUploadPO2'])) {  
                 $deleteMsg = "качи (ПП): " . $filePO->filename;
                 $filePO->save_file();
                 $orders->update_history($deleteMsg); 
                }
          redirect_to("orders_details.php?order_id={$orders->id}");   

    } else {
    $messageError = join("<br />", $filePO->errors);
    echo $messageError;
    } //UPLOAD FILES


    //FILE MANAGER OTHER orders
    $fileOthers = new FileManagement();
    //define dirs
    $OthersfolderName = $subject['number']."-Others";
    $fileOthers->specify_dirsPO('ORDERS', $subject['number'], $OthersfolderName);
    $fileOthers->check_dir(); //make dir
    $dirArrayOthers = $fileOthers->get_files_array(); //loop files
    if (isset($_GET['deleteFileOthers']) && 
        isset($_GET['deleteFileChkOthers']) && 
        $_GET['deleteFileOthers'] == $_GET['deleteFileChkOthers'] ) {

      if ($fileOthers->delete_file($_GET['deleteFileOthers'])) {
                $deleteMsg = "изтри (Други): " . $_GET['deleteFileOthers'];
                $orders->update_history($deleteMsg);
                redirect_to("orders_details.php?order_id={$orders->id}");  
      }
     } elseif ( isset($_GET['deleteFileOthers']) ) {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте потвърдили заявката (Други Файлове)!</h3>";
    $checkbocMsg .= "</div>"; 
        
    } //DELETE FILE
    if (isset($_POST['fileUploadSubmitOthers'])) { 
        
          if ($fileOthers->attach_file($_FILES['fileToUploadOthers1'])) {  
                 $deleteMsg = "качи (Други): " . $fileOthers->filename;
                 $fileOthers->save_file();
                 $orders->update_history($deleteMsg); 
                }
          if ($fileOthers->attach_file($_FILES['fileToUploadOthers2'])) {  
                 $deleteMsg = "качи (Други): " . $fileOthers->filename;
                 $fileOthers->save_file();
                 $orders->update_history($deleteMsg); 
                }
          redirect_to("orders_details.php?order_id={$orders->id}");   

    } else {
    $messageError = join("<br />", $fileOthers->errors);
    echo $messageError;
    } //UPLOAD FILES

    //DELETE AND CREATE REV PROCESS  
    if (isset($_POST['submit_delete']) && isset($_POST['checkbox_delete']) ) {
       if ($orders->delete()){
        $path =  FILES_DB . DS . $file->upload_dir;
        $file->destroy($path);
        redirect_to('orders_overview.php');
        }
} //delete process    
    if (isset($_POST['submit_rev'])) {
        if ( $orders->create_revision() ){ 
            $orders->find_last_rev( $subject['number'] );
            redirect_to('orders_details.php?order_id='.$orders->lastRevId);
        }
} //create rev process
   
    if (isset($_GET['deleteFile']) && 
        isset($_GET['deleteFileChk']) && 
        $_GET['deleteFile'] == $_GET['deleteFileChk'] ) {

                if ($file->delete_file($_GET['deleteFile'])) {
                $deleteMsg = "изтри: (ВФП): " . $_GET['deleteFile'];
                $orders->update_history($deleteMsg);
                redirect_to("orders_details.php?order_id={$orders->id}");  
                } 
        
     } elseif ( isset($_GET['deleteFile']) ) {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте потвърдили заявката (Файлове ВФП и други)!</h3>";
    $checkbocMsg .= "</div>"; 
        
    } //DELETE FILE

    if (isset($_POST['fileUploadSubmit'])) { 
        
          if ($file->attach_file($_FILES['fileToUpload1'])) {  
                 $deleteMsg = "качи: (ВФП): " . $file->filename;
                 $file->save_file();
                 $orders->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload2'])) {  
                 $deleteMsg = "качи: (ВФП): " . $file->filename;
                 $file->save_file();
                 $orders->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload3'])) {  
                 $deleteMsg = "качи: (ВФП): " . $file->filename;
                 $file->save_file();
                 $orders->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload4'])) {  
                 $deleteMsg = "качи: (ВФП): " . $file->filename;
                 $file->save_file();
                 $orders->update_history($deleteMsg); 
                }
          if ($file->attach_file($_FILES['fileToUpload5'])) {  
                 $deleteMsg = "качи: (ВФП): " . $file->filename;
                 $file->save_file();
                 $orders->update_history($deleteMsg); 
                }
     
          redirect_to("orders_details.php?order_id={$orders->id}");   

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
            $orders->updateAprroveField($_GET['approveKey']); 
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
    $lockPPOnApproveStatus = $ss->lockButtonAccordingStatus($arrayApprove[4]['approveStatus']);
    $lockPPOnApproveStatus .= $ss->lockButtonAccordingStatus($arrayApprove[5]['approveStatus']);
    $lockPPOnApproveStatus .= $ss->lockButtonAccordingStatus($arrayApprove[6]['approveStatus']);

    //echo "status rdy:".$lockPPOnApproveStatus;
    //echo "<pre>";    
    //print_r($arrayApprove);     
    //echo "</pre>";  
    
    //INSERT COMMENT
    if (isset($_GET['sbmComment']) && !$_GET['comment'] == "") {
        $orders->updateComment($_GET['comment']);
        //redirect_to("orders_details.php?order_id={$orders->id}"); 
    } elseif (isset($_GET['sbmComment']) && $_GET['comment'] == "") {
        
    $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
    $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
    $checkbocMsg .= "<h3>Не сте въвели коментар!</h3>";
    $checkbocMsg .= "</div>";   
          
    }

?>

<div class="w3-border w3-margin">
<div class="w3-container w3-teal">
<h2> ВФП № <?php echo $subject['number']." REV.".$subject['rev'];?></h2>
</div> <!-- HEADER -->
<div class="w3-container w3-teal"> 
<FORM METHOD='POST' action=''>  
    
<ul class="w3-navbar w3-teal">  
  
<li><a class='w3-btn w3-teal<?php echo $ss->userPermissions('1010'); ?>' 
    href="<?php echo $ordersMainEmailTest; ?>"target="_top"><i class="fa fa-envelope-o" aria-hidden="true"></i> Изпрати</a></li>
    
<li><a class='w3-btn w3-teal<?php echo $ss->userPermissions('1010') . $ss->lockButtonAccordingStatus($arrayApprove[1]['approveStatus']); ?>' href="<?php echo $page_ref_edit; ?>">Редактирай</a></li>
    
<li><a class='w3-btn w3-teal <?php echo $ss->userPermissions('1100'); ?>' href="<?php echo $page_ref_rev; ?>">Създай ревизия</a></li>    
        
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
</div> <!-- MAIN MENU -->
<div class="w3-container w3-teal">
<ul class="w3-navbar w3-teal">  
<?php //find all revissions and generate REV menu.     
    while($revs_fetch = $orders->fetch_assoc($getAllRevs)) {  
             
        $page_ref_by_id  = "<li><a class='w3-btn w3-teal'"; 
        $page_ref_by_id .= "href='orders_details.php?order_id={$revs_fetch['id']}'>";
        $page_ref_by_id .= "REV.{$revs_fetch['rev']}</a></li>";        
        print $page_ref_by_id;  
        
}   
        $printCountRevs  = "<li class='w3-right'>";
        $printCountRevs .= "<a  class='w3-btn w3-teal'>";
        $printCountRevs .="Брой рев. : " . $countRevs . "</a></li>";
        print $printCountRevs;      
?>    
</ul>  
</div> <!-- REVISION MENU -->  
</div> <!-- HEADER && MENU --> 
<?php if (isset($checkbocMsg)){echo $checkbocMsg;} //error msg if !checkbox ?> 
    
<div id="printableArea" class="w3-row-padding w3-margin">      
         
<div class="w3-container w3-border w3-teal">
<h6>ВЪТРЕШНО-ФИРМЕНА ПОРЪЧКА <button class="w3-btn w3-teal w3-right" onclick="printDiv('printableArea')"><i class="fa fa-print" aria-hidden="true"></i></button></h6>  
</div>
    
<div class="w3-section">
<table class="w3-table w3-hoverable w3-bordered w3-border">   
<?php         
print "<tr>";  
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Номер</b><br><i>Number</i>" . "</td>";
print "<td class=''>" . $subject['number']  . " Rev." . $subject['rev'] . "<div class='w3-right'>" . $QRcode . "</div>". "</td>";
print "</tr>";

print "<tr>";    
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Относно:</b><br><i>Subject:</i>" . "</td>";        
print "<td  class=\"{$orders->applyRevColor($subject['ico_subject'], $preRev['ico_subject'])}\">";
print nl2br($subject['ico_subject']) . "</td>";  
print "</tr>";   
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Дата на създаване</b><br><i>Date Created</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['create_date'], $preRev['create_date'])}\">";
print $subject['create_date'] . "</td>";    
print "</tr>";     
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Изработена от</b><br><i>Prepared by</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_preparedby'], $preRev['ico_preparedby'])}\">";
print $subject['ico_preparedby'] . "</td>";    
print "</tr>";    
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Клиент, държава</b><br><i>Client, country</i></i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_client'], $preRev['ico_client'])}\">";
print $subject['ico_client'] . " " . $subject['ico_clientcountry'] . "</td>";    
print "</tr>";   
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Краен клиент, Държава</b><br><i>End user, country</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_enduser'], $preRev['ico_enduser'])}\">";
print $subject['ico_enduser'] . " " . $subject['ico_endusercountry'] . "</td>";    
print "</tr>";     
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Стойност на поръчката</b><br><i>Order amount</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_amount'], $preRev['ico_amount'])}\">";
print $subject['ico_amount'] . " " . $subject['ico_amountcurrency'] . "</td>";    
print "</tr>";      
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Описание-Количество</b><br><i>Scope of supply</i>" . "</td>";
            $scopeOfSupply = unserialize($subject['ico_scopeofsupply']);
            $scopeOfSupplyCount = count($scopeOfSupply); 
            $scopeOfSupplyPreRev = unserialize($preRev['ico_scopeofsupply']);    

            print "<td class=\"{$orders->applyRevColor($scopeOfSupply, $scopeOfSupplyPreRev)}\">"; 
            print "<table class=\"w3-table w3-small\">";
 
         for ($row = 0; $row < $scopeOfSupplyCount; $row++) {
            echo "<tr>";
            echo "<td class=\"w3-left-align\" width=\"10%\">";
            echo "Поз. " .$scopeOfSupply[$row]['sos01'] . ". ";   
            echo "</td>";                                   
            echo "<td class=\"w3-left-align\" width=\"65%\">";
            echo $scopeOfSupply[$row]['sos05'] . " ";                                                      
            echo $scopeOfSupply[$row]['sos06'] . " ";                                                     
            echo $scopeOfSupply[$row]['sos07'] . " ";                            
            echo $scopeOfSupply[$row]['sos08'] . " ";                            
            echo $scopeOfSupply[$row]['sos09'] . " ";                                                                  
            echo $scopeOfSupply[$row]['sos10'] . " ";                              
            echo $scopeOfSupply[$row]['sos11'] . " ";                                                     
            echo $scopeOfSupply[$row]['sos12'] . "<br> ";                              
            echo $scopeOfSupply[$row]['sos13'] . " ";                                                       
            echo $scopeOfSupply[$row]['sos14'] . " ";                           
            echo $scopeOfSupply[$row]['sos15'] . "<br> ";                                                       
            echo $scopeOfSupply[$row]['sos16'] . "";  
            echo "</td>";                         
            echo "<td class=\"w3-left-align\" width=\"25%\">";           
            echo "<b><h9>Кол: " . $scopeOfSupply[$row]['sos02'] . " к-т </b></h9> x ";
            echo "" . $scopeOfSupply[$row]['sos03'] . " " . $subject['ico_amountcurrency'] . "/бр. <br>";   
            echo "Експедиция: ". $scopeOfSupply[$row]['sos04'] . " <br>";  
            echo "</td>";                                              
            echo "</tr>";
        }    
            print "</table>";     
print  "</td>";   
print "</tr>";     
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Изпитания</b><br><i>Factory tests</i>"  . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_factorytests'], $preRev['ico_factorytests'])}\">";
print nl2br($subject['ico_factorytests']) . "</td>";    
print "</tr>";    
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" ."<b>Условия на доставка</b><br><i>Delivery terms</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_deliveryterms'], $preRev['ico_deliveryterms'])}\">";
print nl2br($subject['ico_deliveryterms']) . "</td>";    
print "</tr>";         
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Вид на превоза</b><br><i>Means of transport</i>". "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_meansoftransport'], $preRev['ico_meansoftransport'])}\">";
print nl2br($subject['ico_meansoftransport']) . "</td>";    
print "</tr>";          
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Гранционен срок</b><br><i>Warranty period</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_warrantyperiod'], $preRev['ico_warrantyperiod'])}\">";
print $subject['ico_warrantyperiod'] ." Months" . "</td>";    
print "</tr>";         
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Приложения</b><br><i>Attachments</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_attachments'], $preRev['ico_attachments'])}\">";
print nl2br($subject['ico_attachments']) . "</td>";    
print "</tr>";     
        
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">"  . "<b>Забележки</b><br><i>Notes</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_notes'], $preRev['ico_notes'])}\">";
print nl2br($subject['ico_notes']) . "</td>";    
print "</tr>";     
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Експедиционни документи</b><br><i>Shipping documents</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_shippingdocuments'], $preRev['ico_shippingdocuments'])}\">";
print nl2br($subject['ico_shippingdocuments']) . "</td>";    
print "</tr>";     
    
print "<tr>";      
print "<td class=\"w3-right-align\" width=\"20%\">" . "<b>Начин на плащане</b><br><i>Payment way</i>" . "</td>";
print "<td class=\"{$orders->applyRevColor($subject['ico_paymentway'], $preRev['ico_paymentway'])}\">";
print nl2br($subject['ico_paymentway']) . "</td>";    
print "</tr>";      
?>  
</table>              
</div>
      
</div> <!-- ORDER PAGE --> 

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
          <th>Изпълнил, дата</th> 
          <th>Коментар</th>
          <th><i class="fa fa-envelope-o" aria-hidden="true"></i></th>
          <th class="<?php echo $chkDeletePos ?>"><i class="fa fa-ban" aria-hidden="true"></i></th>  
          <th class="<?php echo $chkUnlock ?>"><i class="fa fa-unlock" aria-hidden="true"></i></th>
        </tr>
    </thead>  
<?php  
             
$newTextLine = "%0D%0A";
$approveEmailSubject = " " . $subject['number'] . " Rev. " . $subject['rev'];
$approveEmailBody = "Order Number: " . $subject['number'] . " Rev. " . $subject['rev'] . $newTextLine;
$approveEmailBody .= "Date Created: " . $subject['create_date'] . $newTextLine;
$approveEmailBody .= "Prepared by: " . $subject['ico_preparedby'] . $newTextLine;
$approveEmailBody .= "More Info: " . $urlOfThisPage . $newTextLine;            
     
for ($row = 0; $row < count($arrayApprove); $row++) {      
    
//mail stuff   
$ApproveEmail = $user->sendMailOutlook($ordersApproveEmailFile, $row, $approveEmailSubject, $approveEmailBody); 
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
if ($row==2 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") or 
    $row==3 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") or 
    $row==4 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") or 
    $row==5 and ($arrayApprove[$row]['stageTitle']<>"ПРЕМАХНАТ ЕТАП") ) {
            
        echo "<td class=\"{$chkDeletePos}\">";   
        echo "<input class=\"w3-check-small\" type=\"checkbox\" name=\"chkDeletePossition\" value=\"{$row}\">";
        echo "<i class=\"fa fa-ban\" aria-hidden=\"true\"></i>";
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
         if (isset($approveButtonText2)) {echo $approveButtonText2;}; ?>
</p>
    
<p>
<input type="hidden" name="order_id" value="<?php echo $subject['id'];?>">
<input type="hidden" name="approveKey" value="<?php echo $approveKey;?>">
</p> 
    
<p>
<input type="text" class="w3-input w3-border" name="textApprove" placeholder="Въведи коментар, ако е необходимо">
</p> 
    
<p>
<input type="submit" class="btn btn-default" name="btnApprove" value="Запиши"> 
</p>
 
    
    
    
</div>
    
</div>
    
    
    
</form>
</div><!-- APPROVE -->

<div class="w3-row-padding w3-margin">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-teal"> 
<h6>Файлове ВФП и други, <?php echo $subject['number']."-REV.".$subject['rev']?> 
<a class="w3-right" target="_blank"
   href="<?php echo "http://".$ip.DS.$file->dbFolder.DS.$file->upload_dir.DS;?>">  
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
<form method="get" action="orders_details.php"> 
<p class="w3-hide"><input type="hidden" name="order_id" value="<?php echo $orders->id;?>"</p>    
<?php
 // loop through the array of files and print them all
$indexCount	= count($dirArray);
for($index=0; $index < $indexCount; $index++) {
    if (substr("$dirArray[$index]", 0, 1) != ".") {  // don't list hidden files
        
$file_name = str_replace(" ", "%20",$file->downloadUrl.$dirArray[$index]);
$fileDate = (date("Y/m/d h:i ", filemtime($file->full_dir.$dirArray[$index])));     
$file_size = $file->size_as_text($file->full_dir.$dirArray[$index]);  
        
        
// $ss->userPermissions('1001').$ss->lockButtonAccordingStatus($arrayApprove[1]['approveStatus'])             
//$deleteFile = "<a class=\"".$ss->userPermissions('1001');
//$deleteFile .= $ss->lockButtonAccordingStatus($arrayApprove[1]['approveStatus']);
//$deleteFile .= "\" href='orders_details.php?order_id={$orders->id}&deleteFile={$dirArray[$index]}' ><i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"> Delete</i></a>";
 
$deleteFile = "<div class=\"form-inline ".$ss->userPermissions('1001');
$deleteFile .= $ss->lockButtonAccordingStatus($arrayApprove[1]['approveStatus']) . "\">";    
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
<div class="w3-third <?php print $ss->userPermissions('1110').$ss->lockButtonAccordingStatus($arrayApprove[1]['approveStatus']) ?>">
<div class="w3-container w3-border w3-teal"><h6>Качване на файлове</h6></div>
  
<div class="w3-section">      
<form class="w3-container w3-padding w3-border w3-small" 
      method="POST" 
      action="orders_details.php?order_id=<?php print $subject['id'];?>"
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
</div><!-- FILES ICO -->
  
<div class="w3-row-padding w3-margin">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-brown">
       
<h6>Файлове Производствена Поръчка, <?php echo $subject['number']?>   
<a class="w3-right" target="_blank"
   href="<?php echo "http://".$ip.DS.$filePO->dbFolder.DS.$filePO->upload_dir.DS;?>">  
<i class="fa fa-folder-o" aria-hidden="true"></i>
</a></h6>
      
</div> 
<div class="w3-section"> 
    
<table class="w3-table-all w3-hoverable w3-small">
    <thead>
      <tr class="w3-light-grey">
        <th>Име на файла</th>
        <th>Размер на файла</th>
        <th>Последна промяна</th>
        <th>Действие</th> 
      </tr>
    </thead> 
<form method="get" action="orders_details.php"> 
<p class="w3-hide"><input type="hidden" name="order_id" value="<?php echo $orders->id;?>"</p>      
<?php
 // loop through the array of files and print them all
$indexCountPO	= count($dirArrayPO);
for($indexPO=0; $indexPO < $indexCountPO; $indexPO++) {
    if (substr("$dirArrayPO[$indexPO]", 0, 1) != ".") {  // don't list hidden files
        
$file_namePO = str_replace(" ", "%20",$filePO->downloadUrl.$dirArrayPO[$indexPO]);
$fileDatePO = (date("Y/m/d h:i ", filemtime($filePO->full_dir.$dirArrayPO[$indexPO])));     
$file_sizePO = $filePO->size_as_text($filePO->full_dir.$dirArrayPO[$indexPO]);      

//$deleteFilePO = "<a class=\"" . $ss->userPermissions('1001') . $lockPPOnApproveStatus;
//$deleteFilePO .= "\" href='orders_details.php?order_id={$orders->id}&deleteFilePO={$dirArrayPO[$indexPO]}' ><i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"> Delete</i></a>";
  
$deleteFilePO = "<div class=\"form-inline ".$ss->userPermissions('1001');
$deleteFilePO .= $lockPPOnApproveStatus . "\">";    
$deleteFilePO .= "<div class=\"checkbox\">";
$deleteFilePO .= "<input type=\"checkbox\" "; 
$deleteFilePO .= "name=\"deleteFileChkPO\" value=\"{$dirArrayPO[$indexPO]}\">";
$deleteFilePO .= "</div>";
$deleteFilePO .= "<button type=\"submit\" class=\"btn btn-default btn-xs w3-right\" ";
$deleteFilePO .= "name=\"deleteFilePO\" value=\"{$dirArrayPO[$indexPO]}\">";
$deleteFilePO .= "<i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"></i></button>";     
$deleteFilePO .= "</div>";    
        
print "<tr>";        
print "<td><a href=\"{$file_namePO}\" download>{$dirArrayPO[$indexPO]}</a></td>";      
print "<td>" . $file_sizePO . "</td>";  
print "<td>" . $fileDatePO . "</td>";             
print "<td>" . $deleteFilePO . "</td>";      
print "</tr>";
	}
}   

?>    
</form>        
</table>
</div>     
</div> <!-- files table -->
<div class="w3-third <?php print $ss->userPermissions('1110') . $lockPPOnApproveStatus; ?>">
<div class="w3-container w3-border w3-brown"><h6>Качване на файлове</h6></div>
  
<div class="w3-section">      
<form class="w3-container w3-padding w3-border w3-small" 
      method="POST" 
      action="orders_details.php?order_id=<?php print $subject['id'];?>"
      enctype="multipart/form-data">
            
    <input type="hidden" name="MAX_FILE_SIZE" value="150000000">                   
                  
    <p><input type="file" class="" name="fileToUploadPO1"></p>
    <p><input type="file" class="" name="fileToUploadPO2"></p>                     
  
<p> max 150mb/file
    <button type="submit"  name="fileUploadSubmitPO" class="w3-right">
<i class="fa fa-upload fa-2x" aria-hidden="true"></i></button></p>                 
</form>   
</div>  
</div> <!-- files upload --> 
</div><!-- FILES PO-->

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
<form method="get" action="orders_details.php"> 
<p class="w3-hide"><input type="hidden" name="order_id" value="<?php echo $orders->id;?>"</p>       
<?php
 // loop through the array of files and print them all
$indexCountOthers	= count($dirArrayOthers);
for($indexOthers=0; $indexOthers < $indexCountOthers; $indexOthers++) {
    if (substr("$dirArrayOthers[$indexOthers]", 0, 1) != ".") {  // don't list hidden files
        
$file_nameOthers = str_replace(" ", "%20",$fileOthers->downloadUrl.$dirArrayOthers[$indexOthers]);
$fileDateOthers = (date("Y/m/d h:i ", filemtime($fileOthers->full_dir.$dirArrayOthers[$indexOthers])));     
$file_sizeOthers = $fileOthers->size_as_text($fileOthers->full_dir.$dirArrayOthers[$indexOthers]);  
       
//$deleteFileOthers = "<a class=\"{$ss->userPermissions('1001')}\" href='orders_details.php?order_id={$orders->id}&";
//$deleteFileOthers .= "deleteFileOthers={$dirArrayOthers[$indexOthers]}'>";
//$deleteFileOthers .= "<i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"> Delete</i></a>";

$deleteFileOthers = "<div class=\"form-inline ".$ss->userPermissions('1001');
$deleteFileOthers .= "\">";    
$deleteFileOthers .= "<div class=\"checkbox\">";
$deleteFileOthers .= "<input type=\"checkbox\" "; 
$deleteFileOthers .= "name=\"deleteFileChkOthers\" value=\"{$dirArrayOthers[$indexOthers]}\">";
$deleteFileOthers .= "</div>";
$deleteFileOthers .= "<button type=\"submit\" class=\"btn btn-default btn-xs w3-right\" ";
$deleteFileOthers .= "name=\"deleteFileOthers\" value=\"{$dirArrayOthers[$indexOthers]}\">";
$deleteFileOthers .= "<i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"></i></button>";     
$deleteFileOthers .= "</div>";         
        
echo "<tr>";        
echo "<td><a href=\"{$file_nameOthers}\" download>{$dirArrayOthers[$indexOthers]}</a></td>";      
echo "<td>" . $file_sizeOthers . "</td>";  
echo "<td>" . $fileDateOthers . "</td>";             
echo "<td>" . $deleteFileOthers . "</td>";      
echo "</tr>";
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
      action="orders_details.php?order_id=<?php echo $subject['id'];?>"
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
</div><!-- FILES OTHERS-->

<div class="w3-row-padding w3-margin">    
<div class="w3-half">
                <div class="w3-container w3-teal">
                    <h6>История на действията</h6>
                </div>
                <div class="w3-section w3-border">
                <ul class="w3-ul w3-margin w3-small"><?php echo nl2br($subject['history']); ?></ul> 
                </div>      
</div>  <!-- history --> 
    
<div class="w3-half">
                <div class="w3-container w3-teal">
                <h6>Коментари</h6>
                </div>
    
<div class="w3-section w3-border <?php echo $ss->userPermissions('0111');?>">   
<form class="w3-container w3-margin" method="GET" action="">   
<input type="hidden" name="order_id" value="<?php echo $subject['id'];?>">
    
<p><textarea rows="2" placeholder="Въведи коментар..." name="comment" class="w3-input w3-border-0"></textarea></p>   
<p><input class="btn btn-default w3-right" value="Запиши" name="sbmComment" type="submit"></p>
    
</form>
</div> 
    
    
<div class="w3-section w3-border">
<ul class="w3-ul w3-small w3-margin"><?php echo nl2br($subject['comment']); ?></ul> 
</div>  
    
  
            
</div>   <!-- comments -->      
</div>  <!-- HISTORY && COMMENT PAGE -->   

<script>
function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>

<?PHP include_layout_template('footer.php'); ?>     