<?php
    if(isset($user)){
        $conn = connect();
        $query = $conn->query("SELECT * FROM staff WHERE staffID = '{$user['userID']}'");
        $userInfo = $query->fetch_object();
        $conn->close();
    }
?>
<div class="content">
    <h2>Your account profile</h2>
    <div class="user info">
        <form id="useraccount" action="updateAccount.php" method="post">
            <div class="container" style="width:60%">
                <div class="row mb-3">
                    <div class="col">
                        <label for="name">Username:</label>
                        <input id='name' type="text" class='form-control' disabled value="<?=isset($userInfo)?$userInfo->userName:''?>">
                    </div>
                    <div class="col">
                        <label for="email">Email:</label>
                        <input id='email' name="email" type="text" class='form-control' value="<?=isset($userInfo)?$userInfo->email:''?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="oldpass">Old password:</label>
                        <input name='oldpass' type="password" class='form-control'>
                    </div>
                    <div class="col">
                        <label for="newpass">New password:</label>
                        <input name='newpass' type="password" class='form-control'>
                    </div>
                    <div class="col">
                        <label for="repass">Confirm password:</label>
                        <input name='repass' type="password" class='form-control'>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="text-align:center">
                        <input style="width:200px" type="submit" value="Change Email" name="upemail" class="btn btn-primary">
                        <input style="width:200px" type="submit" value="Change Password" name="uppass" class="btn btn-warning">
                    </div>
                </div>
            </div>

        </form>
    </div>
    <hr>
</div>
</div>
<?php
if (isset($_SESSION['error'])) {
    echo "<script>alert('{$_SESSION['error']}')</script>";
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    print_r($_SESSION['success']);
    unset($_SESSION['success']);
}
?>
