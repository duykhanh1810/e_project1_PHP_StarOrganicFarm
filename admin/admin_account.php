<div class="content">
    <h2>Your account profile</h2>
    <div class="user info">
        <h4>User information</h4>
        <form id="useraccount" action="updateAccount.php" method="post">
            <div class="container" style="width:60%">
                <div class="row mb-3">
                    <div class="col">
                        <label for="name">Username:</label>
                        <input id='name' type="text" class='form-control' disabled value="<?=isset($_SESSION['account'])?$_SESSION['account']['userName']:''?>">
                    </div>
                    <div class="col">
                        <label for="email">Email:</label>
                        <input id='email' type="text" class='form-control' value="<?=isset($_SESSION['account'])?$_SESSION['account']['userEmail']:''?>">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="oldpass">Old password:</label>
                        <input id='oldpass' type="text" class='form-control'>
                    </div>
                    <div class="col">
                        <label for="newpass">New password:</label>
                        <input id='newpass' type="text" class='form-control'>
                    </div>
                    <div class="col">
                        <label for="repass">Confirm password:</label>
                        <input id='repass' type="text" class='form-control'>
                    </div>
                </div>
                <div class="row">
                    <div class="col" style="text-align:center">
                        <input style="width:200px" type="submit" value="Update" class="btn btn-primary">
                        <!-- <input style="width:200px" type="submit" value="Change email" class="btn btn-primary"> -->
                    </div>
                </div>
            </div>

        </form>
    </div>
    <hr>
</div>
</div>
<?php
if (isset($_SESSION['error1'])) {
    echo "<script>alert('{$_SESSION['error1']}')</script>";
    unset($_SESSION['error1']);
}

if (isset($_SESSION['error2'])) {
    echo "<script>alert('Operation FAILED! Please check the following error(s):\\n";
    foreach ($_SESSION['error2'] as $value) {
        echo " - " . $value . "\\n";
    }
    echo "')</script>";
    unset($_SESSION['error2']);
}

if (isset($_SESSION['success'])) {
    echo "<script>alert('{$_SESSION['success']}')</script>";
    print_r($_SESSION['success']);
    unset($_SESSION['success']);
}
?>