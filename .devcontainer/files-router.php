<?php
$rootPath = realpath(getcwd());

function serveFile($path) {
    if (is_file($path)) {
        // Determine the MIME type of the file
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $path);
        finfo_close($finfo);

        if (strpos($mimeType, 'text') === 0) {
            // For text files, display in browser
            header('Content-Type: ' . $mimeType);
            readfile($path);
        } else {
            // For binary files, force download
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));

            // Clear output buffer and read the file
            ob_clean();
            flush();
            readfile($path);
        }
        exit;
    }
}

function listDirectory($path, $rootPath) {
    $relativePath = str_replace($rootPath, '', $path);
    $relativePath = ltrim($relativePath, DIRECTORY_SEPARATOR);

    echo "<h2>Index of /" . htmlspecialchars($relativePath) . "</h2>";
    echo "<ul>";
    foreach (new DirectoryIterator($path) as $fileInfo) {
        if ($fileInfo->isDot()) continue;

        $name = $fileInfo->getFilename();
        $href = ($relativePath ? $relativePath . '/' : '') . $name;

        // Updated to use directory-style links
        if ($fileInfo->isDir()) {
            echo "<li><a href='/" . $href . "/'>" . htmlspecialchars($name) . "/</a></li>";
        } else {
            echo "<li><a href='/" . $href . "'>" . htmlspecialchars($name) . "</a></li>";
        }
    }
    echo "</ul>";
}

function uploadFile($path) {
    if (!empty($_FILES['uploaded_file'])) {
        $uploadedFile = $_FILES['uploaded_file']['tmp_name'];
        $destination = $path . DIRECTORY_SEPARATOR . $_FILES['uploaded_file']['name'];
        move_uploaded_file($uploadedFile, $destination);
    }
}

// Main logic to determine the current path and serve files
$currentPath = $rootPath;
$requestUri = ltrim($_SERVER['REQUEST_URI'], '/');
$filePath = '';

// Checking if the request is for a directory
if (is_dir($rootPath . '/' . $requestUri)) {
    $currentPath = realpath($rootPath . '/' . $requestUri);
} else if (is_file($rootPath . '/' . $requestUri)) {
    // If a file is requested, serve the file
    serveFile(realpath($rootPath . '/' . $requestUri));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    uploadFile($currentPath);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>JuniorIT.AI File Browser</title>
    <link rel="icon" type="image/x-icon" href="https://juniorit.ai/favicon.ico">
</head>
<body>
    <h1>JuniorIT.AI's File Browser</h1>
    <?php if (is_dir($currentPath)) { listDirectory($currentPath, $rootPath); } ?>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="uploaded_file">
        <input type="submit" value="Upload">
    </form>
</body>
</html>
