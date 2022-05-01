<?php
include_once 'includes\header.inc.php';
require_once 'classes\dbh.classes.php';
require_once 'classes\highscores.classes.php';
$highscore = new Highscore();
$result = $highscore->getHighscores();
?>

<h1 class="landing-header pt-5">Highscores</h1>
<div class="container test d-flex justify-content-center">

    <div class="container pt-5">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Member</th>
                    <th scope="col">Points</th>
                    <th scope="col">Position</th>
                </tr>
            </thead>

            <tbody>
                <?php
        $position = 1;
        foreach($result as $highscore): 
        echo '
        
          <tr>
            <th scope="row">' . $highscore['first_name']." ".$highscore['last_name'] .'</th>
            <td>' . $highscore['points'] . '</td>
            <td>'. $position++ . '</td>
          </tr>';
        endforeach; 
        ?>

        </table>
    </div>
</div>
</div>

<?php
include_once 'includes\footer.inc.php'
?>