function assetCreate() {

    function handleCreatedFormSubmit() {

        const createdBtn = document.getElementById("created-btn");
        const checkIcon = document.getElementById("check-icon");
        const loadingIcon = document.getElementById("loading-icon");

        // ボタンを無効化し、アイコンの表示を切り替える
        createdBtn.disabled = true;
        checkIcon.classList.add("hidden");
        loadingIcon.classList.remove("hidden");

        // 5秒後にボタンを有効化し、アイコンの表示を切り替える
        setTimeout(function () {
            createdBtn.disabled = false;
            loadingIcon.classList.add("hidden");
            checkIcon.classList.remove("hidden");
        }, 5000);
    }

    document
        .getElementById("created-form")
        .addEventListener("submit", handleCreatedFormSubmit);

}

document.addEventListener("DOMContentLoaded", function() {
    assetCreate();
});
