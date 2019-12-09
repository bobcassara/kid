$(document).ready(function() {

    //Get ticket number for success

    $('.successLink').click(function() {
        repairid = $(this).attr('rel');
        var ticket = prompt("Enter Ticket Number");
        if (ticket) {
            window.location.replace("success.php?ticket=" + ticket + "&id=" + repairid);
        }
    });

    //reset Form

    $('#reset').click(function() {
        window.location.href = "index.php";
        return false;
    });

	//IDC toggle

    $('#idcToggle').click(function() {
        console.log("IDC TOGGLE PROESSED")
		window.location.href = "../idp/index.php";
		return false;
    });
    // //Delete Cookie on logout
    // $('.logout').click(function() {
    //
    // document.cookie = "user=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
    // document.cookie = "admin=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
    // window.location.href = "index.php";
    // return false;
    // });

    //AddNew Form
	
    $('#addNew').click(function() {
        window.location.href = "newform.php";
        return false;
    });

    //admin area

    $('#admin').click(function() {
        window.location.href = "admin/index.php";
        return false;
    });
    
//---------------------------------------------------------------------------------------------------------------------------
    //category selected - SHOW or HIDE the subs

    $("select[name=category]").click(function() {
        var str = "";
        $("select[name=category] option:selected").each(function() {
            str += $(this).text() + " ";
        });
        
        console.log(str);
        
        if (str === 'ALL ') {//ALL
            $(".jam").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === 'Jam Codes ') {//Jam Codes
            $(".jam").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        
        } else if (str === 'Error Code ') {//Error Codes
            console.log(str);
			$(".serviceCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Print or Copy ") {//printer Codes
            $(".printCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Scan ") {//scan Codes
            $(".scanCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Image Quality ") {//Image Codes
            $(".imageCode").fadeIn(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Fax ") {//fax Codes
            $(".faxCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Status or Alert Msg ") {//Status Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeIn(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Boot Failure ") {//Boot Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeIn(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Procedure ") {//Procedure Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeIn(1);
        } else if (str === "Authentication ") {//Authentication Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeIn(1);
            $(".procedureCode").fadeOut(1);
        } else if (str === "Output or Finishing ") {//Fin Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeIn(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        }else if (str === "Presales ") {//Presales
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        }else if (str === "Noise ") {//Noise
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".jam").fadeOut(1);
            $(".statusCode").fadeOut(1);
            $(".bootCode").fadeOut(1);
            $(".finCode").fadeOut(1);
            $(".authCode").fadeOut(1);
            $(".procedureCode").fadeOut(1);
        }
    });
    //-------------------------------------------------------------------------------------------------------------------------------
    //Model Selection in Add form
    
    $("select[name=modelType]").click(function() {
        var str = "";
        $("select[name=modelType] option:selected").each(function() {
            str += $(this).text() + " ";
        });
        //console.log(str);
        if (str === 'All ') {
            $(".allModels").fadeIn(1);
            $(".mxModels").fadeOut(1);
            $(".solutionModels").fadeOut(1);
            
        } else if (str === 'MX Series ') {
            $(".allModels").fadeOut(1);
            $(".mxModels").fadeIn(1);
            $(".solutionModels").fadeOut(1);
    	} else if (str === 'Select ') {
            $(".allModels").fadeOut(1);
            $(".mxModels").fadeOut(1);
            $(".solutionModels").fadeOut(1);
       } else if (str === 'Solutions ') {
            $(".allModels").fadeOut(1);
            $(".mxModels").fadeOut(1);
            $(".solutionModels").fadeIn(1);
           }
    	});
    //Cancel Button

    $('#cancel').click(function() {
        window.location.href = "index.php";
        return false;
    });

    //Hide Extras on search form

    $('#more').click(function() {

        var expand = $.cookie("more");
        if (expand == "show") {
            $.cookie("more", "hidden");
        } else {
            $.cookie("more", "show");
        }
        $('.ticketTextBox').fadeToggle(500);
        $('.hidden').fadeToggle(500);
        $('.suggestion').fadeToggle(500);
        
        //reload page to relect changes made to more cookie
        location.replace('index.php');
        
    });

    //Hide Models when over 100

    $('.showModels').click(function() {
        $('.hideModels', this).fadeToggle(500);
    });

    //Make the NON-defaults green

    var cat = $('.category').val();
    if (cat !== "%") {
        $('.category').css("background-color", "#ffff99");

    }
    var mod = $('.modelTextBox').val();
    if (mod !== "") {
        $('.modelTextBox').css("background-color", "#ffff99");
    }
    var tik = $('.resizedTextBox').val();
    if (tik !== "") {
        $('.resizedTextBox').css("background-color", "#ffff99");
    }
    var prob = $('.problem').val();
    if (prob !== "") {
        $('.problem').css("background-color", "#ffff99");
    }
    var sol = $('.solutions').val();
    if (sol !== "%") {
        $('.solutions').css("background-color", "#ffff99");
    }
    var sug = $('.suggestion').val();
    if (sug !== "") {
        $('.suggestion').css("background-color", "#ffff99");
    }
    var sug = $('.status').val();
    if (sug !== "custom") {
        $('.status').css("background-color", "#ffff99");
    }
    var aut = $('.author').val();
    if (aut !== "%") {
        $('.author').css("background-color", "#ffff99");
    }
    //Enter Pressed - Then submit form

    $('.problem').keypress(function(event) {
        if (event.which == 13 || event.which == 10) {
            event.preventDefault();
            $('#updateButton').click();
        }
    });
    
  $('.textBox').keypress(function(event) {
        if (event.which == 13 || event.which == 10) {
            event.preventDefault();
            $('#updateButton').click();
        }
    });
    
    
    
//----------------------------------------------- 
//bobble redirect
//ToDo

$('#bobbleSearch').click(function() {
	location.replace('bobble.php');
})

$('#kidSearch').click(function() {
	location.replace('index.php');
})
//------------------------------------------------
    //ThumbsDown

    $('#adminThumbsDown').click(function() {
        window.location.href = "thumbsDown.php";
        return false;
    });
    //odd columns in grey

    $('table#mainTable tr:even').css("background-color", "#ccc");

//GET MODEL INFO/////
	
	$('img[src="images/get_info.png"]').click(function() {
        var model=$( ".modelNumber option:selected" ).text();
        
        if (model=="All Models"){
        alert("First select a model from the model pull down!");
        }else{
        var url="modelInfo.php?model=" + model;
        window.open(url,null, "height=500,width=400,status=no,toolbar=no,menubar=no,location=no");
        return false;}
    });
    
//GET TICKET INFO/////
	
	$('img[src="images/get_ticketinfo.png"]').click(function() {
        var ticket=$('#ticket').val();
        console.log(ticket);
        if (ticket==""){
        alert("First enter a ticket number");
        }else{
        var url="ticketInfo.php?ticket=" + ticket;
        window.open(url,null, "height=500,width=1000,status=no,toolbar=no,menubar=no,location=no");
        return false;}
    });    
        
    
    
 //Forgot Password
	$('#forgotPassword').click(function() {
		console.log('forgotPassword line 379');
		var url="forgotPassword.php";
        window.open(url,null, "height=200,width=400,status=no,toolbar=no,menubar=no,location=no");
        return false;
		
		
	});

// HowTo or model exclusive

	$('.howTo').css("border", "2px solid red");

    /////////Admin Functions/////////////////////////////

    //Home

    $('#home').click(function() {
        window.location.href = "../index.php";
        return false;
    });

    //Summary
    $('#summary').click(function() {
        window.location.href = "summary.php";
        return false;
    });
    
    //Avaya
    $('#avaya').click(function() {
        window.location.href = "avaya.php";
        return false;
    });
    //Add Model Series
    $('#adminNewModel').click(function() {
        window.location.href = "addModel.php";
        return false;
    });
    
    //Edit Model Series
    $('#editModel').click(function() {
        window.location.href = "editModel.php";
        return false;
    });
    
    
    //Authored by staff
    $('#authoredByAgent').click(function() {
        window.location.href = "authoredByAgent.php";
        return false;
    });
    //Edits By Staff
    $('#editsByAgent').click(function() {
        window.location.href = "viewEdits.php";
        return false;
    });

    //Edit Staff

    $('#editStaff').click(function() {
        window.location.href = "editStaff.php";
        return false;
    });
	//Export Database

    $('#exportDatabase').click(function() {
        window.location.href = "exportDatabase.php";
        return false;
    });
    //Success By Agent

    $('#successByAgent').click(function() {
        window.location.href = "successByAgent.php";
        return false;
    });
    
    $('#adminConfirmedRepair').click(function() {
        window.location.href = "confirmedRepair.php";
        return false;
    });
    
    
    //No Success

    $('#thumbsDown').click(function() {
        repairid = $(this).attr('rel');
        var url = window.location.href;
        url = url.replace('/index.php', '/nosuccess.php');
        url = url.replace('#','');
        console.log(url);
        var jticket = prompt("Enter Ticket Number");
        console.log(jticket);
        
        var notes = prompt("Notes:");
        if (jticket) {
            window.location.replace(url + "&jticket=" + jticket + "&notes=" + notes);
        }else{alert("You did not enter a ticket number!");}
    });
    
    
	
	//POPUP for add confirmed repair
		$('#confirmedRepairForm').on('change', function() {
			var existingStatus = ($('input[name="existing"]:checked', '#confirmedRepairForm').val());
			$(".newConfirmedRepair").fadeOut(1);
			if (existingStatus =="new") {
				$(".newConfirmedRepair").fadeIn(1);
				//$("#confirmedSolution").val("");
				}else{ 
					$(".newConfirmedRepair").fadeOut(1);
					$("#confirmedSolution").val(existingStatus);
					console.log(existingStatus);
			} 
			
		});
		
		
	
});//End DocReady
