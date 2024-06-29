<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Viewer.js Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.0/viewer.min.css" />
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }
        #pdf-viewer {
            width: 100%;
            height: 100vh;
            border: none;
        }
    </style>
</head>
<body>
    <iframe id="pdf-viewer" src="../justificatif/667fba7ce48da-Atelier_5_Exploitation.pdf" allowfullscreen></iframe>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.10.0/viewer.min.js"></script>
</body>
</html>
