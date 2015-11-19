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

    //category selected - SHOW or HIDE the subs

    $("select[name=category]").click(function() {
        var str = "";
        $("select[name=category] option:selected").each(function() {
            str += $(this).text() + " ";
        });
        if (str === 'ALL ') {//ALL
            $(".jam").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
        } else if (str === 'Jam Codes ') {//Jam Codes
            $(".jam").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
        } else if (str === "Service Codes ") {//Service Codes
            $(".serviceCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
        } else if (str === "Print ") {//printer Codes
            $(".printCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
        } else if (str === "Scan ") {//scan Codes
            $(".scanCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
        } else if (str === "Image Quality ") {//Image Codes
            $(".imageCode").fadeIn(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".faxCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
        } else if (str === "Fax ") {//fax Codes
            $(".faxCode").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeOut(1);
            $(".jam").fadeOut(1);
        } else if (str === "Status Message ") {//Status Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".jam").fadeOut(1);
        } else if (str === "Electrical ") {//Electrical Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".jam").fadeOut(1);
            $(".imageCode").fadeOut(1);
        } else if (str === "Procedure ") {//Procedure Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".imageCode").fadeOut(1);
            $(".jam").fadeOut(1);
        } else if (str === "Authentication ") {//Authentication Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".jam").fadeOut(1);
        } else if (str === "Mechanical ") {//Mechanical Codes
            $(".faxCode").fadeOut(1);
            $(".scanCode").fadeOut(1);
            $(".printCode").fadeOut(1);
            $(".imageCode").fadeOut(1);
            $(".serviceCode").fadeOut(1);
            $(".spacer").fadeIn(1);
            $(".jam").fadeOut(1);
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
        console.log(expand);
        if (expand == "") {
            $.cookie("more", "hidden");
        } else {
            $.cookie("more", "");
        }

        //$('#addNew').fadeToggle(500);
        //$('#admin').fadeToggle(500);
        $('.ticketTextBox').fadeToggle(500);
        $('.hidden').fadeToggle(500);
        $('.suggestion').fadeToggle(500);
        location.reload();
        //$("more").toggleClass("hidden");
        //$(more).toggleClass("expanded");
        //if ($(more).hasClass("expanded")){
        //   document.cookie="more=hidden";
        //   console.log("hidden");
        //}else{
        //    document.cookie="more=nothidden";
        //    console.log("nothidden");

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
    console.log("suggest:" + sug);
    if (sug !== "%") {
        $('.status').css("background-color", "#ffff99");

    }

    /////////Admin

    //Home

    $('#home').click(function() {
        window.location.href = "../index.php";
        return false;
    });

    //Authored by staff

    $('#authoredByAgent').click(function() {
        window.location.href = "authoredByAgent.php";
        return false;
    });

    //Edit Staff

    $('#editStaff').click(function() {
        window.location.href = "editStaff.php";
        return false;
    });

    //Success By Agent

    $('#successByAgent').click(function() {
        window.location.href = "successByAgent.php";
        return false;
    });

    //ThumbsDown

    $('#adminThumbsDown').click(function() {
        window.location.href = "thumbsDown.php";
        return false;
    });

    //Enter Pressed - Then submit form

    $(function() {
        $('form').each(function() {
            $(this).find('input').keypress(function(e) {
                // Enter pressed?
                if (e.which === 10 || e.which === 13) {

                    e.preventDefault();
                    $('#updateButton').click();
                }
            });
        });
    });

    //No Success

    $('#thumbsDown').click(function() {
        repairid = $(this).attr('rel');
        var url = window.location.href;
        url = url.replace('/index.php', '/nosuccess.php');
        //if (url) {
        //alert(url);}
        var ticket = prompt("Enter Ticket Number");
        if (ticket) {
            window.location.replace(url + "&ticket=" + ticket);
        }
    });

    //odd columns

    $('table#mainTable tr:even').css("background-color", "#ccc");

});
//End DocReady
