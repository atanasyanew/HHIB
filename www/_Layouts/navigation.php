<ul class="w3-navbar w3-light-grey w3-border"> 
    
 <li>
     <a href="/index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
    </li> 

 <li>
     <a href="/about.php"><i class="fa fa-info" aria-hidden="true"></i></a>
    </li>     
    
 <li>
     <a href="/Offers/offers_overview.php" style="font-weight: bold;">Оферти</a>
    </li>
    
 <li>
     <a href="/Orders/orders_overview.php"style="font-weight: bold;">ВФ Поръчки</a>
    </li>

 <li>
     <a href="/Reports/reports_overview.php"style="font-weight: bold;"><i class="fa fa-line-chart" aria-hidden="true"></i> Доклади</a>
    </li>  
      
 <li class="w3-right">
     <a href="/User/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i> Изход</a>
    </li>
    
 <li class="w3-right">
     <a href="/User/user_profile.php"><i class="fa fa-user" aria-hidden="true"></i> <?php echo $_SESSION['real_name'];?></a>
    </li>
    
</ul>
