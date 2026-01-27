import { defineConfig } from "vite";
import browserSync from "browser-sync";
import fs from "fs";
import path from "path";
import { networkInterfaces } from "os";

function getNetworkIp() {
  const nets = networkInterfaces();
  for (const name of Object.keys(nets)) {
    for (const net of nets[name]) {
      if (net.family === 'IPv4' && !net.internal) {
        return net.address;
      }
    }
  }
  return 'localhost';
}

const writeHotFile = () => ({
  name: 'write-hot-file',
  configureServer(server) {
    const hotFilePath = path.resolve(process.cwd(), 'hot');
    
    server.httpServer?.on('listening', () => {
      const port = server.config.server.port;
      const ip = getNetworkIp();
      const url = `http://${ip}:${port}`;
      fs.writeFileSync(hotFilePath, url);
    });

    server.httpServer?.on('close', () => {
      if (fs.existsSync(hotFilePath)) {
        fs.unlinkSync(hotFilePath);
      }
    });
  },
  buildStart() {
    const hotFilePath = path.resolve(process.cwd(), 'hot');
    if (fs.existsSync(hotFilePath)) {
      fs.unlinkSync(hotFilePath);
    }
  }
});

export default defineConfig({
  plugins: [
    writeHotFile(),
    {
      name: "browser-sync",
      apply: "serve",
      configureServer(server) {
        const bs = browserSync.create();
        bs.init({
          proxy: "http://civshows.local",
          https: false,
          files: ["**/*.php"],
          notify: false,
          open: true,
          port: 3005
        });
      },
    },
  ],
  build: {
    outDir: "assets",
    emptyOutDir: false,
    rollupOptions: {
      input: {
        main: "./src/main.js",
        "admin-style": "./src/css/admin-style.css",
        "acf-layouts": "./src/css/acf-layouts.css",
      },
      output: {
        entryFileNames: "js/[name].js",
        chunkFileNames: "js/[name].js",
        assetFileNames: ({ name }) => {
          if (/\.css$/.test(name ?? "")) {
            return "css/[name].[ext]";
          }
          return "[name].[ext]";
        },
      },
    },
  },
  server: {
    strictPort: true,
    port: 5174,
    host: true, // Listen on all local IPs
    cors: {
      origin: '*', // Allow all origins
      methods: ['GET', 'POST', 'OPTIONS'],
      allowedHeaders: ['Content-Type', 'Authorization'],
      credentials: true,
    },
  },
});