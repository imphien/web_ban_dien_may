<?php
session_start();
include('../db/connect.php');
?>
<?php
// session_destroy();

 if(isset($_POST['dangnhap'])){
    $taikhoan = $_POST['taikhoan'];
    $matkhau = md5($_POST['matkhau']);
    if($taikhoan == '' || $matkhau == ''){
        echo '<p>Xin điền đầy đủ thông tin</p>';
    }else{
        $sql_select_admin = mysqli_query($conn, "SELECT * FROM tbl_admin WHERE email = '$taikhoan' AND password = '$matkhau'
        LIMIT 1");
        $count = mysqli_num_rows($sql_select_admin);
        $row_dangnhap = mysqli_fetch_array($sql_select_admin);
        if($count > 0){
            $_SESSION['dangnhap'] = $row_dangnhap['admin_name'];
            $_SESSION['admin_id'] = $row_dangnhap['admin_id'];

            header('Location: dashboard.php');
        }else{
            echo '<p>Tài khoản hoặc mật khẩu sai</p>';
        }
    }
 }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập admin</title>
	<link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <h2 align="center"> Đăng nhập Admin</h2>
    <div class="col-md-6">
        <div class="form-group">  
            <form action="" method="post">
                <label>Tài khoản</label>
                <input type="text" name="taikhoan" placeholder="Điền email" class="form-control"><br>
                <label>Mật khẩu</label>
                <input type="password" name="matkhau" placeholder="Điền mật khẩu" class="form-control"><br>
                <input type="submit" value="Đăng nhập Admin" class="btn btn-primary" name="dangnhap">
            </form>
         </div>
    </div>
    
</body>
</html>