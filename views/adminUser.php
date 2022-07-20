<h1 class='admin-title'>Panel Admin</h1>
<div class='admin-container'>
    <h2>Les utilisateurs et leurs privileges</h2>
    <div class='admin-table'>
        <table>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th>ACTION</th>
                <th>DESACTIVER</th>
            </tr>
            <?php foreach($members as $member) {
                echo "<tr>";
                echo "<td>{$member->html_id_member()}</td>"; 
                echo "<td>{$member->html_username()}</td>"; 
                echo "<td>{$member->html_email()}</td>"; 
                echo "<td>".MEMBER_RANK[$member->html_privilege()]."</td>"; 
                if ($member->html_privilege()=="admin") {
                    echo "<td><a href='index.php?action=admin-user&privilege=member&member={$member->html_email()}'><b>Mettre membre</b></a></td>";
                } else {
                    echo "<td><a href='index.php?action=admin-user&privilege=admin&member={$member->html_email()}'><b>Mettre administrateur</b></a></td>";
                }
                echo ($member->html_active()==1)?"<td><a href='index.php?action=admin-user&active=disable&member={$member->html_email()}'><b>Désactiver</b></a></td>":"<td></td>";
                echo "</tr>";
            }?>
        </table>
    </div>
</div>