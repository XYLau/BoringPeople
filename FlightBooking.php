<html>
<head> <title>Flight Booking System</title> </head>
<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500;">
<h1>Flight Catalog</h1>
</td> </tr>
<?php
putenv('ORACLE_HOME=/oraclient');
$dbh = ocilogon('a0114573', 'crse1410', sid3);
?>
<tr> <td style="background-color:#eeeeee;">
<form>
<select name="Departure"> <option value="">From</option>
<?php
$sql = "SELECT DISTINCT A.country
FROM Airport A, FlightInfo FI
WHERE FI.infotype = ‘D’ and FI.airportcode = A.airportcode";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
while ($row = oci_fetch_array($stid)) {
echo "<option value=\"".$row["DEPARTURE"]."\">".$row["DEPARTURE"]."</option><br>";
}
oci_free_statement($stid);
?>
</select>
<select name="To"> <option value="">To</option>
<?php
$sql = "SELECT DISTINCT A.country
FROM Airport A, FlightInfo FI
WHERE FI.infotype = ‘A’ and FI.airportcode = A.airportcode";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
while ($row = oci_fetch_array($stid)) {
echo "<option value=\"".$row["TO"]."\">".$row["TO"]."</option><br>";
}
oci_free_statement($stid);
?>
</select>
<select name="Class"> <option value="">Class</option>
<?php
$sql = "SELECT DISTINCT FC.classtype
FROM FlightClass FC";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
while ($row = oci_fetch_array($stid)) {
echo "<option value=\"".$row["CLASS"]."\">".$row["CLASS"]."</option><br>";
}
oci_free_statement($stid);
?>
</select>
<select name="Date"> <option value="">Departure Date</option>
<?php
$sql = "SELECT DISTINCT FI.dateflight
FROM FlightInfo FI
WHERE FI.infotype = ‘D’";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
while ($row = oci_fetch_array($stid)) {
echo "<option value=\"".$row["DATE"]."\">".$row["DATE"]."</option><br>";
}
oci_free_statement($stid);
?>
</select>
<input type="submit" name="formSubmit" value="Search" >
</form>
<?php
If (isset ($_GET['formSubmit'])) {
$sql = "SELECT A1.country, A2.country, F1.dateflight, F1.timeflight, F2.dateflight, F2.timeflight, FC.price
FROM Airport A1, Airport A2, FlightInfo F1, FlightInfo F2, FlightClass FC 
WHERE A1.country = '".$_GET['Departure']."' and A2.country = '".$_GET['To']."' and F1.infotype = 'D'
and F1.airportcode = A1.airportcode and F1.dateflight = '".$_GET['Date']."' and F2.infotype = 'A'
and F2.airportcode = A2.airportcode and FC.classtype = '".$_GET['Class']."' and F1.flightnum = FC.flightnum";
echo "<b>SQL: </b>".$sql."<br><br>";
$stid = oci_parse($dbh, $sql);
oci_execute($stid, OCI_DEFAULT);
echo "<table border=\"1\" >
<col width=\"75%\"> <col width=\"25%\"> 
<tr>
<th>From</th> <th>To</th> <th>Departure Date</th> <th>Departure Time</th> <th>Arrival Date</th> <th>Arrival Time</th> <th>Price</th> <th>Book Flight</th>
</tr>";
while ($row = oci_fetch_array($stid)) {
echo "<tr>";
echo "<td>" . $row[0] . "</td>";
echo "<td>" . $row[1] . "</td>";
echo "<td>" . $row[2] . "</td>";
echo "<td>" . $row[3] . "</td>";
echo "<td>" . $row[4] . "</td>";
echo "<td>" . $row[5] . "</td>";
echo "<td>" . $row[6] . "</td>";
//echo "<td>" <form action="Booking.php" method="post"> <input type="submit" value="Book flight"> </form> "</td>";
echo "</tr>";
}
echo "</table>";
oci_free_statement($stid);
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
