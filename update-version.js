/**
 * This script updates the version number for the main php file and all block.json files
 */

const fs = require("fs");
const packageJson = require("./package.json");

const updateVersion = (filePath, version) => {
  let fileContent = fs.readFileSync(filePath, "utf8");

  // Update the version number in the main plugin file
  if (filePath.endsWith("wp-block-boilerplate.php")) {
    // Refresh the version mentioned inside the WP Plugin comment
    fileContent = fileContent.replace(
      /Version:\s*\d+\.\d+\.\d+/,
      `Version:         ${version}`
    );

    // Refresh the version number for WPBLOCKBOILERPLATE_VERSION constant
    fileContent = fileContent.replace(
      /const WPBLOCKBOILERPLATE_VERSION = '\d+\.\d+\.\d+';/,
      `const WPBLOCKBOILERPLATE_VERSION = '${version}';`
    );
  }
  // Update the version number in all blocks
  else if (filePath.endsWith("block.json")) {
    const jsonContent = JSON.parse(fileContent);
    jsonContent.version = version;
    fileContent = JSON.stringify(jsonContent, null, 2);
  }

  fs.writeFileSync(filePath, fileContent, "utf8");
};

// Use the version number from package.json
const version = packageJson.version;

// Update the following files
const filesToUpdate = [
  "./wp-block-boilerplate.php",
  "./src/exampleblock/block.json",
]; // usw.

filesToUpdate.forEach((filePath) => updateVersion(filePath, version));