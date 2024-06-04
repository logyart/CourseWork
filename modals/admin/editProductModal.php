<div class="modal fade" id="editProductModal<?=$product['id'];?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Изменить товар</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <div class="modal-body">
                <form action="<?=PATH . '/forms/admin/editProduct.php'?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <input type="hidden" name="product[id]" value="<?=$product['id'];?>">
                        <input type="hidden" name="product[category_en]" value="<?=$category['title_en'];?>">
                        <label for="productCategory" class="form-label">Категория:</label>
                        <select class="form-select" name="product[category_id]">
                            <?php foreach ($categories as $c):?>
                                <option <?php if ($category['id'] == $c['id']) echo "selected"?> id="productCategory" value="<?=$c['id']?>"><?=$c['title_ru']?></option>
                            <?php endforeach;?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <?php foreach ($subcategories as $subcategory):?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="product[subcategory_id]"
                                       id="productType<?=$subcategory['id'];?>" value="<?=$subcategory['id'];?>"
                                    <?php if ($product['subcategory_id'] == $subcategory['id']) echo "checked"?>
                                >
                                <label class="form-check-label" for="productType<?=$subcategory['id'];?>">
                                    <?=$subcategory['title'];?>
                                </label>
                            </div>
                        <?php endforeach;?>
                    </div>

                    <div class="mb-3 row row-cols-2">
                        <div class="col">
                            <label for="productName" class="form-label">Название</label>
                            <input type="text" class="form-control" id="productName" name="product[title]" required value="<?=$product['title'];?>">
                        </div>
                        <div class="col">
                            <label for="productPrice" class="form-label">Цена</label>
                            <input type="number" class="form-control" id="productPrice" name="product[price]" required value="<?=$product['price'];?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="productDescription">Описание:</label>
                        <textarea class="form-control" rows="3" id="productDescription" name="product[description]" required><?=$product['description'];?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="productImage" class="form-label">Изображение товара</label>
                        <input type="hidden" name="product[old_path]" value="<?=$product['img_path'];?>">
                        <input class="form-control" type="file" id="productImage" name="product" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-success col-12" name="product[edit]">Изменить</button>

                </form>
            </div>
        </div>
    </div>
</div>
