import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    // logLevel: "error", // show error messages, ignore warnings
    plugins: [
        laravel({
            input: ["resources/js/app.js"],
            refresh: true,
        }),
    ],
    css: {
        // wyłącz dev sourcemap (przyspieszy kompilację i transfer CSS)
        devSourcemap: false,
    },
    server: {
        host: "0.0.0.0", // to make Vite accessible from outside the container
        port: 5173, // standard port for Vite — does not conflict with 8000
        strictPort: false, // if 5173 is occupied, Vite will try another
        hmr: {
            host: "localhost", // for Windows with Docker Desktop
            protocol: "ws",
            port: 5173,
        },
        watch: {
            usePolling: true, // this is crucial for Docker/WSL
            interval: 20000, // time in ms, how often Vite checks for changes
        },
    },
});
