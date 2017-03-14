 <?php

     function include_layout_template($template=""){
        include(SITE_ROOT.DS.'_Layouts'.DS.$template);
}     

     function require_login_session($page){
        if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
        header ("Location: /HHIB/$page");
       // echo "nqma sesiq";
}
        else{
          //  print $_SESSION['login'];
          //  print_r($_SESSION);
        }
    }                

     function redirect_to($location = NULL){
        echo "<meta http-equiv='refresh' content='0;URL=".$location."'>"; 
        exit;
    }

     function replace_text_newline($string){    
        $string = preg_replace("/;/",";\n",$string);
        $string = nl2br($string);
        return $string;    
    }              

     function session_history_msg($msg=""){
         if ((isset($_SESSION['history_msg']) && $_SESSION['history_msg'] != '')) { 
             unset ($_SESSION['history_msg']);  
         }
         $datetime  =  strftime('%Y-%m-%d %H:%M');       
         $real_name =  $_SESSION['real_name'];         
         $history_string = "[" . $datetime . "] [" . $real_name . "] [" . $msg . "].\r\n";
         $_SESSION['history_msg'] = $history_string; 
    }               

     function comment_msg_format($msg=""){
        $datetime  =  strftime('%Y-%m-%d %H:%M');       
        $real_name =  $_SESSION['real_name'];         
        $history_array = "[" . $datetime . "] [" . $real_name . "] [" . $msg . "].\r\n";
        return $history_array;
    }                

     function output_message($message="") {
        if (!empty($message)) { 
            return "<p class=\"message\">{$message}</p>";
        } else {
            return "";
        }
    }

     function txtToList ($txtFile="") {

  if (file_exists($filePath = DESIGN_SETTINGS.DS.$txtFile)) {
   
      $menuItems = file($filePath);
      
      foreach ($menuItems as $menuItem) {
         echo "<option value='$menuItem'>$menuItem</option>";
     }// fclose($filePath);
  } else {
         echo "<option value='няма файл с позиции'>няма файл с позиции</option>";
         echo "<option value='-'>-</option>";
         echo "<option selected value=''></option>";   
    }
}

     function approveColor ($approveStatus) {
     
     if ($approveStatus == "За Изработване") { $colorToApply = "w3-text-red";    };
     if ($approveStatus == "Изработена")     { $colorToApply = "w3-text-teal";  };    
     if ($approveStatus == "За Одобрение") { $colorToApply = "w3-text-deep-orange"; };
     if ($approveStatus == "Одобрена")     { $colorToApply = "w3-text-teal";  };
     if ($approveStatus == "Отказано Одобрение")     { $colorToApply = "w3-text-red";  };    
         

     return $colorToApply;     
 }  

//TO DO:
    //function  make msg
    //delete ms
?>