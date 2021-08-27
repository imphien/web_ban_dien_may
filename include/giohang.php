<?php
if(isset($_POST['themgiohang'])){
	$tensanpham = $_POST['tensanpham'];
	$sanpham_id = $_POST['sanpham_id'];
	$hinhanh = $_POST['hinhanh'];
	$gia = $_POST['gia'];
	$soluong = $_POST['soluong'];
	$sql_select_giohang = mysqli_query($conn, "SELECT * FROM tbl_giohang WHERE sanpham_id = '$sanpham_id'");
	$count = mysqli_num_rows($sql_select_giohang);
	if($count > 0){
		$row_sanpham = mysqli_fetch_array($sql_select_giohang);
		$soluong = $row_sanpham['soluong'] + 1;
		$sql_giohang =  "UPDATE tbl_giohang SET soluong = '$soluong' WHERE sanpham_id = '$sanpham_id' ";
	}else{
		$soluong = $soluong;
		$sql_giohang =  "INSERT INTO tbl_giohang(tensanpham,sanpham_id,giasanpham,hinhanh,soluong) values
		('$tensanpham','$sanpham_id','$gia','$hinhanh','$soluong') ";
	}
	$insert_row = mysqli_query($conn, $sql_giohang);
	if($insert_row == 0){
		//header('Location:index.php?quanly=chitietsp&id='.$sanpham_id);
	}
}elseif(isset($_POST['capnhatsoluong'])){
	for($i=0; $i<count($_POST['sanpham_id']);$i++){
		$sanpham_id = $_POST['sanpham_id'][$i];
		$soluong = $_POST['soluong'][$i];
		if($soluong <= 0){
			$sql_delete = mysqli_query($conn, "DELETE FROM  tbl_giohang WHERE sanpham_id ='$sanpham_id'");
		}else{
			$sql_update = mysqli_query($conn, "UPDATE tbl_giohang SET soluong='$soluong' WHERE sanpham_id ='$sanpham_id'");
		}
	}
}elseif(isset($_GET['xoa'])){
	$id = $_GET['xoa'];
	$sql_delete = mysqli_query($conn, "DELETE FROM  tbl_giohang WHERE giohang_id ='$id'");
	
}
?>
<?php

if(isset($_POST['thanhtoan'])){
	$name = $_POST['name'];
	$phone = $_POST['phone'];
	$address = $_POST['address'];
	$note = $_POST['note'];
	$email = $_POST['email'];
	$giaohang = $_POST['giaohang'];

	$sql_khachhang =  mysqli_query($conn,"INSERT INTO tbl_khachhang(name,phone,address,note,email,giaohang) values
		('$name','$phone','$address','$note','$email','$giaohang') ");
	$mahang = rand(0,9999);
	if($sql_khachhang){
		$sql_select_khachhang = mysqli_query($conn, "SELECT * FROM tbl_khachhang ORDER BY khachhang_id DESC LIMIT 1");
		$row_khachhang = mysqli_fetch_array($sql_select_khachhang);
		$khachhang_id = $row_khachhang['khachhang_id'];
		for($i=0; $i<count($_POST['thanhtoan_sanpham_id']);$i++){
			$sanpham_id = $_POST['thanhtoan_sanpham_id'][$i];
			$soluong = $_POST['thanhtoan_soluong'][$i];
			$sql_donhang =  mysqli_query($conn,"INSERT INTO tbl_donhang(sanpham_id,khachhang_id,soluong,mahang) values
			('$sanpham_id','$khachhang_id','$soluong','$mahang') ");
			$sql_delete_thanhtoan = mysqli_query($conn, "DELETE FROM  tbl_giohang WHERE sanpham_id ='$sanpham_id'");
		}
		
	}
	
}

?>
<!-- checkout page -->
	<div class="privacy py-sm-5 py-4">
		<div class="container py-xl-4 py-lg-2">
			<!-- tittle heading -->
			<h3 class="tittle-w3l text-center mb-lg-5 mb-sm-4 mb-3">
				<span>C</span>heckout
			</h3>
			<!-- //tittle heading -->
			<div class="checkout-right">
                <?php
                $sql_lay_giohang = mysqli_query($conn, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
                
                ?>
				<div class="table-responsive">
					<form action="" method="post">
					<table class="timetable_sub">
						<thead>
							<tr>
								<th>Thứ tự</th>
								<th>Sản phẩm</th>
								<th>Số lượng</th>
								<th>Tên sản phẩm</th>

								<th>Giá</th>
								<th>Giá tổng</th>
								<th>Xóa</th>
							</tr>
						</thead>
						<tbody>
                            <?php 
								$i = 0;
								$total = 0;
                                while($row_lay_giohang = mysqli_fetch_array($sql_lay_giohang)){ 
									$subtotal = $row_lay_giohang['soluong'] * $row_lay_giohang['giasanpham'];
									$total += $subtotal;
                                    $i++;
                            ?>
							<tr class="rem1">
								<td class="invert"><?php echo $i; ?></td>
								<td class="invert-image">
									<a href="single.html">
										<img src="images/<?php echo $row_lay_giohang['hinhanh']; ?>" alt=" " height="120" class="img-responsive">
									</a>
								</td>
								<td class="invert">
									<input type="number" min="1" name="soluong[]"  value="<?php echo $row_lay_giohang['soluong']; ?>">
									<input type="hidden" name="sanpham_id[]"  value="<?php echo $row_lay_giohang['sanpham_id']; ?>">
								</td>
								<td class="invert"><?php echo $row_lay_giohang['tensanpham']; ?></td>
								<td class="invert"><?php echo $row_lay_giohang['giasanpham']; ?></td>
								<td class="invert"><?php echo $subtotal ?></td>
								<td class="invert">
									<a href="?quanly=giohang&xoa=<?php echo $row_lay_giohang['giohang_id']; ?>">Xóa</a>
								</td>
							</tr>
                            <?php } ?>
							<tr>
								<td colspan="7">Tổng tiền:<?php echo $total; ?></td>
							</tr>
							<tr>
							<td colspan="7"><input type="submit" class="btn btn-success" value="Cập nhật giỏ hàng" name="capnhatsoluong"></td>
							</tr>
						</tbody>
					</table>
					</form>
				</div>
                
			</div>
			<div class="checkout-left">
				<div class="address_form_agile mt-sm-5 mt-4">
					<h4 class="mb-sm-4 mb-3">Thêm địa chỉ giao hàng</h4>
					<form action="" method="post" class="creditly-card-form agileinfo_form">
						<div class="creditly-wrapper wthree, w3_agileits_wrapper">
							<div class="information-wrapper">
								<div class="first-row">
									<div class="controls form-group">
										<input class="billing-address-name form-control" type="text" name="name" placeholder="Điền tên" required="">
									</div>
									<div class="w3_agileits_card_number_grids">
										<div class="w3_agileits_card_number_grid_left form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Số điện thoại" name="phone" required="">
											</div>
										</div>
										<div class="w3_agileits_card_number_grid_right form-group">
											<div class="controls">
												<input type="text" class="form-control" placeholder="Địa chỉ" name="address" required="">
											</div>
										</div>
									</div>
									<div class="controls form-group">
										<input type="text" class="form-control" placeholder="Email" name="email" required="">
									</div>
									<div class="controls form-group">
										<textarea style="resize=none;" class="form-control" placeholder="Ghi chú" name="note" required=""></textarea>
									</div>
									<div class="controls form-group">
										<select class="option-w3ls" name="giaohang">
											<option>Chọn hình thức giao hàng</option>
											<option value="1">Thanh toán ATM</option>
											<option vakue="0">Nhận tiền tại nhà</option>
											

										</select>
									</div>
								</div>
								<?php	
									$sql_lay_giohang = mysqli_query($conn, "SELECT * FROM tbl_giohang ORDER BY giohang_id DESC");
									while($row_thanhtoan = mysqli_fetch_array($sql_lay_giohang)){
								 ?>
									<input type="hidden" min="1" name="thanhtoan_soluong[]"  value="<?php echo $row_thanhtoan['soluong']; ?>">
									<input type="hidden" name="thanhtoan_sanpham_id[]"  value="<?php echo $row_thanhtoan['sanpham_id']; ?>">
								<?php } ?>
								<input type="submit" name="thanhtoan" class="btn btn-success" style="width:20%" value="Thanh toán"> 
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- //checkout page -->