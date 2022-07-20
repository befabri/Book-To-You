<h1 class='admin-title'>Panel Admin</h1>
<div class='admin-container'>
    <h2>Toutes les idées</h2>
    <div class='admin-table'>
        <table>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Statut</th>
                <th>Votes</th>
                <th>Commentaires</th>
                <th>ACTION</th>
                <th>ACTION</th>
            </tr>
            <?php foreach($ideas as $idea) {
                echo "<tr>";
                echo "<td>{$idea->html_id_idea()}</td>"; 
                echo "<td><a href='index.php?action=idea&id={$idea->html_id_idea()}'>{$idea->html_title()}</a></td>";
                echo "<td>".STATUS[$idea->html_status()]."</td>";
                echo "<td>{$idea->html_votes_count()}</td>";
                echo "<td>{$idea->html_comments_count()}</td>";
                if ($idea->html_status()=='ACCEPTED') {
                    echo "<td><a href='index.php?action=admin-idea&status=closed&idea={$idea->html_id_idea()}'><b>Fermée l'idée</b></a></td>";
                    echo "<td><a href='index.php?action=admin-idea&status=refused&idea={$idea->html_id_idea()}'><b>Refusée l'idée</b></a></td>";
                }
                if ($idea->html_status()=='SUBMITTED') {
                    echo "<td><a href='index.php?action=admin-idea&status=accepted&idea={$idea->html_id_idea()}'><b>Acceptée l'idée</b></a></td>";
                    echo "<td><a href='index.php?action=admin-idea&status=refused&idea={$idea->html_id_idea()}'><b>Refusée l'idée</b></a></td>";
                }
                if ($idea->html_status()=='REFUSED') {
                    echo "<td><a href='index.php?action=admin-idea&status=accepted&idea={$idea->html_id_idea()}'><b>Acceptée l'idée</b></a></td>";
                    echo "<td><a href='index.php?action=admin-idea&status=closed&idea={$idea->html_id_idea()}'><b>Fermée l'idée</b></a></td>";
                }
                if ($idea->html_status()=='CLOSED') {
                    echo "<td></td>";
                    echo "<td></td>";
                }
                echo "</tr>";
            }?>
        </table>
    </div>
</div>