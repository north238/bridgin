function reorderAsset() {

    /**
     * ソート機能
     * @param {Object} sort
     */
    function submitSortData(sort) {
        const mAssetTable = document.getElementById("m-assets-table");
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
                return res.text();
            })
            .then((data) => {
                mAssetTable.innerHTML = data;
                console.log("非同期処理に成功しました！");
            })
            .catch((err) => {
                console.error("エラーが発生しています。", err.message);
            });
    }

    const categoryNameSort = document.getElementById("category-sort");
    const amountSort = document.getElementById("amount-sort");
    const registrationDateSort = document.getElementById(
        "registration-date-sort"
    );

    categoryNameSort.addEventListener("click", function (e) {
        e.preventDefault();
        const sort = JSON.parse(categoryNameSort.dataset.sort);
        sort.newOrder = "category_id";
        submitSortData(sort);
    });

    amountSort.addEventListener("click", function (e) {
        e.preventDefault();
        const sort = JSON.parse(amountSort.dataset.sort);
        sort.newOrder = "amount";
        submitSortData(sort);
    });

    registrationDateSort.addEventListener("click", function (e) {
        e.preventDefault();
        const sort = JSON.parse(registrationDateSort.dataset.sort);
        sort.newOrder = "registration_date";
        submitSortData(sort);
    });

}

document.addEventListener("DOMContentLoaded", function () {
    reorderAsset();
});
