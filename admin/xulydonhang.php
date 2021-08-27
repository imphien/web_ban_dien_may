<?php
include('../db/connect.php');
?>
<?php
// if(isset($_POST['themdanhmuc'])){
//     $tendanhmuc = $_POST['danhmuc'];
//     $sql_ibsert = mysqli_query($conn, "INSERT INTO tbl_category(category_name) VALUES ('$tendanhmuc')");
// }elseif(isset($_POST['capnhatdanhmuc'])){
//     $id_post = $_POST['id_danhmuc'];
//     $tendanhmuc = $_POST['danhmuc'];
//     $sql_ibsert = mysqli_query($conn, "UPDATE tbl_category SET category_name = '$tendanhmuc' WHERE category_id ='$id_post'");
//     header('Location:xulydanhmuc.php');
// }
// if(isset($_GET['xoa'])){
//     $id = $_GET['xoa'];
//     $sql_xoa = mysqli_query($conn, "DELETE FROM tbl_category WHERE category_id = '$id'");
// }
if(isset($_POST['capnhatdonhang'])){
    $xuly = $_POST['xuly'];
    $mahang = $_POST['mahang_xuly'];
    $sql_update_donhang = mysqli_query($conn,"UPDATE tbl_donhang SET tinhtrang='$xuly' WHERE mahang = '$mahang'");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đơn hàng </title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
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
    </nav><br><br>
    <div class="container">
        <div class="row">
            <div  class="col-md-7">
                <?php
                    if(isset($_GET['quanly'])){
                        $quanly = $_GET['quanly'];
                    }else{
                        $quanly = '';
                    }
                    if($quanly=='xemdonhang'){
                        $mahang = $_GET['mahang'];
                        $i = 0;
                        $sql_xemdonhang = mysqli_query($conn,"SELECT *FROM tbl_donhang,tbl_sanpham,tbl_khachhang WHERE 
                        tbl_sanpham.sanpham_id = tbl_donhang.sanpham_id AND tbl_khachhang.khachhang_id = tbl_donhang.khachhang_id AND tbl_donhang.mahang ='$mahang'"); 
                        ?>
                        <p>Xem chi tiết đơn hàng</p>
                        <form action="" method="post">
                        <table class="table table-boredred">
                        <tr>
                            <th>Thứ tự</th>
                            <th>Mã hàng</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Tổng tiền</th>
                            <th>Ngày đặt</th>
                            
                            <th>Ghi chú</th>
                            <!-- <th>Quản lý</th> -->
                        </tr>
                        <?php
                        while($row_xemdonhang = mysqli_fetch_array($sql_xemdonhang)) {
                            $i++;
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $row_xemdonhang['mahang'] ?></td>
                            <td><?php echo $row_xemdonhang['sanpham_name'] ?></td>
                            <td><?php echo $row_xemdonhang['soluong'] ?></td>
                            <td><?php echo number_format($row_xemdonhang['sanpham_giakhuyenmai']*$row_xemdonhang['soluong']).'VND' ?></td>
                            <td><?php echo $row_xemdonhang['ngaythang'] ?></td>
                          
                            <td><?php echo $row_xemdonhang['note'] ?></td>
                            <input type="hidden" name="mahang_xuly" value="<?php echo $row_xemdonhang['mahang'] ?>">
                            <!-- <td><a href="?xoa=<?php echo  $row_donhang['donhang_id']  ?>">Xóa</a> || 
                            <a href="?quanly=xemdonhang&mahang=<?php echo  $row_donhang['mahang']  ?>">Xem đon hàng</a></td> -->
                        </tr>
                        <?php } ?>
                    </table>
                    <select class="form-control" name="xuly">
                        <option value="1">Đã xử lý</option>
                        <option value="0">Chưa xử lý</option>
                    </select><br>
                    <input type="submit" value="Cập nhật đơn hàng" name="capnhatdonhang" class="btn btn-success">
                    </form>
                        
                <?php }else{ ?>
                        <div class="col-md-7">
                            <h4>Đơn hàng</h4>
                            <!-- <label>Tên danh mục</label>
                            <form action="" method="post">
                                <input type="text" class="form-control" name="danhmuc" placeholder="Tên danh mục" value="<?php echo $row_capnhat['category_name'] ?>"><br>
                                <input type="hidden" class="form-control" name="id_danhmuc" value="<?php echo $row_capnhat['category_id'] ?>">
                                <input type="submit" name="capnhatdanhmuc" value="Cập nhật danh mục" class="btn btn-defaul">
                            </form> -->
                        </div>
                    <?php } ?>
                
                </div>
                <div class="col-md-5">
                <h4>Liệt kê đơn hàng</h4>
                <?php
                    $sql_select = mysqli_query($conn, "SELECT * FROM tbl_sanpham,tbl_khachhang,tbl_donhang 
                    WHERE tbl_sanpham.sanpham_id = tbl_donhang.sanpham_id and tbl_khachhang.khachhang_id = tbl_donhang.khachhang_id 
                    ORDER BY tbl_donhang.donhang_id DESC");
                    $i=0;
                ?>
                <table class="table table-boredred ">
                    <tr>
                        <th>Thứ tự</th>
                        <th>Mã hàng</th>
                        <th>Tên khách hàng</th>
                        <th>Ngày đặt</th>
                        <th>Tính trạng</th>
                        <th>Quản lý</th>
                    </tr>
                    <?php
                    while($row_donhang = mysqli_fetch_array($sql_select)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row_donhang['mahang'] ?></td>
                        <td><?php echo $row_donhang['name'] ?></td>
                        <td><?php echo $row_donhang['ngaythang'] ?></td>
                        <th><?php
                            if($row_donhang['tinhtrang'] == '0'){
                                echo 'Chưa xử lý';
                            }else{
                                echo 'Đã xử lý';
                            }
                        ?></th>
                        <td><a href="?xoa=<?php echo  $row_donhang['donhang_id']  ?>">Xóa</a> || 
                        <a href="?quanly=xemdonhang&mahang=<?php echo  $row_donhang['mahang']  ?>">Xem đon hàng</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>