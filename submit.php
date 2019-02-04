<?php
// retriving the sent values via the post array
$employeeId = $_POST['employeeID'];
$boardRoom  = $_POST['boardRoom'] ;
$startTime = $_POST['startTime'];
$startDate = $_POST['startDate'];
$period = $_POST['period'];
// calculating start time and end time before entry into database
$calcstr = strtotime($startDate." ".$startTime);
$strTime = date("Y-m-d H:i:s",$calcstr);
$endTime= date("Y-m-d H:i:s",$calcstr +(3600 * $period));
bookRoom($employeeId,$boardRoom,$strTime,$endTime);
// function to book the boardroom
function bookRoom($id,$rm,$st,$pr){
    // necessary credentials to connect to db
    $servername = '';
    $username ='';
    $userpassword ='';
    $database ='';
    $link = mysqli_connect($servername,$username,$userpassword,$database);
    if(!$link){
        Die("could not connect ".mysqli_error());
    }
    $retrive = "SELECT `Booking ID`, `EmployeeId`, `BoardRoomName`, `StartTime`, `EndTime` FROM `BookingTable` WHERE  `BoardRoomName`='$rm'";
    $result =mysqli_query($link,$retrive);
    if ($result){
        $Booked = False;
        $freefrom = "";
        foreach($result as $row){
            $timeStart  = date("Y-m-d H:i:s",strtotime($row['StartTime']));
            $timeStop   = date ("Y-m-d H:i:s",strtotime($row['EndTime']));
            //Checking if there exists the same boardroom within the records.
            if ($row['BoardRoomName'] == $rm){
                if($st >= $timeStart && $st < $timeStop){
                    $freefrom = $timeStop;
                    $Booked = True;           
                }
            }
        }
        // checks if boardRoom is booked if not booked it books the board room.
        if ($Booked){
            echo("The board room is not free until ".$freefrom);
        }else{    
            $query ="INSERT INTO `BookingTable`(`Booking ID`,`EmployeeId`, `BoardRoomName`, `StartTime`, `EndTime`) VALUES ('','$id','$rm','$st','$pr')";
            if(mysqli_query($link,$query)){
                echo("You have booked ".$rm." boardroom as from ".$st. " to ".$pr);
            }else{
                echo("Error not back our systems are currently down we are working to resolve this");
             }     
        }

   }else{
       echo("Error not back our systems are currently down we are working to resolve this");
   }  
}

?>