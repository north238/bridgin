import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        // colors: {
        //     gray: colors.coolGray,
        //     blue: colors.lightBlue,
        //     red: colors.rose,
        //     pink: colors.fuchsia,
        // },
        screens: {
            sm: "480px",
            md: "768px",
            lg: "976px",
            xl: "1440px",
        },
        extend: {
            // spacing: {
            //     128: "32rem",
            //     144: "36rem",
            // },
            // borderRadius: {
            //     "4xl": "2rem",
            // },
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                // sans: ["Graphik", "sans-serif"],
                // serif: ["Merriweather", "serif"],
            },
        },
    },
    plugins: [forms, require("flowbite/plugin")],
};
