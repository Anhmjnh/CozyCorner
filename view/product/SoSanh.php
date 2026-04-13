<?php require_once __DIR__ . '/../../includes/header.php'; ?>

<style>
    .compare-container {
        max-width: 1200px;
        margin: 48px auto;
        padding: 0 24px;
        min-height: 60vh;
    }

    .compare-title {
        font-size: 32px;
        font-weight: bold;
        margin-bottom: 32px;
        color: #333;
        text-align: center;
    }

    /* Breadcrumb đã sửa lỗi rớt dòng */
    .breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
        list-style: none;
        margin: 0;
        padding: 16px 72px;
        background-color: #fafafa;
    }
    
    .breadcrumb li {
        display: flex;
        align-items: center;
    }
    
    .breadcrumb a {
        text-decoration: none;
        color: #555;
    }

    .compare-grid {
        display: flex;
        gap: 24px;
        overflow-x: auto;
        padding-bottom: 24px;
        align-items: stretch;
    }

    .compare-col {
        flex: 1;
        min-width: 280px;
        max-width: 380px;
        background: #fff;
        border: 1px solid #eaeaea;
        border-radius: 16px;
        text-align: center;
        position: relative;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        display: flex;
        flex-direction: column;
        align-items: center;
        transition: transform 0.2s;
        overflow: hidden; /* Quan trọng: Bo góc ảnh theo viền thẻ */
    }
    
    .compare-col:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    /* Ảnh tràn viền */
    .compare-img {
        width: 100%;
        aspect-ratio: 1/1;
        object-fit: cover;
        display: block;
    }

    /* Phần thông tin lùi vào trong để chừa viền */
    .compare-info {
        padding: 20px 24px 24px 24px;
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        flex: 1;
    }

    .compare-name {
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 12px;
        color: #333;
        height: 44px;
        line-height: 22px;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }

    .compare-price {
        color: #355F2E;
        font-size: 22px;
        font-weight: 800;
        margin-bottom: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
    }

    .compare-price .old-price {
        font-size: 14px; 
        color: #A0A0A0; 
        text-decoration: line-through; 
        font-weight: normal;
    }

    .compare-badges {
        margin-bottom: 16px;
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        color: white;
        letter-spacing: 0.3px;
    }

    .compare-row {
        width: 100%;
        padding: 16px 0;
        border-top: 1px solid #f0f0f0;
        text-align: center;
        font-size: 15px;
        line-height: 1.6;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }

    .compare-row strong {
        color: #888;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .btn-remove {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #fff;
        color: #e74c3c;
        border: 1px solid #ffebee;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        z-index: 10;
    }

    .btn-remove:hover {
        background: #e74c3c;
        color: white;
    }
</style>

<ul class="breadcrumb">
    <li><a href="<?= BASE_URL ?>">Trang chủ</a></li>
    <li><img src="<?= BASE_URL ?>assets/icon/icon-next.svg" width="12" height="12" alt=">"></li>
    <li><a href="javascript:void(0)" style="font-weight: 600; color: #355F2E;">So sánh sản phẩm</a></li>
</ul>

<div class="compare-container">
    <h1 class="compare-title">So Sánh Sản Phẩm Chi Tiết</h1>

    <div class="compare-grid">
        <?php foreach ($products as $p): ?>
            <div class="compare-col">
                <button class="btn-remove" onclick="removeCompareItem(<?= $p['id'] ?>)" title="Xóa khỏi danh sách">
                    <i class="fas fa-times"></i>
                </button>

                <a href="<?= BASE_URL ?>index.php?url=product/detail&id=<?= $p['id'] ?>" style="width: 100%; display: block;">
                    <img class="compare-img" src="<?= BASE_URL ?>uploads/<?= htmlspecialchars($p['anh']) ?>"
                        alt="<?= htmlspecialchars($p['ten_sp']) ?>">
                </a>

                <div class="compare-info">
                    <div class="compare-badges">
                        <?php foreach ($p['badges'] as $badge): ?>
                            <span class="badge" style="background: <?= $badge['bg'] ?>"><?= $badge['text'] ?></span>
                        <?php endforeach; ?>
                    </div>

                    <div class="compare-name">
                        <a href="<?= BASE_URL ?>index.php?url=product/detail&id=<?= $p['id'] ?>"
                            style="text-decoration: none; color: inherit;">
                            <?= htmlspecialchars($p['ten_sp']) ?>
                        </a>
                    </div>

                    <div class="compare-price">
                        <?= number_format($p['gia']) ?>đ
                        <?php if ($p['gia_cu'] > 0): ?>
                            <span class="old-price"><?= number_format($p['gia_cu']) ?>đ</span>
                        <?php endif; ?>
                    </div>

                    <div class="compare-row" style="margin-top: auto;">
                        <strong>Đánh giá cộng đồng</strong>
                        <div style="display: flex; align-items: center; justify-content: center; gap: 6px;">
                            <span style="font-weight: bold; color: #f39c12; font-size: 16px;">
                                <?= $p['rating'] > 0 ? $p['rating'] : 'Chưa có' ?>
                            </span>
                            <i class="fas fa-star" style="color: #f39c12;"></i>
                            <span style="color: #888; font-size: 13px;">(<?= $p['total_reviews'] ?> lượt)</span>
                        </div>
                    </div>

                    <div class="compare-row">
                        <strong>Trạng thái</strong>
                        <?php if ($p['so_luong_ton'] > 0): ?>
                            <span style="color: #28a745; font-weight: bold; background: #e8f5e9; padding: 4px 12px; border-radius: 4px; font-size: 13px;">Còn hàng</span>
                        <?php else: ?>
                            <span style="color: #e74c3c; font-weight: bold; background: #fce4e4; padding: 4px 12px; border-radius: 4px; font-size: 13px;">Hết hàng</span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        
        <?php if (count($products) < 3): ?>
            <div class="compare-col" style="padding: 24px; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #f9fbf9; border: 2px dashed #b4d499; cursor: pointer; transition: 0.3s; box-shadow: none;" onmouseover="this.style.background='#f2fbeb'" onmouseout="this.style.background='#f9fbf9'" onclick="window.location.href='<?= BASE_URL ?>index.php?url=product&category=<?= !empty($products) ? $products[0]['category_slug'] : '' ?>&compare_mode=1'">
                <div style="width: 64px; height: 64px; background: #355F2E; color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 16px;">
                    <i class="fas fa-plus" style="font-size: 24px;"></i>
                </div>
                <span style="font-size: 16px; font-weight: bold; color: #355F2E;">Thêm sản phẩm</span>
                <span style="font-size: 13px; color: #888; margin-top: 8px;">(Tối đa 3 sản phẩm)</span>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    function removeCompareItem(id) {
        fetch('<?= BASE_URL ?>index.php?url=product/api_compare_remove', { 
            method: 'POST', 
            headers: { 'Content-Type': 'application/json' }, 
            body: JSON.stringify({ product_id: id }) 
        })
        .then(res => res.json())
        .then(() => window.location.reload());
    }
</script>

<?php require_once __DIR__ . '/../../includes/footer.php'; ?>