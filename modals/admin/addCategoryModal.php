<div class="modal fade" id="addCategoryModal<?=$newCategoryID;?>" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="addModalLabel">Добавить категорию</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
            </div>

            <div class="modal-body">
                <form action="<?=PATH . '/forms/admin/addCategory.php'?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3 row row-cols-2">
                        <div class="col">
                            <label for="productNameRu" class="form-label">Название на русском</label>
                            <input type="text" class="form-control" id="productNameRu" name="category[title_ru]" required minlength="2">
                        </div>
                        <div class="col">
                            <label for="productNameEn" class="form-label">Название на английском</label>
                            <input type="text" class="form-control" id="productNameEn" name="category[title_en]" required minlength="2">
                        </div>
                    </div>

                    <div class="mb-3" >
                        <label for="subcategory1">Подкатегория 1:</label>
                        <input type="text" name="subcategories[]" id="subcategory1">
                    </div>

                    <div class="mb-3" id="subcategories">
                        <label for="subcategory2">Подкатегория 2:</label>
                        <input type="text" name="subcategories[]" id="subcategory2">
                    </div>

                    <button type="button" class="btn mb-3 btn-outline-primary" onclick="addSubcategory()">Добавить подкатегорию</button>

                    <button type="submit" class="btn btn-success col-12" name="category[add]">Добавить</button>

                </form>
            </div>
        </div>
    </div>
</div>
