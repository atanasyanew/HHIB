<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>
 
<?php
    $offers = new Offers();

	// 1. the current page number ($current_page)
	$page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;

    // 3. total record count ($total_count)
	$total_count = $offers->count_all_unique();

	// 2. records per page ($per_page)
    if (isset($_GET['page']) && $_GET['page']=='showAll') {
       $per_page = (int)$total_count;
       $page = 1;
    
    } else {
         $per_page = 20;
    }

	$pagination = new Pagination($page, $per_page, $total_count);

    $offset = $pagination->offset();

    if (isset($_GET['submitSearch'])) {
        
     $number = $_GET['number'];
     $rev = $_GET['rev'];  
     $create_by = $_GET['create_by']; 
     $create_date = $_GET['create_date'];            
        
     $result = $offers->search_by_sql($number, $rev, $create_by, $create_date);

        
     $total_count = $offers->num_rows($result);
    
    
    } else {
        $result = $offers->find_by_pagination($per_page, $offset);  
    }
    
    $counted  = $offers->num_rows($result); 

$button_cr  = "<a class='w3-btn w3-teal" . $ss->userPermissions('0100') . "' href=\"offers_form_create.php\">Създай Оферта</a>";

?>

<div class="w3-border w3-margin">
<div class="w3-container w3-teal">
<h2>Оферти</h2>
</div> <!-- header -->   
<div class="w3-container w3-teal"> 
<ul class="w3-navbar w3-teal">   
<li><?php print $button_cr; ?></li>  
<li><li><button onclick="myFunction('searchInclude')" class="w3-btn w3-teal"><i class="fa fa-search" aria-hidden="true"></i></button></li> </li>    
</ul> 
</div> <!-- Buttons -->  
</div> <!-- HEADERS && MENU -->

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
    <label class="w3-label w3-text-grey">Създадена от</label>
    <input class="w3-input w3-border" type="text" name="create_by" placeholder="Създадена от">
</div>    
    
<div class="form-group w3-margin">  
    <label class="w3-label w3-text-grey">Дата на създаване</label>
    <input class="w3-input w3-border" type="date" name="create_date">
</div>
    
<!--     
<div class="form-group w3-margin">
    <label class="w3-label w3-text-grey">Дата на изпращане</label>
    <input class="w3-input w3-border" type="date" name="send_date"> 
</div>
 
<div class="form-group w3-margin">
    <label class="w3-label w3-text-grey">Изпратена от</label>
    <input class="w3-input w3-border" type="text" name="send_by" placeholder="Изпратена от">
</div>    
-->
    
<div class="form-group w3-margin">
    <label class="w3-label w3-text-grey"><i class="fa fa-search" aria-hidden="true"></i></label>
    <input class="w3-input w3-dark-grey w3-btn" type="submit" name="submitSearch" value="Търси">
</div>   

</form>
</div> <!-- search -->
			
<div class="w3-container">
<table class="w3-table-all w3-hoverable w3-small">
    <caption class=""><?php print " Управление на офертите" . " (" . $total_count ." съществуващи оферти)"?></caption>
    <thead>
      <tr class="w3-dark-grey">
        <th>Номер</th>
        <th>Ревизия</th> 
        <th>Създадена от</th>
        <th>Дата на създаване</th>
        <th>Дата на завършване</th>
        <th>Прогрес</th>
      </tr>
    </thead>
<?php  
while($subject = $offers->fetch_assoc($result)) {      
$page_ref_by_id = "<a href='offer_details.php?subjectId={$subject['id']}'>{$subject['number']}</a>";    
print "<tr>";  
        print "<td nowrap>" . $page_ref_by_id                           .    "</td>";
        print "<td>" . $subject['rev']                           .    "</td>";
        print "<td>" . $subject['create_by']                     .    "</td>";
        print "<td>" . $subject['create_date']                   .    "</td>"; 
    
        $arrayApprove = unserialize($subject['approve']); //need for status and approve date
    
        echo "<td>"; //date of approve
        if ( $arrayApprove[4]['approveStatus'] == "Одобрена" ) {
                $approvedDate = $arrayApprove[4]['approvedDate']; 
            } else {$approvedDate = "";};
            echo $approvedDate;
        echo "</td>";    
    
    
    
        echo "<td>";
            //status 
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
    
    /* OLD
        echo "<td>";  //status  
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
    
print "</tr>";
} 
?>
</table>
</div> <!-- TABLE PAGE -->
    
<div class="w3-center w3-padding">
<ul class="w3-pagination w3-small">
<?php
	if($pagination->total_pages() > 1) {
		
		if($pagination->has_previous_page()) { 
    	echo "<li><a href=\"offers_overview.php?page=";
       echo $pagination->previous_page();
       echo "\">&laquo;</a></li> "; 
    }

		for($i=1; $i <= $pagination->total_pages(); $i++) {
			if($i == $page) {
				echo " <li><a class=\"w3-dark-grey\">{$i}</a></li> ";
			} else {
				echo " <li><a href=\"offers_overview.php?page={$i}\">{$i}</a></li> "; 
			}
		}

		if($pagination->has_next_page()) { 
			echo " <li><a href=\"offers_overview.php?page=";
			echo $pagination->next_page();
			echo "\">&raquo;</a></li> "; 
    }
		
	}

?>
</ul>
    <br>
<ul class="w3-pagination w3-small">
    <li><a href="offers_overview.php?page=showAll">Покажи всички</a></li>
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