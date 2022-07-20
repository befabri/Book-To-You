<?php include 'notificationPopup.php';?>
<div class="loginCadre">
    <h2>Se connecter</h2>
    <form action="index.php?action=login" method="post">
        <label for="email">Adresse e-mail</label><br>
        <input type="email" id="email" name="email" placeholder="admin@gmail.com"><br>
        <label for="password">Mot de passe</label><br>
        <input type="password" id="password" name="password" placeholder="admin"><br><br>
        <input type="submit" name="form_login" value="Se connecter">
    </form>
    <p>Pas de compte ? <a href="index.php?action=signin" class="loginBack">S'enregistrer</a></p>		
</div>
