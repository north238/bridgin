function createWithUpdate() {

    /**
     * カテゴリ選択の制御（ジャンルの中から選択）
     */
    function handleGenreChange() {
        const genreId = document.getElementById("genre_id").value;
        const categorySelect = document.getElementById("category_id");
        categorySelect.disabled = false;

        // カテゴリーリストをクリアしてから再構築する
        categorySelect.innerHTML =
            '<option value="">--選択してください--</option>';

        categories.forEach(function (category) {
            if (category.genre_id == genreId) {
                const option = document.createElement("option");
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            }
        });
    }

    document
        .getElementById("genre_id")
        .addEventListener("change", handleGenreChange);

    /**
     * 資産タイプの選択の制御(どちらか一方しか選択できない)
     * @param sourceAsset
     * @param targetAsset
     */
    function handleAssetClick(sourceAsset, targetAsset) {
        const sourceChecked = sourceAsset.checked;
        if (sourceChecked) {
            targetAsset.checked = false;
        } else {
            targetAsset.checked = true;
        }
    }

    const fixedAsset = document.getElementById("fixed-asset");
    const currentAsset = document.getElementById("current-asset");

    currentAsset.addEventListener("change", () => {
        handleAssetClick(currentAsset, fixedAsset);
    });

    fixedAsset.addEventListener("change", () => {
        handleAssetClick(fixedAsset, currentAsset);
    });
}

document.addEventListener("DOMContentLoaded", () => {
    createWithUpdate();
});
