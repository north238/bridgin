import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
const colors = require("tailwindcss/colors");

export default {
    darkMode: "class",
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
        "./resources/**/*.js",
    ],
    theme: {
        colors: {
            red: colors.red,
            gray: colors.gray,
            sky: colors.sky,
            rose: colors.rose,
            pink: colors.fuchsia,
            zinc: colors.zinc,
            slate: colors.slate,
            amber: colors.amber,
            cyan: colors.cyan,
            transparent: "transparent",
            current: "currentColor",
            white: "#ffffff",
        },
        screens: {
            sm: "480px",
            md: "768px",
            lg: "976px",
            xl: "1440px",
        },
        extend: {
            colors: {
                red: colors.red,
                primary: {
                    50: "#eff6ff",
                    100: "#dbeafe",
                    200: "#bfdbfe",
                    300: "#93c5fd",
                    400: "#60a5fa",
                    500: "#3b82f6",
                    600: "#2563eb",
                    700: "#1d4ed8",
                    800: "#1e40af",
                    900: "#1e3a8a",
                    950: "#172554",
                },
            },
            fontFamily: {
                sans: [
                    "Noto Sans JP",
                    "Noto Sans CJK JP",
                    "Roboto",
                    "sans-serif",
                ],
            },
        },
    },
    plugins: [
        forms,
        require("flowbite/plugin")({
            charts: true,
            forms: true,
            tooltips: true,
        }),
    ],
};
