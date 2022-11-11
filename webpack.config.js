const path = require("path");

module.exports = {
  mode: "development",
  entry: "./resources/js/index.js",
  output: {
    filename: "bundle.js",
    path: path.resolve(__dirname, "public/js"),
  },
  module: {
    rules: [],
  },
};
