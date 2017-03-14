<?PHP 
require "_Includes/initialize.php";
include_layout_template('header.php');
require_login_session("login.php");
?>

<?php
//general stuff
$host= gethostname();
$ip = gethostbyname($host);
$file = new FileManagement();
$file->specify_nonrelativedir('Other_files');
$file->check_dir(); //make dir
$dirArray = $file->get_files_array(); //loop files

if (isset($_POST['fileUploadSubmit'])) { 
        
          if ($file->attach_file($_FILES['fileToUpload1'])) {  
                 $file->save_file();
          }  
            redirect_to("about.php");   

    } else {
    $messageError = join("<br />", $file->errors);
    echo $messageError;
    } //UPLOAD FILE

if (isset($_GET['deleteFile'])) {

      if ($file->delete_file($_GET['deleteFile'])) {
            redirect_to("about.php");  
      }
     } //DELETE FILE 

//echo $file->upload_dir . "<br>";
//echo $file->full_dir;
?>


<div class="w3-border w3-margin">
    <div class="w3-container w3-teal">
        <h2>Информация</h2>  
    </div>   
</div>   <!-- header --> 





<!-- OLD VER
<div class="w3-row-padding">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-teal"> 
<h6>Полезни файлове
<a class="w3-right" target="_blank" href="<?php// echo "http://".$ip.DS.$file->dbFolder.DS."Other_files".DS;?>"> 
<i class="fa fa-folder-o" aria-hidden="true"></i>
</a></h6>
</div> 
    
<div class="w3-section w3-border"> 
<ul class="w3-ul">
    
<li>
<a target="_blank" 
   href="<?php// echo "http://".$ip.DS.$file->dbFolder.DS."Other_files".DS."Instruction_web management.doc";?>">
   <i class="fa fa-download" aria-hidden="true"></i> Инструкция за работа</a>
</li>    
<li>
<a target="_blank" 
   href="<?php// echo "http://".$ip.DS.$file->dbFolder.DS."Other_files".DS."Problems_WBS.doc";?>">
   <i class="fa fa-download" aria-hidden="true"></i> Проблеми и решения</a>
</li>
    
</ul>  
</div> 
    
</div> 
</div> 

-->


<div class="w3-section w3-border w3-margin"> 
<ul class="w3-ul">
    
<li>
<a target="_blank" 
   href="<?php echo "http://".$ip.DS.$file->dbFolder.DS."Other_files".DS."Instruction_web management.doc";?>">
   <i class="fa fa-download" aria-hidden="true"></i> Инструкция за работа</a>
</li>    
<li>
<a target="_blank" 
   href="<?php echo "http://".$ip.DS.$file->dbFolder.DS."Other_files".DS."Problems_WBS.doc";?>">
   <i class="fa fa-download" aria-hidden="true"></i> Проблеми и решения</a>
</li>
    
</ul>  
</div> 




<div class="w3-row-padding">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-teal"> 
<h6>Полезни файлове
<a class="w3-right" target="_blank" href="<?php echo "http://".$ip.DS.$file->dbFolder.DS.$file->upload_dir.DS;?>"> 
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
<?php
 // loop through the array of files and print them all
$indexCount	= count($dirArray);
for($index=0; $index < $indexCount; $index++) {
    if (substr("$dirArray[$index]", 0, 1) != ".") {  // don't list hidden files
        
$file_name = str_replace(" ", "%20",$file->downloadUrl.$dirArray[$index]);
        
$fileDate = (date("Y/m/d h:i ", filemtime($file->full_dir.$dirArray[$index]))); 
        
$file_size = $file->size_as_text($file->full_dir.$dirArray[$index]); 
        
$deleteFile = "<a class=\"{$ss->userPermissions('1000')}\" href='about.php?deleteFile={$dirArray[$index]}' ><i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"> Delete</i></a>";
             
print "<tr>";        
print "<td><a href=\"{$file_name}\" download><i class=\"fa fa-download\" aria-hidden=\"true\"></i> {$dirArray[$index]}</a></td>";      
print "<td>" . $file_size . "</td>";  
print "<td>" . $fileDate . "</td>";             
print "<td>" . $deleteFile . "</td>";      
print "</tr>";
	}
}   

?>           
</table>
</div>     
</div> <!-- files table -->
    
<div class="w3-third <?php print $ss->userPermissions('1000'); ?>">
<div class="w3-container w3-border w3-teal"><h6>Качване на файлове</h6></div>
  
<div class="w3-section">      
<form class="w3-container w3-padding w3-border w3-small" 
      method="POST" 
      action="about.php"
      enctype="multipart/form-data">
            
    <input type="hidden" name="MAX_FILE_SIZE" value="50000000">                              
    <p><input type="file" class="" name="fileToUpload1"></p>
        
<p><button type="submit"  name="fileUploadSubmit" class="w3-right">
<i class="fa fa-upload fa-2x" aria-hidden="true"></i></button></p>                 
</form>   
</div>  
</div> <!-- file upload -->  
</div> <!-- report files table -->









































<?PHP include_layout_template('footer.php'); ?>