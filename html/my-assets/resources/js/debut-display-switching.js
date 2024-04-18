function debutStatusHandler() {
    const assetSwitchForm = document.getElementById("asset-switch-form");
    const debutStatusButton = document.getElementById("debut-status");
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');

    debutStatusButton.addEventListener("click", function () {
        const url = assetSwitchForm.getAttribute("action");
        const method = assetSwitchForm.getAttribute("method");
        const formData = new FormData(assetSwitchForm);
        const debutStatusValue = formData.get("debut-status");
        console.log(debutStatusValue);

        const csrfToken = csrfTokenMeta.getAttribute("content");

        fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": csrfToken,
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formData),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("非同期処理でエラーが発生しています。");
                }
                return response.text();
            })
            .then((data) => {
                console.log("非同期処理が成功しました。", data);
            })
            .catch((err) => {
                console.error("エラーが発生しています。", err.message);
            });
    });
}

document.addEventListener("DOMContentLoaded", function () {
    debutStatusHandler();
});
