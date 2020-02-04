<html lan="en">

	<head>
        <meta charset="utf-8" />
        <title>Assignment5</title>

		<link rel="stylesheet" href="css/main.css" />
		<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
		<script src="http://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        
        
		<script type="text/javascript" src="js/index.js"></script>
        
		<?php
            include("connection.php");
        
            $vendorSel = "<select name='VendorNo' id='VendorNo'>";
        
            $db = ConnectToDatabase();

            $qryStr = "SELECT VendorNo, VendorName FROM Vendors";
            $result = $db -> prepare($qryStr);
            $result -> execute();
        
            while ($row = $result -> fetch())
            {
                $vendorNo = number_format($row['VendorNo'], 0, '', '');
                $vendorName = $row['VendorName'];
                
                $vendorSel = $vendorSel."<option value='".$vendorNo."'>";
                $vendorSel = $vendorSel.$vendorName."</option>"."\n";
            }
        
            $vendorSel = $vendorSel."</select>";
		?>
	</head>

	<body>
        
<!--
        <input type="button" name="parts" id="parts" value="PARTS"/>
        <input type="button" name="vendors" id="vendors" value="VENDORS"/>
        <input type="button" name="query" id="query" value="QUERY"/>
-->

        <fieldset>
            <legend>Parts</legend>
            <form onsubmit="return PartsValidationForm();" action="parts.php" method="post">
                    <B>Instructions:</B>
            <br>
            <ol>
                <li>Fill in the form below to create a new part.</li>
                <li>Make sure to fill in <i>all</i> required fields.</li>
                <li>Once completed correctly, click the <i>Submit</i> button to add the new vendor.</li>
            </ol>
                <br>* indicates a required field.
                <table class=division>
                    <tr>
                        <td>Vendor Name *</td>
                        <td><?php	echo $vendorSel; ?></td>
                    </tr>
                    <tr>
                        <td>Description *</td>
                        <td><input type="text" id="Description" name="Description" size="50"/></td>
                    </tr>
                    <tr>
                        <td>On Hand *</td>
                        <td><input type="text" id="OnHand" name="OnHand" size="20"/></td>
                    </tr>
                    <tr>
                        <td>On Order *</td>
                        <td><input type="text" id="OnOrder" name="OnOrder" size="20"/></td>
                    </tr>
                    <tr>
                        <td>Cost *</td>
                        <td><input type="text" id="Cost" name="Cost" size="20"/></td>
                    </tr>
                    <tr>
                        <td>List Price *</td>
                        <td><input type="text" id="ListPrice" name="ListPrice" size="20"/></td>
                    </tr>
                </table>

                <div class="btnDiv" >
                    <input type="submit" name="submit" id="submit" value="SUBMIT"/>
                    <input type="reset" name="reset" id="reset" value="RESET"/>
                </div>
                <div id="partsErrList"></div>

            </form>
        </fieldset>
        
        <fieldset>
            <legend>Vendors</legend>
            <form onsubmit="return VendorsValidationForm();" action="vendors.php" method="post">
            <B>Instructions:</B>
            <br>
            <ol>
                <li>Fill in the form below to create a new Vendor.</li>
                <li>Make sure to fill in <i>all</i> required fields.</li>
                <li>Once completed correctly, click the <i>Submit</i> button to add the new vendor.</li>
            </ol>
            <br>* indicates a required field.
                <table class=division>
                    <tr>
                        <td>Vendor Name *</td>
                        <td><input type="text" id="VendorName" name="VendorName" size="30"/></td>
                    </tr>
                    <tr>
                        <td>Address1 *</td>
                        <td><input type="text" id="Address1" name="Address1" size="50"/></td>
                    </tr>
                    <tr>
                        <td>Address2 *</td>
                        <td><input type="text" id="Address2" name="Address2" size="50"/></td>
                    </tr>
                    <tr>
                        <td>City *</td>
                        <td><input type="text" id="City" name="City"/ size="30"></td>
                    </tr>
                    <tr>
                        <td>Prov./State *</td>
                        <td>
                            <select name="Prov" id="Prov">
                                <option value="AB">Alberta, CA</option>
                                <option value="BC">British Columbia, CA</option>
                                <option value="MB">Manitoba, CA</option>
                                <option value="NB">New Brunswick, CA</option>
                                <option value="NL">Newfoundland and Labrador, CA</option>
                                <option value="NT">Northwest Territories, CA</option>
                                <option value="NS">Nova Scotia, CA</option>
                                <option value="NU">Nunavut, CA</option>
                                <option value="ON">Ontario, CA</option>
                                <option value="PE">Prince Edward Island, CA</option>
                                <option value="QC">Quebec, CA</option>
                                <option value="SK">Saskatchewan, CA</option>
                                <option value="YT">Yukon, CA</option>
                                <option value="AL">Alabama, US</option>
                                <option value="AK">Alaska, US</option>
                                <option value="AZ">Arizona, US</option>
                                <option value="AR">Arkansas, US</option>
                                <option value="CA">California, US</option>
                                <option value="CO">Colorado, US</option>
                                <option value="CT">Connecticut, US</option>
                                <option value="DE">Delaware, US</option>
                                <option value="DC">District of Columbia, US</option>
                                <option value="FL">Florida, US</option>
                                <option value="GA">Georgia, US</option>
                                <option value="HI">Hawaii, US</option>
                                <option value="ID">Idaho, US</option>
                                <option value="IL">Illinois, US</option>
                                <option value="IN">Indiana, US</option>
                                <option value="IA">Iowa, US</option>
                                <option value="KS">Kansas, US</option>
                                <option value="KY">Kentucky, US</option>
                                <option value="LA">Louisiana, US</option>
                                <option value="ME">Maine, US</option>
                                <option value="MD">Maryland, US</option>
                                <option value="MA">Massachusetts, US</option>
                                <option value="MI">Michigan, US</option>
                                <option value="MN">Minnesota, US</option>
                                <option value="MS">Mississippi, US</option>
                                <option value="MO">Missouri, US</option>
                                <option value="MT">Montana, US</option>
                                <option value="NE">Nebraska, US</option>
                                <option value="NV">Nevada, US</option>
                                <option value="NH">New Hampshire, US</option>
                                <option value="NJ">New Jersey, US</option>
                                <option value="NM">New Mexico, US</option>
                                <option value="NY">New York, US</option>
                                <option value="NC">North Carolina, US</option>
                                <option value="ND">North Dakota, US</option>
                                <option value="OH">Ohio, US</option>
                                <option value="OK">Oklahoma, US</option>
                                <option value="OR">Oregon, US</option>
                                <option value="PA">Pennsylvania, US</option>
                                <option value="RI">Rhode Island, US</option>
                                <option value="SC">South Carolina, US</option>
                                <option value="SD">South Dakota, US</option>
                                <option value="TN">Tennessee, US</option>
                                <option value="TX">Texas, US</option>
                                <option value="UT">Utah, US</option>
                                <option value="VT">Vermont, US</option>
                                <option value="VA">Virginia, US</option>
                                <option value="WA">Washington, US</option>
                                <option value="WV">West Virginia, US</option>
                                <option value="WI">Wisconsin, US</option>
                                <option value="WY">Wyoming, US</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Postal/Zip *</td>
                        <td><input type="text" id="PostCode" name="PostCode"  size="20"/></td>
                    </tr>
                    <tr>
                        <td>Country *</td>
                        <td><input type="text" id="Country" name="Country"  size="30"/></td>
                    </tr>
                    <tr>
                        <td>Phone *</td>
                        <td><input type="text" id="Phone" name="Phone"  size="20"/></td>
                    </tr>
                    <tr>
                        <td>FAX *</td>
                        <td><input type="text" id="Fax" name="Fax"  size="20"/></td>
                    </tr>
                </table>

                <div class="btnDiv" >
                    <input type="submit" name="submit" id="submit" value="SUBMIT"/>
                    <input type="reset" name="reset" id="reset" value="RESET"/>
                </div>
                <div id="vendorsErrList"></div>
            </form>
        </fieldset>
        
        <fieldset>
            <legend>Query</legend>
            <form onsubmit="return queryValidationForm();" action="query.php" method="post">
                
                <table class=division>
                    <tr>
                        <td>Vendor Name</td>
                        <td><?php	echo $vendorSel; ?></td>
                    </tr>
                </table>
                
                <div class="btnDiv" >
                    <input type="submit" name="submit" id="submit" value="SEARCH"/>
                </div>
                <div id="vendorsErrList"></div>
            </form>            
        </fieldset>
	</body>
</html>



