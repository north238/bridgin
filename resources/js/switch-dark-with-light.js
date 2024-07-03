function switchDarkWithLight() {
    const themeToggleDarkIcon = document.getElementById(
        "theme-toggle-dark-icon"
    );
    const themeToggleDarkIconSP = document.getElementById(
        "theme-toggle-dark-icon-sp"
    );
    const themeToggleLightIcon = document.getElementById(
        "theme-toggle-light-icon"
    );
    const themeToggleLightIconSP = document.getElementById(
        "theme-toggle-light-icon-sp"
    );
    const themeToggleBtn = document.getElementById("theme-toggle");
    const themeToggleBtnSP = document.getElementById("theme-toggle-sp");

    // テーマの切り替えに応じてアイコンの表示を設定する
    if (
        localStorage.getItem("color-theme") === "dark" ||
        (!("color-theme" in localStorage) &&
            window.matchMedia("(prefers-color-scheme: dark)").matches)
    ) {
        // ダークモードの場合はライトアイコンを表示
        themeToggleLightIcon.classList.remove("hidden");
        themeToggleLightIconSP.classList.remove("hidden");
    } else {
        // ライトモードの場合はダークアイコンを表示
        themeToggleDarkIcon.classList.remove("hidden");
        themeToggleDarkIconSP.classList.remove("hidden");
    }

    // PC用切替ロジック
    themeToggleBtn.addEventListener("click", function () {
        themeToggleDarkIcon.classList.toggle("hidden");
        themeToggleLightIcon.classList.toggle("hidden");

        // ローカルストレージ経由で設定されていた場合
        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }

            // ローカルストレージ経由で設定されていない場合
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        }
    });

    // SP用切替ロジック
    themeToggleBtnSP.addEventListener("click", function () {
        themeToggleDarkIconSP.classList.toggle("hidden");
        themeToggleLightIconSP.classList.toggle("hidden");

        // ローカルストレージ経由で設定されていた場合
        if (localStorage.getItem("color-theme")) {
            if (localStorage.getItem("color-theme") === "light") {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            } else {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            }

            // ローカルストレージ経由で設定されていない場合
        } else {
            if (document.documentElement.classList.contains("dark")) {
                document.documentElement.classList.remove("dark");
                localStorage.setItem("color-theme", "light");
            } else {
                document.documentElement.classList.add("dark");
                localStorage.setItem("color-theme", "dark");
            }
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    switchDarkWithLight();
});
