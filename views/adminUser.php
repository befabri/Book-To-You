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
            <?php foreach($users as $user) {
                echo "<tr>";
                echo "<td>{$user->html_id_member()}</td>"; 
                echo "<td><a href='index.php?action=profil&user={$user->html_username()}'>{$user->html_username()}</a></td>"; 
                echo "<td><a href='index.php?action=profil&user={$user->html_username()}'>{$user->html_email()}</a></td>"; 
                echo "<td>".MEMBER_RANK[$user->html_privilege()]."</td>";
                if ($user->html_id_member()!=$member->html_id_member()){
                    if ($user->html_privilege()=="admin")
                        echo "<td><a href='index.php?action=admin-user&privilege=member&user={$user->html_email()}'><b>Mettre membre</b></a></td>";
                    else
                        echo "<td><a href='index.php?action=admin-user&privilege=admin&user={$user->html_email()}'><b>Mettre administrateur</b></a></td>";
                }
                echo ($user->html_active()==1 && $user->html_id_member()!=$member->html_id_member())?"<td><a href='index.php?action=admin-user&active=disable&user={$user->html_email()}'><b>Désactiver</b></a></td>":"<td></td>";
                echo "</tr>";
            }?>
        </table>
    </div>
</div>