<aside>
    <form class="filter" action="index.php?filter=" method="GET">
        <h2>Filtrer</h2>
        <div class="flex-select">
            <label>Affichage:</label>
            <select name="display">
                <option value="3" <?php echo (!empty($_GET['display'])&&$_GET['display']==3?"selected":"")?>>3</option>
                <option value="10" <?php echo (!empty($_GET['display'])&&$_GET['display']==10?"selected":"")?>>10</option>
                <option value="all" <?php echo (empty($_GET['display'])||$_GET['display']!=3&&$_GET['display']!=10?"selected":"")?>>Tout</option>
            </select>
        </div>
        <div class="flex-select">
            <label>Trier:</label>
            <select name="sort">
                <option value="vote" <?php echo (empty($_GET['sort'])||$_GET['sort']=="vote"?"selected":"")?>>Vote</option>
                <option value="date" <?php echo (!empty($_GET['sort'])&&$_GET['sort']=="date"?"selected":"")?>>Récent</option>
            </select>
        </div>

        <div class="flex-checkbox">
        <label class="checkbox-status">Statuts:</label>
        <div class="checkbox">
            <input type="checkbox" name="submitted" id="submitted" <?php echo (!empty($_GET['submitted'])?"checked":"")?>>
            <label for="submitted">Envoyé</label>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="accepted" id="accepted" <?php echo (!empty($_GET['accepted'])?"checked":"")?>>
            <label for="accepted">Accepté</label>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="refused" id="refused" <?php echo (!empty($_GET['refused'])?"checked":"")?>>
            <label for="refused">Refusé</label>
        </div>
        <div class="checkbox">
            <input type="checkbox" name="closed" id="closed" <?php echo (!empty($_GET['closed'])?"checked":"")?>>
            <label for="closed">Fermé</label>
        </div>
        </div>
        <input class="button" type="submit" name="form_filter" value="Appliquer">
    </form>
</aside>