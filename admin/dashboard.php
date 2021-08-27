<?php
session_start();
if(!isset($_SESSION['dangnhap'])){
    header('Location: index.php');
}

?>
<?php
if(isset($_GET['login'])){
    $dangxuat = $_GET['login'];
}else{
    $dangxuat = '';
}
if($dangxuat == 'dangxuat'){
    session_destroy();
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Admin</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <p>Xin chào: <?php echo $_SESSION['dangnhap']; ?></p><br>
    <a href="?login=dangxuat">Đăng xuất</a>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="xulydonhang.php">Đơn hàng <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="xulydanhmuc.php">Danh mục</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="xulysanpham.php">Sản phẩm</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Khách hàng</a>
          </li>
        </ul>
      </div>
    </nav>
</body>
</html>