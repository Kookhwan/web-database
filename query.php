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
            include("connection.php");

            // PHP validation for user input 
            // Get connection to dba_close// prepare sql statement
            // Execute sql statement

            function CreateTableHeader()
            {

                $text = "<tr id='tableHeader'>";
                $text .= "<th>PartID</th>";
                $text .= "<th>Description</th>";
                $text .= "<th>OnHand</th>";
                $text .= "<th>OnOrder</th>";
                $text .= "<th>Cost</th>";
                $text .= "<th>ListPrice</th>";
                $text .= "</tr>";

                echo $text;
            }
        
            function FillInfoTable()
            {
                $vendorNo = $_POST["VendorNo"];
                
                if(isset($vendorName))
                {
                    $db = ConnectToDatabase();

                    $qryStr = "";
                    $qryStr .= "SELECT ";
                    $qryStr .=      "B.VendorName, ";
                    $qryStr .=      "A.PartID, ";
                    $qryStr .=      "A.Description, ";
                    $qryStr .=      "A.OnHand, ";
                    $qryStr .=      "A.OnOrder, ";
                    $qryStr .=      "A.Cost, ";
                    $qryStr .=      "A.ListPrice ";
                    $qryStr .= "FROM ";
                    $qryStr .=      "Parts A, ";
                    $qryStr .=      "Vendors B ";
                    $qryStr .= "WHERE A.VendorNo = B.VendorNo ";
                    $qryStr .= "AND   A.VendorNo = ?";

                    $qlist = array($vendorNo);

                    $result = $db -> prepare($qryStr);
                    $result -> execute($qlist);

                    $tableBodyText = ""; 

                    while ($row = $result -> fetch())
                    {
                        $vendorName = $row['VendorName'];
                        $partId = number_format($row['PartID'], 0, '', '');
                        $description = $row['Description'];
                        $onHand = number_format($row['OnHand'], 0, '', ',');
                        $onOrder = number_format($row['OnOrder'], 0, '', ',');
                        $cost = number_format($row['Cost'], 4, '.', ',');
                        $listPrice = number_format($row['ListPrice'], 2, '.', ',');

                        $tableBodyText .= "<tr>";
                        $tableBodyText .= "<td>$partId</td>";
                        $tableBodyText .= "<td class='text'>$description</td>";

                        $tableBodyText .= "<td class='num'>$onHand</td>";
                        $tableBodyText .= "<td class='num'>$onOrder</td>";
                        $tableBodyText .= "<td class='num'>$cost</td>";
                        $tableBodyText .= "<td class='num'>$listPrice</td>";
                        $tableBodyText .= "</tr>";
                    }
                    
                    echo "<h3>Vendor Name: ".$vendorName." (".$vendorNo.")</h3>";
                    
                    echo $tableBodyText;
                }
                else
                {
                    echo "<h3>There are parts associated with this vendor.</h3>";
                }

                
            }

        ?>
    </head>
      
    <body>
        <header>
            <div id="allDv"><br><br>        
                <div class="resultDiv">
                    <h2>Parts information by vendors</h2>
                    <div class="btnHomeDiv" >
                        <input type="button" name="btnBack" id="btnBack" value="Go Home"/>
                    </div>
                </div>
            </div>
        </header>
		<main>
            <table class="parameter">
                <?php
				    CreateTableHeader();
				    FillInfoTable();
			     ?>
	       </table>
	   </main>
  </body>
    
</html>





