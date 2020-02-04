<!DOCTYPE html>
<!-- result of adding vendor table  -->
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
					if ($regEx === '/^[0-9]+$/')  # number only '/^[0-9]+$/'
					{
						$returnMsg = $name." field should consist of all digits."."<br>";
					}
					else if ($regEx === '/^[-@.#&+\w\s]*$/') # alphanumeric only '/^[-@.#&+\w\s]*$/'
					{
						$returnMsg = $name." field should consist of all letters or digits."."<br>";
					}
					else if ($regEx === '/^[a-zA-Z .]+$/')
					{
                        // alphabet only '/^[a-zA-Z .]+$/'
						$returnMsg = $name." field should consist of all letters."."<br>";
					}
					else if ($regEx === '/^[ABCEGHJKLMNPRSTVXY]\d[A-Z]\d[A-Z]\d$/')  
					{
                        // PostCode '/^[ABCEGHJKLMNPRSTVXY]\d[A-Z]\d[A-Z]\d$/'
						$returnMsg = "Postal Code field is wrong format. ex) N1N2N3"."<br>";
					}
					else if ($regEx === '/^[0-9]{5}/')
					{
                        // ZIP Code '/^[0-9]{5}/'
						$returnMsg = "ZIP code should consist to 5 digits."."<br>";
					}
				}
				return $returnMsg;				
			}
					
		?>
	</head>
	<body>
		<div id="allDv"><br><br>
			
			<div class="resultDiv" id="partsDiv">
				Result of Add Vendors  <br>
		
			<div class="btnHomeDiv" >
				<input type="button" name="btnBack" id="btnBack" value="Go Home"/>
			</div>

			<?php
                include ("connection.php");
                
                $db = ConnectToDatabase();
                
				$qryStr = "select max(VendorNo) as maxNumber from Vendors;";
                $result = $db -> prepare($qryStr);
                $result -> execute();
                $row = $result->fetch();

                $maxNum = number_format($row['maxNumber'], 0, '', '');
				$maxNum = $maxNum + 1;
                
				$qryFieldName = "VendorNo, ";
				$qryFieldVal = $maxNum.", ";
				$fieldValStr = "";     // for input check
				
				foreach($_POST as $key => $value)
				{
				    if (strpos($key, "submit") !== 0) 
				    {
						if (!empty($value)) 
						{
							$qryFieldName = $qryFieldName.$key.", ";
							if ($key !== "VendorNo") 
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
				}
                
                
				$qryFieldName = trim($qryFieldName);
				$qryFieldVal = trim($qryFieldVal);
				$fieldValStr = trim($fieldValStr);
				$qryFieldName = substr($qryFieldName, 0, strlen($qryFieldName) - 1);
				$qryFieldVal = substr($qryFieldVal, 0, strlen($qryFieldVal) - 1);
				$fieldValStr = substr($fieldValStr, 0, strlen($fieldValStr) - 1);

				// input check ,mandatory, regular expression
				$fieldVals = explode ( "|" , $fieldValStr);
				$fieldNames = array("VendorName", "Address1", "Address2", "City", "Prov", 
									"PostCode", "Country", "Phone", "FAX");
				// 0: VendorName(A), 1: Address1(AN),  2: Address2(AN), 3: City(A), 4: Prov(A), 
				// 5: PostCode, 6: Country(A), 7: Phone(N), 8: Fax(N) 
                
                
				$errMsg = "";
				$regPtrn = '';
				for ($i = 0; $i < count($fieldVals); $i++)
				{
                    //  checking of madatory fields
					if ($i !== 8)
					{
						$errMsg = $errMsg.checkManField($fieldVals[$i], $fieldNames[$i]);
					}
                    
					if ($i === 3  || $i === 4 || $i === 6)
					{
						$regPtrn = '/^[a-zA-Z .]+$/';
					}
					else if ($i === 7 || $i === 8)
					{
						$regPtrn = '/^[0-9]+$/';
					}
					else if ($i === 0 || $i === 1 || $i === 2)
					{
						$regPtrn = '/^[-@.#&+\w\s]*$/';
					}
					else if ($i === 5)
					{
						if ($fieldVals[6] === "Canada")
						{
							$regPtrn = '/^[ABCEGHJKLMNPRSTVXY]\d[A-Z]\d[A-Z]\d$/';
						}
						else
						{
							$regPtrn = '/^[0-9]{5}/';
						}
					}
                    
					$errMsg = $errMsg.checkRegExp($fieldVals[$i], $fieldNames[$i], $regPtrn);
				}
				
				if ($errMsg === "")
				{				
					$qryStr = "INSERT INTO Vendors (".$qryFieldName.") VALUES (".$qryFieldVal.");" ;
                    $result = $db -> prepare($qryStr);
                    $result -> execute();
					
					echo "<h2>Add vendor Information was successful.</h2><br>";
					
/*
                    echo "<b>Vendor Number: </b>".$maxNum."<br>";
					
                    
                    for ($i = 0; $i < count($fieldVals); $i++)
					{
						echo "<b>".$fieldNames[$i].": </b>".$fieldVals[$i]."<br>";
					}
*/
                    
                    $tableBodyText = "<table class='allResult'>";

                    $tableBodyText .= "<tr>";
                    $tableBodyText .= "<td>Vendor Number</td>";
                    $tableBodyText .= "<td>$maxNum</td>";
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
					echo "<h3>"."Error has occured"."</h3>";
					echo $errMsg;
				}
			?>
			</div>
		</div>
	</body>
</html>