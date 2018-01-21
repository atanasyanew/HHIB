<?php require_once(LIB_PATH.DS."config.php");

class MySQLDatabase {
	
	private $connection;
    
	public  $last_query;
    
	private $magic_quotes_active;
    
	private $real_escape_string_exists;
	
    function __construct() {
    $this->open_connection();
		$this->magic_quotes_active = get_magic_quotes_gpc();
		$this->real_escape_string_exists = function_exists( "mysql_real_escape_string" );
  }    

	public function open_connection() {
		$this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS);
		if (!$this->connection) {
			die("Database connection failed: " . mysqli_error());
		} else {
			$db_select = mysqli_select_db($this->connection, DB_NAME);
			if (!$db_select) {
				die("Database selection failed: " . mysqli_error());
			}
		}
	}         

	public function close_connection() {
		if(isset($this->connection)) {
			mysqli_close($this->connection);
			unset($this->connection);
		}
	}        

	public function query($sql) {
		$this->last_query = $sql;
		$result = mysqli_query($this->connection, $sql);
		$this->confirm_query($result);
		return $result;
	}               
	
	public function escape_value($value) {
		if( $this->real_escape_string_exists ) { // PHP v4.3.0 or higher
			// undo any magic quote effects so mysql_real_escape_string can do the work
			if( $this->magic_quotes_active ) { $value = stripslashes( $value ); }
			$value = mysqli_real_escape_string($this->connection, $value);
		} else { // before PHP v4.3.0
			// if magic quotes aren't already on then add slashes manually
			if( !$this->magic_quotes_active ) { $value = addslashes( $value ); }
			// if magic quotes are active, then the slashes already exist
		}
		return $value;
	}     
	
    public function fetch_array($result_set) {
    return mysqli_fetch_array($result_set);
  } 
    
    public function fetch_assoc($result_set) {
    return mysqli_fetch_assoc($result_set);
  }  
  
    public function num_rows($result_set) {
    return mysqli_num_rows($result_set);
  }     
  
    public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }
  
    public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }

    private function confirm_query($result) {
		if (!$result) {
	    $output = "Database query failed: " . mysqli_error($this->connection) . "<br /><br />";
	    die( $output );
		}
	}  
	
	public function update() {
	  global $database;
		// Don't forget your SQL syntax and good habits:
		// - UPDATE table SET key='value', key='value' WHERE condition
		// - single-quotes around all values
		// - escape all values to prevent SQL injection
		$attributes = $this->sanitized_attributes();
		$attribute_pairs = array();
		foreach($attributes as $key => $value) {
		  $attribute_pairs[] = "{$key}='{$value}'";
		}
		$sql = "UPDATE ".self::$table_name." SET ";
		$sql .= join(", ", $attribute_pairs);
		$sql .= " WHERE id=". $database->escape_value($this->id);
	  $database->query($sql);
	  return ($database->affected_rows() == 1) ? true : false;
	}
}
$database = new MySQLDatabase();
$db =& $database;


class Orders extends MySQLDatabase {
	
	protected static $table_name="orders";
    
    public $id;
    
    public $lastRevId;
    
    public $preRevId;
    
    public $fetchPreRev;
    
    
    protected static $db_fields=array('id', 
                                      'number', 
                                      'rev',
                                      'create_date', //date+time
                                      'create_by',   //real name from session
                                      'comment', 
                                      'history',     //session - history         
                                      'ico_preparedby',
                                      'ico_approvedby',
                                      'ico_subject',
                                      'ico_client',
                                      'ico_clientcountry',
                                      'ico_enduser',
                                      'ico_endusercountry',
                                      'ico_amount',
                                      'ico_amountcurrency',
                                      'ico_scopeofsupply',
                                      'ico_factorytests',
                                      'ico_deliveryterms',
                                      'ico_meansoftransport',
                                      'ico_warrantyperiod',
                                      'ico_attachments',
                                      'ico_notes',
                                      'ico_shippingdocuments',
                                      'ico_paymentway');

      public function find_all(){  
       return self::query("SELECT * FROM ".self::$table_name." ORDER BY id DESC");     
    }             
    
      public function find_all_unique(){        
         $sql  = "SELECT * FROM ".self::$table_name;
         $sql .= " WHERE (number, rev) IN ";
         $sql .= "(SELECT number, MAX(rev) FROM ".self::$table_name." GROUP BY number)";
         $sql .= " ORDER BY id DESC";    
         return self::query($sql);   
    }       
    
      public function find_all_revs($number) {      
         return self::query("SELECT * FROM ".self::$table_name." WHERE number='".$number."' ORDER BY id DESC");     
    } 
    
      public function find_last_rev($number) {   
         $sql = "SELECT * FROM ".self::$table_name." WHERE number='".$number."' ORDER BY rev DESC";      
         $result = self::query($sql);   
         $result = mysqli_fetch_assoc($result);  
         $this->lastRevId=$result['id'];
    } 
        
      public function delete() {
		global $database;
		// Don't forget your SQL syntax and good habits:
		// - DELETE FROM table WHERE condition LIMIT 1
		// - escape all values to prevent SQL injection
		// - use LIMIT 1
	    $sql = "DELETE FROM ".self::$table_name;
	    $sql .= " WHERE id=". $database->escape_value($this->id);
	    $sql .= " LIMIT 1";
	    $database->query($sql);
        // echo $sql;    
        return ($database->affected_rows() == 1) ? true : false;
	
		// NB: After deleting, the instance of User still 
		// exists, even though the database entry does not.
		// This can be useful, as in:
		//   echo $user->first_name . " was deleted";
		// but, for example, we can't call $user->update() 
		// after calling $user->delete().
	}              
      
      public function find_row_by_id($id=0) { 
         global $database;
         $result = self::query("SELECT * FROM ".self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1"); 
         return mysqli_fetch_assoc($result);
          //info:
          // $result_key = $orders->find_row_by_id($id="61");
          // print   $result_key['number'];
          //print $variable[key];
  }  
    
      public function find_by_sql($sql=""){
         global $database;
         $result_set = $database->query($sql); //make query based on func variable
         $object_array = array();
         while ($row = $database->fetch_array($result_set)) {
             $object_array[] = self::instantiate($row);
         }
         return $object_array;
  }
    
      public function find_by_id($id=0) {
	     global $database;
         $sql = "SELECT * FROM ".self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1"; 
         $result_array = self::find_by_sql($sql);
         return !empty($result_array) ? array_shift($result_array) : false;
  } 
    
      private function instantiate($record) {
        $object = new self;
		foreach($record as $attribute=>$value){
		  if($object->has_attribute($attribute)) {
		    $object->$attribute = $value;
		  }
		}
		return $object;
	}
	
	  private function has_attribute($attribute) {
         return array_key_exists($attribute, $this->attributes());
	}
  
	  public function attributes() { 
      // return an array of attribute names and their values
	    $attributes = array();
          foreach(self::$db_fields as $field) {
              if(property_exists($this, $field)) {
                  $attributes[$field] = $this->$field;
              }
          }
	  return $attributes;
	}
    
      protected function sanitized_attributes() {
	       global $database;
	       $clean_attributes = array();
	       // sanitize the values before submitting
	       // Note: does not alter the actual value of each attribute
	       foreach($this->attributes() as $key => $value){
	         $clean_attributes[$key] = $database->escape_value($value);
	       }
	       return $clean_attributes;
	}
      
      public function get_revision_value () {  
          global $database;
          // fetch last revission info from global lastRevId
          $lastRevInfo =  self::find_row_by_id($this->lastRevId); 
          if ($lastRevInfo['rev']==0) { 
              $revNumberAdd = 1;
          } else { 
              $revNumberAdd = ++$lastRevInfo['rev'];
          }
          return $revNumberAdd;   
    }

      public function check_order_number($number) {  
         self::query("SELECT * FROM ".self::$table_name." WHERE number='".$number."'");  
         return  self::affected_rows();
    }  

      public function create_order() {  
          
        global $database;
        global $db;    
  
        if(($scopeOfSupplyNumber = count($_GET['sos01'])) > 0) {   
         
             $arrayScope = array ();

             for($i=0; $i<$scopeOfSupplyNumber; $i++) {  
             
                $arrayScope[] = array( 'sos01' => $_GET['sos01'][$i],
                                       'sos02' => $_GET['sos02'][$i],
                                       'sos03' => $_GET['sos03'][$i],
                                       'sos04' => $_GET['sos04'][$i],
                                       'sos05' => $_GET['sos05'][$i],
                                       'sos06' => $_GET['sos06'][$i],
                                       'sos07' => $_GET['sos07'][$i],
                                       'sos08' => $_GET['sos08'][$i],
                                       'sos09' => $_GET['sos09'][$i],
                                       'sos10' => $_GET['sos10'][$i],
                                       'sos11' => $_GET['sos11'][$i],
                                       'sos12' => $_GET['sos12'][$i],
                                       'sos13' => $_GET['sos13'][$i],
                                       'sos14' => $_GET['sos14'][$i],
                                       'sos15' => $_GET['sos15'][$i],
                                       'sos16' => $_GET['sos16'][$i]
                                     );
             } 
            
            $arrayScopeAmount = array ();
            for ($k=0; $k<$scopeOfSupplyNumber; $k++) {  
            $arrayScopeAmount[] = ($_GET['sos02'][$k] * $_GET['sos03'][$k]);
            }    
                      
            }  
          
        $arrayApprove = array(

                    array( 'approveStatus' => 'Изработена', 
                           'stageNumber'   => '1', 
                           'stageTitle'    => 'Изготвяне ВФП',     
                           'approvedBy'    => $_SESSION['real_name'],
                           'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                           'approveComment'=>"" ),
            
                    array( 'approveStatus' => 'За Одобрение', 
                           'stageNumber'   => '2', 
                           'stageTitle'    => 'Одобрение ВФП',     
                           'approvedBy'    => "", 
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Изработване", 
                           'stageNumber'   => "3", 
                           'stageTitle'    => "ПП Изработване СР",      
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Изработване",  
                           'stageNumber'   => "4", 
                           'stageTitle'    => "ПП Изработване МЗ",     
                           'approvedBy'    => "", 
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Одобрение", 
                           'stageNumber'   => "5", 
                           'stageTitle'    => "ПП Одобрение СР",      
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Одобрение", 
                           'stageNumber'   => "6", 
                           'stageTitle'    => "ПП Одобрение МЗ",      
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
                     
                    array( 'approveStatus' => "За Одобрение", 
                           'stageNumber'   => "7", 
                           'stageTitle'    => "Утвърждаване на ПП",    
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" )
                );  
          
          if ($_GET['comment']=="") {
              $comment = "";
          } else {
              $comment = comment_msg_format($_GET['comment']);
          }
          
              
        $sql  = "INSERT INTO ".self::$table_name." (";    
        $sql .= "number, ";                   
        $sql .= "rev, ";                     
        $sql .= "create_date, ";             
        $sql .= "create_by, ";               
        $sql .= "comment, ";                 
        $sql .= "history, ";                 
        $sql .= "ico_preparedby, ";         
        //$sql .= "ico_approvedby, ";        
        $sql .= "ico_subject, ";             
        $sql .= "ico_client, ";              
        $sql .= "ico_clientcountry, ";        
        $sql .= "ico_enduser, ";             
        $sql .= "ico_endusercountry, ";     
        $sql .= "ico_amount, ";               
        $sql .= "ico_amountcurrency, ";      
        $sql .= "ico_scopeofsupply, ";        
        $sql .= "ico_factorytests, ";         
        $sql .= "ico_deliveryterms, ";       
        $sql .= "ico_meansoftransport, ";     
        $sql .= "ico_warrantyperiod, ";       
        $sql .= "ico_attachments, ";          
        $sql .= "ico_notes, ";                
        $sql .= "ico_shippingdocuments, ";    
        $sql .= "ico_paymentway, ";             
        $sql .= "approve";

        $sql .= ") VALUES ("; // volues for columns

        $sql .= "'{$db->escape_value(trim($_GET['number']))}',";           
        $sql .= "'{$db->escape_value($_GET['rev'])}',";                 
        $sql .= "'{$_GET['create_date']} {$_GET['create_time']}',";        
        $sql .= "'{$db->escape_value($_SESSION['real_name'])}',"; 
          
        $sql .= "'{$db->escape_value($comment)}',"; 
          
        $sql .= "'{$db->escape_value($_SESSION['history_msg'])}',";          
        $sql .= "'{$db->escape_value($_GET['ico_preparedby'])}',"; 
        //$sql .= "ico_approvedby, ";         //$sql .= "'',";        
        $sql .= "'{$db->escape_value($_GET['ico_subject'])}',";                   
        $sql .= "'{$db->escape_value($_GET['ico_client'])}',";           
        $sql .= "'{$db->escape_value($_GET['ico_clientcountry'])}',";       
        $sql .= "'{$db->escape_value($_GET['ico_enduser'])}',";           
        $sql .= "'{$db->escape_value($_GET['ico_endusercountry'])}',";          
        $sql .= "'{$db->escape_value(array_sum($arrayScopeAmount))}',";   
        $sql .= "'{$db->escape_value($_GET['ico_amountcurrency'])}',"; 
        $sql .= "'{$db->escape_value(serialize($arrayScope))}',";                   
        $sql .= "'{$db->escape_value($_GET['ico_factorytests'])}',";        
        $sql .= "'{$db->escape_value($_GET['ico_deliveryterms'])}',";  
        $sql .= "'{$db->escape_value($_GET['ico_meansoftransport'])}',";            
        $sql .= "'{$db->escape_value($_GET['ico_warrantyperiod'])}',";         
        $sql .= "'{$db->escape_value($_GET['ico_attachments'])}',";        
        $sql .= "'{$db->escape_value($_GET['ico_notes'])}',"; 
        $sql .= "'{$db->escape_value($_GET['ico_shippingdocuments'])}',"; 
        $sql .= "'{$db->escape_value($_GET['ico_paymentway'])}', ";            
        $sql .= "'{$db->escape_value(serialize($arrayApprove))}' ";                 
        $sql .= ")";  
    
     unset ($_SESSION['history_msg']);
     $database->query($sql);
     $idOfNewRecord = $database->insert_id(); //get last id
     $page ='orders_details.php?order_id='.$idOfNewRecord; //generate page link
     echo "<meta http-equiv='refresh' content='0;URL=".$page."'>"; //redirect
     }

      public function update_order() {
      
      global $db;   
          
     if (($scopeOfSupplyNumber = count($_GET['sos01'])) > 0) {   
         $arrayScope = array ();
         for ($i=0; $i<$scopeOfSupplyNumber; $i++) {  

             $arrayScope[] = array( 'sos01' => $_GET['sos01'][$i],
                                    'sos02' => $_GET['sos02'][$i],
                                    'sos03' => $_GET['sos03'][$i],
                                    'sos04' => $_GET['sos04'][$i],
                                    'sos05' => $_GET['sos05'][$i],
                                    'sos06' => $_GET['sos06'][$i],
                                    'sos07' => $_GET['sos07'][$i],
                                    'sos08' => $_GET['sos08'][$i],
                                    'sos09' => $_GET['sos09'][$i],
                                    'sos10' => $_GET['sos10'][$i],
                                    'sos11' => $_GET['sos11'][$i],
                                    'sos12' => $_GET['sos12'][$i],
                                    'sos13' => $_GET['sos13'][$i],
                                    'sos14' => $_GET['sos14'][$i],
                                    'sos15' => $_GET['sos15'][$i],
                                    'sos16' => $_GET['sos16'][$i] );
            }   

         $arrayScopeAmount = array ();
         for ($k=0; $k<$scopeOfSupplyNumber; $k++) {  

             $arrayScopeAmount[] = ($_GET['sos02'][$k] * $_GET['sos03'][$k]);
            }    

         $ico_scopeofsupply = serialize($arrayScope);   
         $ico_amount = array_sum($arrayScopeAmount);    
     }     
          if ($_GET['comment']=="") {
              $comment = "";
          } else {
              $comment = comment_msg_format($_GET['comment']);
          }
          
 $sql  = "UPDATE ".self::$table_name." SET ";                    
          // $sql .= "number='" . $db->escape_value($_GET['number']) . "', ";       
          // $sql .= "rev='" . $db->escape_value($_GET['rev']) . "', ";           
          // $sql .= "create_date='" . $db->escape_value($_GET['create_date']) . "', ";  
          // $sql .= "create_by='" . $db->escape_value($_GET['create_by']) . "', ";        
          // $sql .= "send_date='" . $db->escape_value($_GET['send_date']) . "', ";       
          // $sql .= "send_by='" . $db->escape_value($_GET['send_by']) . "', ";         
 
 $sql .= "comment=CONCAT('{$db->escape_value($comment)}', comment), ";  
         
 $sql .= "history=CONCAT('".$db->escape_value($_SESSION['history_msg'])."', history), ";      
 $sql .= "ico_preparedby='" . $db->escape_value($_GET['ico_preparedby']) . "', ";     
 //$sql .= "ico_approvedby='" . $db->escape_value($_GET['ico_approvedby']) . "', ";      
 $sql .= "ico_subject='" . $db->escape_value($_GET['ico_subject']) . "', ";       
 $sql .= "ico_client='" . $db->escape_value($_GET['ico_client']) . "', ";       
 $sql .= "ico_clientcountry='" . $db->escape_value($_GET['ico_clientcountry']) . "', ";     
 $sql .= "ico_enduser='" . $db->escape_value($_GET['ico_enduser']) . "', ";      
 $sql .= "ico_endusercountry='" . $db->escape_value($_GET['ico_endusercountry']) . "', ";       
 $sql .= "ico_amount='" . $ico_amount . "', ";        
 $sql .= "ico_amountcurrency='" . $db->escape_value($_GET['ico_amountcurrency']) . "', ";     
 $sql .= "ico_scopeofsupply='" .  $ico_scopeofsupply . "', ";                  
 $sql .= "ico_factorytests='" . $db->escape_value($_GET['ico_factorytests']) . "', ";        
 $sql .= "ico_deliveryterms='" . $db->escape_value($_GET['ico_deliveryterms']) . "', ";     
 $sql .= "ico_meansoftransport='" . $db->escape_value($_GET['ico_meansoftransport']) . "', ";    
 $sql .= "ico_warrantyperiod='" . $db->escape_value($_GET['ico_warrantyperiod']) . "', ";           
 $sql .= "ico_attachments='" . $db->escape_value($_GET['ico_attachments']) . "', ";       
 $sql .= "ico_notes='" . $db->escape_value($_GET['ico_notes']) . "', ";       
 $sql .= "ico_shippingdocuments='" . $db->escape_value($_GET['ico_shippingdocuments']) . "', "; 
 $sql .= "ico_paymentway='" . $db->escape_value($_GET['ico_paymentway']) . "' ";               
        
 $sql .= " WHERE id='". $db->escape_value($_GET['order_id']) . "' ";
 
 $db->query($sql); 
 unset ($_SESSION['history_msg']);  
       
 $page ='orders_details.php?order_id='.$_GET['order_id']; 
 echo "<meta http-equiv='refresh' content='0;URL=".$page."'>"; 
          
   // echo $page;   //test        
   // $test = str_replace("', ","'<br>",$sql);
   // print_r($sql);
     }

      public function find_last_prev($number) { 
          $sql = "SELECT * FROM ".self::$table_name." WHERE number='".$number."' ORDER BY id LIMIT 1  OFFSET 1";   
          $result = self::query($sql);   
          $result = mysqli_fetch_assoc($result);   
        // $this->lastRevId=$result['id']; //Find last rev id, asign to global $lastRevId.
          return $result['id'];
    } 
    
      public static function count_all_unique() {
          global $database;
          $sql = "SELECT COUNT(*) FROM ".self::$table_name;
          $sql .= " WHERE (number, rev) IN ";
          $sql .= "(SELECT number, MAX(rev) FROM ".self::$table_name." GROUP BY number)";
          $sql .= " ORDER BY id DESC"; 
          
          $result_set = $database->query($sql);
          $row = $database->fetch_array($result_set);
          return array_shift($row);
          //return $database->num_rows($row);
        }
    
      public function find_by_pagination($limit, $offset) {   
         $sql  = "SELECT * FROM ".self::$table_name;
         $sql .= " WHERE (number, rev) IN ";
         $sql .= "(SELECT number, MAX(rev) FROM ".self::$table_name." GROUP BY number) "; 
         $sql .= "ORDER BY id DESC ";
         $sql .= "LIMIT {$limit} "; 
	     $sql .= "OFFSET {$offset}";
         return self::query($sql);     
    }     
    
      public function search_by_sql ($number, $rev, $create_date, $create_by, $ico_client, $ico_clientcountry) {
          $sql  = "SELECT * FROM ".self::$table_name . " ";
          $sql .= "WHERE number LIKE '%$number%' ";
          $sql .= "AND rev LIKE '%$rev%' ";
          $sql .= "AND create_date LIKE '%$create_date%' ";  
          $sql .= "AND create_by LIKE '%$create_by%' ";
          $sql .= "AND ico_enduser LIKE '%$ico_client%' ";
          $sql .= "AND ico_endusercountry LIKE '%$ico_clientcountry%' "; 
          $sql .= "ORDER BY id DESC";             
          return self::query($sql);   
        }
    
      public function update_history($msg=""){
          global $db;
          $datetime  =  strftime('%Y-%m-%d %H:%M');  
          $real_name =  $_SESSION['real_name'];         
          $history_string = "[" . $datetime . "] [" . $real_name . "] [" . $msg . "].\r\n";
        
          $sql  = "UPDATE ".self::$table_name." SET ";              
          $sql .= "history=CONCAT('".$db->escape_value($history_string)."', history) "; 
          $sql .= "WHERE id='". $db->escape_value($this->id) . "'";
          $db->query($sql);     
    }  
        
      public function updateComment($msg=""){
          global $db;
          
          if ($_GET['comment']=="") {
              $comment = "";
          } else {
              $comment = comment_msg_format($_GET['comment']);
          }
          
          $sql  = "UPDATE ".self::$table_name." SET ";              
          $sql .= "comment=CONCAT('{$db->escape_value($comment)}', comment) ";   
          $sql .= "WHERE id='{$db->escape_value($this->id)}' ";
          $db->query($sql); 
        
           $page ="orders_details.php?order_id={$this->id}"; 
           echo "<meta http-equiv='refresh' content='0;URL={$page}'>";
    }  
    
      public function applyRevColor($varNew, $varOld){      
         if ($this->preRevId != null) {
                 if ($varNew != $varOld) {
                        return "w3-text-deep-orange";
                 } else {
                   //return " ednakvi no color";
                        return "";
                 }
         } else {
            //return "no id, no prerev";  
            return "";  
         }     
    }  
      
      public function findPreRev($number, $rev){ 
           global $db;   
           if ($rev>0) {
               $rev = $rev-1; //rev is intiger in db 
               $sql  = "SELECT * FROM ".self::$table_name." WHERE number='".$number."' ";
               $sql .= "AND rev='".$rev."'";   
               $query = self::query($sql); 
               if ($db->num_rows($query)==1) {
                   $result = mysqli_fetch_assoc($query); 
                   $this->fetchPreRev = $result;
                   $this->preRevId = $result['id'];
               }
           } else { 
                $this->preRevId = null;
                  }    
           }
  
      public function updateAprroveField($approveKey) {
         
        //INFO:
          
        // $dbApproveArray     //main array from db to operate   
        // $newArrayApprove    //new array for replaceing old one
        // $arrayForUpperKey   //optional array to apply IF->$newArrayApprove stat is canceleted
        // $approveKey         //key we give to this function  
          
        global $db; 

        $dbArray = self::find_row_by_id($this->id); 
        $dbApproveArray = unserialize($dbArray['approve']);
        $approveKey; 

        //ON CHECKBOX APPROVE 
        if ( isset($_GET['chkApprove']) ) {  
                  
            if ($dbApproveArray[$approveKey]['approveStatus'] == "За Изработване" ) {      
                $newArrayApprove = array (
                    'approveStatus' => 'Изработена',                     
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'],                     
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],                          
                    'approvedBy'    => $_SESSION['real_name'],                
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),                    
                    'approveComment'=> $_GET['textApprove']
                );
                
            } elseif ($dbApproveArray[$approveKey]['approveStatus'] == "За Одобрение" xor 
                      $dbApproveArray[$approveKey]['approveStatus'] == "Отказано Одобрение" ){          
                $newArrayApprove = array ( 
                    'approveStatus' => 'Одобрена', 
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $_SESSION['real_name'], 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> $_GET['textApprove']
                );     
                
            } else { //prevent error    
                $newArrayApprove = array ( 
                    'approveStatus' => $dbApproveArray[$approveKey]['approveStatus'],
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $dbApproveArray[$approveKey]['approvedBy'], 
                    'approvedDate'  => $dbApproveArray[$approveKey]['approvedDate'],
                    'approveComment'=> $dbApproveArray[$approveKey]['approveComment'] 
                ); 
            };
            
        //apply the new approve array to the existing one
        $dbApproveArray[$approveKey] = $newArrayApprove;
        $modifiedArray = $dbApproveArray;
            
        //Prepare text for history msg  
        $hmsg  = $newArrayApprove['approveStatus'] . " - ";
        $hmsg .= $newArrayApprove['stageNumber'] . ". ";
        $hmsg .= $newArrayApprove['stageTitle']; 
        }

        //ON CHECKBOX CANCEL  
        if ( isset($_GET['chkCancel']) ) { 
                
            if ($dbApproveArray[$approveKey]['approveStatus'] == "За Одобрение" xor
                $dbApproveArray[$approveKey]['approveStatus'] == "Отказано Одобрение"){
                
                $newArrayApprove = array (
                    'approveStatus' => 'Отказано Одобрение', 
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $_SESSION['real_name'], 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> $_GET['textApprove'] 
                );   
                
            } else { //prevent error
                $newArrayApprove = array (
                    'approveStatus' => $dbApproveArray[$approveKey]['approveStatus'],
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $dbApproveArray[$approveKey]['approvedBy'], 
                    'approvedDate'  => $dbApproveArray[$approveKey]['approvedDate'],
                    'approveComment'=> $dbApproveArray[$approveKey]['approveComment'] 
                );
                
            }
            
        //apply 1st array 
        $dbApproveArray[$approveKey] = $newArrayApprove;

                //conditions to get key for updating upper/second array
                if (($approveKey==(int)6)) {
                   $modifiedKeyForUpperArray = $approveKey;
                }
                elseif ( ($approveKey==(int)4) xor ($approveKey==(int)5) ) {
                    $modifiedKeyForUpperArray = $approveKey-(int)2;
                } else {
                    $modifiedKeyForUpperArray = $approveKey-(int)1;
                }
        
                $arrayForUpperKey = array (
                    'approveStatus' => 'За Изработване', 
                    'stageNumber'   => $dbApproveArray[$modifiedKeyForUpperArray]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$modifiedKeyForUpperArray]['stageTitle'],     
                    'approvedBy'    => '', 
                    'approvedDate'  => '',
                    'approveComment'=> $_GET['textApprove']
                ); 
                   
        //apply second array
        $dbApproveArray[$modifiedKeyForUpperArray] = $arrayForUpperKey;
        //masterpiece array    
        $modifiedArray = $dbApproveArray; 
            
            
        //Prepare text for history msg  
        $hmsg  = $newArrayApprove['approveStatus'] . " - ";
        $hmsg .= $newArrayApprove['stageNumber'] . ". ";
        $hmsg .= $newArrayApprove['stageTitle'];    
        }
          
        //ON CHECKBOX UNLOCK 
        if ( isset($_GET['chkUnlock']) ) {
            $approveKeyFromCheckBox = $_GET['chkUnlock']; //check box has array key for each row
            
            if ($dbApproveArray[$approveKeyFromCheckBox]['approveStatus'] == "Изработена" ) {
                $newArrayApprove = array (
                    'approveStatus' => 'За Изработване', 
                    'stageNumber'   => $dbApproveArray[$approveKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKeyFromCheckBox]['stageTitle'], 
                    'approvedBy'    => '', 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> "[окл. от: " . $_SESSION['real_name'] . "] " . $_GET['textApprove'] 
                );
                
            } elseif ($dbApproveArray[$approveKeyFromCheckBox]['approveStatus'] == "Одобрена" ){
                $newArrayApprove = array ( 
                    'approveStatus' => 'За Одобрение', 
                    'stageNumber'   => $dbApproveArray[$approveKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKeyFromCheckBox]['stageTitle'],     
                    'approvedBy'    => '', 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> "[окл. от: " .  $_SESSION['real_name'] . "] " . $_GET['textApprove']  
                                          );      
            } else { //prevent error
                
                $newArrayApprove = array ( 
                    'approveStatus' => $dbApproveArray[$approveKeyFromCheckBox]['approveStatus'],
                    'stageNumber'   => $dbApproveArray[$approveKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKeyFromCheckBox]['stageTitle'],     
                    'approvedBy'    => $dbApproveArray[$approveKeyFromCheckBox]['approvedBy'], 
                    'approvedDate'  => $dbApproveArray[$approveKeyFromCheckBox]['approvedDate'],
                    'approveComment'=> $dbApproveArray[$approveKeyFromCheckBox]['approveComment']
                                          );
            }
            
            //apply the new approve array to the existing one
            $dbApproveArray[$approveKeyFromCheckBox] = $newArrayApprove;
            $modifiedArray = $dbApproveArray;
            
            //MODIFY text for history msg
            $hmsg  = "откл. на етап: ";
            $hmsg .= ". сменен статус на: ";
            $hmsg .= $newArrayApprove['approveStatus'] . " - ";
            $hmsg .= $newArrayApprove['stageNumber'] . ". ";
            $hmsg .= $newArrayApprove['stageTitle'];  
        }
 
          
        if ( isset($_GET['chkDeletePossition']) ) {  
            $deleteKeyFromCheckBox = $_GET['chkDeletePossition']; //check box has array key for each row 

            $newArrayApprove = array (
                    'approveStatus' => 'Одобрена', 
                    'stageNumber'   => $dbApproveArray[$deleteKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => 'ПРЕМАХНАТ ЕТАП', 
                    'approvedBy'    => $_SESSION['real_name'], 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> "[Премахнат: " . $_SESSION['real_name'] . "] " . $_GET['textApprove'] 
                );

             $dbApproveArray[$deleteKeyFromCheckBox] = $newArrayApprove;
             $modifiedArray = $dbApproveArray;

             //MODIFY text for history msg
             $hmsg  = "Премахна етап: ";
             $hmsg .= $dbApproveArray[$deleteKeyFromCheckBox]['stageNumber'] . ". ";
             $hmsg .= $dbApproveArray[$deleteKeyFromCheckBox]['stageTitle'];  
        }
          
        session_history_msg($hmsg); 
          
            //MAINTENANCE:
          /*
                    //echo "<pre>";
                    //echo "<h2>ARRAY FROM DB</h2>";
                    //print_r($dbApproveArray);
                    //echo "</pre><br>";
     
           
            echo "<div class=\"w3-container w3-indigo\">";
          
                 echo "<div class=\"w3-container\">";
                    echo "<h1> REPLACE ARRAY FROM DB WITH THE NEW MODIFYTED ARRAY <h1>";
                    echo "<h5>1st replaced array key is: " . $approveKey . "</h5>";
                    $secondArraykey = ((isset($_GET['chkUnlock'])) ? $approveKeyFromCheckBox : "no key");
                    echo "<h5>for unlock - replaced array key is: ". $secondArraykey . "</h5>";
                    $secondArraykey = ((isset($_GET['chkCancel'])) ? $modifiedKeyForUpperArray : "no key");
                    echo "<h5>for cancel - replaced upper array key is: ". $secondArraykey . "</h5>";
                 echo "</div>";

                    echo "<div class=\"w3-row\">";
          
                            echo "<div class=\"w3-half w3-container\">";
                            echo "<p> Original Array is: </p>";
                            echo "<pre>";
                            print_r(unserialize($dbArray['approve']));
                            echo "</pre>";             
                            echo "</div>";

                            echo "<div class=\"w3-half w3-container\">";
                            echo "<p> Modifyted Array is: </p>";
                            echo "<pre>";
                            print_r($modifiedArray);
                            echo "</pre>";  
                            echo "</div>";
          
                    echo "</div>";
          
            echo "</div>";
            */
       
            //  /*
       $sql  = "UPDATE ".self::$table_name." SET "; 
       $sql .= "history=CONCAT('".$db->escape_value($_SESSION['history_msg'])."', history), ";     
       $sql .= "approve='" . serialize($modifiedArray) . "' "; 
       $sql .= "WHERE id='". $db->escape_value($this->id) . "' "; 

            //MAINTENANCE:
                    //echo "<pre>";
                    //echo $sql ;  
                    //echo "</pre><br>"; 
           
        $db->query($sql); 
        unset ($_SESSION['history_msg']);  
        $page ='orders_details.php?order_id='.$this->id; 
                    //echo $page . "<br>"; 
        echo "<meta http-equiv='refresh' content='0;URL=".$page."'>";   
            // */
      }
    
      public function getNextOrderNumber () {
          
          $year = date("y");
          //$year = "17";
          
          $sql  = "SELECT number FROM ".self::$table_name." "; 
          $sql .= "WHERE MID(number,4,2)='{$year}' ";
          $sql .= "ORDER BY MID(number,7,3) DESC";
          $result = self::query($sql);  //return all records with this year
         
          if (mysqli_num_rows($result)==0) {   
              //echo "RS-".$year."-001";
              $nextNumberIs = "RS-".$year."-001";
              
          } else {
              $rows = []; 
              while($row = mysqli_fetch_array($result))
              {
                  $rows[] = substr($row['number'],6,3);
              }

              //echo "<pre>";
              //print_r($rows);
              //echo "</pre><br>";
              //echo "next number: ". max($rows)."<br>" ;
              $number = max($rows)+1;
              $number = str_pad($number, 3, "0", STR_PAD_LEFT);
              $nextNumberIs = "RS-".$year."-".$number;
          }
           
          return $nextNumberIs;
      }
    
    

}


class FileManagement { 
      
    public $filename;
    
	public $type;
    
	public $size;
    
	private $temp_path;
    
    public $upload_dir;
    
    public $full_dir;
    
    public $downloadUrl;

    public $dbFolder = 'HHIBFILEDB'; //also in initialuize
    
    public $errors=array();
    
    protected $upload_errors = array(
      // http://www.php.net/manual/en/features.file-upload.errors.php
      UPLOAD_ERR_OK 				=> "No errors.",
      UPLOAD_ERR_INI_SIZE       	=> "Larger than upload_max_filesize.",
	  UPLOAD_ERR_FORM_SIZE 	        => "Larger than form MAX_FILE_SIZE.",
	  UPLOAD_ERR_PARTIAL 		    => "Partial upload.",
	  UPLOAD_ERR_NO_FILE 		    => "No file.",
	  UPLOAD_ERR_NO_TMP_DIR         => "No temporary directory.",
	  UPLOAD_ERR_CANT_WRITE         => "Can't write to disk.",
	  UPLOAD_ERR_EXTENSION 	        => "File upload stopped by extension."
	);
    
	// Pass in $_FILE(['uploaded_file']) as an argument
   
    public function specify_dirs($mainFolder, $subjectNumber, $revFolder) {
        $yearFolder = substr($subjectNumber, 3, 2); 
        $revFolder = $subjectNumber."-REV.".$revFolder;
        $this->upload_dir = $mainFolder . DS . $yearFolder . DS . $subjectNumber . DS . $revFolder;
        $this->full_dir = FILES_DB . DS . $this->upload_dir. DS;  
        $host= gethostname();
        $ip = gethostbyname($host);
        $this->downloadUrl = "http://".$ip.DS.$this->dbFolder.DS.$this->upload_dir . DS;  
        //assign upload dir var
    }
    
    public function specify_dirsPO($mainFolder, $subjectNumber, $folderPO) {
        $yearFolder = substr($subjectNumber, 3, 2); 
        $revFolder = $subjectNumber.$folderPO;
        $this->upload_dir = $mainFolder . DS . $yearFolder . DS . $subjectNumber . DS . $folderPO;
        $this->full_dir = FILES_DB . DS . $this->upload_dir. DS;  
        $host= gethostname();
        $ip = gethostbyname($host);
        $this->downloadUrl = "http://".$ip.DS.$this->dbFolder.DS.$this->upload_dir . DS;  
        //assign upload dir var
    }
    
    public function specify_nonrelativedir($nonRelativeDir="") {
           
        $this->upload_dir = $nonRelativeDir;
        $this->full_dir = FILES_DB . DS . $this->upload_dir. DS;  
        
        $host= gethostname();
        $ip = gethostbyname($host);
        $this->downloadUrl = "http://".$ip.DS.$this->dbFolder.DS.$this->upload_dir . DS;  
        //assign upload dir var
    }
    
    public function check_dir() {
        if (!is_dir($this->full_dir)) {    
            mkdir($this->full_dir, 0777, true);
        }
    }
    
    public function attach_file($file) {
		// Perform error checking on the form parameters
		if(!$file || empty($file) || !is_array($file)) {
		  // error: nothing uploaded or wrong argument usage
		  $this->errors[] = "No file was uploaded.";
		  return false;   
		} elseif($file['error'] != 0) {
		  // error: report what PHP says went wrong
		  $this->errors[] = $this->upload_errors[$file['error']];
		  return false;
		} else {
			// Set object attributes to the form parameters.
		  $this->temp_path  = $file['tmp_name'];
		  $this->filename   = basename($file['name']);
		  $this->type       = $file['type'];
		  $this->size       = $file['size'];
          return true;
		}
	}
   
	public function save_file() {
         //Can't save if there are pre-existing errors
		  if(!empty($this->errors)) { 
              return false; 
          }
		  // Can't save without filename and temp location
		  if(empty($this->filename) || empty($this->temp_path)) {
		    $this->errors[] = "The file location was not available.";
		    return false;
		  }
			// Determine the target_path
		  $target_path = FILES_DB .DS. $this->upload_dir .DS. $this->filename;
		  // Make sure a file doesn't already exist in the target location
		  if(file_exists($target_path)) {
		    $this->errors[] = "The file {$this->filename} already exists.";
		    return false;
		  }
			// Attempt to move the file 
			if(move_uploaded_file($this->temp_path, $target_path)) {
            // Success	
            // We are done with temp_path, the file isn't there anymore
            //unset($this->temp_path;);
            return true;	
			} else {
            // File was not moved.
		    $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
		    return false;
			}
		}
	
	public function get_files_array(){   
        $openDirectory = opendir($this->full_dir);
        while($entryName = readdir($openDirectory)) {
           $dirArray[] = $entryName;
        }
        
        return $dirArray;
}
      
    public function delete_file($fileToDelete){  
         if (unlink($this->full_dir . $fileToDelete)){
             return true;
         } 
            else {return false;}
         } 

    public function dir_fix () {
        $hd = opendir($this->full_dir);
        closedir($hd); //fix bugs
    }
    
    public function destroy($path) {   
        if (is_dir($path) === true) {
            $files = array_diff(scandir($path), array('.', '..'));
            foreach ($files as $file) {
               $this->destroy(realpath($path) . '/' . $file);
            } 
            $hd = opendir($path);
            closedir($hd);
            return rmdir($path);
        }
        else if (is_file($path) === true) {
            return unlink($path);
        } 
        return false;
    }
	
	public function file_path() {    
	  return $this->upload_dir.DS.$this->filename;
	}
	
	public function size_as_text($dirAndFile) {
        $file_size = filesize($dirAndFile);    
        if($file_size < 1024) {
			$var = $file_size . " bytes";           
		} elseif($file_size < 1048576) {
			$file_size = round($file_size/1024);
			$var = $file_size . " KB";                 
		} else {
			$file_size = round($file_size/1048576, 1);
			$var = $file_size . " MB";
		}
        return $var;
    }
          
}      


class Offers extends MySQLDatabase {
    
    protected static $table_name="offers";
    
    public $id;
    
    public $lastRevId;
    
    protected static $db_fields=array('id', 
                                      'number', 
                                      'rev', 
                                      'create_date', 
                                      'create_by',    
                                      'comment', 
                                      'history',
                                      'approve' 
                                    );

      public function find_all(){  
          return self::query("SELECT * FROM ".self::$table_name." ORDER BY id DESC");     
    }  
    
      public function find_row_by_id($id=0){ 
          global $database;
      $sql = "SELECT * FROM ".self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1";
          $result = self::query($sql); 
          return mysqli_fetch_assoc($result);
            //info:
            // $result_key = $orders->find_row_by_id($id="61");
            // print   $result_key['number'];
            //print $variable[key];
      } 
    
      public function delete() {
		 global $database;
	     $sql = "DELETE FROM ".self::$table_name;
	     $sql .= " WHERE id=". $database->escape_value($this->id);
	     $sql .= " LIMIT 1";
 	     $database->query($sql);
         return ($database->affected_rows() == 1) ? true : false;
	} 
    
      public function find_all_unique(){  
         $sql  = "SELECT * FROM ".self::$table_name;
         $sql .= " WHERE (number, rev) IN ";
         $sql .= "(SELECT number, MAX(rev) FROM ".self::$table_name." GROUP BY number)";
         $sql .= " ORDER BY id DESC";
         return self::query($sql);     
    }       
    
      public function find_all_revs($number){  
         return self::query("SELECT * FROM ".self::$table_name." WHERE number='".$number."' ORDER BY id DESC");     
    } 
    
      public function find_last_rev($number){ 
         $sql = "SELECT * FROM ".self::$table_name." WHERE number='".$number."' ORDER BY rev DESC";  
         $result = self::query($sql);   
         $result = mysqli_fetch_assoc($result);  
         $this->lastRevId=$result['id'];
    } 
        
      public function check_for_number($number){  
         self::query("SELECT * FROM ".self::$table_name." WHERE number='".$number."'");  
         return  self::affected_rows();
    }    
    
      public function create_record(){
 
        global $db;
  
        $arrayApprove = array(

                    array( 'approveStatus' => "За Изработване", 
                           'stageNumber'   => "1", 
                           'stageTitle'    => "Изработване СР",      
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Изработване",  
                           'stageNumber'   => "2", 
                           'stageTitle'    => "Изработване МЗ",     
                           'approvedBy'    => "", 
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Одобрение", 
                           'stageNumber'   => "3", 
                           'stageTitle'    => "Одобрение СР",      
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
            
                    array( 'approveStatus' => "За Одобрение", 
                           'stageNumber'   => "4", 
                           'stageTitle'    => "Одобрение МЗ",      
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" ),
                     
                    array( 'approveStatus' => "За Одобрение", 
                           'stageNumber'   => "5", 
                           'stageTitle'    => "Утвърждаване (За изпращане)",    
                           'approvedBy'    => "",  
                           'approvedDate'  => "",
                           'approveComment'=> "" )
                );  
          
          
         if ($_GET['comment']=="") {
              $comment = "";
          } else {
              $comment = comment_msg_format($_GET['comment']);
          }     

         $sql  = "INSERT INTO ".self::$table_name." (";    
         $sql .= "number, ";                   
         $sql .= "rev, ";                      
         $sql .= "create_date, ";              
         $sql .= "create_by, ";                                   
         $sql .= "comment, ";           
         $sql .= "history, "; 
         $sql .= "approve"; 
         $sql .= ") VALUES ("; 
          
         $sql .= "'{$db->escape_value($_GET['number'])}',";   
         $sql .= "'{$db->escape_value($_GET['rev'])}',";   
         $sql .= "'{$_GET['create_date']} {$_GET['create_time']}',";        
         $sql .= "'{$db->escape_value($_SESSION['real_name'])}',";            
         $sql .= "'{$db->escape_value($comment)}',";        
         $sql .= "'{$db->escape_value($_SESSION['history_msg'])}', ";
         $sql .= "'{$db->escape_value(serialize($arrayApprove))}' "; 
         $sql .= ")";      
    
         unset ($_SESSION['history_msg']); 
         $db->query($sql);   
         // print_r($sql); 
         $page ='offer_details.php?subjectId='.$db->insert_id();
         echo "<meta http-equiv='refresh' content='0;URL=".$page."'>"; 
     }
        
      public function update_offer_details(){  
    
          global $db;  
           if ($_GET['comment']=="") {
              $comment = "";
          } else {
              $comment = comment_msg_format($_GET['comment']);
          }
          
          $sql  = "UPDATE ".self::$table_name." SET ";   
          $sql .= "send_date='{$_GET['send_date']} {$_GET['send_time']}', ";
          $sql .= "send_to='" . $db->escape_value($_GET['send_to']) . "', "; 
          $sql .= "send_by='" . $db->escape_value($_GET['send_by']) . "', ";   
          $sql .= "comment=CONCAT('{$db->escape_value($comment)}', comment), ";       
          $sql .= "history=CONCAT('".$db->escape_value($_SESSION['history_msg'])."', history) ";    
          $sql .= "WHERE id='". $db->escape_value($_GET['subjectId']) . "'";
     
          $db->query($sql); 
          session_history_msg("");    //session msg clear      
          $page ='offer_details.php?subjectId='.$_GET['subjectId'];          
          echo "<meta http-equiv='refresh' content='0;URL=".$page."'>"; 
     }  // for del
        
      public function get_revision_value (){ 
          $lastRevInfo =  self::find_row_by_id($this->lastRevId); 
          if ($lastRevInfo['rev']==0) { 
              $revNumberAdd = 1;
          } else { 
              $revNumberAdd = ++$lastRevInfo['rev'];
          }
          return $revNumberAdd;   
    }
    
      public static function count_all_unique() {
          global $database;
          $sql = "SELECT COUNT(*) FROM ".self::$table_name;
          $sql .= " WHERE (number, rev) IN ";
          $sql .= "(SELECT number, MAX(rev) FROM ".self::$table_name." GROUP BY number)";
          $sql .= " ORDER BY id DESC"; 
          $result_set = $database->query($sql);
          $row = $database->fetch_array($result_set);
          return array_shift($row);
          // return $database->num_rows($row);
        }
    
      public function find_by_pagination($limit, $offset) {  
          $sql  = "SELECT * FROM ".self::$table_name;
          $sql .= " WHERE (number, rev) IN ";
          $sql .= "(SELECT number, MAX(rev) FROM ".self::$table_name." GROUP BY number) ";
          $sql .= "ORDER BY id DESC ";
          $sql .= "LIMIT {$limit} "; 
	      $sql .= "OFFSET {$offset}"; 
          return self::query($sql);     
    }       
  
      public function search_by_sql($number, $rev, $create_by, $create_date) {
         $sql  = "SELECT * FROM ".self::$table_name . " ";
         $sql .= "WHERE number LIKE '%$number%' ";
         $sql .= "AND rev LIKE '%$rev%' ";
         $sql .= "AND create_by LIKE '%$create_by%' "; 
         $sql .= "AND create_date LIKE '%$create_date%' ";  
         $sql .= "ORDER BY id DESC";           
         return self::query($sql); 
        }
    
      public function update_history($msg=""){
          global $db;
          $datetime  = strftime('%Y-%m-%d %H:%M');  
          $real_name = $_SESSION['real_name'];         
          $history_string = "[" . $datetime . "] [" . $real_name . "] [" . $msg . "].\r\n";
          $sql  = "UPDATE ".self::$table_name." SET ";            
          //if ($_GET['comment']!=""){
          // $sql .= "comment=CONCAT('".$db->escape_value($_GET['comment'])."\r\n', comment), "; }   
          $sql .= "history=CONCAT('".$db->escape_value($history_string)."', history) "; 
          $sql .= "WHERE id='". $db->escape_value($this->id) . "'";
          $db->query($sql);     
      }  
    
      public function updateAprroveField($approveKey) {
         
        //INFO:
          
        // $dbApproveArray     //main array from db to operate   
        // $newArrayApprove    //new array for replaceing old one
        // $arrayForUpperKey   //optional array to apply IF->$newArrayApprove stat is canceleted
        // $approveKey         //key we give to this function  
          
        global $db; 

        $dbArray = self::find_row_by_id($this->id); 
        $dbApproveArray = unserialize($dbArray['approve']);
        $approveKey; 

        //ON CHECKBOX APPROVE 
        if ( isset($_GET['chkApprove']) ) {  
                  
            if ($dbApproveArray[$approveKey]['approveStatus'] == "За Изработване" ) {      
                $newArrayApprove = array (
                    'approveStatus' => 'Изработена',                     
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'],                     
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],                          
                    'approvedBy'    => $_SESSION['real_name'],                
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),                    
                    'approveComment'=> $_GET['textApprove']
                );
                
            } elseif ($dbApproveArray[$approveKey]['approveStatus'] == "За Одобрение" xor 
                      $dbApproveArray[$approveKey]['approveStatus'] == "Отказано Одобрение" ){          
                $newArrayApprove = array ( 
                    'approveStatus' => 'Одобрена', 
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $_SESSION['real_name'], 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> $_GET['textApprove']
                );     
                
            } else { //prevent error    
                $newArrayApprove = array ( 
                    'approveStatus' => $dbApproveArray[$approveKey]['approveStatus'],
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $dbApproveArray[$approveKey]['approvedBy'], 
                    'approvedDate'  => $dbApproveArray[$approveKey]['approvedDate'],
                    'approveComment'=> $dbApproveArray[$approveKey]['approveComment'] 
                ); 
            };
            
        //apply the new approve array to the existing one
        $dbApproveArray[$approveKey] = $newArrayApprove;
        $modifiedArray = $dbApproveArray;
            
        //Prepare text for history msg  
        $hmsg  = $newArrayApprove['approveStatus'] . " - ";
        $hmsg .= $newArrayApprove['stageNumber'] . ". ";
        $hmsg .= $newArrayApprove['stageTitle']; 
        }

        //ON CHECKBOX CANCEL  
        if ( isset($_GET['chkCancel']) ) { 
                
            if ($dbApproveArray[$approveKey]['approveStatus'] == "За Одобрение" xor
                $dbApproveArray[$approveKey]['approveStatus'] == "Отказано Одобрение"){
                
                $newArrayApprove = array (
                    'approveStatus' => 'Отказано Одобрение', 
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $_SESSION['real_name'], 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> $_GET['textApprove'] 
                );   
                
            } else { //prevent error
                $newArrayApprove = array (
                    'approveStatus' => $dbApproveArray[$approveKey]['approveStatus'],
                    'stageNumber'   => $dbApproveArray[$approveKey]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKey]['stageTitle'],     
                    'approvedBy'    => $dbApproveArray[$approveKey]['approvedBy'], 
                    'approvedDate'  => $dbApproveArray[$approveKey]['approvedDate'],
                    'approveComment'=> $dbApproveArray[$approveKey]['approveComment'] 
                );
                
            }
            
        //apply 1st array 
        $dbApproveArray[$approveKey] = $newArrayApprove;

                //conditions to get key for updating upper/second array
                if (($approveKey==(int)4)) {
                   $modifiedKeyForUpperArray = $approveKey;
                }
                elseif ( ($approveKey==(int)2) xor ($approveKey==(int)3) ) {
                    $modifiedKeyForUpperArray = $approveKey-(int)2;
                } else {
                    $modifiedKeyForUpperArray = $approveKey-(int)1;
                }
        
                //bug fix
                if ($approveKey==(int)4) {$apvStatus = "Отказано Одобрение";} else {$apvStatus="За Изработване";};
            
                $arrayForUpperKey = array (
           
                    'approveStatus' => $apvStatus, 
                    'stageNumber'   => $dbApproveArray[$modifiedKeyForUpperArray]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$modifiedKeyForUpperArray]['stageTitle'],     
                    'approvedBy'    => '', 
                    'approvedDate'  => '',
                    'approveComment'=> $_GET['textApprove']
                ); 
                   
        //apply second array
        $dbApproveArray[$modifiedKeyForUpperArray] = $arrayForUpperKey;
        //masterpiece array    
        $modifiedArray = $dbApproveArray; 
            
            
        //Prepare text for history msg  
        $hmsg  = $newArrayApprove['approveStatus'] . " - ";
        $hmsg .= $newArrayApprove['stageNumber'] . ". ";
        $hmsg .= $newArrayApprove['stageTitle'];    
        }
          
        //ON CHECKBOX UNLOCK 
        if ( isset($_GET['chkUnlock']) ) {
            $approveKeyFromCheckBox = $_GET['chkUnlock']; //check box has array key for each row
            
            if ($dbApproveArray[$approveKeyFromCheckBox]['approveStatus'] == "Изработена" ) {
                $newArrayApprove = array (
                    'approveStatus' => 'За Изработване', 
                    'stageNumber'   => $dbApproveArray[$approveKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKeyFromCheckBox]['stageTitle'], 
                    'approvedBy'    => '', 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> "[окл. от: " . $_SESSION['real_name'] . "] " . $_GET['textApprove'] 
                );
                
            } elseif ($dbApproveArray[$approveKeyFromCheckBox]['approveStatus'] == "Одобрена" ){
                $newArrayApprove = array ( 
                    'approveStatus' => 'За Одобрение', 
                    'stageNumber'   => $dbApproveArray[$approveKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKeyFromCheckBox]['stageTitle'],     
                    'approvedBy'    => '', 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> "[окл. от: " .  $_SESSION['real_name'] . "] " . $_GET['textApprove']  
                                          );      
            } else { //prevent error
                
                $newArrayApprove = array ( 
                    'approveStatus' => $dbApproveArray[$approveKeyFromCheckBox]['approveStatus'],
                    'stageNumber'   => $dbApproveArray[$approveKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => $dbApproveArray[$approveKeyFromCheckBox]['stageTitle'],     
                    'approvedBy'    => $dbApproveArray[$approveKeyFromCheckBox]['approvedBy'], 
                    'approvedDate'  => $dbApproveArray[$approveKeyFromCheckBox]['approvedDate'],
                    'approveComment'=> $dbApproveArray[$approveKeyFromCheckBox]['approveComment']
                                          );
            }
            
            //apply the new approve array to the existing one
            $dbApproveArray[$approveKeyFromCheckBox] = $newArrayApprove;
            $modifiedArray = $dbApproveArray;
            
            //MODIFY text for history msg
            $hmsg  = "откл. на етап: ";
            $hmsg .= ". сменен статус на: ";
            $hmsg .= $newArrayApprove['approveStatus'] . " - ";
            $hmsg .= $newArrayApprove['stageNumber'] . ". ";
            $hmsg .= $newArrayApprove['stageTitle'];  
        }
 
          
        if ( isset($_GET['chkDeletePossition']) ) {  
            $deleteKeyFromCheckBox = $_GET['chkDeletePossition']; //check box has array key for each row 

            $newArrayApprove = array (
                    'approveStatus' => 'Одобрена', 
                    'stageNumber'   => $dbApproveArray[$deleteKeyFromCheckBox]['stageNumber'], 
                    'stageTitle'    => 'ПРЕМАХНАТ ЕТАП', 
                    'approvedBy'    => $_SESSION['real_name'], 
                    'approvedDate'  => strftime('%Y-%m-%d %H:%M'),
                    'approveComment'=> "[Премахнат: " . $_SESSION['real_name'] . "] " . $_GET['textApprove'] 
                );

             $dbApproveArray[$deleteKeyFromCheckBox] = $newArrayApprove;
             $modifiedArray = $dbApproveArray;

             //MODIFY text for history msg
             $hmsg  = "Премахна етап: ";
             $hmsg .= $dbApproveArray[$deleteKeyFromCheckBox]['stageNumber'] . ". ";
             $hmsg .= $dbApproveArray[$deleteKeyFromCheckBox]['stageTitle'];  
        }
          
        session_history_msg($hmsg); 
          
            //MAINTENANCE:
          /*
                    //echo "<pre>";
                    //echo "<h2>ARRAY FROM DB</h2>";
                    //print_r($dbApproveArray);
                    //echo "</pre><br>";
     
           
            echo "<div class=\"w3-container w3-indigo\">";
          
                 echo "<div class=\"w3-container\">";
                    echo "<h1> REPLACE ARRAY FROM DB WITH THE NEW MODIFYTED ARRAY <h1>";
                    echo "<h5>1st replaced array key is: " . $approveKey . "</h5>";
                    $secondArraykey = ((isset($_GET['chkUnlock'])) ? $approveKeyFromCheckBox : "no key");
                    echo "<h5>for unlock - replaced array key is: ". $secondArraykey . "</h5>";
                    $secondArraykey = ((isset($_GET['chkCancel'])) ? $modifiedKeyForUpperArray : "no key");
                    echo "<h5>for cancel - replaced upper array key is: ". $secondArraykey . "</h5>";
                 echo "</div>";

                    echo "<div class=\"w3-row\">";
          
                            echo "<div class=\"w3-half w3-container\">";
                            echo "<p> Original Array is: </p>";
                            echo "<pre>";
                            print_r(unserialize($dbArray['approve']));
                            echo "</pre>";             
                            echo "</div>";

                            echo "<div class=\"w3-half w3-container\">";
                            echo "<p> Modifyted Array is: </p>";
                            echo "<pre>";
                            print_r($modifiedArray);
                            echo "</pre>";  
                            echo "</div>";
          
                    echo "</div>";
          
            echo "</div>";
            */
       
            //  /*
       $sql  = "UPDATE ".self::$table_name." SET "; 
       $sql .= "history=CONCAT('".$db->escape_value($_SESSION['history_msg'])."', history), ";     
       $sql .= "approve='" . serialize($modifiedArray) . "' "; 
       $sql .= "WHERE id='". $db->escape_value($this->id) . "' "; 

            //MAINTENANCE:
                    //echo "<pre>";
                    //echo $sql ;  
                    //echo "</pre><br>"; 
           
        $db->query($sql); 
        unset ($_SESSION['history_msg']);  
        $page ='offer_details.php?subjectId='.$this->id; 
                    //echo $page . "<br>"; 
        echo "<meta http-equiv='refresh' content='0;URL=".$page."'>";   
            // */
      }
    
      public function updateComment($msg=""){
          global $db;
          
          if ($_GET['comment']=="") {
              $comment = "";
          } else {
              $comment = comment_msg_format($_GET['comment']);
          }
          
          $sql  = "UPDATE ".self::$table_name." SET ";              
          $sql .= "comment=CONCAT('{$db->escape_value($comment)}', comment) ";   
          $sql .= "WHERE id='{$db->escape_value($this->id)}' ";
          $db->query($sql); 
        
           $page ="offer_details.php?subjectId={$this->id}"; 
           echo "<meta http-equiv='refresh' content='0;URL={$page}'>";
    } 
    
    
}


class User extends MySQLDatabase {
    
    public $id;
    
    protected static $table_name = "accounts";
    
    protected static $db_fields = array( 'id', 
                                         'user_name', 
                                         'user_password', 
                                         'user_type', 
                                         'user_email',    
                                         'real_name'
                                       );
    
    public $ordersMainEmailFile = "ordersMainEmail.txt";
    
    public $offersMainEmailFile = "offersMainEmail.txt";
    
    public $ordersApproveEmailFile = "ordersApproveEmail.txt";
    
    public $offersApproveEmailFile = "offerApproveEmail.txt";
    
    public function checkAndReturnMainMailFile ($file) {
        
        if ( !file_exists(DESIGN_SETTINGS.DS.$file) ) {
            
            $mailFile = fopen(DESIGN_SETTINGS.DS.$file, "w");
            
            $mailArray = array(

                                array ( 'to'       => 'to', 
                                        'cc'       => 'cc', 
                                        'bcc'      => 'bcc',     
                                        'subject'  => 'subject',
                                        'bodytext' => 'email data only in latin!'
                                        )
            );              
             
            $serializedData = serialize($mailArray);
            file_put_contents(DESIGN_SETTINGS.DS.$file, $serializedData);
            fclose($mailFile);
            
            $recoveredData = file_get_contents(DESIGN_SETTINGS.DS.$file);
            $recoveredArray = unserialize($recoveredData);
            return $recoveredArray; 
            
        } else {
            
            $recoveredData = file_get_contents(DESIGN_SETTINGS.DS.$file);
            $recoveredArray = unserialize($recoveredData);
            return $recoveredArray;
        }      
    }
    
    public function editMainMailFile ($file, $to="", $cc="", $bcc="", $subject="", $bodytext=""){
 
        $mailArray = array(

                                array ( 'to'       => htmlspecialchars($to), 
                                        'cc'       => htmlspecialchars($cc), 
                                        'bcc'      => htmlspecialchars($bcc),     
                                        'subject'  => htmlspecialchars($subject),
                                        'bodytext' => htmlspecialchars($bodytext)
                                        )
            );
        
        $mailFile = fopen(DESIGN_SETTINGS.DS.$file, "w");
        $serializedData = serialize($mailArray);
        file_put_contents(DESIGN_SETTINGS.DS.$file, $serializedData);
        fclose($mailFile);
        } 
    
    public function sendMailOutlook($file, $key, $subjectVars, $bodyVars) {
        
        $returnedArray = self::checkAndReturnMainMailFile ($file);
           
        $new_line = "%0D%0A";

        $to = $returnedArray[$key]['to'];
        $cc = $returnedArray[$key]['cc'];
        $bcc = $returnedArray[$key]['bcc'];
        $subject = $returnedArray[$key]['subject'];
        $body = $returnedArray[$key]['bodytext'];
        
        $mail = "mailto:";
        $mail .= $to;
        $mail .= "?cc=";
        $mail .= $cc;
        $mail .= "&bcc=";
        $mail .= $bcc; 
        $mail .= "&subject=";
        $mail .= $subject . $subjectVars;
        $mail .= "&body=";
        $mail .= $body . $new_line . $new_line . $new_line . $bodyVars;
        $mailString = str_replace(" ", "%20", $mail);
        return $mailString;
        echo $mailString;
    }
    
    public function checkAndReturnApproveOrdersFile ($file) {
        
        if ( !file_exists(DESIGN_SETTINGS.DS.$file) ) {
            
            $mailFile = fopen(DESIGN_SETTINGS.DS.$file, "w");
            
            $mailArray = array(

                    array( 'approveTitle'  => 'Approve status 1', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 2', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 3', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 4', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 5', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 6', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
                     
                    array( 'approveTitle'  => 'pprove status 7', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' )
                );             
             
            $serializedData = serialize($mailArray);
            file_put_contents(DESIGN_SETTINGS.DS.$file, $serializedData);
            fclose($mailFile);
            
            $recoveredData = file_get_contents(DESIGN_SETTINGS.DS.$file);
            $recoveredArray = unserialize($recoveredData);
            return $recoveredArray; 
            
        } else {
            
            $recoveredData = file_get_contents(DESIGN_SETTINGS.DS.$file);
            $recoveredArray = unserialize($recoveredData);
            return $recoveredArray;
        }      
    }
    
    public function editMailApproveOrdersFile ($file=""){
        
        //just for infor vars from for-each form loop  
        
        // orderApproveMail01[{$row}] //approveTitle
        // orderApproveMail02[{$row}] //to    
        // orderApproveMail03[{$row}] //ccc
        // orderApproveMail04[{$row}] /bcc
        // orderApproveMail05[{$row}] //subject
        // orderApproveMail06[{$row}] //bodytext
             
        if(($arrayMailNumber = count($_GET['orderApproveMail01'])) > 0) {   
         
             $mailArray = array ();

             for($i=0; $i<$arrayMailNumber; $i++) {  
             
                $mailArray[] = array(  'approveTitle' => htmlspecialchars($_GET['orderApproveMail01'][$i]),
                                       'to'           => htmlspecialchars($_GET['orderApproveMail02'][$i]),
                                       'cc'           => htmlspecialchars($_GET['orderApproveMail03'][$i]),
                                       'bcc'          => htmlspecialchars($_GET['orderApproveMail04'][$i]),
                                       'subject'      => htmlspecialchars($_GET['orderApproveMail05'][$i]),
                                       'bodytext'     => htmlspecialchars($_GET['orderApproveMail06'][$i])
                                     );
             }             
            } 
        
        $mailFile = fopen(DESIGN_SETTINGS.DS.$file, "w");
        $serializedData = serialize($mailArray);
        file_put_contents(DESIGN_SETTINGS.DS.$file, $serializedData);
        fclose($mailFile);  
        return true;
    }
    
    public function checkAndReturnApproveOffersFile ($file) {
        
        if ( !file_exists(DESIGN_SETTINGS.DS.$file) ) {
            
            $mailFile = fopen(DESIGN_SETTINGS.DS.$file, "w");
            
            $mailArray = array(

                    array( 'approveTitle'  => 'Approve status 1', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 2', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 3', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 4', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' ),
            
                    array( 'approveTitle'  => 'Approve status 5', 
                           'to'            => 'to', 
                           'cc'            => 'cc', 
                           'bcc'           => 'bcc',     
                           'subject'       => 'subject',
                           'bodytext'      => 'email data only in latin!' )
                );             
             
            $serializedData = serialize($mailArray);
            file_put_contents(DESIGN_SETTINGS.DS.$file, $serializedData);
            fclose($mailFile);
            
            $recoveredData = file_get_contents(DESIGN_SETTINGS.DS.$file);
            $recoveredArray = unserialize($recoveredData);
            return $recoveredArray; 
            
        } else {
            
            $recoveredData = file_get_contents(DESIGN_SETTINGS.DS.$file);
            $recoveredArray = unserialize($recoveredData);
            return $recoveredArray;
        }      
    }
    
    public function editMailApproveOffersFile ($file=""){
        
         //just for infor vars from for-each form loop  
        
         // offerApproveMail01[{$row}] //approveTitle
         // offerApproveMail02[{$row}] //to    
         // offerApproveMail03[{$row}] //ccc
         // offerApproveMail04[{$row}] /bcc
         // offerApproveMail05[{$row}] //subject
         // offerApproveMail06[{$row}] //bodytext
             
        if(($arrayMailNumber = count($_GET['offerApproveMail01'])) > 0) {   
         
             $mailArray = array ();

             for($i=0; $i<$arrayMailNumber; $i++) {  
             
                $mailArray[] = array(  'approveTitle' => htmlspecialchars($_GET['offerApproveMail01'][$i]),
                                       'to'           => htmlspecialchars($_GET['offerApproveMail02'][$i]),
                                       'cc'           => htmlspecialchars($_GET['offerApproveMail03'][$i]),
                                       'bcc'          => htmlspecialchars($_GET['offerApproveMail04'][$i]),
                                       'subject'      => htmlspecialchars($_GET['offerApproveMail05'][$i]),
                                       'bodytext'     => htmlspecialchars($_GET['offerApproveMail06'][$i])
                                     );
             }             
            } 
        
        $mailFile = fopen(DESIGN_SETTINGS.DS.$file, "w");
        $serializedData = serialize($mailArray);
        file_put_contents(DESIGN_SETTINGS.DS.$file, $serializedData);
        fclose($mailFile);  
        return true;
    }
    
    public static function authenticate($username="", $password="") {
        global $database;
        $username = $database->escape_value($username);
        $password = $database->escape_value($password);
        $sql  = "SELECT * FROM ".self::$table_name; 
        $sql .= " WHERE username = '{$username}' ";
        $sql .= "AND password = '{$password}' ";
        $sql .= "LIMIT 1";
        $result_array = self::find_by_sql($sql);
        return !empty($result_array) ? array_shift($result_array) : false;
	}
    
    public function login($user_name, $user_password) {
        if ( (!empty($user_name)) && (!empty($user_password)) ) {          
        $sql  = "SELECT * FROM ".self::$table_name;
        $sql .= " WHERE user_name='".self::escape_value($user_name)."'";
        $sql .= " AND user_password='".self::escape_value($user_password)."'";      
        $checkForUser = self::query($sql);
        if (self::num_rows($checkForUser) == 1) {
        // session_start();
        $subject = self::fetch_array($checkForUser);      
        $_SESSION['user_permission'] = $subject['user_type'];    
        $_SESSION['login'] = $subject['user_name']; 
        $_SESSION['real_name'] = $subject['real_name']; 
        redirect_to("index.php");
        exit;  
        } else { 
        print "<div class=\"w3-panel w3-margin w3-red\">";
        print "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
        print "<h2>Неуспешно влизане! Грешено потребителско име или парола</h2>";
        print "</div>";             
        print "<div class=\"w3-panel w3-margin w3-yellow\">";
        print "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
        print "<h2><a href='login.php' title='Начало'>Върни се обратно</a></h2>";
        print "</div>";             
        exit;
        }
        } 
    }
    
    public function changePassword($new_password, $current_password) {
        $user_name = $_SESSION['login']; 
        $sql  = "UPDATE ".self::$table_name." SET user_password=";
        $sql .= "'".self::escape_value($new_password)."'";
        $sql .= " WHERE user_name='".$user_name."'";
        $sql .= " AND user_password='".self::escape_value($current_password)."'";
        $changePassword = self::query($sql);
        if ( self::affected_rows()==1 ) {
            $msg  = "<div class=\"w3-panel w3-margin w3-green\">";
            $msg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            $msg .= "<h2>Сменена парола!</h2>";
            $msg .= "</div>";  
        }
        else {
            $msg  = "<div class=\"w3-panel w3-margin w3-red\">";
            $msg .= "<span onclick=\"this.parentElement.style.display='none'\" class=\"w3-closebtn\">&times;</span>";
            $msg .= "<h2>Неуспешна смяна на паролата!</h2>";
            $msg .= "<h5>Възможни причини:</h5>";
            $msg .= "<ul> - несъвпадение на паролите.</ul>";
            $msg .= "</div>";  
        }
        echo $msg; 
    }
  
    public function checkUsername($uname) {
    if (preg_match("/[^A-Za-z\.]/", $uname))
    {
        return false;
    } else {return true;};

}
    
    public function checkRealName($uname) {
    if (preg_match("/[^A-Za-z\. ]/", $uname))
    {
        return false;
    } else {return true;};

}

    public function checkEmail($email) {

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) { return true; } else { return false; }        
}  
    
    public function checkForUserName($uname) {  
         self::query("SELECT * FROM ".self::$table_name." WHERE user_name='".$uname."'");  
         return  self::affected_rows();
    } 
    
    public function singUp() {
    
        global $db;
        
        $userName = $_POST['userName'];
        $userPassword1 = $_POST['userPassword1'];
        $userPassword2 = $_POST['userPassword2'];
        $userRealName = $_POST['userRealName'];
        $userMail = $_POST['userMail'];
        
        //MAINTENANCE
        //echo "<pre>";   
        //echo "userName      :" . $userName      . "<br>";    
        //echo "userPassword1 :" . $userPassword1 . "<br>"; 
        //echo "userPassword1 :" . $userPassword2 . "<br>";
        //echo "userRealName  :" . $userRealName  . "<br>";
        //echo "userMail      :" . $userMail      . "<br>";
        //echo "</pre>";	
        
        if ($this->checkForUserName($userName) == 0 ) {    
        
        $sql  = "INSERT INTO ".self::$table_name." (";    
        $sql .= "user_name, ";                   
        $sql .= "user_password, ";                      
        $sql .= "user_type, "; 
        $sql .= "user_email, ";                                   
        $sql .= "real_name ";  
            
        $sql .= ") VALUES ("; 
            
        $sql .= "'{$db->escape_value($userName)}',";   
        $sql .= "'{$db->escape_value($userPassword1)}',";         
        $sql .= "'{$db->escape_value('0000')}',";            
        $sql .= "'{$db->escape_value($userMail)}',";        
        $sql .= "'{$db->escape_value($userRealName)}' ";
        $sql .= ")";
            
        $db->query($sql);  
        return true;
            
        } else {
        return false;
            
        }
    
} 
    
    public function findAllUsers(){  
       return self::query("SELECT * FROM ".self::$table_name." ORDER BY user_name ASC");     
    } 

    public function find_row_by_id($id=0) { 
         global $database;
         $result = self::query("SELECT * FROM ".self::$table_name." WHERE id=".$database->escape_value($id)." LIMIT 1"); 
         return mysqli_fetch_assoc($result);
          //info:
          // $result_key = $orders->find_row_by_id($id="61");
          // print   $result_key['number'];
          //print $variable[key];
  } 
    
    public function editUser() {
        
        global $db;
        
        $userPassword = $_POST['userPassword'];
        $userType = $_POST['userType'];
        $userMail = $_POST['userMail'];
        $userRealName = $_POST['userRealName'];
        
        $sql  = "UPDATE ".self::$table_name." SET ";                       
        $sql .= "user_password='" . $db->escape_value($userPassword) . "', ";      
        $sql .= "user_type='" . $db->escape_value($userType) . "', ";         
        $sql .= "user_email='" . $db->escape_value($userMail) . "', ";       
        $sql .= "real_name='" . $db->escape_value($userRealName) . "' ";                  
        $sql .= " WHERE id='". $db->escape_value($this->id) . "'";
 
        if ($db->query($sql)) {
            return true;
        } else {return false; }

        
    }
    
    public function delete() {
		 global $database;
	     $sql = "DELETE FROM ".self::$table_name;
	     $sql .= " WHERE id=". $database->escape_value($this->id);
	     $sql .= " LIMIT 1";
 	     $database->query($sql);
         return ($database->affected_rows() == 1) ? true : false;
	} 
    
    //TO DO:
        //LOGIN AND ACTION HISTORY FOR USER
}
$ur = new User();


class Sessions {
    
   // public $userPermission = ;//$_SESSION['user_permission'];
   // public $userType = $_SESSION['user_permission'];

    
    public function userPermissions($requiredPerm) {
         
        /* $_SESSION['user_permission']
       
        key index:
                        x x x x     1 - true
                        A C U D     0 - false
            
        button grps: 
                        0100 - create button
                        0001 - delete button
                        0010 - update button
                        0110 - create and update
                        0011 - delete and update
                        0101 - create and delete    
            
        how it works?
            
        - in div tag we put class that return hide style if user key cant get requered div key
           
        - examples:
            
            user key : 0110 (user create anmd update)
            
            default button is disabled and cant be pressed
            
            button key : 0100 (create button)
        
            soo user should have permissions to create record
            
            //class=\"{$ss->userPermissions('1001')}\"
        */

       $classToApply = " w3-hide";
        
       $strKey1 = substr($requiredPerm, 0, 1);
       $strKey2 = substr($requiredPerm, 1, 1);
       $strKey3 = substr($requiredPerm, 2, 1); 
       $strKey4 = substr($requiredPerm, 3, 1); 
        
       $userKey = $_SESSION['user_permission'];
       //$userKey = $this->userPermission;
       $userKey1 = substr($userKey, 0, 1);
       $userKey2 = substr($userKey, 1, 1);
       $userKey3 = substr($userKey, 2, 1); 
       $userKey4 = substr($userKey, 3, 1); 
        
        if ($userKey1 == 1) { 
          
          $classToApply = "";  //admin dostup nishto ne apply na classa.
        }
        elseif ($strKey1 == 1 && $strKey1 == $userKey1) { 
          //admin permis
          $classToApply = "" ;
        }
        elseif ($strKey2 == 1 && $strKey2 == $userKey2) { 
          //second key - create
         $classToApply = ""; 
        }
        elseif ($strKey3 == 1 && $strKey3 == $userKey3) { 
          //3rd key - update    
            $classToApply = "";
        }    
        elseif ($strKey4 == 1 && $strKey4 == $userKey4) { 
          //4 key - delete     
            $classToApply = "";
        }    
        else {
          //if no match for the button
            $classToApply = " w3-hide";
        }
        return $classToApply;
    }
    
    public function lockButtonAccordingStatus($status) {
    
        $classToApply = "";

        if ($status == 'Одобрена') {
            $classToApply = " w3-hide";
        } else {
            $classToApply;
        }
        return $classToApply;
        
    }
    
    
    
    
    
    
} 

$ss = new Sessions();

?>