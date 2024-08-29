import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    // 本番環境では不要のためコメント
    server: {
        host: true,
        hmr: {
            host: "localhost",
        },
        watch: {
            // usePolling: true,
            interval: 2000,
        },
    },
    build: {
        outDir: 'public/build', // ビルド結果を出力するディレクトリ
        sourcemap: false, // 本番環境ではソースマップを生成しない
        minify: 'esbuild', // コードの最小化
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/scss/app.scss",
                "resources/js/app.js",
            ],
            // 本番ではfalse
            refresh: false,
        }),
    ],
    resolve: {
        alias: {
            "@": "/resources/js",
        },
    },
});
