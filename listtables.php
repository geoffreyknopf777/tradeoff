<?php 
//Preprocessing:
$servername = "localhost";
$username = "root";
$password = "mysqlpassword207";
$dbs = array();
$tbls = array();
$cols = array();
		
	//Open up a database connection:
		//Create connection
		$conn = new mysqli($servername, $username, $password);
		//Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error . "<br />");
		} 
		//echo "Connected successfully <br />";

	//Get a list of databases:
	$sql = "SHOW DATABASES";
	$dbresult = $conn->query($sql);
	if ($dbresult->num_rows > 0) {
		while($row = $dbresult->fetch_object()) {
			if (($row->Database!="information_schema") && ($row->Database!="performance_schema") && ($row->Database!="mysql")) {
				$db = $row->Database;
				array_push($dbs, $db);
				//Get a list of tables:
				$sql = "SHOW TABLES FROM $db";
				$tbresult = $conn->query($sql);
				$dbtbls = array();
				$dbcols = array();
				if ($tbresult->num_rows > 0) {
					while($row = $tbresult->fetch_array()) {
						$tbl = $row[0];
						array_push($dbtbls, $tbl);
						//Get a list of columns:
						$sql = "USE $db";
						$conn->query($sql);
						$sql = "DESCRIBE $tbl";
						$colresult = $conn->query($sql);
						$tbcols = array();
						if ($colresult->num_rows > 0) {
							while($col = $colresult->fetch_array()) {
								$colname = $col['Field'];
								array_push($tbcols, $colname);	
							}
						}
					array_push($dbcols, $tbcols);
					}
				} else {
					//echo "0 results";
				}
				$cols[] = $dbcols;
				$tbls[] = $dbtbls;
			}
		}
	} else {
		//echo "0 results";
	}

	//Get a list of labels:
	//$label_dir = "labels/";
	//$labels = array_diff(scandir($label_dir), array('..', '.'));
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" >
<head>
    <title>Show Databases/Tables</title>
    <script language="javascript" type="text/javascript">
    <!--
    var aDBs = [<?php echo "'" . implode("', '", $dbs) . "'"; ?>];
	var aTBs = [ 
		<?php 
		for($i=0; $i<sizeof($dbs); $i++){
			echo "[" . "'" . implode("', '", $tbls[$i]) . "'" . "]";
			if($i < sizeof($dbs)-1){ //do not echo comma for last database
				echo ", ";
			}
		}
		?> 
		];
	
	var aCOLs = [
		<?php
		for($i=0; $i<sizeof($dbs); $i++){
			echo "[";
			for($j=0; $j<sizeof($tbls[$i]);$j++){
				echo "[" . "'" . implode("', '", $cols[$i][$j]) . "'" . "]";
				if($j < sizeof($cols[$i])-1){ //do not echo comma for last table
					echo ", ";
				}
			}
			echo "]";
			if($i < sizeof($cols)-1){ //do not echo comma for last database
				echo ", ";
			}
		}
		?>
	];

	//Store the directory of label files
	var DATA_FOLDER = "<?php 
		$dir = getcwd() . "\\labels\\";
		$newdir = str_replace("\\", "\\\\", $dir); 
		echo $newdir;
		?>";
		
	//Store the directory of bitmap preview files
	var PREVIEW_FOLDER = "<?php 
		$dir = getcwd() . "\\preview\\";
		$newdir = str_replace("\\", "\\\\", $dir); 
		echo $newdir;
		?>";
	
	function mapColumnsToFields(objDoc){
		numFieldsSelect = document.getElementById("numFields");
		var numFields = numFieldsSelect[numFieldsSelect.selectedIndex].value;
		
		for(var i=0; i<numFields; i++){
			fieldName = document.getElementById("labelField" + i).value;
			colSelect = document.getElementById("tableCol" + i);
			colName = colSelect[colSelect.selectedIndex].value;
			//alert(fieldName + " " + colName);
			objDoc.GetObject(fieldName).Text = colName;
		}
	}
	
	function DoPrint(strExport)
    {
        var theForm = document.getElementById("myForm");
        var nItem = theForm.labels.selectedIndex;
        var strPath = DATA_FOLDER + theForm.labels.options[nItem].value;

	 	//Get the ActiveXObject
		var objDoc = new ActiveXObject("bpac.Document");
		if(objDoc.Open(strPath) != false)
		{
			mapColumnsToFields(objDoc);
			theForm.txtWidth.value = objDoc.Width;
			
			if(strExport == "")
			{
				//objDoc.SetMediaByName(objDoc.Printer.GetMediaName(), true);
				objDoc.StartPrint("", 0);
				objDoc.PrintOut(1, 0);
				objDoc.Close();
				objDoc.EndPrint();
			}
			else
			{
				var fso = new ActiveXObject("Scripting.FileSystemObject");
				//var TEMP_FOLDER = fso.GetSpecialFolder(2);
				strPreview = "preview/" + strExport;
				strExport = PREVIEW_FOLDER + strExport;
				objDoc.Export(4, strExport, 180);
				objDoc.Close();
				document.getElementById("preview_img").src = "";
				document.getElementById("preview_img").src = strPreview;
			}
		}
    }   
	
	function updateTables(){
		//Determine which database is selected:
			var index = document.getElementById("databases").selectedIndex;
		//Clear all the previous dropdown options:
			document.getElementById("tables").innerHTML = "";
		//Add the tables in the selected database as dropdown options:
		for(var i=0; i<aTBs[index].length; i++){
			document.getElementById("tables").innerHTML += '<option value"' + aTBs[index][i] + '">' + aTBs[index][i] + '</option>';
		}
	}
	
	function updateTableQuery(){
		var tables = document.getElementById("tables");
		document.getElementById("tableQuery").innerHTML = tables.options[tables.selectedIndex].value;
	}
	
	function updateFields(){
		var fields = document.getElementById("numFields");
		var num = fields.selectedIndex + 1;
		var pairs = document.getElementById("pairs");
		pairs.innerHTML = "";
		
		//Determine which database is selected:
		var indexDB = document.getElementById("databases").selectedIndex;
		//Determine which table is selected:
		var indexTB = document.getElementById("tables").selectedIndex;
			
		var options = "";
		for(var i=0; i<aCOLs[indexDB][indexTB].length; i++){
			options += '<option value="' + aCOLs[indexDB][indexTB][i] + '">' + aCOLs[indexDB][indexTB][i] + '</option>';
		}
		
		for(var i=0; i<num; i++){
			pairs.innerHTML += '<input id="labelField' + i + '" name="labelField' + i + '" type="text" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			pairs.innerHTML += '<select id="tableCol' + i + '" name="tableCol' + i + '">' + options + '</select><br /><br />';
		}
	}
	
    -->
    </script>
</head>

<body style="color:black;background-color:white" onload="updateTableQuery(); updateFields()">

<h1 style="text-align:center">Show Databases/Tables</h1>

<form id="myForm" method="post" action="print_action.php">
    <p>
	Database:
	<select name="databases" id="databases" onchange="updateTables(); updateTableQuery(); updateFields()" style="width: 320px; height: 22px">
		<?php
			foreach ($dbs as $db) {
				echo "<option value='" . $db . "'>" . $db . "</option>";
			}
		?>
    </select>
	</p>
	
	<p>
	Table:
	<select name="tables" id="tables" onchange="updateTableQuery(); updateFields()" style="width: 320px; height: 22px">
		<?php
			foreach ($tbls[0] as $tb) {
				echo "<option value='" . $tb . "'>" . $tb . "</option>";
			}
		?>
    </select>
	</p>
	
</body>
</html>
