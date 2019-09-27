  <?php
//Database connection by using PHP PDO
$username = 'root';
$password = '';
$connection = new PDO( 'mysql:host=localhost;dbname=crud', $username, $password ); // Create Object of PDO class by connecting to Mysql database

if(isset($_POST["action"])) //Check value of $_POST["action"] variable value is set to not
{
 //For Load All Data
 if($_POST["action"] == "Load") 
 {
  $statement = $connection->prepare("SELECT * FROM customers ORDER BY customer_id DESC");
  $statement->execute();
  $result = $statement->fetchAll();
  $output = '';
  $output .= '
   <table class="table table-bordered">
    <tr>
     <th width="40%">Customer Name</th>
     <th width="40%">Address</th>
     <th width="40%">Contact Number</th>
     <th width="10%">Update</th>
     <th width="10%">Delete</th>
    </tr>
  ';
  if($statement->rowCount() > 0)
  {
   foreach($result as $row)
   {
    $output .= '
    <tr>
     <td>'.$row["customer_name"].'</td>
     <td>'.$row["customer_address"].'</td>
     <td>'.$row["customer_contact"].'</td>
     <td><button type="button" id="'.$row["customer_id"].'" class="btn btn-warning btn-xs update">Update</button></td>
     <td><button type="button" id="'.$row["customer_id"].'" class="btn btn-danger btn-xs delete">Delete</button></td>
    </tr>
    ';
   }
  }
  else
  {
   $output .= '
    <tr>
     <td align="center">Data not Found</td>
    </tr>
   ';
  }
  $output .= '</table>';
  echo $output;
 }

 //This code for Create new Records
 if($_POST["action"] == "Create")
 {
  $statement = $connection->prepare("
   INSERT INTO customers (customer_name, customer_address,customer_contact) 
   VALUES (:customer_name, :customer_address,:customer_contact)
  ");
  $result = $statement->execute(
   array(
    ':customer_name' => $_POST["name"],
    ':customer_address' => $_POST["address"],
    ':customer_contact' => $_POST["contact"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Inserted';
  }
 }

 //This Code is for fetch single customer data for display on Modal
 if($_POST["action"] == "Select")
 {
  $output = array();
  $statement = $connection->prepare(
   "SELECT * FROM customers 
   WHERE customer_id = '".$_POST["id"]."' 
   LIMIT 1"
  );
  $statement->execute();
  $result = $statement->fetchAll();
  foreach($result as $row)
  {
   $output["customer_name"] = $row["customer_name"];
   $output["address"] = $row["customer_address"];
   $output["contact"] = $row["customer_contact"];
  }
  echo json_encode($output);
 }

 if($_POST["action"] == "Update")
 {
  $statement = $connection->prepare(
   "UPDATE customers 
   SET customer_name = :customer_name, customer_address = :address, customer_contact = :contact
   WHERE customer_id = :id
   "
  );
  $result = $statement->execute(
   array(
    ':customer_name' => $_POST["name"],
    ':address' => $_POST["address"],
    ':contact' => $_POST["contact"],
    ':id'   => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Updated';
  }
 }

 if($_POST["action"] == "Delete")
 {
  $statement = $connection->prepare(
   "DELETE FROM customers WHERE customer_id = :id"
  );
  $result = $statement->execute(
   array(
    ':id' => $_POST["id"]
   )
  );
  if(!empty($result))
  {
   echo 'Data Deleted';
  }
 }

}

?>