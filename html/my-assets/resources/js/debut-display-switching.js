/**
 * 負債の表示・非表示を切り替える
 * フォームに入力された値をサーバーへ送信
 */
function debutStatusHandler() {
    const assetSwitchForm = document.getElementById("asset-switch-form");
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

    assetSwitchForm.addEventListener("submit", function (e) {
        e.preventDefault();
        const url = assetSwitchForm.getAttribute("action");
        const method = assetSwitchForm.getAttribute("method");
        const formData = new FormData(assetSwitchForm);
        const csrfToken = csrfTokenMeta.getAttribute("content");

        fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("非同期処理でエラーが発生しています。");
                }
                return response.json();
            })
            .then((data) => {
                console.log("非同期処理が成功しました。", data);
                window.location.reload();
            })
            .catch((err) => {
                console.error("エラーが発生しています。", err.message);
            });
    });
}

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
            amountElement.classList.add("text-red-500");
            amountElement.classList.remove("text-green-500");
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    debutStatusHandler();
    debutAssetColor();
});
