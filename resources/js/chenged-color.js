/**
 * 負債の背景色を変更する
 */
function debutAssetColor() {
    const genreNameTds = document.querySelectorAll("td[data-genre_id]");

    genreNameTds.forEach((genreNameTd) => {
        const parentElement = genreNameTd.parentElement;
        const genreId = genreNameTd.dataset.genre_id;
        const amountElement = parentElement.querySelector(".amount-cell");

        if (genreId === "8") {
            amountElement.classList.add("text-rose-500");
            amountElement.classList.remove("text-green-500");
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    debutAssetColor();
});
