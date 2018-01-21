<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
//require_login_session("login.php");

$orders = new Orders();
?>


<div class="w3-row w3-border">
  
<div class="w3-half">   
<div class="w3-border w3-margin"> 
<div class="w3-container w3-teal">
<h2>Таблица с всички позиции на последни Рев. на ВФП</h2>
</div>   
<div style="overflow-x:auto;">  
<table class="w3-table-all w3-small">
    <thead>
      <tr class="w3-dark-grey">
        <th nowrap>Номер</th>
        <th nowrap>Рев.</th>
        <th nowrap>Дата на създаване</th>
        <th nowrap>Създадена от</th>       
        <th nowrap>Клиент</th>
        <th nowrap>Държава</th>
        <th nowrap>Краен Клиент</th>
        <th nowrap>Държава</th> 
        <th nowrap>Прогрес</th>  
        <th nowrap>Обща стойност</th> 
        <th nowrap>Валута</th>
        <th nowrap>ВФП поз.</th> 
        <th nowrap>бр.</th> 
        <th nowrap>Цена за бр.</th>
        <th nowrap>Срок на доставка</th>
        <th nowrap>Вид</th>  
        <th nowrap>Фази</th>  
        <th nowrap>Ток</th>  
        <th nowrap>изол.</th>  
        <th nowrap>Изол. ред</th>  
        <th nowrap>деление</th>   
        <th nowrap>стъпала</th>
        <th nowrap>предизбирач</th>
        <th nowrap>Задвижване</th>
        <th nowrap>тип</th>
        <th nowrap>друго към задвижването</th>
        <th nowrap>друго в поз</th>
      </tr>
    </thead>
<?php 
    
$getAllLastRevs = $orders->find_all_unique();
    
while($subject = $orders->fetch_assoc($getAllLastRevs)) {    
    
    $scopeOfSupply = unserialize($subject['ico_scopeofsupply']); 
    $scopePosCount = count($scopeOfSupply);
    
    $arrayApprove = unserialize($subject['approve']);
    $arrayCount = count($arrayApprove);
    
    for ($row = 0; $row < $scopePosCount; $row++) {   
    
        $page_ref_by_id  = "<a href='/HHIB/Orders/orders_details.php?order_id={$subject['id']}'>";
        $page_ref_by_id .= $subject['number'] . "</a>"; 
        
        echo "<tr>";  
        echo "<td nowrap>" . $page_ref_by_id . "</td>";
        echo "<td nowrap>" . $subject['rev'] . "</td>";
        echo "<td nowrap>" . $subject['create_date'] . "</td>"; 
        echo "<td nowrap>" . $subject['create_by'] . "</td>";
        echo "<td nowrap>" . $subject['ico_client'] . "</td>";
        echo "<td nowrap>" . $subject['ico_clientcountry'] . "</td>";
        echo "<td nowrap>" . $subject['ico_enduser'] . "</td>";
        echo "<td nowrap>" . $subject['ico_endusercountry'] . "</td>";
        
       // OLD, THE NEW IS IN TEST STAGE 
       // echo "<td nowrap>";
       //     //status 
       //     $approveKey = (int)0;
       //     while ( $arrayApprove[$approveKey]['approveStatus'] == 'Одобрена' or
       //         $arrayApprove[$approveKey]['approveStatus'] == 'Изработена') {
       //         if ($approveKey == (int)count($arrayApprove)-1) { break; } //prevent errors.
       //         $approveKey++; }
       //     
       //     $keyNumForApprove = $arrayApprove[$approveKey]['stageNumber'];
       //     
       //     if ($keyNumForApprove == $arrayCount) { $stagePercent = 100;     
       //     } else {  
       //       $keyNumForApprove = $keyNumForApprove-1;  
       //       $stagePercent = ($keyNumForApprove) * (100/$arrayCount);  
       //       $stagePercent = (int)$stagePercent;  
       //     }
       // 
       //     echo $stagePercent . "% " . "(".$keyNumForApprove ."/" . $arrayCount . ")";
       // echo "</td>"; 
        
         echo "<td nowrap>";
            //status 
            $approveKey = (int)0;
            while ( $arrayApprove[$approveKey]['approveStatus'] == 'Одобрена' or
                $arrayApprove[$approveKey]['approveStatus'] == 'Изработена') {
                if ($approveKey == (int)count($arrayApprove)-1) { break; } //prevent errors.
                $approveKey++; }
            
            $keyNumForApprove = $arrayApprove[$approveKey]['stageNumber']; 
            $getLastArrayKey = $arrayCount-1;
        
            if ($arrayApprove[$getLastArrayKey]['approvedBy'] != "" ) {
                $stagePercent = ($keyNumForApprove) * (100/$arrayCount);          
            } else {
                $keyNumForApprove = $keyNumForApprove-1;  
                $stagePercent = ($keyNumForApprove) * (100/$arrayCount);  
                $stagePercent = (int)$stagePercent;  
            }
                
            echo $stagePercent . "% " . "(".$keyNumForApprove ."/" . $arrayCount . ")";
        echo "</td>";
        
        
        
        
        
        
        
        
        
        
        
        echo "<td nowrap>" . $subject['ico_amount'] . "</td>";
        echo "<td nowrap>" . $subject['ico_amountcurrency'] . "</td>";
        echo "<td nowrap>Поз." . $scopeOfSupply[$row]['sos01'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos02'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos03'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos04'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos05'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos06'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos07'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos08'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos09'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos10'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos11'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos12'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos13'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos14'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos15'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos16'] . "</td>";
        echo "</tr>";
    }
} 
?>
</table>
</div> 
</div> <!-- all possitions in orders, last revs -->   
</div>
    

    
<div class="w3-half">   
<div class="w3-border w3-margin"> 
<div class="w3-container w3-teal">
<h2>Таблица с всички позиции на ВСИЧКИ Рев. на ВФП</h2>
</div>   
<div style="overflow-x:auto;">  
<table class="w3-table-all w3-small">
    <thead>
      <tr class="w3-dark-grey">
        <th nowrap>Номер</th>
        <th nowrap>Рев.</th>
        <th nowrap>Дата на създаване</th>
        <th nowrap>Създадена от</th>
        <th nowrap>Клиент</th>
        <th nowrap>Държава</th>
        <th nowrap>Краен Клиент</th>
        <th nowrap>Държава</th>  
        <th nowrap>Прогрес</th>  
        <th nowrap>Обща стойност</th> 
        <th nowrap>Валута</th>
        <th nowrap>ВФП поз.</th> 
        <th nowrap>бр.</th> 
        <th nowrap>Цена за бр.</th>
        <th nowrap>Срок на доставка</th>
        <th nowrap>Вид</th>  
        <th nowrap>Фази</th>  
        <th nowrap>Ток</th>  
        <th nowrap>изол.</th>  
        <th nowrap>Изол. ред</th>  
        <th nowrap>деление</th>   
        <th nowrap>стъпала</th>
        <th nowrap>предизбирач</th>
        <th nowrap>Задвижване</th>
        <th nowrap>тип</th>
        <th nowrap>друго към задвижването</th>
        <th nowrap>друго в поз</th>
      </tr>
    </thead>
<?php 
    
$getAllRevs = $orders->find_all();
    
while($subject = $orders->fetch_assoc($getAllRevs)) {    
    
    $scopeOfSupply = unserialize($subject['ico_scopeofsupply']); 
    $scopePosCount = count($scopeOfSupply);
    
    $arrayApprove = unserialize($subject['approve']);
    $arrayCount = count($arrayApprove);
    
    for ($row = 0; $row < $scopePosCount; $row++) {   
    
        $page_ref_by_id  = "<a href='/HHIB/Orders/orders_details.php?order_id={$subject['id']}'>";
        $page_ref_by_id .= $subject['number'] . "</a>"; 
        
        echo "<tr>";  
        echo "<td nowrap>" . $page_ref_by_id . "</td>";
        echo "<td nowrap>" . $subject['rev'] . "</td>";
        echo "<td nowrap>" . $subject['create_date'] . "</td>"; 
        echo "<td nowrap>" . $subject['create_by'] . "</td>";
        echo "<td nowrap>" . $subject['ico_client'] . "</td>";
        echo "<td nowrap>" . $subject['ico_clientcountry'] . "</td>";
        echo "<td nowrap>" . $subject['ico_enduser'] . "</td>";
        echo "<td nowrap>" . $subject['ico_endusercountry'] . "</td>";
         echo "<td nowrap>";
            //status 
            $approveKey = (int)0;
            while ( $arrayApprove[$approveKey]['approveStatus'] == 'Одобрена' or
                $arrayApprove[$approveKey]['approveStatus'] == 'Изработена') {
                if ($approveKey == (int)count($arrayApprove)-1) { break; } //prevent errors.
                $approveKey++; }
            
            $keyNumForApprove = $arrayApprove[$approveKey]['stageNumber']; 
            $getLastArrayKey = $arrayCount-1;
        
            if ($arrayApprove[$getLastArrayKey]['approvedBy'] != "" ) {
                $stagePercent = ($keyNumForApprove) * (100/$arrayCount);          
            } else {
                $keyNumForApprove = $keyNumForApprove-1;  
                $stagePercent = ($keyNumForApprove) * (100/$arrayCount);  
                $stagePercent = (int)$stagePercent;  
            }
                
            echo $stagePercent . "% " . "(".$keyNumForApprove ."/" . $arrayCount . ")";
        echo "</td>";
        
        
        
        
        
        
        
        
        
        
        
        echo "<td nowrap>" . $subject['ico_amount'] . "</td>";
        echo "<td nowrap>" . $subject['ico_amountcurrency'] . "</td>";
        echo "<td nowrap>Поз." . $scopeOfSupply[$row]['sos01'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos02'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos03'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos04'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos05'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos06'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos07'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos08'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos09'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos10'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos11'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos12'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos13'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos14'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos15'] . "</td>";
        echo "<td nowrap>" . $scopeOfSupply[$row]['sos16'] . "</td>";
        echo "</tr>";
    }
} 
?>
</table>
</div> 
</div>  <!-- all possitions in orders, all revs revs -->   
</div>

</div>
<!-- last revs orders -->   

<?PHP include_layout_template('footer.php'); ?>