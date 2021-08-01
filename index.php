<?php
use Phppot\DataSource;

require_once 'DataSource.php';
$db = new DataSource();
$conn = $db->getConnection();

if (isset($_POST["import"])) {
    
    $fileName = $_FILES["file"]["tmp_name"];
    
    if ($_FILES["file"]["size"] > 0) {
        
        $file = fopen($fileName, "r");
        
        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            
            $userId = "";
            if (isset($column[0])) {
                $userId = mysqli_real_escape_string($conn, $column[0]);
            }
            $item = "";
            if (isset($column[1])) {
                $item = mysqli_real_escape_string($conn, $column[1]);
            }
            $statusitem = "";
            if (isset($column[2])) {
                $statusitem = mysqli_real_escape_string($conn, $column[2]);
            }
            $region = "";
            if (isset($column[3])) {
                $region = mysqli_real_escape_string($conn, $column[3]);
            }
            $password = "";
            if (isset($column[4])) {
                $password = mysqli_real_escape_string($conn, $column[4]);
            }
            
            $sqlInsert = "INSERT into users (userId,item,statusitem,region,password)
                   values (?,?,?,?,?)";
            $paramType = "issss";
            $paramArray = array(
                $userId,
                $item,
                $statusitem,
                $region,
                md5($password)
            );
            $insertId = $db->insert($sqlInsert, $paramType, $paramArray);
            
            if (! empty($insertId)) {
                $type = "success";
                $message = "CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
<script src="jquery-3.2.1.min.js"></script>

<style>
body {
	background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
	background-size: 400% 400%;
	animation: gradient 15s ease infinite;
}

@keyframes gradient {
	0% {
		background-position: 0% 50%;
	}
	50% {
		background-position: 100% 50%;
	}
	100% {
		background-position: 0% 50%;
	}
}

.outer-scontainer {
    background: #F0F0F0;
    border: #e0dfdf 1px solid;
    padding: 5px;
    border-radius: 1px;
    width:500px;
    height:40px;
    
    
}

.input-row {
    margin-top: 10px;
    margin-bottom: 20px;
}

.btn-submit {
    background: #333;
    border: #1d1d1d 1px solid;
    color: #f0f0f0;
    font-size: 0.9em;
    width: 100px;
    border-radius: 2px;
    cursor: pointer;
}

.outer-scontainer table {
    
    width:10px;
    height:20px;
    margin:auto;
    position:relative;
}

.outer-scontainer th {
    border: 1px solid #dddddd;
    padding: 3px;
    width:10px;
    height:20px;
    margin:auto;
    position:relative;
    text-align: left;
}

.outer-scontainer td {
    border: 1px solid #dddddd;
    padding: 8px;
    width:10px;
    height:20px;
    margin:auto;
    position:relative;
    text-align: left;
}

#response {
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 2px;
    display: none;
}

.success {
    background: #c7efd9;
    border: #bbe2cd 1px solid;
}

.error {
    background: #fbcfcf;
    border: #f3c6c7 1px solid;
}

div#response.display-block {
    display: block;
}
</style>
<script type="text/javascript">
$(document).ready(function() {
    $("#frmCSVImport").on("submit", function () {

	    $("#response").attr("class", "");
        $("#response").html("");
        var fileType = ".csv";
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + fileType + ")$");
        if (!regex.test($("#file").val().toLowerCase())) {
        	    $("#response").addClass("error");
        	    $("#response").addClass("display-block");
            $("#response").html("Invalid File. Upload : <b>" + fileType + "</b> Files.");
            return false;
        }
        return true;
    });
});
</script>
</head>

<body>
    <h2>Upload your CSV file below</h2>
    <h2>Project for Grootan by Boopesh</h2>

    <div id="response"
        class="<?php if(!empty($type)) { echo $type . " display-block"; } ?>">
        <?php if(!empty($message)) { echo $message; } ?>
        </div>
    <div class="outer-scontainer">
        <div class="row">

            <form class="form-horizontal" action="" method="post"
                name="frmCSVImport" id="frmCSVImport"
                enctype="multipart/form-data">
                <div class="input-row">
                    <label class="col-md-4 control-label">Choose CSV
                        File</label> <input type="file" name="file"
                        id="file" accept=".csv">
                    <button type="submit" id="submit" name="import"
                        class="btn-submit">Import</button>
                    <br />

                </div>

            </form>

        </div>
               
                </tbody>
        </table>
        <?php  ?>
    </div>

</body>

</html>