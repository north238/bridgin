function assetUpdate() {
    /**
     * 画面読み込み時にチェックをつける資産タイプを判定
     */
    (function assetTypeCheck() {
        const assetTypeFlgVal = document.getElementById("asset-type-flg").value;
        const fixedAsset = document.getElementById("fixed-asset");
        const currentAsset = document.getElementById("current-asset");
        if (assetTypeFlgVal === "0") {
            currentAsset.checked = true;
        } else {
            fixedAsset.checked = true;
        }
    })();

    /**
     * 資産更新時のボタンの色を制御
     * チェックボックスがクリックされたらボタンの色を変える
     */
    function handleTypeChange() {
        const updatedText = document.getElementById("updated-text");
        const updatedBtn = document.getElementById("updated-btn");
        const updatedIcon = document.getElementById("updated-icon");
        const plusIcon = document.getElementById("plus-icon");
        const greenClass = [
            "bg-green-500",
            "hover:bg-green-600",
            "peer-focus:ring-green-300",
            "dark:bg-green-500",
            "dark:hover:bg-green-600",
            "dark:peer-focus:ring-green-700",
            "focus:ring-green-700",
            "dark:focus:ring-green-700",
        ];

        const blueClass = [
            "bg-blue-500",
            "hover:bg-blue-600",
            "peer-focus:ring-blue-500",
            "dark:bg-blue-500",
            "dark:hover:bg-blue-600",
            "dark:peer-focus:ring-blue-700",
            "focus:ring-blue-700",
            "dark:focus:ring-blue-700",
        ];

        if (this.checked) {
            updatedText.textContent = "追加する";
            updatedBtn.classList.remove(...greenClass);
            updatedBtn.classList.add(...blueClass);
            updatedIcon.classList.add('hidden');
            plusIcon.classList.remove('hidden');
        } else {
            updatedText.textContent = "更新する";
            updatedBtn.classList.remove(...blueClass);
            updatedBtn.classList.add(...greenClass);
            updatedIcon.classList.remove("hidden");
            plusIcon.classList.add("hidden");
        }
    }

    document
        .getElementById("changed_type_flg")
        .addEventListener("change", handleTypeChange);

    /**
     * 更新ボタンがクリックされたときの制御
     * 5秒間ボタンがクリックできないようになっています
     */
    function handleUpdatedFormSubmit() {
        const updatedBtn = document.getElementById("updated-btn");
        const updatedIcon = document.getElementById("updated-icon");
        const PlusIcon = document.getElementById("plus-icon");
        const updatedLoadingIcon = document.getElementById(
            "updated-loading-icon"
        );

        updatedBtn.disabled = true;
        updatedIcon.classList.add("hidden");
        PlusIcon.classList.add("hidden");
        updatedLoadingIcon.classList.remove("hidden");

        setTimeout(function () {
            updatedBtn.disabled = false;
            updatedLoadingIcon.classList.add("hidden");
            PlusIcon.classList.remove("hidden");
            updatedIcon.classList.remove("hidden");
        }, 5000);

    }

    document
        .getElementById("updated-form")
        .addEventListener("submit", handleUpdatedFormSubmit);

    /**
     * モーダル内のフォームが送信された際の処理を行います。
     * フォームのデフォルトの送信を防止し、ボタンの無効化とアイコンの表示を制御します。
     */
    function handleDeletedModalFormSubmit() {

        const deletedModal = document.getElementById("deleted-modal");
        const deletedModalBtn = document.getElementById("deleted-modal-btn");
        const deletedModalIcon = document.getElementById("deleted-modal-icon");
        const deletedLoadingIcon = document.getElementById(
            "deleted-loading-icon"
        );

        // モーダルを非表示にし、ボタンを無効化し、アイコンの表示を切り替える
        deletedModal.style.display = "none";
        deletedModalBtn.disabled = true;
        deletedModalIcon.classList.add("hidden");
        deletedLoadingIcon.classList.remove("hidden");

        // 5秒後にボタンを有効化し、アイコンの表示を切り替える
        setTimeout(function () {
            deletedModalBtn.disabled = false;
            deletedModalIcon.classList.remove("hidden");
            deletedLoadingIcon.classList.add("hidden");
        }, 5000);
    }

    document
        .getElementById("deleted-modal-form")
        .addEventListener("submit", handleDeletedModalFormSubmit);
}

function generateShowBackUrl() {
    const backBtn = document.getElementById("show-back-btn");
    const previousUrl = backBtn.dataset.previousUrl;
    backBtn.href = previousUrl;
}

document.addEventListener("DOMContentLoaded", () => {
    assetUpdate();
    generateShowBackUrl();
});
