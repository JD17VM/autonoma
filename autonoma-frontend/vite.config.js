import { defineConfig } from 'vite'
import react from '@vitejs/plugin-react-swc'

// https://vite.dev/config/
export default defineConfig({
  plugins: [react()],

  css: {
    preprocessorOptions: {
      scss: {
        silenceDeprecations: [
          'legacy-js-api', 
          'import', 
          'global-builtin',
          'color-functions',
          'mixed-decls',
        ], // Esto silencia las advertencias de deprecación de SASS
      },
    },
  },
})
