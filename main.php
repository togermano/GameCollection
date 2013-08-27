<?php

define('MYSQL_HOST', '127.0.0.1');
define('MYSQL_USER', 'root');
define('MYSQL_PASS', '');
define('MYSQL_DB',   'VideoGames');

/**
 * Wrapper to get a database connection based on the config above.
 */
function get_connection () {
  return mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB);
}

/**
 * Function to get an array of games from the db.
 *
 * @return array
 *  Collection of game objects.
 */
function get_games () {
  $db = get_connection();
  $result = mysqli_query($db ,"SELECT * FROM NES ORDER BY NesTitle");

  $games = array();

  while ($game = mysqli_fetch_object($result)) {
    $games[] = $game;
  }

  return $games;
}

/**
 * Function to save a new game to the db.
 *
 * @param array $fields
 *  Raw POST data.
 *
 * @return string
 *  Status if the query was successful or not.
 */
function save_game ($fields) {
  $db = get_connection();  

  // Filter out all the params in $_POST.
  foreach ($fields as $key => &$field) {

    // Disallow multivalued fields.
    if (is_array($field)) unset($fields[$key]);

    // Some known ways to prevent attacks.
    $field = trim(htmlentities(strip_tags($field)));
    if (get_magic_quotes_gpc()) $field = stripslashes($field);
  }

  $query = "INSERT INTO NES (NesTitle, NesCompany, NesYear, NesRating, NesNumOwned)
            VALUES ( '{$fields['videoname']}', '{$fields['company']}', '{$fields['year']}', '{$fields['rating']}', '{$fields['numowned']}' )";

  if (!mysqli_query($db, $query)) {
    return "<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>GAME NOT ADDED TO DATABASE!!!</div>";
  } else {
    return "<div class='alert alert-success'><button type='button' class='close' data-dismiss='alert'>&times;</button> Game Succesfully ADDED to database!</div>";
  }
}