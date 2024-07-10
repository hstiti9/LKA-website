<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration</title>
    <link rel="stylesheet" href="includes/Admin-style.css">
</head>
<body>
    <div id='back'>
        <a href="../accueil/index.php">Retourner</a>
    </div>
    <style>
        *{
            color: rgb(50, 50, 50);
        }
        body{
            padding-top: 30vh;
        }
    </style>
    <form action="includes/verify.php" method='post'>
        <Label>Se connecter tant qu'un Administrateur</Label>
        <input type="text" placeholder='Utilisateur' name="user">
        <input type="password" placeholder='Mot de Passe' name='pass'>
        <input type="submit" value="Se connecter" class='btn'>
    </form>
</body>
</html>