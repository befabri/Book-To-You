<div class="loginCadre">
    <h2>Se créer un compte</h2>
    <form action="index.php?action=signin" method="post">
        <label for="email">Adresse e-mail</label><br>
        <input type="email" id="email" name="email" placeholder="admin@localhost.lan"><br>
        <label for="username">Identifiant</label><br>
        <input type="username" id="username" name="username" placeholder="admin"><br>
        <label for="password">Mot de passe</label><br>
        <input type="password" id="password" name="password" placeholder="admin"><br><br>
        <input type="submit" name="form_signin" value="S'enregistrer">
    </form>
    <p>Déjà un compte ? <a href="index.php?action=login" class="loginBack">Se connecter</a></p>
    <p><a href="index.php" class="loginBack">Revenir à l'accueil</a></p>		
</div>			
