<?php
/**
 * Created by PhpStorm.
 * User: stijn versluis
 * Date: 4/15/2019
 * Time: 10:15 AM
 */

$pagetitle = 'Home';
$pagename = 'index';
require 'header.php';

$sql = "SELECT * FROM teams";
$query =$db->query($sql);
$teams = $query->fetchAll(PDO::FETCH_ASSOC);

if( isset($_GET['msg'])){
    echo $_GET['msg'];
}
?>

<div class="container">
    <div class="navigation">
        <div class="head">
            <i class="far fa-futbol"></i>
            <h1>Voetbal Poules</h1>
            <i class="far fa-futbol"></i>
        </div>
        <div class="login_register">
            <?php
            if ( isset($_SESSION['id']) ) {
                echo "<a href='teamplayer.php'>Team aanmaken</a>";
                echo "<a href='logout.php'>logout</a>";
            }

            else {
                echo "<a href='login.php'>Login</a> &nbsp;  &nbsp; <a href='register.php'> Register </a>";
            }
            ?>
        </div>
    </div>
</div>
    <div class="info_top">
        <div class="information">
            <div class="heading">
                <h3>Informatie</h3>
            </div>
            <p class="information_text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui.</p>
            <div class="box_information"></div>
        </div>
    </div>
    <div class="main_top">
        <div class="uitslagen">
            <div class="heading">
            <h3>Uitslagen</h3>
            </div>
            <div class="box uitslag">

            </div>
        </div>
        <div class="teams">
            <div class="heading">
                <h3>Teams</h3>
            </div>
            <div class="box teams">
                <label for="selectionBox" style="display: none;">teams</label>
                <select class="listOfTeams" onchange="MyListSelect();" size="<?=count($teams)?>" name="" id="selectionBox">
                    <?php
                    foreach ($teams as $team) {
                        $name = htmlentities($team['name']);
                        $id = $team['id'];

                        $sql_2 = "SELECT * FROM player_names WHERE team_id = :id";

                        $prepare_2 = $db->prepare($sql_2);
                        $prepare_2->execute([
                            'id' => $id
                        ]);
                        $player_names = $prepare_2->fetch(PDO::FETCH_ASSOC);

                        $player_count = $team['player_count'];

                        $players = array($player_names['player_1'],$player_names['player_2'],$player_names['player_3'],$player_names['player_4'],$player_names['player_5'],$player_names['player_6'],);
                        $encoded = json_encode($players);

                        echo "<option id='mySelect' name='mySelect' value='$encoded'>$name</option>";

                    }
                        ?>
                </select>
            </div>
        </div>
        <div class="spelers">
            <div class="heading">
                <h3>Spelers</h3>
            </div>
            <div class="box spelers">
                <ol id="spelers_lijst">

                </ol>
            </div>
        </div>
    </div>
    <div class="main_bottom">
        <div class="poules">
            <div class="heading">
                <h3>Poules</h3>
            </div>
            <div class="boxx de_poules">
                <div class="poule_A">
                    <h3><a href="playschedule.php"> Poule A</a></h3>
                    <?php
                    echo '<ul>';
                            for ($x = 0; $x <= 9; $x++) {
                            $team = $teams[$x];
                            $name = htmlentities($team['name']);
                            echo "<li><?id={$team['id']}'> {$team['name']}</li>";
                        }
                    echo '</ul>'
                    ?>
                </div>
                <div class="poule_B">
                    <h3>Poule B</h3>

                    <?php
                    echo '<ul>';
                        for ($x = 0; $x <= 9; $x++) {
                            $team = $teams[$x];
                            $name = htmlentities($team['name']);
                            echo "<li><?id={$team['id']}'> {$team['name']}</li>";
                        }
                    echo '</ul>';
                    ?>

                </div>
            </div>
        </div>
        <div class="quaterfinals">
            <div class="heading">
                <h3>Kwart Finales</h3>
            </div>
            <div class="boxx kwartfinale">

            </div>
        </div>
        <div class="halffinals">
            <div class="heading">
                <h3>Halve Finales</h3>
            </div>
            <div class="boxx halvefinale">

            </div>
        </div>
        <div class="finals">
            <div class="heading">
                <h3>Finale</h3>
            </div>
            <div class="boxx finale">

            </div>
        </div>
    </div>
<script type="text/javascript">
    function MyListSelect () {

        let selectionBox = document.getElementById('selectionBox');
        let selectionOption = document.getElementById('mySelect');
        let players = selectionBox.options[selectionBox.selectedIndex].value;

        let playerNames = JSON.parse(players);

        console.log(playerNames);

        selectionOption.addEventListener("dblclick", selectIt());

        function selectIt() {
            let playerList = document.getElementById('spelers_lijst');
            let lis = playerList.getElementsByTagName("li");

            while (lis.length > 0) {
                playerList.removeChild(lis[0]);
            }


            for (var I = 0; I < playerNames.length; I++){
                let node = document.createElement("LI");

                var textnode = document.createTextNode(playerNames[I]);

                node.appendChild(textnode);
                playerList.appendChild(node);
            }

        }
    }
</script>
<?php require 'footer.php'; ?>
