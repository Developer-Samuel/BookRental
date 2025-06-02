// 📄 vite/config/resolve.ts

import path from 'path';

const resolveConfig = {
  alias: {
    '@': path.resolve(__dirname, '../../resources/ts'),
  },
};

export default resolveConfig;
