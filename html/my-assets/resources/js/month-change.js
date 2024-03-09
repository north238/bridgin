$(document).ready(function () {
    $(".month-btn").click(function () {
        let btnId = $(this).attr("id"); // クリックされたボタンのidを取得
        $("#clicked-btn").val(btnId);
    });
    // 前月のボタンがクリックされたら
    $("#month-form-data").submit(function (event) {
        event.preventDefault(); // デフォルトのクリック動作を無効化
        const tableId = $("#m-assets-table");
        let monthFormData = $(this).serialize();
        let formData = new URLSearchParams(monthFormData); //serialize()で取得した文字列をURLSearchParamsオブジェクトに変換
        let formDataObject = Object.fromEntries(formData.entries()); // URLSearchParamsオブジェクトからJavaScriptのオブジェクトに変換

        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: url,
            data: formDataObject,
            type: "POST",
        })
            .done(function (res) {
                tableId.html(res);
            })
            .fail(function (err) {
                console.log("エラーが発生しています。", err);
            });
    });
});
