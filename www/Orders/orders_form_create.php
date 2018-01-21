<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

<?php //CANCEL BUTTON, REDIRECT TO BACK
if (isset($_GET['submit_cancel'])) {
    $pref = "orders_overview.php";
    redirect_to($pref); 
} 

?>

<div class="w3-border w3-margin w3-center w3-container w3-teal">
    <h2> СЪЗДАВАНЕ <br/> ВЪТРЕШНО-ФИРМЕНА ПОРЪЧКА <br/> INTERNAL COMPANY ORDER</h2>  
</div>  <!-- HEADER --> 
     
<?php  
if (isset($_GET['submit_form']) && isset($_GET['checkbox_confirm'])){
$orders_cr = new Orders(); //open new class    
     
if (!$orders_cr->check_order_number($_GET['number'])==0) { 
    
$orders_cr->find_last_rev( $_GET['number'] ); //asign to global  
$revLink = 'orders_details.php?order_id='.$orders_cr->lastRevId; // link to last rev
     
print "<div class=\"w3-panel w3-margin w3-red\">";
print "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
print "<h3>Съществуваща поръчка!</h3>";
print "<p>Линк към ВФП № <a href=\"".$revLink."\">".$_GET['number']."</a></p>";
print "</div>";
     
}
 else {
     session_history_msg("създадена");
     $orders_cr->create_order();
      }     
    
} //create or redirect
$orders = new Orders();
$nextNumberIs = $orders->getNextOrderNumber();
?>



<div class="w3-margin">                     
<FORM class="form-horizontal" METHOD='GET' ACTION=''>
    
<div class="w3-hide">  
<p>Всичко в този div е скрито </p>      
<input type="hidden" name="rev" value="0">       
</div> <!-- hide ones-->
     
<br>
     
<div class="form-group">
    <label class="col-sm-3 control-label">Номер<br>Number</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               placeholder='XX-XX-XXX'
               name="number"
               MAXLENGTH='9'
               required
               value="<?php echo $nextNumberIs;?>"></div>
        
        <div class="col-sm-1">
        <input class="form-control" 
               type="text" 
               name=""
               disabled
               value="Rev. 0"></div>
     
</div>     <!-- Number -->

<div class="form-group">
    <label class="col-sm-3 control-label">Относно<br>Subject</label>
        <div class="col-sm-7">
        <textarea class="form-control"
                  placeholder='Производство на...'
                  name="ico_subject"></textarea></div>
</div>     <!-- Subject -->  
      
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
</div>     <!-- Create date   -->         
      
<div class="form-group">
    <label class="col-sm-3 control-label">Изработена от<br>Prepared by</label>
        <div class="col-sm-7">
        <input class="form-control" 
               type="text" 
               name="ico_preparedby"
               value="<?php echo $_SESSION['real_name'];?>"></div>
</div>     <!-- Prepared by   -->  
    
<div class="form-group">
    <label class="col-sm-3 control-label">Клиент, държава<br>Client, country</label>
        <div class="col-sm-5">
        <input class="form-control" 
               type="text" 
               name="ico_client"
               placeholder='Клиент'
               value=""></div>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name="ico_clientcountry"
               placeholder='Държава'
               value=""></div>
</div>     <!-- Client, country   -->         
      
<div class="form-group">
    <label class="col-sm-3 control-label">Краен клиент, Държава<br>End user, country</label>
    
        <div class="col-sm-5">
        <input class="form-control" 
               type="text" 
               name="ico_enduser"
               placeholder='Клиент'
               value=""></div>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name="ico_endusercountry"
               placeholder='Държава'
               value=""></div>
</div>     <!-- End user, country   -->    
      
<div class="form-group">
    <label class="col-sm-3 control-label">Валута на поръчката<br>Currency</label>
        <div class="col-sm-2">
       <select class="form-control"
               name="ico_amountcurrency">
                      <option value="EUR">EUR</option>
                      <option value="BGN">BGN</option>
                      <option value="USD">USD</option></select></div>
</div>     <!-- Order amount   -->
       
<div class="form-group">
<label class="col-sm-3 control-label">Описание-Количество<br>Scope of supply</label>

<div class="col-sm-9"> 
    <div class="w3-border" id="dynamic_field">
        <div>
<table class="w3-table w3-small">  
    <tr>  
    <td width="10%">
               <label class=" w3-text-grey w3-small">Позиция</label>
               <input type="text"       
               name="sos01[]"  
               class="w3-input w3-border w3-round"
               placeholder="Поз."
               maxlength="4"></td> 
    <td width="10%">
               <label class=" w3-text-grey w3-small">бр.</label>
               <input type="text" 
               name="sos02[]"       
               class="w3-input w3-border w3-round"
               placeholder="бр. к-ти"
               maxlength="4"></td> 
    <td width="20%">
               <label class=" w3-text-grey w3-small">Цена за бр.</label>
               <input type="number" 
               name="sos03[]" 
               class="w3-input w3-border w3-round" 
               value=""></td>  
   <td width="20%">
       <label class="w3-text-grey w3-small">Срок на доставка</label>
        <input class="form-control" 
               type="date" 
               name="sos04[]" 
               value=""> </td>   
    <td width="" >
        <label class="w3-text-grey w3-small w3-center">add</label><br>
               <button type="button" 
                name="add" 
                id="add"  
                class="btn btn-success">+</button></td>
    </tr>  
    
       </table>   
<table class="w3-table w3-small"> 
        <caption class="w3-margin-left">Регулатор</caption>
<tr>
<td width="15%">
    <select id="sos05" name="sos05[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos2.txt');?></select></td>     
<td width="11%">
    <select id="sos06" name="sos06[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos3.txt');?></select></td>      
    
<td width="12%">
    <select id="sos07" name="sos07[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos4.txt');?></select></td>    
<td width="15%">
    <select id="sos08" name="sos08[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos5.txt');?></select></td>  
<td width="12%">
    <select id="sos09" name="sos09[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos6.txt');?></select></td>    
<td width="10%">
    <select id="sos10" name="sos10[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos7.txt');?></select></td>   
<td width="12%">
    <select id="sos11" name="sos11[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos8.txt');?></select></td>      
<td width="20%">
    <select id="sos12" name="sos12[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos9.txt');?></select></td>
</tr>
</table>     
 
<table class="w3-table w3-small"> 
<caption class="w3-margin-left">Задвижване</caption>
<tr>      
<td width="15%"><select id="sos13" name="sos13[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos10.txt');?></select></td>     
<td width="20%"><select id="sos14" name="sos14[]" class="form-control"><?php txtToList('ScopeOfSupplyFormPos11.txt');?></select></td>
<td width="60%"><textarea name="sos15[]" rows="1" cols="50" class="form-control" type="text" placeholder="Мониторингова..."></textarea></td>     
</tr>
</table>          
        
<table class="w3-table w3-small"> 
<caption class="w3-margin-left">Друго</caption>
<tr>
<td><textarea name="sos16[]" rows="1" cols="50" class="form-control" type="text" placeholder="резервни..."></textarea></td>
</tr>
</table>         
</div>      
</div>    
    
</div>   

</div>     <!-- Scope of supply   -->     
     
<div class="form-group">
    <label class="col-sm-3 control-label">Изпитания<br>Factory tests</label>
        <div class="col-sm-7">
        <textarea class="form-control"  
                  name="ico_factorytests"></textarea></div>
  </div>     <!-- Factory tests   -->  
                          
<div class="form-group">
    <label class="col-sm-3 control-label">Условия на доставка<br>Delivery terms</label>
        <div class="col-sm-7">
        <input class="form-control" 
               type="text" 
               name="ico_deliveryterms"
               PLACEHOLDER='FCA - София'
               value=""></div>
</div>     <!-- Delivery terms   -->            
    
<div class="form-group">
    <label class="col-sm-3 control-label">Вид на превоза<br>Means of transport</label>
        <div class="col-sm-7">
        <textarea class="form-control"
                  PLACEHOLDER='Автомобилен'
                  name="ico_meansoftransport">Автомобилен</textarea></div>
  </div>     <!-- Means of transport   -->         

<div class="form-group">
    <label class="col-sm-3 control-label">Гранционен срок<br>Warranty period</label>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name="ico_warrantyperiod"
               PLACEHOLDER='36'
               value="36/42"></div>
        <div class="col-sm-2">
        <input class="form-control" 
               type="text" 
               name=""
               disabled
               value="Months"></div>
</div>     <!-- Warranty period   -->       
      
<div class="form-group">
    <label class="col-sm-3 control-label">Приложения<br>Attachments</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  name="ico_attachments"></textarea></div>
</div>     <!-- Attachments   -->       
      
<div class="form-group">
    <label class="col-sm-3 control-label">Забележки<br>Notes</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  rows="5"
                  name="ico_notes"></textarea></div>
</div>     <!-- Notes   -->       
      
<div class="form-group">
    <label class="col-sm-3 control-label">Експедиционни документи<br>Shipping documents</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  rows="5"
    PLACEHOLDER='1.Фактура&#10;2.Опаковъчен лист&#10;3.Товарителница&#10;Всички документи на език:..' 
      name="ico_shippingdocuments">1.Фактура&#10;2.Опаковъчен лист&#10;3.СМР&#10;4.Сертификат за качество</textarea></div>
</div>     <!-- Shipping documents   -->  
      
<div class="form-group">
    <label class="col-sm-3 control-label">Начин на плащане<br>Payment way</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  PLACEHOLDER='60 дни след експедицията'
                  name="ico_paymentway">60 дни след експедицията</textarea></div>
</div>     <!-- Payment way    -->          
      
<div class="form-group">
    <label class="col-sm-3 control-label">Коментар<br>Comment</label>
        <div class="col-sm-7">
        <textarea class="form-control" 
                  placeholder="Коментара е за служебно ползване"
                  name="comment"></textarea></div>
</div>     <!-- Comment   -->   
  
<br>     
    
<div class="w3-container w3-border w3-center w3-teal">
<h6>

    <a class='w3-btn w3-teal' href="/HHIB/Orders/orders_overview.php">Откажи</a>     

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