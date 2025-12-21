<?php ob_start(); ?>

<div class="form-container">
    <div class="card-header">
        <h3><i class="fa-solid fa-circle-plus"></i> Thêm Loại Phòng Mới</h3>
    </div>

    <div class="card-body">
        <?php if (isset($error)): ?>
            <div class="alert-error"><?= $error ?></div>
        <?php endif; ?>

        <form action="/admin/typeroom/create" method="POST" enctype="multipart/form-data">

            <div class="row">
                <div class="col-7">
                    <div class="form-group">
                        <label>Tên loại phòng <span class="required">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="VD: Deluxe King Suite">
                    </div>

                    <div class="form-group">
                        <label>Giá phòng (VNĐ/Đêm) <span class="required">*</span></label>
                        <input type="number" name="price" class="form-control" required min="0" step="1000" placeholder="VD: 1500000">
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Số người tối đa <span class="required">*</span></label>
                            <input type="number" name="max_adults" class="form-control" required min="1" max="10" value="2" placeholder="VD: 2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Mô tả chi tiết</label>
                        <textarea name="description" class="form-control" rows="5" placeholder="Mô tả tiện nghi, view, diện tích..."></textarea>
                    </div>
                </div>

                <div class="col-5">
                    <div class="form-group">
                        <label>Hình ảnh đại diện</label>
                        <div class="image-upload-box">
                            <img id="preview" src="https://via.placeholder.com/400x300?text=Preview+Image" alt="Preview">
                            <input type="file" name="image" id="imgInp" accept="image/*" class="file-input">
                            <div class="upload-btn" onclick="document.getElementById('imgInp').click();">
                                <i class="fa-solid fa-cloud-arrow-up"></i> Chọn ảnh
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="/admin/typeroom" class="btn-secondary">Quay lại</a>
                <button type="submit" class="btn-primary">Lưu dữ liệu</button>
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