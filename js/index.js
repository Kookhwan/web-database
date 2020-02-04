// member variables - for validation
var ptrnNum = /^[0-9\.]*$/;             // Number only
var ptrnAlpha = /^[a-zA-Z .]+$/;        // Alphabet only
                                        // City(20), Prov(2), Country(2)
var ptrnAlphaNum = /^[-@.#&+\w\s]*$/;   // Alphabet and numeric only
                                        // Description, VendorName, Address1, Address2
var ptrnZip = /^[0-9]{5}/;                                  // Zip code -- U.S.A
var ptrnPost = /^[ABCEGHJKLMNPRSTVXY]\d[A-Z]\d[A-Z]\d$/;    // Post Code -- Canada


// call when loading this file
$(function(){
	// set function of provState select onChange event
	$('select[id=Prov]').on('change', function (e) {
		if ($("#Prov option:selected").text().match(/CA$/) )
		{
			$('#Country').val("Canada");
		}
		else		{
			$('#Country').val("U.S.A.");
		}
	});
    
    // make postal to upper case 
    $('input[id=PostCode]').on('blur', function (e) {
        postUpperCase(e.target.id);
    });
});

// make postal code to upper case 
function postUpperCase() 
{
	makeTrim("PostCode");
	var valEle = $("#PostCode");
	valEle.val(valEle.val().toUpperCase());
}

// trim input value
function makeTrim(eleName)
{
	var name = "#" + eleName;
	var str = $(name).val();
	while(str.startsWith(" "))
	{
		str = str.slice(1);
	}
	while(str.endsWith(" "))
	{
		str = str.slice(0, str.length-1);
	}
	$(name).val(str);
	makeCapital(eleName);
    
	return str;
}

// make the first character capitalize
function makeCapital(eleName)
{
	var name = "#" + eleName;
	var str = $(name).val();
	if (str.length > 0)
	{
	    var strArr = str.split(" ");
	    var newStr = "";
	    for (i = 0 ; i < strArr.length; i++)
	    {
	        strArr[i] = strArr[i].charAt(0).toUpperCase() + strArr[i].slice(1);
	        if (strArr[i] != "")
	        {
	            newStr += strArr[i] + " ";
	        }
	    }
	    if (newStr.endsWith(" "))
	    {
	        newStr = newStr.slice(0, newStr.length-1);
	    }
	    $(name).val(newStr);
	}
}


// set function of parts onSubmit event
function PartsValidationForm()
{
    var dispMsg = "<fieldset><legend>Error Details</legend>";
    var errMsg = checkValue("parts");

    if (errMsg != "")
    {
        dispMsg += errMsg + "</fieldset>";
        document.getElementById("partsErrList").innerHTML = dispMsg;
        return false;
    }
}

// set function of vendors onSubmit event
function VendorsValidationForm()
{
    var dispMsg = "<fieldset><legend>Error Details</legend>";
    var errMsg = checkValue("vendors");

    if (errMsg != "")
    {
        dispMsg += errMsg + "</fieldset>";
        document.getElementById("vendorsErrList").innerHTML = dispMsg;
        return false;
    }
}

// set function of Query onSubmit event
function QueryValidationForm()
{
    var dispMsg = "<fieldset><legend>Error Details</legend>";
    var errMsg = checkValue("query");

    if (errMsg != "")
    {
        dispMsg += errMsg + "</fieldset>";
        document.getElementById("queryErrList").innerHTML = dispMsg;
        return false;
    }
}

// check all input values and generate result message
// focus at the first field which has occured error
// argument: form name
function checkValue(formName) 
{
    var fields;
    var errField = "";
    var errMsg = "";
    var country = "";
    
    country = document.getElementById("Country").value;
    
    if (formName == "parts")
    {
        fields = {	"VendorNo":"VendorName", "Description":"Description", 
                    "OnHand":"OnHand", "OnOrder":"OnOrder", 
                    "Cost":"Cost", "ListPrice":"List Price"	};
    }
    else if (formName == "vendors")
    {
        fields = {	"VendorName":"VendorName", "Address1":"Address1", 
                    "Address2":"Address2", "City":"City",
                    "Prov":"Prov", "PostCode":"PostCode",
                    "Country":"Country", "Phone":"Phone", "Fax":"Fax",	};
    }
    else
    {
        fields = {	"VendorNo":"VendorNo"	};
    }
    
    $.each( fields, function( name, sign )
    {
        if ($.trim($('#' + name).val()) === "") 
        {
            errMsg = errMsg + sign + " is a mandatory Field.<br>";
            
            if (errField == "")
            {
                $('#' + name).focus();
                errField = name;
            }
        }
        else
        {
            switch (sign)
            {
                case "Description":
                case "VendorName":
                case "Address1":
                case "Address2":
                    if (!ptrnAlphaNum.test($('#' + name).val()))
                    {
                        errMsg = errMsg + sign + " field should consist of all letters or digits.<br>"
                    }
                    break;
                case "City":
                case "Prov":
                case "Country":
                    if (!ptrnAlpha.test($('#' + name).val()))
                    {
                        errMsg = errMsg + sign + " field should consist of all letters.<br>"
                    }
                    break;
                case "PostCode":
                    if(country === "Canada")
                    {
                        if (!ptrnPost.test($('#' + name).val()))
                        {
                            errMsg = errMsg + sign + " Postal Code field is wrong format. ex) N1N2N3.<br>"
                        }
                    }
                    else
                    {
                        if (!ptrnZip.test($('#' + name).val()))
                        {
                            errMsg = errMsg + sign + " ZIP code should consist to 5 digits.<br>"
                        }
                    }
                    break;
                default:
                    if (!ptrnNum.test($('#' + name).val()))
                    {
                        errMsg = errMsg + sign + " field should consist of all digits..<br>"
                    }
                    break;
            }
        }            
    });

    return errMsg;
}
