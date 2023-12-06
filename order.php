
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding" style="margin-top: 15px;">
        <?php include('./layout/sidebar.php') ?>
        <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9 clearpaddingr">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding">
                <ol class="breadcrumb">
                    <li><a href="./"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> Trang chủ</a></li>
                    <li class="active">Thanh toán</li>
                </ol>
                <div class="col-md-12 clearpadding">
                    <div class="panel panel-info">
                        <div class="panel-heading cus-color">
                            <h3 class="panel-title">Thông tin thanh toán</h3>
                        </div>
                        <div class="panel-body">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 clearpadding">
                                <form enctype="multipart/form-data" method="post">
                                    <table class="table" id="order_info">
                                        <tbody>
                                            <tr>
                                                <td style="width: 100px">Họ và tên</td>
                                                <td><input style="min-width: 200px" type="text" value="" name="name" required></td>
                                            </tr>
                                            <tr>
                                                <td style="width: 100px">Email</td>
                                                <td><input style="min-width: 200px" type="email" value="" name="email" required></td>
                                            </tr>
                                            <tr>
                                                <td>Số điện thoại</td>
                                                <td><input style="min-width: 200px" name="phone" type="text" value="" required></td>
                                            </tr>
                                            <tr>
                                                <td>Tỉnh,ThànhPhố</td>
                                                <td>
                                                    <select class="form-control" name="province" id="province" style="max-width: 200px;padding: 5px" required>
                                                        <option value>--Chọn Tỉnh,Thành phố--</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Quận,Huyện</td>
                                                <td>
                                                    <select class="form-control" name="district" id="district" style="max-width: 200px;padding: 5px" required>
                                                        <option value>--Chọn Quận,Huyện--</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Phường, Xã</td>
                                                <td>
                                                    <select class="form-control" name="ward" id="ward" style="padding: 5px;max-width: 200px;" required>
                                                        <option value>--Chọn Phường,Xã--</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Địa chỉ cụ thể</td>
                                                <td><input style="min-width: 200px" name="area" type="text" value="" required></td>
                                                <td><input style="max-width: 200px" id="adress" name="adress" type="hidden" value=""></td>
                                            </tr>
                                            <tr>
                                                <td>Tổng tiền</td>
                                                <td>
                                                    <span class="money"><?php echo number_format($total_amount); ?></span>
                                                </td>
                                                <td>VNĐ</td>
                                            </tr>
                                            <tr>
                                                <td>Phí ship</td>
                                                <td>
                                                    <span id="ship_label"> 0</span>
                                                </td>
                                                <td>VNĐ<input style="max-width: 100px" type="hidden" name="ship_money" id="ship_money" value="0"></td>
                                            </tr>
                                            <tr>
                                                <td>Thành tiền</td>
                                                <td style="color: red;max-width: 50px">
                                                    <span id="total_amount"><?php echo number_format($total_amount); ?></span>
                                                </td>
                                                <td>VNĐ</td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button style="min-width: 100px;float: right;margin-top: 50px" type="submit" name="submit" class="btn btn-success">Xác nhận</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>