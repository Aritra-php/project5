<!--------------------start php code for database connection---------------->
<?php
$my_host="localhost";
$my_user="root";
$my_pass="";
$my_db="project6";
$conn=mysqli_connect($my_host,$my_user,$my_pass,$my_db);
if(!$conn)
{
die("Connection Failed");
}
?>
<!-------------------End php code for database connection--------------------->
<!-------------------start php code for data insert--------------------------->
<?php
if(isset($_POST['rReg']))
{
if(($_POST['rName']=="")||($_POST['rEmail']=="")||($_POST['rPass']=="")||($_POST['rConPass']=="")||empty($_POST['rGender'])||empty($_POST['rDate'])||($_POST['rCity']=="")||($_POST['rAddress']=="")||empty($_POST['rOcc'])||empty($_FILES['rImage']))
{
echo '<div class="alert alert-warning mt-3 text-center">Please Fill All The Fields</div>';
}
else
{
$rName=$_POST['rName'];
$rEmail=$_POST['rEmail'];
$rPass=$_POST['rPass'];
$rConPass=$_POST['rConPass'];
$rGender=$_POST['rGender'];
$rDate=$_POST['rDate'];
$rCity=$_POST['rCity'];
$rAddress=$_POST['rAddress'];
$rOcc=$_POST['rOcc'];
$rImage=$_FILES['rImage'];
$rFinalOcc=implode(',',$rOcc);
$iName=$_FILES['rImage']['name'];
$i_tmp_name=$_FILES['rImage']['tmp_name'];
move_uploaded_file($i_tmp_name,'images/'.$iName);
$sql="SELECT rEmail FROM gamora WHERE rEmail='".$rEmail."'";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)==1)
{
echo '<div class="alert alert-warning mt-3 text-center">Email already registered</div>';
}
else
{
if($rPass==$rConPass)
{
$sql="INSERT INTO gamora(rName,rEmail,rPass,rConPass,rGender,rDate,rCity,rAddress,rOcc,rImage)
VALUES('$rName','$rEmail','$rPass','$rConPass','$rGender','$rDate','$rCity','$rAddress',
'$rFinalOcc','$iName')";
if(mysqli_query($conn,$sql))
{
echo '<div class="alert alert-warning mt-3 text-center">Registered Successfully</div>';
}
}
else
{
echo '<div class="alert alert-warning mt-3 text-center">Password and Confirm Password must be same</div>';
}
}
}
}
?>
<!-------------------------End php code for data insert------------------------>
<!---------------------Start Registration form--------------------------------->
<!doctype html>
<html lang="en">
<head>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

<title>RegistrationPage.com</title>
</head>
<body>

<?php
$a=[];
$b=[];
if(isset($_POST['Edit']))
{
$Srno=$_POST['Srno'];
$sql="SELECT *FROM gamora WHERE Srno='".$Srno."'";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$a=$row['rOcc'];
$b=explode(',',$a);
}
?>

<div class="container">
<div class="row">
<div class="col-sm-7">
<form action="" method="POST" enctype="multipart/form-data" class="shadow-lg p-5">
<h4>Welcome To Registration Page</h4>

<div class="form-group">
<label for="Name">Name</label>
<input type="text" placeholder="Type your name here" name="rName" class="form-control"
value="<?php if(isset($row['rName'])) {echo $row['rName'];}?>">
</div>

<div class="form-group">
<label for="Email">Email</label>
<input type="text" placeholder="Type your email here" name="rEmail" class="form-control"
value="<?php if(isset($row['rEmail'])) {echo $row['rEmail'];}?>">
</div>

<div class="form-group">
<label for="Password">Password</label>
<input type="password" placeholder="Type your password here" name="rPass" class="form-control"
value="<?php if(isset($row['rPass'])) {echo $row['rPass'];}?>">
</div>

<div class="form-group">
<label for="Confirm Password">Confirm Password</label>
<input type="password" placeholder="Confirm your password here" name="rConPass" class="form-control"
value="<?php if(isset($row['rConPass'])) {echo $row['rConPass'];}?>">
</div>

<div class="form-group">
<label for="Gender">Gender</label>
Male<input type="radio" name="rGender" value="Male" class="form-inline"
<?php if(isset($row['rGender']) && $row['rGender']=="Male") {echo "checked";}?>>

Female<input type="radio" name="rGender" value="Female" class="form-inline"
<?php if(isset($row['rGender']) && $row['rGender']=="Female") {echo "checked";}?>>

Others<input type="radio" name="rGender" value="Others" class="form-inline"
<?php if(isset($row['rGender']) && $row['rGender']=="Others") {echo "checked";}?>>

</div>

<div class="form-group">
<label for="Date Of Birth">Data Of Birth</label>
<input type="date" name="rDate" class="form-control"
value="<?php if(isset($row['rDate'])) {echo $row['rDate'];}?>">
</div>

<label for="City">City</label>
<select name="rCity">
<option value=""></option>
<option value="Durgapur"
<?php if(isset($row['rCity']) && $row['rCity']=="Durgapur") {echo "selected";}?>>Durgapur</option>

<option value="Kolkata"
<?php if(isset($row['rCity']) && $row['rCity']=="Kolkata") {echo "selected";}?>>Kolkata</option>

<option value="Chennai"
<?php if(isset($row['rCity']) && $row['rCity']=="Chennai") {echo "selected";}?>>Chennai</option>

<option value="Mumbai"
<?php if(isset($row['rCity']) && $row['rCity']=="Mumbai") {echo "selected";}?>>Mumbai</option>
</select>

<div class="form-group">
<label for="Address">Address</label>
<input type="text" placeholder="Type of address here" name="rAddress" class="form-control"
value="<?php if(isset($row['rAddress'])) {echo $row['rAddress'];}?>">
</div>

<div class="form-group">
<label for="Occupation">Occupation</label>
Student<input type="checkbox" name="rOcc[]" value="Student" class="form-inline"
<?php if(in_array('Student',$b)) {echo "checked";}?>>

Employee<input type="checkbox" name="rOcc[]" value="Employee" class="form-inline"
<?php if(in_array('Employee',$b)) {echo "checked";}?>>

Business<input type="checkbox" name="rOcc[]" value="Business" class="form-inline"
<?php if(in_array('Business',$b)) {echo "checked";}?>>

HouseWife<input type="checkbox" name="rOcc[]" value="HouseWife" class="form-inline"
<?php if(in_array('Housewife',$b)) {echo "checked";}?>>
</div>

<input type="file" name="rImage" required>
<input type="hidden" name="Srno" value="<?php if(isset($row['Srno'])) {echo $row['Srno'];}?>">
<input type="submit" value="Update" name="Update" class="btn btn-warning">
<input type="submit" value="Register" name="rReg" class="btn btn-warning">
</form>
<a href="login.php" class="btn btn-danger">Login</a>
</div>
</div>
</div>


<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
-->
</body>
</html>
<!-----------------------End Registration form----------------------->
<!-----------------------start php code for data fetch--------------->
<?php
$sql="SELECT *FROM gamora";
$result=mysqli_query($conn,$sql);
if(mysqli_num_rows($result)>0)
{
echo '<table border="1">';
echo "<tr>";
echo "<thead>";
echo "<th>rName</th>";
echo "<th>rEmail</th>";
echo "<th>rPass</th>";
echo "<th>rConPass</th>";
echo "<th>rGender</th>";
echo "<th>rDate</th>";
echo "<th>rCity</th>";
echo "<th>rAddress</th>";
echo "<th>rOcc</th>";
echo "<th>rImage</th>";
echo "<th>Delete</th>";
echo "<th>Edit</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";
while($row=mysqli_fetch_assoc($result))
{
echo "<tr>";
echo "<td>".$row['rName']."</td>";
echo "<td>".$row['rEmail']."</td>";
echo "<td>".$row['rPass']."</td>";
echo "<td>".$row['rConPass']."</td>";
echo "<td>".$row['rGender']."</td>";
echo "<td>".$row['rDate']."</td>";
echo "<td>".$row['rCity']."</td>";
echo "<td>".$row['rAddress']."</td>";
echo "<td>".$row['rOcc']."</td>";
echo '<td><img src="images/'.$row['rImage'].'"></td>';
echo '<td><form action="" method="POST">
<input type="hidden" name="Srno" value='.$row['Srno'].'>
<input type="submit" value="Delete" name="Delete">
</form></td>';
    
echo '<td><form action="" method="POST">
<input type="hidden" name="Srno" value='.$row['Srno'].'>
<input type="submit" value="Edit" name="Edit">
</form></td>';
echo "</tr>";
}
echo "</tbody>";
echo '<table>';
}
else
{
echo "Data not found";
}
?>
<!----------------------End php code for fetch data------------------>
<!----------------------start php code for delete button------------->
<?php
if(isset($_POST['Delete']))
{
$Srno=$_POST['Srno'];
$sql="SELECT *FROM gamora";
$result=mysqli_query($conn,$sql);
$row=mysqli_fetch_assoc($result);
$dImage=$row['rImage'];
unlink('images/'.$dImage);
$sql="DELETE FROM gamora WHERE Srno='".$Srno."'";
if(mysqli_query($conn,$sql))
{
echo '<div class="alert alert-success mt-3 text-center">Data Deleted Successfully</div>';
}
else
{
echo '<div class="alert alert-warning mt-3 text-center">Unable to delete data</div>'; 
}
}
?>
<!----------------------End php code for delete button--------------->
<!----------------------start php code for update button------------->
<?php
if(isset($_POST['Update']))
{
if(($_POST['rName']=="")||($_POST['rEmail']=="")||($_POST['rPass']=="")||($_POST['rConPass']=="")||empty($_POST['rGender'])||empty($_POST['rDate'])||($_POST['rCity']=="")||($_POST['rAddress']=="")||empty($_POST['rOcc'])||empty($_FILES['rImage']))
{
echo '<div class="alert alert-warning mt-3 text-center">Please Fill All The Fields</div>';
}
else
{
$Srno=$_POST['Srno'];
$rName=$_POST['rName'];
$rEmail=$_POST['rEmail'];
$rPass=$_POST['rPass'];
$rConPass=$_POST['rConPass'];
$rGender=$_POST['rGender'];
$rDate=$_POST['rDate'];
$rCity=$_POST['rCity'];
$rAddress=$_POST['rAddress'];
$rOcc=$_POST['rOcc'];
$rImage=$_FILES['rImage'];
$rFinalOcc=implode(',',$rOcc);
$iName=$_FILES['rImage']['name'];
$i_tmp_name=$_FILES['rImage']['tmp_name'];
move_uploaded_file($i_tmp_name,'images/'.$iName);
$sql="UPDATE gamora SET rName='$rName',rEmail='$rEmail',rPass='$rPass',rConPass='$rConPass',
rGender='$rGender',rDate='$rDate',rCity='$rCity',rAddress='$rAddress',rOcc='$rFinalOcc',
rImage='$iName' WHERE Srno='".$Srno."'";
if(mysqli_query($conn,$sql))
{
echo '<div class="alert alert-success mt-3 text-center">Data Updated Successfully</div>';
}
else
{
echo '<div class="alert alert-warning mt-3 text-center">Unable to Update data</div>';
}
}
}
?>
<!----------------------End php code for update button--------------->