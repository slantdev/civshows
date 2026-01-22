import { defineConfig } from 'vite';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
  plugins: [
    tailwindcss(),
  ],
  build: {
    outDir: 'assets',
    emptyOutDir: true,
    manifest: true,
    rollupOptions: {
      input: 'src/main.js',
      output: {
        entryFileNames: 'js/[name]-[hash].js',
        assetFileNames: (assetInfo) => {
          if (assetInfo.name && assetInfo.name.endsWith('.css')) {
            return 'css/[name]-[hash][extname]';
          }
          return 'img/[name]-[hash][extname]';
        },
      },
    },
  },
  server: {
    cors: true,
    strictPort: true,
    port: 3000,
    origin: 'http://localhost:3000',
    hmr: {
      host: 'localhost',
    },
    proxy: {
      '/': 'http://civshows.local', // Simple proxy, though usually WP needs the dev server entry point
    },
  },
});
