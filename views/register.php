<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
</head>
<body>
    <h1>Inscription</h1>

    <?php 
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    if (isset($errors) && count($errors) > 0): ?>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" action="<?php echo htmlspecialchars('index.php?action=register'); ?>">        
        <label for="username">Nom d'utilisateur :</label>
        <input type="text" name="username" required><br>

        <label for="email">Email :</label>
        <input type="email" name="email" required><br>

        <label for="password">Mot de passe :</label>
        <input type="password" name="password" required><br>

        <input type="hidden" name="csrf_token" value="<?php echo $token; ?>">
        <input type="submit" value="S'inscrire">
    </form>

    <a href="index.php?action=login">Connexion</a>

</body>
</html>
