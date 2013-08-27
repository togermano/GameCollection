<?php
  // Require our main script.
  require_once 'main.php';

  // If we are trying to post a new game, then pass it off to our script.
  if (isset($_POST['videoname'])) {
    $result = save_game($_POST);
  }

  // Get a list of games from the database.
  $games = get_games();

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Tony's Game Database</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="css/screen.css" rel="stylesheet" type="text/css">
  </head>
  <body>
  <div id="Page">
    <div id="ContentArea">

      <div class="navbar">
        <div class="navbar-inner">
          <a class="brand" href="#">Tony's Game Database</a>
          <ul class="nav">
            <li class="active"><a href="#">NES</a></li>
            <li><a href="#">SNES</a></li>
            <li><a href="#">SEGA</a></li>
          </ul>
        </div>
      </div>

      <div id="ContentBox">

        <?php if (isset($result)): ?>
          <?php echo $result; ?>
        <?php endif; ?>

        <a href="#myModal" id="add-modal-trigger" role="button" class="btn btn-large btn-success" data-toggle="modal">Add Game</a>
        <div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-header">
            <h3 id="myModalLabel">Add Game (NES)</h3>
          </div>
          <div class="modal-body">
            <form action="nes.php" method="post" class="form-horizontal"><input type="hidden" name="submit" />
              <div class="control-group">
                <label class="control-label" for="Gname">Game Name:</label>
                <div class="controls">
                  <input type="text" required id="Gname" name="videoname">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="company">Company:</label>
                <div class="controls">
                  <input type="text" name="company" id="company">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="year">Year:</label>
                <div class="controls">
                  <input type="number" name="year" id="year" min="1980">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="rating">Rating (1-10):</label>
                <div class="controls">
                  <input type="number" name="rating" id="rating" min="1" max="10">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="numowned"># Owned:</label>
                <div class="controls">
                  <input type="text" name="numowned" id="numowned" value="1">
                </div>
              </div>
              <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                <button class="btn btn-primary">Save Game</button>
              </div>
            </form>
          </div>
        </div>

        <div class="well">
          <table class="table table-striped">
            <tr>
              <th>Nes Name</th>
              <th>Company</th>
              <th>Year</th>
              <th># Owned</th>
              <th>Rating</th>
            </tr>
            <?php if ( !empty( $games ) ): ?>

            <?php foreach ( $games as $game ): ?>
              <tr>
                <td><?php echo $game->NesTitle; ?></td>
                <td><?php echo $game->NesCompany; ?></td>
                <td><?php echo $game->NesYear; ?></td>
                <td><?php echo $game->NesNumOwned; ?></td>
                <td><?php echo $game->NesRating; ?></td>
              </tr>
            <?php endforeach; ?>

            <?php endif; ?>

            <?php if ( empty( $games ) ): ?>
              <tr>
                <td colspan="5">No games in the database.</td>
              </tr>
            <?php endif; ?>

          </table>
        </div>

      </div>

    </div>
  </div>
</body>
</html>