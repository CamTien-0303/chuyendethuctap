import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
<<<<<<< HEAD
            input: [
                "resources/css/app.css",
                "resources/css/admin.css",
                "resources/css/client-dark-mode.css",
                "resources/js/app.js"
            ],
            refresh: true,
        }),
    ],
    build: {
        manifest: true,
        outDir: "public/build",
        rollupOptions: {
            output: {
                manualChunks: undefined,
            },
        },
    },
    server: {
        hmr: {
            host: "localhost",
        },
    },
=======
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
});
