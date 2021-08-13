<?php
include "adminFunction.php";
$conn = connect();
$roleName = 'admin';
$rolelist = [];
$result = $conn->query("SELECT roleID FROM staffrole");
while($role = $result->fetch_assoc()){
    $roleList[] = $role['roleID'];
}

echo "<br>";
print_r($roleList);
echo"<br><hr>";
$test = 2;
if(in_array($test, $roleList)){
    echo "TRUE";
}else echo "FALSE";
?>