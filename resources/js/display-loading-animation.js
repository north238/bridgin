window.addEventListener("DOMContentLoaded", animationStartStop);

// 画面ローディングアニメーション
// ローディング時に表示、ローディング終了時に非表示または2秒後に非表示
function animationStartStop(e) {
    e.preventDefault();
    const body = document.body;
    const loaderWrap = document.getElementById("loader");
    body.classList.add("overflow-hidden");

    setTimeout(() => {
        loaderWrap.classList.add("hidden");
        body.classList.remove("overflow-hidden");
    }, 2000);
}
