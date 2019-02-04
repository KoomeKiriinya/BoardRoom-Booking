
function OnClick() {
    // Getting the values of the fields required.
    var employeeID =document.getElementById("employeeID").value;
    var boardRoom = document.getElementById("boardroomID").value;
    var startDate = document.getElementById("startDate").value;
    var startTime = document.getElementById("starTime").value;
    var timeBooked = document.getElementById("period").value;
    //form validation
    if(isNaN(employeeID)|| employeeID == ""){
        document.getElementById("presult").innerHTML="Please Enter a number in Employee ID field";
    }else if(timeBooked<= 0){
        console.log(employeeID);
        document.getElementById("presult").innerHTML="Please Enter a valid period of booking";
    }else if (startTime == ""|| startDate == ""){    
        document.getElementById("presult").innerHTML="Enter a valid Start Date / Time";
    }else{
        // create form data to send all the data required to submit.php via ajax.
        var formdata = new FormData();
        formdata.append("employeeID",employeeID);
        formdata.append("boardRoom",boardRoom);
        formdata.append("startDate",startDate)
        formdata.append("startTime",startTime);
        formdata.append("period",timeBooked);  
        $.ajax({
            type:"POST",
            url:"submit.php",
            //add the data that you appended to the form
            data:formdata,
            contentType: false,
			cache: false,
            processData:false,
            success: function(result){
                document.getElementById("presult").innerHTML = result;
            },
            error: function(xhr,status,error){
                alert("Some error please try again"+ " "+ xhr.status+ " "+xhr.statusText);
            }
            

        });

    }
    

}