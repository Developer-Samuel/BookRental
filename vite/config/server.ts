// 📄 vite/config/server.ts

const serverConfig = {
  host: '0.0.0.0',
  port: 5173,
  strictPort: true,
  cors: {
    origin: ['http://localhost:8000'],
  },
  hmr: {
    protocol: 'ws',
    host: 'localhost',
    port: 5173,
  },
  watch: {
    usePolling: true,
    interval: 100,
    ignored: ['**/node_modules/**', '**/vendor/**'],
  },
};

export default serverConfig;
