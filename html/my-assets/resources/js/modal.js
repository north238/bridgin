// 編集ボタンがクリックされたらモーダルを表示する
// モーダルはajaxを使用し非同期処理とする
$(function () {
    $("#updateProductButton").on("click", function () {
        const data = "hogehoge";
        const url = route("ajax.updateAsset", { asset: assetId });
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $("[name='csrf-token']").attr("content"),
            },
            url: url,
            method: "POST",
            data: data,
        }).then(
            function (data) {
                console.log("ajaxで送信しています。");
            },
            function (jqXHR, textStatus, errorThrown) {
                console.log("エラーが発生しています。", errorThrown);
            }
        );
    });
});
