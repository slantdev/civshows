import prefixSelector from "postcss-prefix-selector";

export default {
  plugins: {
    "@tailwindcss/postcss": {},
    "postcss-prefix-selector": {
      prefix: "#poststuff .acf-layout",
      transform(prefix, selector, prefixedSelector, filePath) {
        if (filePath.match(/acf-layouts\.css/)) {
          if (selector === "body" || selector === "html") {
            return prefix;
          }
          return prefixedSelector;
        }
        return selector;
      },
    },
  },
};