<?php
$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $confirmpassword = $_POST["confirm_password"];
    $sex = $_POST["sex"] ?? '';
    $img = $_FILES["img"];
    $province = $_POST["province"];

    if (empty($username)) {
        $errors['username'] = "Tên đăng nhập bắt buộc nhập";
    }
    if (empty($password)) {
        $errors["password"] = 'Mật khẩu bắt buộc nhập';
    }
    if (empty($sex)) {
        $errors['sex'] = "Giới tính băt buộc chọn";
    }
    if (empty($confirmpassword)) {
        $errors["confirm_password"] = 'Nhập lại mật khẩu bắt buộc nhập';
    } else {
        if ($confirmpassword != $password) {
            $errors['confirm_password'] = 'Mật khẩu không khớp';
        }
    }

    if (!empty($img)) {
        $targetDir    = "uploads/";
        $targetFile   = $targetDir . basename($img["name"]);
        $allowImg = ['jpg', 'png', 'bmp', 'gif'];
        $ext = pathinfo($targetFile, PATHINFO_EXTENSION);
        if (!in_array($ext, $allowImg)) {
            $errors['img'] = 'Định dạng file không hợp lệ';
        } else {

            if (!move_uploaded_file($img["tmp_name"], $targetFile)) {
                $errors['img'] = 'Upload thất bại';
            }
        }
    }
    if (empty($province)) {
        $errors['province'] = 'Tỉnh bắt buộc chọn';
    }

    if (empty($errors)) {
        echo 'Tên đăng nhập: ' . $username;
        echo '<br>Mật khẩu: ' . $password;
        echo '<br>Giới tính: ';
        echo ($sex == 1) ? 'Nam' : 'Nữ';
        echo '<br>Avatar: ';
        echo '<br><img width="100px" src="' . $targetFile . '" alt="avatar">';
        echo '<br>Tỉnh thành: ' . $province;
    }
}
?>

<div style="display: flex;  align-items: center; justify-content: center;" class="">
    <form style="display: flex; flex-direction: column; gap: 10px;" action="" method="POST" enctype="multipart/form-data">
        <h2>Đăng ký</h2>
        <div class="">

            <label for="">Tên đăng nhập (*)</label>
            <br>
            <input name="username" type="text">
            <p style="padding: 0;margin: 0; color: red; font-size: 12px; font-style: italic;">
                <?= isset($errors['username']) ? $errors['username'] : false ?>
            </p>
        </div>
        <div class="">
            <label for="">Mật khẩu (*)</label>
            <br>
            <input name="password" type="text">
            <p style="padding: 0;margin: 0; color: red; font-size: 12px; font-style: italic;">
                <?= isset($errors['password']) ? $errors['password'] : false ?>
            </p>

        </div>
        <div class="">
            <label for="">Nhập lại mật khẩu (*)</label>
            <br>
            <input name="confirm_password" type="text">

            <p style="padding: 0;margin: 0; color: red; font-size: 12px; font-style: italic;">
                <?= isset($errors['confirm_password']) ? $errors['confirm_password'] : false ?>
            </p>
        </div>
        <div class="">
            <label for="">Giới tính (*)</label>
            <br>
            <input name="sex" value="1" type="radio">Nam
            <input name="sex" value="2" type="radio">Nữ

            <p style="padding: 0;margin: 0; color: red; font-size: 12px; font-style: italic;">
                <?= isset($errors['sex']) ? $errors['sex'] : false ?>
            </p>
        </div>
        <div class="">
            <label for="">Hình ảnh</label>
            <br>
            <input name="img" type="file">

            <p style="padding: 0;margin: 0; color: red; font-size: 12px; font-style: italic;">
                <?= isset($errors['img']) ? $errors['img'] : false ?>
            </p>
        </div>
        <div class="">
            <label for="">Tỉnh</label>
            <br>
            <select style="width: 253px; padding: 5px 0" name="province" id="">
                <option value="">-- Chọn tỉnh --</option>
                <option value="Hồ Chí Minh">Hồ Chí Minh</option>
                <option value="Bạc Liêu">Bạc Liêu</option>
            </select>
            <p style="padding: 0;margin: 0; color: red; font-size: 12px; font-style: italic;">
                <?= isset($errors['province']) ? $errors['province'] : false ?>
            </p>
        </div>
        <button type="submit">Submit</button>
        <button type="button">Reset</button>
    </form>

</div>