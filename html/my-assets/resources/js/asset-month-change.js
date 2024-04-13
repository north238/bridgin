function assetMonthChange() {
    // 表示のデータが今月の場合「今月」ボタンを非表示
    // データがなければ「前月・今月」のボタンを非表示
    (function () {
        let nowMonth = document.getElementById("now-month").value;

        if (formatDate === nowMonth) {
            document.getElementById("now-month-btn").classList.add("invisible");
            document.getElementById("next-month-btn").classList.add("invisible");
        }
        if (assetMinDate === nowMonth) {
            document.getElementById("prev-month-btn").classList.add("invisible");
        }
    })();

    // 「前月」または「今月」ボタンがクリックされたときの処理
    document.querySelectorAll(".month-btn").forEach(function (btn) {
        btn.addEventListener("click", function () {
            document.getElementById("clicked-btn").value = btn.id;
        });
    });

    // 前月のボタンがクリックされた場合の処理
    document
        .getElementById("month-form-data")
        .addEventListener("submit", function (e) {
            e.preventDefault();

            const tableId = document.getElementById("m-assets-table");
            const url = this.action;
            const method = this.method;
            const formData = new FormData(this);

            fetch(url, {
                method: method,
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                },
                body: formData,
            })
                .then(function (response) {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.text();
                })
                .then(function (data) {
                    tableId.innerHTML = data;
                })
                .catch(function (error) {
                    console.error("エラーが発生しています。", error);
                });
        });
}

document.addEventListener("DOMContentLoaded", function () {
    assetMonthChange();
});
