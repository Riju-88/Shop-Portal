import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";
const daisyui = require("daisyui");
import preset from "./vendor/filament/support/tailwind.config.preset";

/** @type {import('tailwindcss').Config} */
export default {
    presets: [preset],
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./vendor/laravel/jetstream/**/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/views/livewire/**/*.blade.php",
        "./app/Filament/**/*.php",
        "./resources/views/filament/**/*.blade.php",
        "./vendor/filament/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", ...defaultTheme.fontFamily.sans],
            },
        },
    },

    daisyui: {
        themes: [
            {
                mytheme: {
                    primary: "#1e40af",

                    secondary: "#7c3aed",

                    accent: "#ff9a03",

                    neutral: "#090409",

                    "base-100": "#f6fdff",

                    info: "#2563eb",

                    success: "#4ade80",

                    warning: "#fab803",

                    error: "#df2505",
                },
                container: {
                    center: true,
                },
            },
        ],
    },
    plugins: [forms, typography, daisyui],
};
