import { defineConfig } from 'vite'

export default defineConfig({
  build: {
    outDir: 'public',
    assetsDir: 'dist',
    rollupOptions: {
      input: './assets/sociallogin/index.js',
      output: {
        entryFileNames: `dist/bundle.js`,
        assetFileNames: `dist/bundle.[ext]`,
      },
    },
  },
})
