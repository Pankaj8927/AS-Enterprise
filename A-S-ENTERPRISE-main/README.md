# A S ENTERPRISE

## Installation and Setup

## Files Needed To Download & setup

- Composer
  ```bash
  https://getcomposer.org/Composer-Setup.exe
- FPDF
   ```bash
   http://www.fpdf.org/en/dl.php?v=186&f=zip
- Barcode Generator
   ```bash
   https://github.com/picqer/php-barcode-generator


## Bootstrap and Sass

1. **Install Bootstrap:**

   ```bash
   npm install bootstrap
2. **Setup Sass:**

    Create a `scss` directory and a `main.scss` file inside it.

3. **Import Bootstrap in `main.scss`:**

   ```bash
    @import "../node_modules/bootstrap/scss/bootstrap";

3. **Compile Sass to CSS:**

   ```Install sass globally if not already installed:
   npm install -g sass
- Compile main.scss to style.css:
   ```bash
   sass scss/main.scss css/style.css
- Include Compiled CSS in Your HTML:
  ```bash
  <link rel="stylesheet" href="styles/styles.css">
- 
This README provides clear instructions for installing and setting up Bootstrap with Sass, FPDF for PDF generation, and Picqer for QR code generation, along with example usage for each.


