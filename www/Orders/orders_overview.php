<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
//require_login_session("login.php");
?>
 
<?php
    $orders = new Orders();

	//the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    //total record count ($total_count)
	$total_count = $orders->count_all_unique();

	//records per page ($per_page)
    if (isset($_GET['page']) && $_GET['page']=='showAll') {
       $per_page = (int)$total_count;
       $page = 1;
    } else {
         $per_page = 20;
    }

	$pagination = new Pagination($page, $per_page, $total_count);

    $offset = $pagination->offset();

    if (isset($_GET['submitSearch'])) {
     $result = $orders->search_by_sql($_GET['number'], $_GET['rev'], $_GET['create_date'], $_GET['create_by'], $_GET['ico_client'], $_GET['ico_clientcountry']);
         
     $total_count = $orders->num_rows($result);
    
    } else {
        $result = $orders->find_by_pagination($per_page, $offset);  
    }

    $button_cr  = "<a class='w3-btn w3-teal' href=\"orders_form_create.php\">Създай ВФП</a>"; 
?>

<div class="w3-border w3-margin">
<div class="w3-container w3-teal">
<h2>Вътрешно-Фирмени Поръчки</h2>
</div>   
<div class="w3-container w3-teal">    
<ul class="w3-navbar w3-teal">   
<li class="<?php echo $ss->userPermissions('1100'); ?>"><?php echo $button_cr; ?></li> 
<li><button onclick="myFunction('searchInclude')" class="w3-btn w3-teal"><i class="fa fa-search" aria-hidden="true"></i></button></li> 
</ul>      
</div> <!-- Buttons -->     
</div>  <!-- HEADERS -->
    
<div id="searchInclude" class="w3-container w3-accordion-content">
<form method="get" action="" class="form-inline w3-small w3-border">
<input type="hidden" name="page" value="showAll"> 

<div class="form-group w3-margin">
    <label class="w3-label w3-text-grey">Номер</label>
    <input class="w3-input w3-border" type="text" name="number" placeholder="Номер">
    </div>
    
<div class="form-group w3-margin">     
    <label class="w3-label w3-text-grey">Ревизия</label>
    <input class="w3-input w3-border" type="text" name="rev" placeholder="Ревизия">
</div>
    
<div class="form-group w3-margin">  
    <label class="w3-label w3-text-grey">Дата на създаване</label>
    <input class="w3-input w3-border" type="date" name="create_date" placeholder="Дата на създаване">
</div>    
    
<div class="form-group w3-margin">  
    <label class="w3-label w3-text-grey">Kлиент</label>
    <input class="w3-input w3-border" type="text" name="ico_client">
</div> 
    
<div class="form-group w3-margin">  
    <label class="w3-label w3-text-grey">Държава</label>
    <input class="w3-input w3-border" type="text" name="ico_clientcountry" >
</div>      
    
<div class="form-group w3-margin">  
    <label class="w3-label w3-text-grey">Създадена от</label>
    <input class="w3-input w3-border" type="text" name="create_by" placeholder="Създадена от">
</div>
    
<div class="form-group w3-margin">
    <label class="w3-label w3-text-grey"><i class="fa fa-search" aria-hidden="true"></i></label>
    <input class="w3-input w3-dark-grey w3-btn" type="submit" name="submitSearch" value="Търси">
</div>
     

</form>
</div>   <!-- SEARCH --> 

<div class="w3-container">  
<table class="w3-table-all w3-hoverable w3-small">
    <caption class=""><?php echo " Управление на поръчките" . " (" . $total_count ." записа)"?></caption>
    <thead>
      <tr class="w3-dark-grey">
        <th>Номер</th>
        <th>Рев.</th>
        <th>Дата на създаване</th>
        <th>Клиент</th>
        <th>Държава</th>
        <th>Създадена от</th>     
        <th>Прогрес</th>
      </tr>
    </thead>
<?php  
while($subject = $orders->fetch_assoc($result)) {      
$page_ref_by_id = "<a href='orders_details.php?order_id={$subject['id']}'>{$subject['number']}</a>";    
echo "<tr>";  
        echo "<td nowrap>" . $page_ref_by_id . "</td>";
        echo "<td>" . $subject['rev'] . "</td>";
        echo "<td>" . $subject['create_date'] . "</td>";
        echo "<td>" . $subject['ico_client'] . "</td>";
        echo "<td>" . $subject['ico_clientcountry'] . "</td>";
        echo "<td>" . $subject['create_by'] . "</td>";
    
        
        echo "<td>";
            //status 
            $arrayApprove = unserialize($subject['approve']); 
            $arrayCount = count($arrayApprove);
            $approveKey = (int)0;
            while ( $arrayApprove[$approveKey]['approveStatus'] == 'Одобрена' or
                $arrayApprove[$approveKey]['approveStatus'] == 'Изработена') {
                if ($approveKey == (int)count($arrayApprove)-1) { break; } //prevent errors.
                $approveKey++; }
            
            $keyNumForApprove = $arrayApprove[$approveKey]['stageNumber']; 
            $getLastArrayKey = $arrayCount-1;
        
            if ( $arrayApprove[$getLastArrayKey]['approvedBy'] != "" ) {
                 $stagePercent = ($keyNumForApprove) * (100/$arrayCount);          
            } else {
                 $keyNumForApprove = $keyNumForApprove-1;  
                 $stagePercent = ($keyNumForApprove) * (100/$arrayCount);  
                 $stagePercent = (int)$stagePercent;  
            }
             
    
            if ( $stagePercent == 100 ) {
                 echo "<div class=\"w3-progress-container\">";
                 echo "<div class=\"w3-progressbar w3-green\" style=\"width:{$stagePercent}%\">";
                 echo "<div class=\"w3-center w3-text-white\">{$stagePercent}%</div>";
                 echo "</div>";
                 echo "</div>";
              
            } else {
                
                 echo "<div class=\"w3-progress-container\">";
                 echo "<div class=\"w3-progressbar w3-green\" style=\"width:{$stagePercent}%\">";
                 echo "<div class=\"w3-center w3-text-white\">{$stagePercent}%</div>";
                 echo "</div>";
                 echo "</div>"; 
                
                echo "<p class=\"w3-margin-0\">";
                // echo "<div class=\"\">";
                 echo "Следва: " . $arrayApprove[$approveKey]['approveStatus'] . ": ";
                 echo $arrayApprove[$approveKey]['stageNumber'] . ". ";
                 echo $arrayApprove[$approveKey]['stageTitle'] . " ";
                // echo "</div>"; 
                echo "</p>";
            }
            
        echo "</td>";
    
    
    
    /* old 
    echo "<td>";
        //status key
        $arrayApprove = unserialize($subject['approve']); 
        $arrayCount = count($arrayApprove);
        $approveKey = (int)0;
        while ( $arrayApprove[$approveKey]['approveStatus'] == 'Одобрена' or
            $arrayApprove[$approveKey]['approveStatus'] == 'Изработена') {
        if ($approveKey == (int)count($arrayApprove)-1) { break; } //prevent errors.
        $approveKey++;
        }
    
        $keyNumForApprove = $arrayApprove[$approveKey]['stageNumber'];
        
        if ($keyNumForApprove == $arrayCount) {$stagePercent = 100;     
        } else {  
          $stagePercent = ($keyNumForApprove-1) * (100/$arrayCount);  
          $stagePercent = (int)$stagePercent;  
        }
            echo "<div class=\"w3-progress-container\">";
            echo "<div class=\"w3-progressbar w3-green\" style=\"width:{$stagePercent}%\">";
            echo "<div class=\"w3-center w3-text-white\">{$stagePercent}%</div>";
            echo "</div>";
            echo "</div>";
         if ($stagePercent<>100) { 
             //echo "<br>";
             echo "Следва: " . $arrayApprove[$approveKey]['approveStatus'] . ": ";
             echo $arrayApprove[$approveKey]['stageNumber'] . ". ";
             echo $arrayApprove[$approveKey]['stageTitle'] . " ";
         }    
    echo "</td>";
    */
    
echo "</tr>";
} //fetch data
?>
</table>
</div> <!-- OVERVIEW TABLE -->   

<div class="w3-center w3-padding">
<ul class="w3-pagination w3-small">
<?php
	if($pagination->total_pages() > 1) {
		
		if($pagination->has_previous_page()) { 
    	echo "<li><a href=\"orders_overview.php?page=";
        echo $pagination->previous_page();
        echo "\">&laquo;</a></li> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <li><a class=\"w3-dark-grey\">{$i}</a></li> ";
			} else {
				echo " <li><a href=\"orders_overview.php?page={$i}\">{$i}</a></li> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo " <li><a href=\"orders_overview.php?page=";
			echo $pagination->next_page();
			echo "\">&raquo;</a></li> "; 
    }
		
	}

?>
</ul>
    <br>
<ul class="w3-pagination w3-small">
    <li><a href="orders_overview.php?page=showAll">Покажи всички</a></li>
</ul>     
</div>   <!-- PAGINATION -->

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