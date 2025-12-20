<?php ob_start(); ?>

<div class="form-container">
    <div class="card-header">
        <h3><i class="fa-solid fa-pen-to-square"></i> Cập Nhật Loại Phòng</h3>
    </div>

    <div class="card-body">

        <form action="/admin/typeroom/update/<?= $type['id'] ?>" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-7">
                    <div class="form-group">
                        <label>Tên loại phòng <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($type['name']) ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Giá phòng (VNĐ/Đêm) <span class="required">*</span></label>
                        <input type="number" name="price" class="form-control" value="<?= $type['price'] ?>" required>
                    </div>

                    <div class="form-group">
                        <label>Số người tối đa <span class="required">*</span></label>
                        <input type="number" name="max_adults" class="form-control" value="<?= $type['max_adults'] ?>" required min="1">
                    </div>

                    <div class="form-group">
                        <label>Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5"><?= htmlspecialchars($type['description']) ?></textarea>
                    </div>
                </div>

                <div class="col-5">
                    <div class="form-group">
                        <label>Hình ảnh (Chọn nếu muốn đổi)</label>
                        <div class="image-upload-box">
                            <?php $currentImg = !empty($type['image']) ? URLROOT . '/img/' . $type['image'] : 'https://via.placeholder.com/400x300'; ?>
                            <img id="preview" src="<?= $currentImg ?>" alt="Preview">

                            <input type="file" name="image" id="imgInp" accept="image/*" class="file-input">
                            <div class="upload-btn" onclick="document.getElementById('imgInp').click();">
                                <i class="fa-solid fa-camera"></i> Đổi ảnh khác
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="/admin/typeroom" class="btn-secondary">Hủy bỏ</a>
                <button type="submit" class="btn-primary">Cập nhật</button>
            </div>

        </form>
    </div>
</div>

<script>
    document.getElementById('imgInp').onchange = evt => {
        const [file] = document.getElementById('imgInp').files
        if (file) {
            document.getElementById('preview').src = URL.createObjectURL(file);
        }
    }
</script>

<?php
$content = ob_get_clean();
include APPROOT . '/templates/layout-admin.php';
?>