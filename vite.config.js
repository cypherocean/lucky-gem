import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import fs from 'fs';
import path from 'path';

// Function to recursively find all .js files in a directory
function getJsFiles(dir) {
    let files = [];
    fs.readdirSync(dir).forEach((file) => {
        const fullPath = path.join(dir, file);
        if (fs.statSync(fullPath).isDirectory()) {
            files = [...files, ...getJsFiles(fullPath)];
        } else if (file.endsWith('.js')) {
            files.push(fullPath.replace(/\\/g, '/')); // Use forward slashes for compatibility
        }
    });
    return files;
}

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                ...getJsFiles('resources/js/project'),
            ],
            refresh: true,
        }),
    ],
    server: {
        host: 'lucky-gem',
        port: 5173,
        https: {
            key: fs.readFileSync('../../apache/crt/lucky-gem/server.key'),
            cert: fs.readFileSync('../../apache/crt/lucky-gem/server.crt'),
        },
    },
});
