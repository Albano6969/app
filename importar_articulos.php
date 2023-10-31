<!DOCTYPE html>
<html>
<head>
    <title>Importar Artículos</title>
</head>
<body>
    <h1>Importar Artículos</h1>
    <form action="procesar_importar.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="archivo" accept=".csv" required>
        <input type="submit" value="Importar">
    </form>
</body>
</html>
