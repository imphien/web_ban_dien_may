<?php
include('../db/connect.php');
?>
<?php
if(isset($_POST['themsanpham'])){
    $tensanpham = $_POST['tensanpham'];
    $hinhanh = $_FILES['hinhanh']['name'];
  
    $giasanpham = $_POST['giasanpham'];
    $giakhuyenmai = $_POST['giakhuyenmai'];
    $soluong = $_POST['soluong'];
    $danhmuc = $_POST['danhmuc'];
    $chitiet = $_POST['chitiet'];
    $mota = $_POST['mota'];
    $path = '../upload/';
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];
    $sql_insert_product = mysqli_query($conn, "INSERT INTO tbl_sanpham(sanpham_name,sanpham_image,sanpham_gia,sanpham_giakhuyenmai,sanpham_soluong,category_id,sanpham_chitiet,sanpham_mota) 
    VALUES ('$tensanpham','$hinhanh','$giasanpham','$giakhuyenmai','$soluong','$danhmuc','$chitiet','$mota')");
    move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
}
elseif(isset($_POST['capnhatsanpham'])){
    
    $id_sanpham = $_GET['capnhat_id'];
    $tensanpham = $_POST['tensanpham'];
    $hinhanh = $_FILES['hinhanh']['name'];
    $giasanpham = $_POST['giasanpham'];
    $giakhuyenmai = $_POST['giakhuyenmai'];
    $soluong = $_POST['soluong'];
    $danhmuc = $_POST['danhmuc'];
    $chitiet = $_POST['chitiet'];
    $mota = $_POST['mota'];
    $path = '../upload/';
    $hinhanh_tmp = $_FILES['hinhanh']['tmp_name'];

    if($hinhanh == ''){
        $sql_update_no_image = mysqli_query($conn,"UPDATE tbl_sanpham SET sanpham_name='$tensanpham',sanpham_gia='$giasanpham',
        sanpham_giakhuyenmai='$giakhuyenmai',sanpham_soluong='$soluong',category_id='$danhmuc',sanpham_chitiet='$chitiet',sanpham_mota='$mota' WHERE sanpham_id='$id_sanpham'");
    }else{
        move_uploaded_file($hinhanh_tmp,$path.$hinhanh);
        $sql_update_image = mysqli_query($conn,"UPDATE tbl_sanpham SET sanpham_name='$tensanpham',sanpham_gia='$giasanpham',
        sanpham_giakhuyenmai='$giakhuyenmai',sanpham_soluong='$soluong',category_id='$danhmuc',sanpham_chitiet='$chitiet',sanpham_mota='$mota',sanpham_image='$hinhanh' WHERE sanpham_id='$id_sanpham'");
    }

  
    
    header('Location:xulysanpham.php');
}
if(isset($_GET['xoa'])){
    $id_sp = $_GET['xoa'];
    $sql_xoa_sp = mysqli_query($conn, "DELETE FROM tbl_sanpham WHERE sanpham_id = '$id_sp'");
    $path_delete = '../uploads/';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S???n ph???m</title>
    <link href="../css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="xulydonhang.php">????n h??ng <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="xulydanhmuc.php">Danh m???c</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="xulysanpham.php">S???n ph???m</a>
          </li>
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Kh??ch h??ng</a>
          </li>
        </ul>
      </div>
    </nav><br><br>
    <div class="container">
        <div class="row">
            <?php
                if(isset($_GET['quanly'])){
                    $capnhat = $_GET['quanly'];
                }else{
                    $capnhat = '';
                }
                if($capnhat=='capnhat'){
                    $id_capnhat = $_GET['capnhat_id'];
                    $sql_capnhat = mysqli_query($conn,"SELECT *FROM tbl_sanpham WHERE sanpham_id ='$id_capnhat'");
                    $row_capnhat = mysqli_fetch_array($sql_capnhat);
                    $id_category_1 = $row_capnhat['category_id'];

                    ?>
                    <div class="col-md-4">
                    <h4>C???p nh???t s???n ph??m</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <label>T??n s???n ph???m</label>
                        <input type="text" class="form-control" name="tensanpham" value="<?php echo $row_capnhat['sanpham_name']; ?>"><br>
                        <label>H??nh ???nh</label>
                        <input type="file" class="form-control" name="hinhanh" ><br>
                        <img src="../upload/<?php echo $row_capnhat['sanpham_image'] ?>" height="80" width="80"><br>
                        <label>Gi??</label>
                        <input type="text" class="form-control" name="giasanpham" value="<?php echo $row_capnhat['sanpham_gia']; ?>"><br>
                        <label>Gi?? khuy???n m??i</label>
                        <input type="text" class="form-control" name="giakhuyenmai" value="<?php echo $row_capnhat['sanpham_giakhuyenmai']; ?>"><br>
                        <label>S??? l?????ng</label>
                        <input type="text" class="form-control" name="soluong" value="<?php echo $row_capnhat['sanpham_soluong']; ?>"><br>
                        <label>M?? t???</label>
                        <textarea class="form-control" name="mota" ><?php echo $row_capnhat['sanpham_mota']; ?></textarea><br>
                        <label>Chi ti???t</label>
                        <textarea class="form-control" name="chitiet"><?php echo $row_capnhat['sanpham_chitiet']; ?></textarea><br>
                        <label>Danh m???c s???n ph???m</label>
                        <?php
                            $sql_danhmuc = mysqli_query($conn,"SELECT * FROM tbl_category ORDER BY category_id DESC");

                        ?>
                        <select name="danhmuc" class="form-control">
                            <option value="0">Ch???n danh m???c</option>
                            <?php while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)){
                                if($id_category_1 == $row_danhmuc['category_id'] ){
                            ?>
                            <option selected value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
                            <?php
                                } else{
                            ?>
                            <option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
                            <?php
                                }
                            } ?>
                        </select><br>
                        <input type="submit" name="capnhatsanpham" value="C???p nh???t s???n ph???m" class="btn btn-defaul">
                    </form>
                </div><br>
               <?php }else{ ?>
                    <div class="col-md-4">
                    <h4>Th??m s???n ph???m</h4>
                    <form action="" method="post" enctype="multipart/form-data">
                        <label>T??n s???n ph???m</label>
                        <input type="text" class="form-control" name="tensanpham" placeholder="T??n s???n ph???m"><br>
                        <label>H??nh ???nh</label>
                        <input type="file" class="form-control" name="hinhanh" ><br>
                        <label>Gi??</label>
                        <input type="text" class="form-control" name="giasanpham" placeholder="Gi?? s???n ph???m"><br>
                        <label>Gi?? khuy???n m??i</label>
                        <input type="text" class="form-control" name="giakhuyenmai" placeholder="Gi?? khuy???n m??i"><br>
                        <label>S??? l?????ng</label>
                        <input type="text" class="form-control" name="soluong" placeholder="S??? l?????ng"><br>
                        <label>M?? t???</label>
                        <textarea class="form-control" name="mota"></textarea><br>
                        <label>Chi ti???t</label>
                        <textarea class="form-control" name="chitiet"></textarea><br>
                        <label>Danh m???c s???n ph???m</label>
                        <?php
                            $sql_danhmuc = mysqli_query($conn,"SELECT * FROM tbl_category ORDER BY category_id DESC");

                        ?>
                        <select name="danhmuc" class="form-control">
                            <option value="0">Ch???n danh m???c</option>
                            <?php while($row_danhmuc = mysqli_fetch_array($sql_danhmuc)){ ?>
                            <option value="<?php echo $row_danhmuc['category_id'] ?>"><?php echo $row_danhmuc['category_name'] ?></option>
                            <?php } ?>
                        </select>
                        <input type="submit" name="themsanpham" value="Th??m s???n ph???m" class="btn btn-defaul">
                    </form>
                </div>
               
                <?php } ?>
            
            <div class="col-md-8">
                <h4>Li???t k?? s???n ph???m</h4>
                <?php
                    $sql_select_sp = mysqli_query($conn, "SELECT * FROM tbl_sanpham,tbl_category WHERE tbl_sanpham.category_id=tbl_category.category_id ORDER BY tbl_sanpham.sanpham_id DESC");
                    $i=0;
                ?>
                <table class="table table-boredred ">
                    <tr>
                        <th>Th??? t???</th>
                        <th>T??n s???n ph???m</th>
                        <th>H??nh ???nh</th>
                        <th>S??? l?????ng</th>
                        <th>Danh m???c</th>
                        <th>Gi?? s???n ph???m</th>
                        <th>Gi?? khuy???n m??i</th>
                        <th>Qu???n l??</th>
                    </tr>
                    <?php
                    while($row_sanpham = mysqli_fetch_array($sql_select_sp)) {
                        $i++;
                    ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php echo $row_sanpham['sanpham_name'] ?></td>
                        <td><img src="../upload/<?php echo $row_sanpham['sanpham_image'] ?>" height="80" width="80"></td>
                        <td><?php echo $row_sanpham['sanpham_soluong'] ?></td>
                        <td><?php echo $row_sanpham['category_name'] ?></td>
                        <td><?php echo number_format($row_sanpham['sanpham_gia']).'VND' ?></td>
                        <td><?php echo number_format($row_sanpham['sanpham_giakhuyenmai']).'VND' ?></td>
                        <td><a href="?xoa=<?php echo  $row_sanpham['sanpham_id']  ?>">X??a</a> || 
                        <a href="xulysanpham.php?quanly=capnhat&capnhat_id=<?php echo  $row_sanpham['sanpham_id']  ?>">C???p nh???t</a></td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>