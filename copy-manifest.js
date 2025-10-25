// Copy manifest from .vite subdirectory to build root for Laravel compatibility
import { copyFileSync, existsSync } from 'fs';
import { join } from 'path';

const source = join('public', 'build', '.vite', 'manifest.json');
const destination = join('public', 'build', 'manifest.json');

if (existsSync(source)) {
    copyFileSync(source, destination);
    console.log('✅ Manifest copied to', destination);
} else {
    console.error('❌ Source manifest not found at', source);
    process.exit(1);
}
