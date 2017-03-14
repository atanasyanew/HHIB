<?PHP 
require "../_Includes/initialize.php";
include_layout_template('header.php');
require_login_session('login.php');

//stranicata da sudurja tablica s link kum vsi4ki xls report failove 
?>


<?php
//general stuff
$host= gethostname();
$ip = gethostbyname($host);
$file = new FileManagement();
$file->specify_nonrelativedir('Reports');
$file->check_dir(); //make dir
$dirArray = $file->get_files_array(); //loop files

if (isset($_POST['fileUploadSubmit'])) { 
        
          if ($file->attach_file($_FILES['fileToUpload1'])) {  
                 $file->save_file();
          }  
            redirect_to("reports_overview.php");   

    } else {
    $messageError = join("<br />", $file->errors);
    echo $messageError;
    } //UPLOAD FILE

if (isset($_GET['deleteFile'])) {

      if ($file->delete_file($_GET['deleteFile'])) {
            redirect_to("reports_overview.php");  
      }
     } //DELETE FILE 




//echo $file->upload_dir . "<br>";
//echo $file->full_dir;
?>

<div class="w3-row-padding w3-margin">      
<div class="w3-twothird">
<div class="w3-container w3-border w3-teal"> 
<h6>Report files
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
        
$deleteFile = "<a class=\"{$ss->userPermissions('1000')}\" href='reports_overview.php?deleteFile={$dirArray[$index]}' ><i class=\"fa fa-trash fa-1x\" aria-hidden=\"true\"> Delete</i></a>";
             
print "<tr>";        
print "<td><a href=\"{$file_name}\" download>{$dirArray[$index]}</a></td>";      
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
    
<div class="w3-third <?php print $ss->userPermissions('1110'); ?>">
<div class="w3-container w3-border w3-teal"><h6>Качване на файлове</h6></div>
  
<div class="w3-section">      
<form class="w3-container w3-padding w3-border w3-small" 
      method="POST" 
      action="reports_overview.php"
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