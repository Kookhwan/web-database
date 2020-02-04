<!DOCTYPE html>
<!-- result of adding part table  -->
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<title>Assignment5</title>
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
		<script src="js/result.js"></script>
		<link rel="stylesheet" href="css/main.css">
        
		<?php
            /*Get error message - Mandatory*/
            function checkManField($field, $name)
            {
                if (empty($field))
                {
                    return $name." field is empty."."<br>";
                }
                else
                {
                    return "";
                }
            }
        
            /*Get error message - regular expression*/
			function checkRegExp($field, $name, $regEx)
			{
				$returnMsg = "";
                // The preg_match() function searches string for pattern, 
                // returning true if pattern exists, and false otherwise.
				if (preg_match($regEx, $field))
				{
					$returnMsg = "";
				}
				else
				{
					if ($regEx === '/^[0-9.]+$/')      // number only '/^[0-9\.]+$/'
					{
						$returnMsg = $name." field should consist of all digits."."<br>";
					}
					else if ($regEx === '/^[-@.#&+\w\s]*$/') // alphanumeric only '/^[-@.#&+\w\s]*$/'
					{
						$returnMsg = $name." field should consist of all letters or digits."."<br>";
					}
					else if ($regEx === '/^[a-zA-Z ]+$/')  // alphabet only '/^[a-zA-Z ]+$/'
					{
						$returnMsg = $name." field should consist of all letters."."<br>";
					}
				}
				return $returnMsg;				
			}
        
		?>
	</head>
	<body>
		<div id="allDv"><br><br>

			<div class="resultDiv" id="partsDiv">
				Result of Add Part  <br>
		
			<div class="btnHomeDiv" >
				<input type="button" name="btnBack" id="btnBack" value="Go Home"/>
			</div>
		
			<?php
                include ("connection.php");
                
                $db = ConnectToDatabase();
                
				$qryFieldName = "";    // for query
				$qryFieldVal = "";     // for query
				$fieldValStr = "";     // for input check
				
				foreach($_POST as $key => $value)
				{
				    if (strpos($key, "submit") !== 0) 
				    {
					    $qryFieldName = $qryFieldName.$key.", ";
					    if ($key === "Description") 
					    {
							$qryFieldVal = $qryFieldVal."'".$value."', ";
					    }
					    else 
					    {
							$qryFieldVal = $qryFieldVal.$value.", ";
					    }
					    $fieldValStr = $fieldValStr.$value."|";
				    }
				}
                
				$qryFieldName = trim($qryFieldName);
				$qryFieldVal = trim($qryFieldVal);
				$fieldValStr = trim($fieldValStr);
				$qryFieldName = substr($qryFieldName, 0, strlen($qryFieldName) - 1);
				$qryFieldVal = substr($qryFieldVal, 0, strlen($qryFieldVal) - 1);
				$fieldValStr = substr($fieldValStr, 0, strlen($fieldValStr) - 1);
				
				// input check ,mandatory, regular expression
				$fieldVals = explode ( "|" , $fieldValStr);
				$fieldNames = array("VendorNo", "Description", "OnHand", "OnOrder", "Cost", "List Price");
				// 0: vendorNo(N), 1: description(AN), 2: onHand(N), 3: onOrder(N), 4: cost(N), 5: listPrice(N) 
                
				$errMsg = "";
				for ($i = 0; $i < count($fieldVals); $i++)
				{
					$errMsg = $errMsg.checkManField($fieldVals[$i], $fieldNames[$i]);
                    
					if ($i === 1)
					{
						$errMsg = $errMsg.checkRegExp($fieldVals[$i], $fieldNames[$i], '/^[-@.#&+\w\s]*$/');
					}
					else
					{
						$errMsg = $errMsg.checkRegExp($fieldVals[$i], $fieldNames[$i], '/^[0-9.]+$/');
					}
				}
				
				if ($errMsg === "")
				{
                    $qryStr = "INSERT INTO Parts (".$qryFieldName.") VALUES (".$qryFieldVal.");" ;
                    $result = $db -> prepare($qryStr);
                    $result -> execute();
                    
					echo "<h3>Add Parts Information was successful.</h3><br>";
                    
                    
                    $qryStr1 = "select max(PartID) as maxPartID from parts";

                    $result1 = $db->prepare($qryStr1);
                    $result1->execute();
                    $row = $result1->fetch();
                    
                    $maxPartID = number_format($row['maxPartID'], 0, '', '');

                    $tableBodyText = "<table class='allResult'>";

                    $tableBodyText .= "<tr>";
                    $tableBodyText .= "<td>PartID</td>";
                    $tableBodyText .= "<td>$maxPartID</td>";
                    $tableBodyText .= "</tr>";

					for ($i = 0; $i < count($fieldVals); $i++)
					{
                        $tableBodyText .= "<tr>";
                        $tableBodyText .= "<td>$fieldNames[$i]</td>";
                        $tableBodyText .= "<td>$fieldVals[$i]</td>";
                        $tableBodyText .= "</tr>";
					}
                    
                    $tableBodyText .= "</table>";
                    
                    echo $tableBodyText;
				}
				else
				{
					for ($i = 0; $i < count($fieldVals); $i++)
					{
						echo "<b>".$fieldNames[$i].": </b>".$fieldVals[$i]."<br>";
					}
					echo "<h3>"."Error has occured"."</h3>";
					echo $errMsg;
				}

			?>
			</div>
		</div>
	</body>
</html>