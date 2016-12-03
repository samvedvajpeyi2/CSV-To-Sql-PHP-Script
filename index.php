<?php
/*
Script to upload a CSV file and add its contents into database.
Created by: Samved Mohan Vajpeyi

===== SQL query in line 28 can be modified if the column names of table are different =====
===== No other change required on this page =====

*/

require_once("ConnectDB.php");
// If form is submitted
if(isset($_POST['submit'])) {
 
	// Verify file format as CSV
	$filename = $_FILES['csv']['name'];
	$extension = explode('.', $filename);
	$extension = array_pop($extension);
        
        // Check whether "Skip 1st line" is checked, if checked- set $flag
        $flag = (isset($_POST['skipLine'])) ? true : false;
 
	if (strtolower($extension) == "csv") {
		// Get DSN connection to database
		$db = ConnectDB::getConnection();
		
		// Define Sql query, in case of duplicate key it will update the row
		$sql = "INSERT INTO $tableName (product_id, price, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE product_id=VALUES(product_id),price=VALUES(price),quantity=VALUES(quantity)";
                
		// Prepare Sql query to be executed
		$stmt = $db->prepare($sql);
                
		// Define row count variable to get total number of rows inserted
		$rowCount = 0;
		
		// Get temp name and open file
		$temp_name = $_FILES['csv']['tmp_name'];
		$file_handle = fopen($temp_name, 'r');
                
		// Loop through the file and get contents into an array using fgetcsv 
		while (($items = fgetcsv($file_handle, 1000, ',')) !== FALSE) {
 
			// If $flag is set then skip first line and unset $flag
			if($flag) { $flag = false; continue; }
                        
                        // Execute prepared query
			$stmt->execute($items);
 
			// Add 1 to total number of rows inserted
                        $rowCount++;
		}
 
		// Close the opened file
		fclose($file_handle);
		
		// Set success message
		$msg = "<div class=\"alert alert-info\"><strong>Success!</strong> Successfully inserted $rowCount row(s).</div>";
 
	} else {
 
	// Set error message if the file is not .csv
	$msg = "<div class=\"alert alert-info\"><strong>Oops!</strong> Not a CSV file.</div>";
	}	 	 
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trend-Corner Technical Test - Samved Mohan Vajpeyi</title>
    
    <!-- Loading Bootstrap CSS and JS libraries from CDN -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="index.php">Trend-Corner Test</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.php">Home</a></li>
            </ul>
        </div>
    </nav>
    <!-- Page Content -->
    
        <div class="container" >
                <div class="col-lg-3"></div>
                <div class="col-lg-6">
			<div class="jumbotron">
			
				<!-- Display error/success message -->
				<?=(isset($msg)) ? $msg : ""?>
				
				<h2>Upload CSV to database!</h2>
				
				<form action="" method="post" enctype="multipart/form-data">
				    <div class="form-group">
					<label for="csv">Select CSV file to upload:</label>
					<input type="file" name="csv" id="csv" class="form-control">
				    </div>
				    <div class="checkbox">
					<label><input type="checkbox" name="skipLine" value="skipLine"> Skip first line (if column names)</label>
				    </div>
				    <button type="submit" name="submit" class="btn btn-default">Upload CSV</button>
				</form>
			
			</div>
                </div>
                <div class="col-lg-3"></div>
                    <!-- Footer -->
		<footer>
		    <div class="navbar-fixed-bottom">
			<div class="col-lg-12">
			    <p class="text-center">Created By: Samved Mohan VAJPEYI</p>
			</div>
		    </div>
		</footer>
        </div>
    <!-- /.container -->

</body>

</html>
