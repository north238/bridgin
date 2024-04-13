function reorderAsset() {

    /**
     * ソート機能
     * @param {Object} sort 
     * @param {Object} sortLink 
     */
    function submitSortData(sort, sortLink) {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");
        const headers = {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json",
        };

        fetch(sortUrl, {
            headers: headers,
            body: JSON.stringify(sort),
            method: "POST",
        })
            .then((res) => {
                if (!res.ok) {
                    throw new Error(`Ajax Error! Status: ${res.status}`);
                }
                console.log(res);
                return res.text();
            })
            .then((data) => {
                sortLink.dataset.sort = data;
                console.log("非同期処理に成功しました！", data);
            })
            .catch((err) => {
                console.error("エラーが発生しています。", err.message);
            });
    }

    /**
     * 表示する資産の切り替え
     */
    function handleDebutStatusClick() {
        const url = document.getElementById("asset-switch-form").action;
        const method = document.getElementById("asset-switch-form").method;
        const formData = new FormData(
            document.getElementById("asset-switch-form")
        );

        fetch(url, {
            method: method,
            headers: {
                "X-CSRF-TOKEN": document.querySelector(
                    'meta[name="csrf-token"]'
                ).content,
            },
            body: formData,
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                console.log("Fetch成功", data);
            })
            .catch((error) => {
                console.error("エラーが発生しています。", error);
            });
    }

    const categoryNameSort = document.getElementById("category-sort");
    const amountSort = document.getElementById("amount-sort");
    const registrationDateSort = document.getElementById(
        "registration-date-sort"
    );
    const debutStatusBtn = document.getElementById("debut-status");

    categoryNameSort.addEventListener("click", function (e) {
        e.preventDefault();
        const sort = JSON.parse(categoryNameSort.dataset.sort);
        sort.newOrder = "category_id";
        submitSortData(sort, categoryNameSort);
    });

    amountSort.addEventListener("click", function (e) {
        e.preventDefault();
        const sort = JSON.parse(amountSort.dataset.sort);
        sort.newOrder = "amount";
        submitSortData(sort, amountSort);
    });

    registrationDateSort.addEventListener("click", function (e) {
        e.preventDefault();
        const sort = JSON.parse(registrationDateSort.dataset.sort);
        sort.newOrder = "registration_date";
        submitSortData(sort, registrationDateSort);
    });

    debutStatusBtn.addEventListener("click", handleDebutStatusClick);
}

document.addEventListener("DOMContentLoaded", function () {
    reorderAsset();
});
