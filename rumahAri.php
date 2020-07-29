<?php 
// tutorial https://circuits4you.com/2018/03/10/esp8266-http-get-request-example
//save data to db
    //Connect to database
    $servername = "localhost";
    $username = "u1021409_ariApp";
    $password = "112233";
    $dbname = "u1021409_rumahari";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    } 

    //Get current date and time
    date_default_timezone_set('Asia/Kolkata');
    $d = date("Y-m-d");
    //echo " Date:".$d."<BR>";
    $t = date("H:i:s"); 
      
 
    if(!empty($_GET['statusPintu']) && !empty($_GET['statusKunci'])) 
    {
     
    	$statusPintu = $_GET['statusPintu']; 
        $statusKunci = $_GET['statusKunci']; 
        
        // http://rumahari123.000webhostapp.com/esptodb.php?nama=lala&mytext=asdf

// $sql = "INSERT INTO `tbl_kuncipintu` (`id`, `statusPintu`, `statusKunci`, `date`) VALUES (NULL, "tertutup",'".$statusKunci."', current_timestamp())";

        $sql = "INSERT INTO `kunciPintu` (`id`, `statusPintu`, `statusKunci`, `date`) VALUES (NULL, '".$statusPintu."','".$statusKunci."', current_timestamp())";
        
		if ($conn->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    //echo "error";
		    //echo "Error: " . $sql . "<br>" . $conn->error;
		}
	}


	$conn->close();
?>