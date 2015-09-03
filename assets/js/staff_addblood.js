$(document).ready(function () {

    $("#dogsearchbtn").on("click", function (e) {
        $("#dogsearchmodal").openModal();
        $("#dogsearchinput").val("");
        $("#dogsearchinput").removeAttr("disabled");
        $("#dogsearchmodalsearch").removeAttr("disabled");
        $("#dogsearchinput").focus();
        $("#dogsearchloader").hide();
        $("#dogsearchresult").hide();
        $("#dogsearchadd").hide();
    });
    $("#dogsearchmodalcancel").on("click", function (e) {
        $("#dogsearchmodal").closeModal();
    });
    $("#dogsearchmodalsearch").on("click", function (e) {
        $("#dogsearchsearchinput").attr("disabled", "disabled");
        $("#dogsearchmodalsearch").attr("disabled", "disabled");
        $("#dogsearchsearchinput").attr("disabled", "disabled");
        $("#dogsearchresult").hide();
        $("#dogsearchadd").hide();
        $("#dogsearchloader").fadeIn(200);
        $.ajax({
            url: "../api/hospitalDogSearch.php",
            type: "POST",
            data: {"searchby": $("#searchby").val(), "searchtext": $("#dogsearchinput").val()},
            dataType: "json",
            success: function (data) {
                if (data.length > 0) {
                    $("#dogsearchresult").html("");
                    $.each(data, function (i, item) {
                        $("#dogsearchresult").append('<a href="#!" data-dog-id="' + item.hospital_dogid
                                + '" class="collection-item dogsearchselect">' + item.hospital_dogdonorname + ' (สายพันธ์ ' + item.breeds_name + ') ของคุณ ' + item.hospital_donorname + '</a>');
                    });
                    $("#dogsearchresult").fadeIn(200);
                } else {
                    $("#dogsearchadd").fadeIn(200);
                    $("#newdogsearch").val($("#dogsearchsearchinput").val());
                    $("#newdogsearch").prev().addClass("active");
                    $("#newdogsearch").next().addClass("active");
                    $("#newdogsearch").addClass("active");
                    $("#newdogsearch").addClass("vaild");
                    $("#newdogsearch").focus();
                }
                $("#dogsearchloader").hide();
                $("#dogsearchsearchinput").removeAttr("disabled");
                $("#dogsearchmodalsearch").removeAttr("disabled");
            }
        });
    });
    $("#dogsearchresult").on("click", ".dogsearchselect", function (e) {
        $("#dogsearchresult").hide();
        $("#dogsearchloader").fadeIn(200);
        var dog_id = $(this).attr("data-dog-id");
        $.ajax({
            url: "../api/getHospitalDog.php",
            type: "POST",
            data: {"dogid": dog_id},
            dataType: "json",
            success: function (data) {
                if (data.result == "1") {
                    $("#dogsearchbtn").attr("disabled", "disabled");
                    $("#dogaddbtn").attr("disabled", "disabled");
                    $("#dogname").val(data.dogname);
                    $("#ownername").val(data.donorname);
                    $("#dogid").val(dog_id);
                    $("#dogid").prev().addClass("active");
                    $("#dogid").next().addClass("active");
                    $("#dogid").addClass("active");
                    $("#dogid").addClass("vaild");
                    $("#dogid").attr("readonly", "readonly");
                    $("#dogname").attr("readonly", "readonly");
                    $("#ownername").attr("readonly", "readonly");
                    $("#dogname").prev().addClass("active");
                    $("#dogname").next().addClass("active");
                    $("#dogname").addClass("active");
                    $("#dogname").addClass("vaild");
                    $("#dogname").focus();
                    $("#ownername").prev().addClass("active");
                    $("#ownername").next().addClass("active");
                    $("#ownername").addClass("active");
                    $("#ownername").addClass("vaild");
                    $("#ownername").focus();
                    $("#breeds").val(data.breeds_name);
                    $("#breeds").attr("readonly", "readonly");
                    $("#breeds").prev().addClass("active");
                    $("#breeds").next().addClass("active");
                    $("#breeds").addClass("active");
                    $("#breeds").addClass("vaild");
                    $("#breeds").focus();
                    $("#blood").val(data.bloodtype_id);
                    $("#blood").attr("readonly", "readonly");
                    $("select").material_select();
                    $(".caret").filter(".disabled").remove();
                    $("#dogname").removeAttr("disabled");
                    $("#ownername").removeAttr("disabled");
                    $("#volume").removeAttr("disabled");
                    $("#pcv").removeAttr("disabled");
                    $("#savebtn").removeAttr("disabled");
                    $("#dogsearchmodal").closeModal();
                }
            }
        });
    });
    //add new dog function
    $("#dogaddbtn").on("click", function (e) {
        $("#newdogbtn").hide();
        $("#newdogcheck").fadeIn(200);
        $("#dogsearchbtn").hide();
        $("#dogid").removeAttr("readonly");
        $("#dogid").focus();
    });

    $("#newdogcheckbtn").on("click", function (e) {
        var dogid = $("#dogid").val();
        if (dogid.length > 0) {
        $("#newdogcheckbtn").attr("disabled", "disabled");
        $("#newdogcheckbtn").html("Checking...");
            $.ajax({
                url: "../api/getHospitalDog.php",
                type: "POST",
                data: {"dogid": dogid},
                dataType: "json",
                success: function (data) {
                    if (data.result == "1") {
                        alert("This Dog ID can't use, it is already exists in this hospital !");
                        $("#newdogcheckbtn").removeAttr("disabled");
                        $("#newdogcheckbtn").html("Search");
                    } else if (data.result == "2") {
                        alert("This Dog ID can't use, because it has been used by another Hospital.");
                        $("#newdogcheckbtn").removeAttr("disabled");
                        $("#newdogcheckbtn").html("Search");
                    } else if (data.result == "3") {
                        alert("This Dog ID can't use, because it has been removed from database");
                        $("#searchbtn").removeAttr("disabled");
                        $("#searchbtn").html("Search");
                    } else {
                        $("#newdogcheckbtn").hide();
                        $("#dogsearchbtn").hide();
                        $("#dogsearchbtn").attr("disabled", "disabled");
                        $("#breeds").removeAttr("disabled");
                        $("#breedssearchbtn").removeAttr("disabled");
                        $("#blood").removeAttr("disabled");
                        $("select").material_select();
                        $(".caret").filter(".disabled").remove();
                        $("#dogname").removeAttr("disabled");
                        $("#ownername").removeAttr("disabled");
                        $("#volume").removeAttr("disabled");
                        $("#pcv").removeAttr("disabled");
                        $("#savebtn").removeAttr("disabled");
                        $("#dogid").attr("readonly", "readonly");
                        $("#dogname").focus();
                    }
                }
            });
        }
    });
    $("#dogsearchinput").on("keyup", function (e) {
        if (e.keyCode == 13) {
            $("#dogsearchmodalsearch").click();
        }
    });

    $("#form").on("submit", function (e) {
        var pcv = parseFloat$("#pcv").val();
        var vol = parseFloat$("#volume").val();
        if (vol <= pcv) {
            alert("Error : Blood Volume amount (" + vol + " cc.) should greater than PCV value (" + pcv + " %)\nPlease change the values before try saving again.");
            e.preventDefault();
            return false;
        }
    });
    $("#breedssearchbtn").on("click", function (e) {
        $("#breedsmodal").openModal();
        $("#breedssearchinput").removeAttr("disabled");
        $("#breedsmodalsearch").removeAttr("disabled");
        $("#breedssearchinput").val("");
        $("#breedssearchinput").addClass("active");
        $("#breedssearchinput").focus();
        $("#breedsresult").hide();
        $("#breedsloader").hide();
        $("#breedsadd").hide();
    });
    $("#breedsmodalcancel").on("click", function (e) {
        $("#breedsmodal").closeModal();
    });
    $("#breedsmodalsearch").on("click", function (e) {
        $("#breedssearchinput").attr("disabled", "disabled");
        $("#breedsmodalsearch").attr("disabled", "disabled");
        $("#breedssearchinput").attr("disabled", "disabled");
        $("#breedsresult").hide();
        $("#breedsadd").hide();
        $("#breedsloader").fadeIn(200);
        $.ajax({
            url: "../api/breedsSearch.php",
            type: "POST",
            data: {"searchtext": $("#breedssearchinput").val()},
            dataType: "json",
            success: function (data) {
                if (data.length > 0) {
                    $("#breedsresult").html("");
                    $.each(data, function (i, item) {
                        $("#breedsresult").append('<a href="#!" data-breeds_id="' + item.breeds_id +
                                '" data-breeds_name="' + item.breeds_name + '" class="collection-item breedselect">' + item.breeds_name + '</a>');
                    });
                    $("#breedsresult").fadeIn(200);
                } else {
                    $("#breedsadd").fadeIn(200);
                    $("#newbreeds").val($("#breedssearchinput").val());
                    $("#newbreeds").prev().addClass("active");
                    $("#newbreeds").next().addClass("active");
                    $("#newbreeds").addClass("active");
                    $("#newbreeds").addClass("vaild");
                    $("#newbreeds").focus();
                }
                $("#breedsloader").hide();
                $("#breedssearchinput").removeAttr("disabled");
                $("#breedsmodalsearch").removeAttr("disabled");
            }
        });
    });
    $("#breedssearchinput").on("keyup", function (e) {
        if (e.keyCode == 13) {
            $("#breedsmodalsearch").click();
        }
    });
    $("#breedsresult").on("click", ".breedselect", function (e) {
        var breeds_id = $(this).attr("data-breeds_id");
        var breeds_name = $(this).attr("data-breeds_name");
        $("#breeds_id").val(breeds_id);
        $("#breeds").val(breeds_name);
        $("#breeds").prev().addClass("active");
        $("#breeds").next().addClass("active");
        $("#breeds").addClass("active");
        $("#breeds").addClass("vaild");
        $("#breeds").focus();
        $("#breedsmodal").closeModal();
    });
    $("#newbreedsbtn").on("click", function (e) {
        if ($("#newbreeds").val() != "") {
            $("#breedssearcharea").slideUp(200);
            $("#breedsloader").fadeIn(200);
            $("#breedsadd").hide();
            $.ajax({
                url: "../api/breedsSearch.php",
                type: "POST",
                data: {"newbreeds": $("#newbreeds").val()},
                dataType: "json",
                success: function (data) {
                    $("#breeds_id").val(data.breeds_id);
                    $("#breeds").val(data.breeds_name);
                    $("#breeds").prev().addClass("active");
                    $("#breeds").next().addClass("active");
                    $("#breeds").addClass("active");
                    $("#breeds").addClass("vaild");
                    $("#breeds").focus();
                    $("#breedsmodal").closeModal();
                }
            });
        }
    });
    $("#navhospital").addClass("active");
    $("#navhospital_addblood").addClass("active");
    $('.collapsible').collapsible();
    $("select").material_select();
    setInterval(function () {
        $(".prefix").removeClass("active");
    }, 100)

    $("#searchbtn").on("click", function (e) {
        var dogid = $("#dogid").val();
        if (dogid.length > 0) {
            $("#searchbtn").attr("disabled", "disabled");
            $("#searchbtn").html("Searching...");
            $("#errortext").remove();
            $.ajax({
                url: "../api/getHospitalDog.php",
                type: "POST",
                data: {"dogid": dogid},
                dataType: "json",
                success: function (data) {
                    if (data.result == "1") {
                        $("#searchresult").html("Dog found in database.");
                        $("#dogname").val(data.dogname);
                        $("#ownername").val(data.donorname);
                        $("#dogid").attr("readonly", "readonly");
                        $("#dogname").attr("readonly", "readonly");
                        $("#ownername").attr("readonly", "readonly");
                        $("#dogname").prev().addClass("active");
                        $("#dogname").next().addClass("active");
                        $("#dogname").addClass("active");
                        $("#dogname").addClass("vaild");
                        $("#dogname").focus();
                        $("#ownername").prev().addClass("active");
                        $("#ownername").next().addClass("active");
                        $("#ownername").addClass("active");
                        $("#ownername").addClass("vaild");
                        $("#ownername").focus();
                        $("#breeds").val(data.breeds_name);
                        $("#breeds").attr("readonly", "readonly");
                        $("#breeds").prev().addClass("active");
                        $("#breeds").next().addClass("active");
                        $("#breeds").addClass("active");
                        $("#breeds").addClass("vaild");
                        $("#breeds").focus();
                        $("#blood").val(data.bloodtype_id);
                        $("#blood").attr("readonly", "readonly");
                        $("select").material_select();
                        $(".caret").filter(".disabled").remove();
                        $("#dogname").removeAttr("disabled");
                        $("#ownername").removeAttr("disabled");
                        $("#volume").removeAttr("disabled");
                        $("#pcv").removeAttr("disabled");
                        $("#savebtn").removeAttr("disabled");
                    } else if (data.result == "2") {
                        $("#searchresult").append("<span id='errortext' style='color:red'><br><br>This Dog ID can't use, because it has been used by another Hospital.</span>");
                        $("#searchbtn").removeAttr("disabled");
                        $("#searchbtn").html("Search");
                    } else if (data.result == "3") {
                        $("#searchresult").append("<span id='errortext' style='color:red'><br><br>This Dog ID can't use, because it has been removed from database.</span>");
                        $("#searchbtn").removeAttr("disabled");
                        $("#searchbtn").html("Search");
                    } else {
                        $("#searchresult").html("Dog ID is not in database, This will add new hospital dog in database");
                        $("#breeds").removeAttr("disabled");
                        $("#breedssearchbtn").removeAttr("disabled");
                        $("#blood").removeAttr("disabled");
                        $("select").material_select();
                        $(".caret").filter(".disabled").remove();
                        $("#dogname").removeAttr("disabled");
                        $("#ownername").removeAttr("disabled");
                        $("#volume").removeAttr("disabled");
                        $("#pcv").removeAttr("disabled");
                        $("#savebtn").removeAttr("disabled");
                    }
                }
            });
        }
    });
});