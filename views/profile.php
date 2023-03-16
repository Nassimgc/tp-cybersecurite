<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profil</title>
</head>
<body>
    <h1>Profil</h1>

    <p>Bienvenue sur votre profil, <?php echo escape($user['username']); ?> !</p>

    <form action="index.php?action=logout" method="post">
        <input type="submit" value="Se déconnecter">
    </form>
</body>
</html>
