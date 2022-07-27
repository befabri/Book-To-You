<h1 class='admin-title'>Panel Admin</h1>
<div class='admin-container'>
    <h2>Les utilisateurs et leurs privilèges</h2>
    <div class='admin-table'>
        <table>
            <tr>
                <th><a href='index.php?action=admin-user&sort=id'>ID</a></th>
                <th><a href='index.php?action=admin-user&sort=username'>Username</a></th>
                <th><a href='index.php?action=admin-user&sort=email'>Email</a></th>
                <th><a href='index.php?action=admin-user&sort=role'>Role</a></th>
                <th>ACTION</th>
                <th>DESACTIVER</th>
            </tr>
            <?php foreach($members as $member) {
                echo "<tr>";
                echo "<td>{$member->html_id_member()}</td>"; 
                echo "<td><a href='index.php?action=profil&user={$member->html_username()}'>{$member->html_username()}</a></td>"; 
                echo "<td><a href='index.php?action=profil&user={$member->html_username()}'>{$member->html_email()}</a></td>"; 
                echo "<td>".MEMBER_RANK[$member->html_privilege()]."</td>";
                if ($member->html_id_member()!=$memberConnectedId){
                    if ($member->html_privilege()=="admin")
                        echo "<td><a href='index.php?action=admin-user&privilege=member&user={$member->html_email()}'><b>Mettre membre</b></a></td>";
                    else
                        echo "<td><a href='index.php?action=admin-user&privilege=admin&user={$member->html_email()}'><b>Mettre administrateur</b></a></td>";
                } else {
                    echo "<td></td>";
                }
                if ($member->html_active()==1 && $member->html_id_member()!=$memberConnectedId)
                    echo "<td><a href='index.php?action=admin-user&active=disable&user={$member->html_email()}'><b>Désactiver</b></a></td>";
                else
                    echo "<td></td>";
                echo "</tr>";
            }?>
        </table>
    </div>
</div>