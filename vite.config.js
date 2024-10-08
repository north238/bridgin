import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import path from "path";

export default defineConfig(() => {
    const isProduction = process.env.VITE_APP_ENV === "production";
    return {
        // 本番環境では不要のためコメント
        server: {
            https: isProduction,
            host: !isProduction ? true : undefined,
            hmr: !isProduction
                ? {
                      host: "localhost",
                  }
                : undefined,
            watch: !isProduction
                ? {
                      interval: 2000,
                  }
                : undefined,
        },
        base: isProduction ? "https://bridgin-app.com/" : "/", // HTTPSを強制する
        build: {
            outDir: "public/build", // ビルド結果を出力するディレクトリ
            sourcemap: false, // 本番環境ではソースマップを生成しない
        },
        plugins: [
            laravel({
                input: [
                    "resources/css/app.css",
                    "resources/scss/app.scss",
                    "resources/js/app.js",
                    "resources/js/asset-create.js",
                    "resources/js/asset-month-change.js",
                    "resources/js/asset-update.js",
                    "resources/js/chenged-color.js",
                    "resources/js/create-with-update.js",
                    "resources/js/debut-display-switching.js",
                    "resources/js/display-loading-animation.js",
                    "resources/js/monthly-chart.js",
                    "resources/js/reorder-asset.js",
                    "resources/js/switch-dark-with-light.js",
                    "resources/js/yearly-chart.js",
                    "resources/js/csv-upload.js"
                ],
                // 本番ではfalse
                refresh: !isProduction,
            }),
        ],
        resolve: {
            alias: {
                "~": path.resolve(__dirname, "node_modules"),
            },
        },
    };
});
