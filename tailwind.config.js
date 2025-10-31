import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.svg",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Montserrat", ...defaultTheme.fontFamily.sans],
                heading: ["Oswald", "sans-serif"],
                body: ["Montserrat", "sans-serif"],
            },
            colors: {
                primary: "#6B6751",
                secondary: "oklch(26.9% 0 0)",
            },
        },
    },

    plugins: [forms],
};
