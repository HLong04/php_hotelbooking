<?php $isEdit = !empty($user); ?>

<h1><?php echo $isEdit ? 'Cập nhật User' : 'Thêm User mới'; ?></h1>

<form method="POST" action="<?php echo $isEdit ? '/users/update/' . $user['id'] : '/users/create'; ?>">
    
    <label>Họ và tên:</label>
    <input type="text" name="full_name" value="<?php echo $isEdit ? $user['full_name'] : ''; ?>" required>

    <label>Email:</label>
    <input type="email" name="email" value="<?php echo $isEdit ? $user['email'] : ''; ?>" required>

    <label>Số điện thoại:</label>
    <input type="text" name="phone" value="<?php echo $isEdit ? $user['phone'] : ''; ?>" required>

    <?php if (!$isEdit): ?>
        <label>Mật khẩu:</label>
        <input type="password" name="password" required>
        
        <label>Nhập lại mật khẩu:</label>
        <input type="password" name="password_check" required>
    <?php endif; ?>

    <button type="submit">Lưu</button>
</form>