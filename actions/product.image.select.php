<?php




$slug = rawurldecode($slug);


$sourceFilePath = STORAGE_DIR . '/productPictures/' . $slug . '/' . $fileName;
if (false === is_file($sourceFilePath)) {
    flashMessage('Das Bild ' . $sourceFilePath . ' exestiert nicht');
    header("Location: " . $baseUrl . "index.php/product/edit/" . $slug);
}

$oldMainFiles = glob(STORAGE_DIR . '/productPictures/' . $slug . '/*-main*');
foreach ($oldMainFiles as $oldMainFile) {
    $newNormalFile = str_replace('-main', '', $oldMainFile);
    rename($oldMainFile, $newNormalFile);
}

$sourceFilePath = str_replace('-main', '', $sourceFilePath);
$fileName = str_replace('-main', '', $fileName);

$fileNameParts = explode('.', $fileName);

$newFileName = $fileNameParts[0] . '-main.' . $fileNameParts[1];

$targetFilePath = STORAGE_DIR . '/productPictures/' . $slug . '/' . $newFileName;
rename($sourceFilePath, $targetFilePath);

flashMessage('Neues Main Bild wurde gesetzt');
header("Location: " . $baseUrl . "index.php/product/edit/" . $slug);