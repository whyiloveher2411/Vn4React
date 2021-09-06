const path = require('path')

module.exports = {
  devServer: {
    watchOptions: {
      ignored: [
        path.resolve(__dirname, 'uploads') // image folder path
      ]
    }
  },
}