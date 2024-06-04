/* для установки курсора в маске телефона после "+7 (" */
$(document).ready(function() {
    $("#phone").mask("+7 (999) 999-99-99");
});

$.fn.setCursorPosition = function(pos) {
    if ($(this).get(0).setSelectionRange) {
        $(this).get(0).setSelectionRange(pos, pos);
    } else if ($(this).get(0).createTextRange) {
        var range = $(this).get(0).createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
    }
};

$("#phone").click(function(){
    $(this).setCursorPosition(4);  // set position number
});


/* для множественного добавления подкатегорий */
let subcategoryCount = 2;

function addSubcategory() {
    subcategoryCount++;

    const subcategory = document.createElement('div');
    subcategory.id = `subcategory${subcategoryCount}`;
    subcategory.classList.add("mb-3");
    subcategory.innerHTML = `
        <label for="subcategory${subcategoryCount}">Подкатегория ${subcategoryCount}:</label>
        <input type="text" name="subcategories[]" id="subcategory${subcategoryCount}">
        <button type="button" class="btn" onclick="removeSubcategory(${subcategoryCount})">❌</button>
    `;
    document.getElementById('subcategories').appendChild(subcategory);
}

function removeSubcategory(subcategoryId) {
    const subcategory = document.getElementById(`subcategory${subcategoryId}`);
    if (subcategory) {
        subcategory.remove();
        subcategoryCount--;
    }
}