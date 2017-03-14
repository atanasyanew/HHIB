<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
//require_login_session("login.php");

?>


<div class="w3-border w3-margin"> 
<div class="w3-container w3-teal">
<h2>Таблица с всички последни Рев. на ОФЕРТИ</h2>
</div>   
<div style="overflow-x:auto;">  
<table class="w3-table-all w3-small">
    <thead>
        <tr class="w3-dark-grey">
            <th nowrap>Номер</th>
            <th nowrap>Рев.</th> 
            <th nowrap>Създадена от</th>
            <th nowrap>Дата на създаване</th>
            <th nowrap>Дата на завършване</th>
            <th nowrap>Време на изготвяне</th>    
            <th nowrap>Прогрес</th>
            <th nowrap>Етап 1, Отговорен</th>
            <th nowrap>Етап 1, дата</th>
            <th nowrap>Етап 2</th>
            <th nowrap>Етап 2, дата</th>
            <th nowrap>Етап 3</th>
            <th nowrap>Етап 3, дата</th>
            <th nowrap>Етап 4</th>
            <th nowrap>Етап 4, дата</th>
            <th nowrap>Етап 5</th>
            <th nowrap>Етап 5, дата</th>         
      </tr>  
    </thead>
    
<?php 
$offers = new Offers(); 
$result = $offers->find_all();
    
while( $subject = $offers->fetch_assoc($result) ) {    
    
    //prep some stuff
    $arrayApprove = unserialize($subject['approve']);
    $arrayCount = count($arrayApprove);
    $page_ref_by_id  = "<a href='/HHIB/offers/offer_details.php?subjectId={$subject['id']}'>";
    $page_ref_by_id .= $subject['number'] . "</a>"; 
        
    
        echo "<tr>";  
        echo "<td nowrap>" . $page_ref_by_id . "</td>";
        echo "<td nowrap>" . $subject['rev'] . "</td>";
        echo "<td nowrap>" . $subject['create_by'] . "</td>";
        echo "<td nowrap>" . $subject['create_date'] . "</td>";
    
        echo "<td>"; //date of approve
        if ( $arrayApprove[4]['approveStatus'] == "Одобрена" ) {
                $approvedDate = $arrayApprove[4]['approvedDate']; 
            } else {$approvedDate = "";};
            echo $approvedDate;
        echo "</td>";
        
    
        echo "<td nowrap>"; // Време на изготвяне
        if (!$approvedDate==""){
            
        $date1 = new DateTime($subject['create_date']);
        $date2 = new DateTime($approvedDate);
        $diff = $date1->diff($date2)->format("  %Mм. %Dд. %Hч и %Iмин");
        //ver2  //$diff = $date1->diff($date2)->format("  %M-%D-%H-%I");
        echo $diff;
        } else {echo "";};
            
        echo "</td>";
    
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
    
        echo "<td nowrap>" . $arrayApprove[0]['approvedBy'] . "</td>"; 
        echo "<td nowrap>" . $arrayApprove[0]['approvedDate'] . "</td>"; 
 
        echo "<td nowrap>" . $arrayApprove[1]['approvedBy'] . "</td>"; 
        echo "<td nowrap>" . $arrayApprove[1]['approvedDate'] . "</td>"; 
    
        echo "<td nowrap>" . $arrayApprove[2]['approvedBy'] . "</td>"; 
        echo "<td nowrap>" . $arrayApprove[2]['approvedDate'] . "</td>"; 
    
        echo "<td nowrap>" . $arrayApprove[3]['approvedBy'] . "</td>"; 
        echo "<td nowrap>" . $arrayApprove[3]['approvedDate'] . "</td>"; 
    
        echo "<td nowrap>" . $arrayApprove[4]['approvedBy'] . "</td>"; 
        echo "<td nowrap>" . $arrayApprove[4]['approvedDate'] . "</td>"; 
    
    


        echo "</tr>";

} 

?>
</table>
</div> 
</div> <!-- all possitions in offers, last revs -->   


<!-- all possitions in offers, all revs revs -->   


<!-- last revs offers -->   

<?PHP include_layout_template('footer.php'); ?>