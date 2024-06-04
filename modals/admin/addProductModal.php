<div class="modal fade" id="addProductModal<?=$category['id'];?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Добавить товар</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <div class="modal-body">
                <form action="<?=PATH . '/forms/admin/addProduct.php'?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="productImage" class="form-label">Категория: <?=$category['title_ru'];?></label>
                        <input type="hidden" name="product[category_en]" value="<?=$category['title_en'];?>">
                        <input class="form-control" type="hidden" id="productImage" name="product[category_id]" value="<?=$category['id'];?>">
                    </div>

                    <div class="mb-3">
                        <?php foreach ($subcategories as $subcategory):?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product[subcategory_id]" id="productType<?=$subcategory['id'];?>" value="<?=$subcategory['id'];?>">
                                <label class="form-check-label" for="productType<?=$subcategory['id'];?>">
                                    <?=$subcategory['title'];?>
                                </label>
                            </div>
                        <?php endforeach;?>
                    </div>

                    <div class="mb-3 row row-cols-2">
                        <div class="col">
                            <label for="productName" class="form-label">Название</label>
                            <input type="text" class="form-control" id="productName" name="product[title]" required minlength="4">
                        </div>
                        <div class="col">
                            <label for="productPrice" class="form-label">Цена</label>
                            <input type="number" class="form-control" id="productPrice" name="product[price]" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productDescription">Описание:</label>
                        <textarea class="form-control" rows="3" id="productDescription" name="product[description]" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="productImage" class="form-label">Изображение товара</label>
                        <input class="form-control" type="file" id="productImage" name="product" accept="image/*" required>
                    </div>

                    <button type="submit" class="btn btn-success col-12" name="product[add]">Добавить</button>

                </form>
            </div>
        </div>
    </div>
</div>
