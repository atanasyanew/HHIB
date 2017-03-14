<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

  
<?php
    $icoForm = new Orders();
    $subject = $icoForm->find_row_by_id($_GET['order_id']);  

    if (!$icoForm->affected_rows()==1){
        redirect_to('orders_overview.php');
    } else {        
    $icoForm->id=$_GET['order_id'];
    } //CHECK
    
    if (isset($_GET['submit_cancel'])) {
        $pref = "orders_details.php?order_id=".$_GET['order_id'];
        redirect_to($pref); 
    } //CANCEL BUTTON

    if ($_GET['page_process']=="createRevision") {
    $titleMsg =  "Създаване ревизия ВФП №" .$subject['number']." на база на "." REV. ".$subject['rev'];
    $page_process = $_GET['page_process'];
    $icoForm->find_last_rev( $subject['number'] );  
    $rev = $icoForm->get_revision_value();     
    $cr_date = strftime('%Y-%m-%d');
    $cr_time = strftime('%H:%M');

    //SUBMIT
    if ( (isset($_GET['submit_form'])) && 
               (!isset($_GET['checkbox_confirm'])) &&
               ($_GET['page_process']=="createRevision") )  {
      
   $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
   $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
   $checkbocMsg .= "<h3>Не сте потвърдили заявката!</h3>";
   $checkbocMsg .= "</div>";  
                   
    } elseif ( (isset($_GET['submit_form'])) && 
               ($_GET['checkbox_confirm']==$_GET['order_id']) &&
               ($_GET['page_process']=="createRevision") ) {

        $hmsg = "създадена Rev.". $rev . " на база инфо. от Rev.". $subject['rev'];
        session_history_msg($hmsg);
        $icoForm->create_order();                 
    }
        
    } //CREATE REVISION

    if ($_GET['page_process']=="editOrder") {

    $titleMsg =  "Редактиране ВФП №" .$subject['number']." REV.".$subject['rev'];
    $page_process = $_GET['page_process'];  
    $rev = $subject['rev'];  

    $dateTime = $subject['create_date']; 
    $cr_date = substr($dateTime, 0, 10);    
    $cr_time = substr($dateTime, 11, 5);
        
    //SUBMIT 
    if ( (isset($_GET['submit_form'])) && 
               (!isset($_GET['checkbox_confirm'])) &&
               ($_GET['page_process']=="editOrder") )  {
      
   $checkbocMsg  = "<div class=\"w3-panel w3-margin w3-red\">";
   $checkbocMsg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
   $checkbocMsg .= "<h3>Не сте потвърдили заявката!</h3>";
   $checkbocMsg .= "</div>";      
        
    }
        
        
    elseif ( (isset($_GET['submit_form'])) && 
               ($_GET['checkbox_confirm']==$_GET['order_id']) &&
               ($_GET['page_process']=="editOrder") ) {

         $hmsg = "Редактиране на ВФП ". $subject['number'] ." Rev." . $rev;
         session_history_msg($hmsg);
         //print_r($_SESSION); 
         $icoForm->update_order();                 
    } 


    } //UPDATE ORDER
?>


<div class="w3-border w3-margin w3-center w3-container w3-teal">
  <h2><?php echo $titleMsg;?></h2>
</div>  <!-- HEADER -->    

<?php if (isset($checkbocMsg)){echo $checkbocMsg;} //error msg if !checkbox ?> 


<div class="w3-border w3-margin">   <!-- FORM -->
<FORM class="form-horizontal" METHOD='GET' ACTION=''>
    
<div class="w3-hide">  
<p>Всичко в този div е скрито </p>    
<input type="hidden" name="order_id" value="<?php print $subject['id'];?>">
<input type="hidden" name="page_process" value="<?php print $page_process ?>">
<input type="hidden" name="number" value="<?php print $subject['number'];?>">
<input type="hidden" name="rev" value="<?php print $rev;?>"> 
   
    
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
</div>  <!-- Number -->         
      
<div class="form-group">
    <label class="col-sm-3 control-label">Относно<br>Subject</label>
        <div class="col-sm-7">
        <textarea class="form-control"
                  placeholder='Производство на...'
                  name="ico_subject"><?php print $subject['ico_subject'];?></textarea></div>
</div>  <!-- subject -->         
      
<div class="form-group">
    <label class="col-sm-3 control-label">Дата на създаване<br>Create date</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="date" 
               name="create_date"
               value="<?php echo $cr_date;?>"></div>
    
        <div class="col-sm-2">
        <input class="form-control" 
               type="time" 
               name="create_time"
               value="<?php echo $cr_time;?>"></div> 
</div>  <!-- cr date -->      
      
<div class="form-group">
    <label class="col-sm-3 control-label">Изработена от<br>Prepared by</label>
        <div class="col-sm-7">
        <input class="form-control" 
               type="text" 
               name="ico_preparedby"
               value="<?php print $subject['ico_preparedby'];?>"></div>
</div>  <!-- Prepared by -->
    
<div class="form-group">
    <label class="col-sm-3 control-label">Клиент, държава<br>Client, country</label>
        <div class="col-sm-5">
        <input class="form-control" 
               type="text" 
               name="ico_client"
               placeholder='Клиент'
               value="<?php echo $subject['ico_client'];?>"></div>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name="ico_clientcountry"
               placeholder='Държава'
               value="<?php print $subject['ico_clientcountry'];?>"></div>
</div>  <!-- Client, country -->       
      
<div class="form-group">
    <label class="col-sm-3 control-label">Краен клиент, Държава<br>End user, country</label>
    
        <div class="col-sm-5">
        <input class="form-control" 
               type="text" 
               name="ico_enduser"
               placeholder='Клиент'
               value="<?php echo $subject['ico_enduser'];?>"></div>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name="ico_endusercountry"
               placeholder='Държава'
               value="<?php print $subject['ico_endusercountry'];?>"></div>
</div>  <!-- End user, country -->  
      
<div class="form-group">
    <label class="col-sm-3 control-label">Стойност на поръчката<br>Order amount</label>

       <div class="col-sm-2">
       <select class="form-control"
               name="ico_amountcurrency">
           <option selected value="<?php echo $subject['ico_amountcurrency'];?>"><?php echo $subject['ico_amountcurrency']." (current value)";?></option>
                      <option value="EUR">EUR</option>
                      <option value="BGN">BGN</option>
                      <option value="USD">USD</option></select></div>
</div>  <!-- Order amount --> 
    
<div class="form-group">
<label class="col-sm-3 control-label">Описание-Количество<br>Scope of supply</label>
    
<div class="col-sm-9"> 
    <div class="w3-border" id="dynamic_field">
        <div>  
     
<?php    
$scopeOfSupply = unserialize($subject['ico_scopeofsupply']);
$scopePosCount = count($scopeOfSupply);  
       
if($scopePosCount > 0) {   

// OBSHTI     
print "<table class=\"w3-table w3-small\">"; 
print "<tr>";
print "<td width=\"10%\"><label class=\"w3-text-grey w3-small\">Позиция</label>";
print "<input type=\"text\"name=\"sos01[]\"class=\"w3-input w3-border w3-round\" placeholder=\"Поз.\" maxlength=\"4\"";
print "value=\"{$scopeOfSupply[0]['sos01']}\"></td>"; 
        
print "<td width=\"10%\"><label class=\"w3-text-grey w3-small\">бр.</label>";
print "<input type=\"text\" name=\"sos02[]\" class=\"w3-input w3-border w3-round\" placeholder=\"бр. к-ти\" maxlength=\"4\"";  
print "value=\"{$scopeOfSupply[0]['sos02']}\"></td>"; 
         
print "<td width=\"20%\"><label class=\"w3-text-grey w3-small\">Цена за бр.</label>";
print "<input type=\"number\" name=\"sos03[]\" class=\"w3-input w3-border w3-round\""; 
print "value=\"{$scopeOfSupply[0]['sos03']}\"></td>";
     
print "<td width=\"20%\"><label class=\"w3-text-grey w3-small\">Срок на доставка</label>";
print "<input class=\"form-control\" type=\"date\" name=\"sos04[]\"";
print "value=\"{$scopeOfSupply[0]['sos04']}\"></td>";
     
print "<td width=\"\"><label class=\"w3-text-grey w3-small w3-center\">add</label><br>";
print "<button type=\"button\" name=\"add\" id=\"add\" class=\"btn btn-success\">+</button></td>";
print "</tr>";    
print "</table>";  
    
// OLTC   
print "<table class=\"w3-table w3-small\"><caption class=\"w3-margin-left\">Регулатор</caption>";
print "<tr>";
    
print "<td width=\"15%\">";
print "<select id=\"sos05\" name=\"sos05[]\" class=\"form-control\">"; 
print "<option selected value='{$scopeOfSupply[0]['sos05']}'>{$scopeOfSupply[0]['sos05']}</option>";
txtToList('ScopeOfSupplyFormPos2.txt');
print "</select></td>";     
      
print "<td width=\"11%\">";
print "<select id=\"sos06\" name=\"sos06[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos06']}'>{$scopeOfSupply[0]['sos06']}</option>";    
txtToList('ScopeOfSupplyFormPos3.txt');
print "</select></td>";     
 
print "<td width=\"12%\">";
print "<select id=\"sos07\" name=\"sos07[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos07']}'>{$scopeOfSupply[0]['sos07']}</option>";     
txtToList('ScopeOfSupplyFormPos4.txt');
print "</select></td>";   
      
print "<td width=\"15%\">";
print "<select id=\"sos08\" name=\"sos08[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos08']}'>{$scopeOfSupply[0]['sos08']}</option>";    
txtToList('ScopeOfSupplyFormPos5.txt');
print "</select></td>"; 
    
    
print "<td width=\"12%\">";
print "<select id=\"sos09\" name=\"sos09[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos09']}'>{$scopeOfSupply[0]['sos09']}</option>";      
txtToList('ScopeOfSupplyFormPos6.txt');
print "</select></td>";
    
print "<td width=\"10%\">";
print "<select id=\"sos10\" name=\"sos10[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos10']}'>{$scopeOfSupply[0]['sos10']}</option>";       
txtToList('ScopeOfSupplyFormPos7.txt');
print "</select></td>"; 
    
print "<td width=\"12%\">";
print "<select id=\"sos11\" name=\"sos11[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos11']}'>{$scopeOfSupply[0]['sos11']}</option>";     
txtToList('ScopeOfSupplyFormPos8.txt');
print "</select></td>"; 
    
print "<td width=\"20%\">";
print "<select id=\"sos12\" name=\"sos12[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos12']}'>{$scopeOfSupply[0]['sos12']}</option>";  
txtToList('ScopeOfSupplyFormPos9.txt');
print "</select></td>";
    
print "</tr>";
print "</table>";         
    
// MDU
print "<table class=\"w3-table w3-small\"><caption class=\"w3-margin-left\">Задвижване</caption>";   
print "<tr>";
       
print "<td width=\"15%\"><select id=\"sos13\" name=\"sos13[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos13']}'>{$scopeOfSupply[0]['sos13']}</option>";     
txtToList('ScopeOfSupplyFormPos10.txt');
print "</select></td>";
     
print "<td width=\"20%\"><select id=\"sos14\" name=\"sos14[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[0]['sos14']}'>{$scopeOfSupply[0]['sos14']}</option>";     
txtToList('ScopeOfSupplyFormPos11.txt');
print "</select></td>";
    
print "<td width=\"60%\"><textarea name=\"sos15[]\" rows=\"1\" cols=\"50\" class=\"form-control\" type=\"text\" placeholder=\"Мониторингова...\">";
print "{$scopeOfSupply[0]['sos15']}</textarea></td>";    
print "</tr>";
print "</table>";          
  
    
print "<table class=\"w3-table w3-small\"><caption class=\"w3-margin-left\">Друго</caption>";
print "<tr>";
print "<td><textarea name=\"sos16[]\" rows=\"1\" cols=\"50\" class=\"form-control\" type=\"text\" placeholder=\"резервни...\">";
print "{$scopeOfSupply[0]['sos16']}</textarea></td>";    
print "</tr>";
print "</table>";      
    
    
    if($scopePosCount > 1) { 
    
    for ($row = 1; $row < $scopePosCount; $row++) {
                
print "<div id=\"row{$row}\"";
print "<br><br><br>";        
print "<table class=\"w3-table w3-small\">"; 
print "<tr>";
print "<td width=\"10%\"><label class=\"w3-text-grey w3-small\">Позиция</label>";
print "<input type=\"text\"name=\"sos01[]\"class=\"w3-input w3-border w3-round\" placeholder=\"Поз.\" maxlength=\"4\"";
print "value=\"{$scopeOfSupply[$row]['sos01']}\"></td>"; 
        
print "<td width=\"10%\"><label class=\"w3-text-grey w3-small\">бр.</label>";
print "<input type=\"text\" name=\"sos02[]\" class=\"w3-input w3-border w3-round\" placeholder=\"бр. к-ти\" maxlength=\"4\"";  
print "value=\"{$scopeOfSupply[$row]['sos02']}\"></td>"; 
         
print "<td width=\"20%\"><label class=\"w3-text-grey w3-small\">Цена за бр.</label>";
print "<input type=\"number\" name=\"sos03[]\" class=\"w3-input w3-border w3-round\""; 
print "value=\"{$scopeOfSupply[$row]['sos03']}\"></td>";
     
print "<td width=\"20%\"><label class=\"w3-text-grey w3-small\">Срок на доставка</label>";
print "<input class=\"form-control\" type=\"date\" name=\"sos04[]\"";
print "value=\"{$scopeOfSupply[$row]['sos04']}\"></td>";
     
print "<td width=\"\"><label class=\"w3-text-grey w3-small w3-center\">remove</label><br>";
print "<button type=\"button\" name=\"remove\" id=\"{$row}\" class=\"btn btn-danger btn_remove\">X</button></td>";
print "</tr>";    
print "</table>";  
    
// OLTC   
print "<table class=\"w3-table w3-small\"><caption class=\"w3-margin-left\">Регулатор</caption>";
print "<tr>";
    
print "<td width=\"15%\">";
print "<select id=\"sos05copy\" name=\"sos05[]\" class=\"form-control\">"; 
print "<option selected value='{$scopeOfSupply[$row]['sos05']}'>{$scopeOfSupply[$row]['sos05']}</option>";
txtToList('ScopeOfSupplyFormPos2.txt');
print "</select></td>";     
      
print "<td width=\"11%\">";
print "<select id=\"sos06copy\" name=\"sos06[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos06']}'>{$scopeOfSupply[$row]['sos06']}</option>";    
txtToList('ScopeOfSupplyFormPos3.txt');
print "</select></td>";     
 
print "<td width=\"12%\">";
print "<select id=\"sos07copy\" name=\"sos07[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos07']}'>{$scopeOfSupply[$row]['sos07']}</option>";     
txtToList('ScopeOfSupplyFormPos4.txt');
print "</select></td>";   
      
print "<td width=\"15%\">";
print "<select id=\"sos08copy\" name=\"sos08[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos08']}'>{$scopeOfSupply[$row]['sos08']}</option>";    
txtToList('ScopeOfSupplyFormPos5.txt');
print "</select></td>"; 
    
    
print "<td width=\"12%\">";
print "<select id=\"sos09copy\" name=\"sos09[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos09']}'>{$scopeOfSupply[$row]['sos09']}</option>";      
txtToList('ScopeOfSupplyFormPos6.txt');
print "</select></td>";
    
print "<td width=\"10%\">";
print "<select id=\"sos10copy\" name=\"sos10[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos10']}'>{$scopeOfSupply[$row]['sos10']}</option>";       
txtToList('ScopeOfSupplyFormPos7.txt');
print "</select></td>"; 
    
print "<td width=\"12%\">";
print "<select id=\"sos11copy\" name=\"sos11[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos11']}'>{$scopeOfSupply[$row]['sos11']}</option>";     
txtToList('ScopeOfSupplyFormPos8.txt');
print "</select></td>"; 
    
print "<td width=\"20%\">";
print "<select id=\"sos12copy\" name=\"sos12[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos12']}'>{$scopeOfSupply[$row]['sos12']}</option>";  
txtToList('ScopeOfSupplyFormPos9.txt');
print "</select></td>";
    
print "</tr>";
print "</table>";         
    
// MDU
print "<table class=\"w3-table w3-small\"><caption class=\"w3-margin-left\">Задвижване</caption>";   
print "<tr>";
       
print "<td width=\"15%\"><select id=\"sos13copy\" name=\"sos13[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos13']}'>{$scopeOfSupply[$row]['sos13']}</option>";     
txtToList('ScopeOfSupplyFormPos10.txt');
print "</select></td>";
     
print "<td width=\"20%\"><select id=\"sos14copy\" name=\"sos14[]\" class=\"form-control\">";
print "<option selected value='{$scopeOfSupply[$row]['sos14']}'>{$scopeOfSupply[$row]['sos14']}</option>";     
txtToList('ScopeOfSupplyFormPos11.txt');
print "</select></td>";
    
print "<td width=\"60%\"><textarea name=\"sos15[]\" rows=\"1\" cols=\"50\" class=\"form-control\" type=\"text\" placeholder=\"Мониторингова...\">";
print "{$scopeOfSupply[$row]['sos15']}</textarea></td>";    
print "</tr>";
print "</table>";          
  
print "<table class=\"w3-table w3-small\"><caption class=\"w3-margin-left\">Друго</caption>";
print "<tr>";
print "<td><textarea name=\"sos16[]\" rows=\"1\" cols=\"50\" class=\"form-control\" type=\"text\" placeholder=\"резервни...\">";
print "{$scopeOfSupply[$row]['sos16']}</textarea></td>";    
print "</tr>";
print "</table>";
print "</div>";               

    }         
    }
       
 } 
?>       

</div>      
</div>      
</div>   
   <br><br><br> 
</div>  <!-- scope of supply -->  
          
<div class="form-group">
    <label class="col-sm-3 control-label">Изпитания<br>Factory tests</label>
        <div class="col-sm-7">
        <textarea class="form-control"  
          name="ico_factorytests"><?php print $subject['ico_factorytests'];?></textarea></div>
 </div>  <!-- Factory tests -->
          
<div class="form-group">
    <label class="col-sm-3 control-label">Условия на доставка<br>Delivery terms</label>
        <div class="col-sm-7">
        <input class="form-control" 
               type="text" 
               name="ico_deliveryterms"
               PLACEHOLDER='FCA - Sofia'
               value="<?php print $subject['ico_deliveryterms'];?>"></div>
</div>  <!-- Delivery terms -->      

<div class="form-group">
    <label class="col-sm-3 control-label">Вид на превоза<br>Means of transport</label>
        <div class="col-sm-7">
        <input class="form-control" 
               type="text" 
               name="ico_meansoftransport"
               PLACEHOLDER='Автомобилен'
               value="<?php print $subject['ico_meansoftransport'];?>"></div>
</div> <!-- Means of transport -->
      
<div class="form-group">
    <label class="col-sm-3 control-label">Гранционен срок<br>Warranty period</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name="ico_warrantyperiod"
               PLACEHOLDER='36'
               value="<?php print $subject['ico_warrantyperiod'];?>"></div>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name=""
               disabled
               value="Months"></div>
</div> <!-- Warranty period -->     
           
<div class="form-group">
    <label class="col-sm-3 control-label">Приложения<br>Attachments</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  name="ico_attachments"><?php print $subject['ico_attachments'];?></textarea></div>
</div>  <!-- Attachments -->        
      
<div class="form-group">
    <label class="col-sm-3 control-label">Забележки<br>Notes</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  rows="5"
                  name="ico_notes"><?php print $subject['ico_notes'];?></textarea></div>
</div>  <!-- Notes -->        
      
<div class="form-group">
    <label class="col-sm-3 control-label">Експедиционни документи<br>Shipping documents</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  rows="5"
    PLACEHOLDER='1.Фактура&#10;2.Опаковъчен лист&#10;3.Товарителница&#10;Всички документи на език:..' 
      name="ico_shippingdocuments"><?php print $subject['ico_shippingdocuments'];?></textarea></div>
</div>  <!-- Shipping documents-->   
      
<div class="form-group">
    <label class="col-sm-3 control-label">Начин на плащане<br>Payment way</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  PLACEHOLDER='60 дни след експедицията'
                  name="ico_paymentway"><?php print $subject['ico_paymentway'];?></textarea></div>
</div>  <!-- Payment way -->           
      
<div class="form-group">
    <label class="col-sm-3 control-label">Коментар<br>Comment</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  placeholder="Коментара е за служебно ползване"
                  name="comment"></textarea></div>
</div> <!-- Comment -->   
    
<br> 
       
<div class="w3-container w3-border w3-center w3-teal">
<h6>

<INPUT class='w3-btn w3-teal' 
               type='Submit' 
               name='submit_cancel' 
               value='Откажи'>
       
<INPUT class='w3-check' 
                        type='checkbox' 
                        name='checkbox_confirm' 
                        value='<?php echo $subject['id'];?>'>
<label>Потвърди</label>
    

<INPUT class='w3-btn w3-teal' 
                        type='Submit' 
                        name='submit_form'
       
                        VALUE='Запиши'>     
        
</h6>  
</div> 
       

</FORM>  
</div>  

<script>  

 $(document).ready(function(){  
      var i=1;  
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<div id="row'+i+'"><br><br><br><table class="w3-table w3-small"><table class="w3-table w3-small"><tr><td width="10%"><label class=" w3-text-grey w3-small">Позиция</label><input type="text" name="sos01[]" class="w3-input w3-border w3-round" placeholder="Поз." maxlength="4"></td><td width="10%"><label class=" w3-text-grey w3-small">бр.</label><input type="text" name="sos02[]" class="w3-input w3-border w3-round" placeholder="бр. к-ти" maxlength="4"></td> <td width="20%"><label class=" w3-text-grey w3-small">Цена за бр.</label><input type="number" name="sos03[]" class="w3-input w3-border w3-round" value=""></td> <td width="20%"><label class="w3-text-grey w3-small">Срок на доставка</label><input class="form-control" type="date"  name="sos04[]" value=""> </td><td width="" ><label class="w3-text-grey w3-small w3-center">remove</label><br><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr></table><table class="w3-table w3-small"><caption class="w3-margin-left">Регулатор</caption><tr><td width="15%"><select id="sos05copy'+i+'" name="sos05[]" class="form-control"></select></td> <td width="11%"><select id="sos06copy'+i+'" name="sos06[]" class="form-control"></select></td> <td width="12%"><select id="sos07copy'+i+'" name="sos07[]" class="form-control"></select></td><td width="15%"><select id="sos08copy'+i+'" name="sos08[]" class="form-control"></select></td><td width="12%"><select id="sos09copy'+i+'" name="sos09[]" class="form-control"></select></td><td width="10%"><select id="sos10copy'+i+'" name="sos10[]" class="form-control"></select></td> <td width="12%"><select id="sos11copy'+i+'" name="sos11[]" class="form-control"></select></td><td width="20%"><select  id="sos12copy'+i+'" name="sos12[]" class="form-control"></select></td></tr></table><table class="w3-table w3-small"><caption class="w3-margin-left">Задвижване</caption><tr><td width="15%"><select id="sos13copy'+i+'" name="sos13[]" class="form-control"></select></td><td width="20%"><select id="sos14copy'+i+'" name="sos14[]" class="form-control"></select></td><td width="60%"><textarea name="sos15[]" rows="1" cols="50" class="form-control" type="text" placeholder="Мониторингова..."></textarea></td> </tr></table><table class="w3-table w3-small"><caption class="w3-margin-left">Друго</caption><tr><td><textarea name="sos16[]" rows="1" cols="50" class="form-control" type="text" placeholder="резервни..."></textarea></td></tr></table></div></div>'); 
           $('#sos05 option').clone().appendTo('#sos05copy'+i+'');
           $('#sos06 option').clone().appendTo('#sos06copy'+i+'');
           $('#sos07 option').clone().appendTo('#sos07copy'+i+'');
           $('#sos08 option').clone().appendTo('#sos08copy'+i+'');
           $('#sos09 option').clone().appendTo('#sos09copy'+i+'');
           $('#sos10 option').clone().appendTo('#sos10copy'+i+'');
           $('#sos11 option').clone().appendTo('#sos11copy'+i+'');
           $('#sos12 option').clone().appendTo('#sos12copy'+i+'');
           $('#sos13 option').clone().appendTo('#sos13copy'+i+'');
           $('#sos14 option').clone().appendTo('#sos14copy'+i+'');
      });  
      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

 });  
</script>           

<?PHP include_layout_template('footer.php'); ?>