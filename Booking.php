<html>
<head> <title>Make booking</title> </head>
<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500;">
<h1>Make a booking</h1>
</td> </tr>
<?php
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('a0115194', 'crse1410', sid3);
?>
<tr> <td style="background-color:#eeeeee;">
<form action="BookingDetails.php" method="post">
Name: <input type="text" name="name">
Contact number: <input type="number" name="contact">
Email : <input type="text" name="email">
<input type="submit" name="formSubmit" value="Submit Booking">
</form>
<?php
If (isset ($_GET['formSubmit'])) {
$sql = "INSERT INTO Passenger(pname,pcontact,pemail) VALUES(' ".$_POST['name']." ', ' ".$_POST['contact']." ',' ".$_POST['email']." ')"; //pid not here because want to use auto_increment.
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
$sql = "INSERT INTO Booking()";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
$sql = "INSERT INTO Ticket(seatnum,flightnum,classtype) VALUES('".$_POST['']." ', ' " .$_POST['']."', '".$_POST['']."', '".$_POST['']."')";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
}
?>

</td> </tr>
<?php
oci_close($dbh);
?>
<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
</td> </tr>
</table>
</body>
</html>
