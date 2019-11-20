module.exports = {
    extends: [
      // add more generic rulesets here, such as:
      'eslint:recommended',
      'plugin:vue/recommended'
    ],
    rules: {
      // override/add rules settings here, such as:
      // 'vue/no-unused-vars': 'error'
        "no-extra-parens": ["warn", "all"],
        "no-template-curly-in-string": ["warn"],
        "array-callback-return": ["warn"],
        "block-scoped-var": ["warn"],
        "class-methods-use-this": ["warn"],
        "complexity": ["warn"],
        "consistent-return": ["warn"],
        "curly": ["warn", "all"],
        "default-case": ["warn"],
        "dot-location": ["warn", "property"],
        "dot-notation": ["warn"],
        "eqeqeq": ["warn"],
        "guard-for-in": ["warn"],
        "no-div-regex": ["warn"],
        "no-else-return": ["warn"],
        "no-empty-function": ["warn"],
        "no-eq-null": ["warn"],
        "no-eval": ["warn"],
        "no-extend-native": ["warn"],
        "no-extra-bind": ["warn"],
        "no-floating-decimal": ["warn"],
        "no-implicit-coercion": ["warn"],
        "no-implicit-globals": ["warn"],
        "no-invalid-this": ["warn"],
        "no-lone-blocks": ["warn"],
        "no-loop-func": ["warn"],
        "no-multi-spaces": ["warn"],
        "no-new": ["warn"],
        "no-return-assign": ["warn"],
        "no-return-await": ["warn"],
        "no-sequences": ["warn"],
        "no-self-compare": ["warn"],
        "no-unmodified-loop-condition": ["warn"],
        "no-unused-expressions": ["warn"],
        "no-useless-return": ["warn"],
        "no-useless-concat": ["warn"],
        "radix": ["warn"],
        "require-await": ["warn"],
        "vars-on-top": ["warn"],
        "yoda": ["warn"],

        "init-declarations": ["warn"],
        "no-shadow": ["warn"],

        "callback-return": ["warn"],

        "array-bracket-newline": ["warn", {"multiline": true}],
        "array-bracket-spacing": ["warn"],
        "array-element-newline": ["error", "consistent"],
        "block-spacing": ["warn"],
        "brace-style": ["warn"],
        "comma-dangle": ["warn", "always-multiline"],
        "comma-spacing": ["warn"],
        "computed-property-spacing": ["warn"],
        "eol-last": ["warn"],
        "func-call-spacing": ["warn"],
        "func-name-matching": ["warn"],
        "function-paren-newline": ["warn"],
        "implicit-arrow-linebreak": ["warn"],
        "key-spacing": ["warn"],
        "keyword-spacing": ["warn"],
        "linebreak-style": ["warn"],
        "lines-between-class-members": ["warn"],
        "new-cap": ["warn"],
        "no-lonely-if": ["warn"],
        "no-trailing-spaces": ["warn"],
        "object-curly-newline": ["warn"],
        "quote-props": ["warn", "as-needed"],
        "space-before-blocks": ["warn"],
        "quotes": ["warn", "single", {"avoidEscape": true, "allowTemplateLiterals": true}],
        "semi": ["warn"],
        "space-before-function-paren": ["warn", {"anonymous": "always", "named": "never", "asyncArrow": "always"}],
        "space-in-parens": ["warn"],
        "space-infix-ops": ["warn"],
        "space-unary-ops": ["warn"],
        "arrow-body-style": ["warn"],
        "arrow-parens": ["warn", "as-needed"],
        "arrow-spacing": ["warn"],
        "no-confusing-arrow": ["warn"],
        "no-duplicate-imports": ["warn"],
        "no-useless-computed-key": ["warn"],
        "no-var": ["warn"],
        "object-shorthand": ["warn"],
        "prefer-template": ["warn"],
        "sort-imports": ["warn"],
        "template-curly-spacing": ["warn"],


        "vue/script-indent": ["warn", 4, {
          "baseIndent": 0,
          "switchCase": 0,
          "ignores": []
        }],
        "vue/html-indent": ["warn", 4, {
          "attribute": 1,
          "baseIndent": 1,
          "closeBracket": 0,
          "alignAttributesVertically": true,
          "ignores": []
        }],
        "vue/component-name-in-template-casing": ["error", "kebab-case", {
          "registeredComponentsOnly": false,
          "ignores": []
        }],
          "vue/html-self-closing": ["error", {
          "html": {
            "void": "never",
            "normal": "never",
            "component": "always"
          },
          "svg": "always",
          "math": "always"
        }],
        "vue/no-boolean-default": ["error", "no-default"],
        "vue/require-direct-export": ["error"],
    },
    overrides: [
      {
        files: ["*.vue"],
        rules: {
            indent: "off",
        }
      }
    ]
  }