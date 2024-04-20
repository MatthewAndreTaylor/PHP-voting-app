<?php
session_start();
$dbconn = pg_connect("host=localhost dbname=postgres user=postgres password=password");
function executeQuery($dbconn, $query, $params) {
    $result = pg_prepare($dbconn, "", $query);
    return pg_execute($dbconn, "", $params);
}
function getVote($dbconn, $userId) {
    $query = "SELECT * FROM votes WHERE userid=$1";
    $result = executeQuery($dbconn, $query, array($userId));
    $result = pg_fetch_assoc($result);
    $_SESSION['myVote'] = $result['vote'];
    return $result;
}
function getUser($dbconn, $userId) {
    $query = "SELECT * FROM appuser WHERE userid=$1";
    $result = executeQuery($dbconn, $query, array($userId));
    return pg_fetch_assoc($result);
}
function countVotes($dbconn, $vote) {
    $query = "SELECT COUNT(*) AS count FROM votes WHERE vote=$1";
    $result = executeQuery($dbconn, $query, array($vote));
    $result = pg_fetch_assoc($result);
    return $result['count'];
}
if (!isset($_SESSION['state'])) $_SESSION['state'] = 'login';
if (isset($_REQUEST['submit'])) $_SESSION['state'] = $_REQUEST['submit'];

switch ($_SESSION['state']) {
    case "logout":
        session_destroy();
        session_start();
        $_SESSION['state'] = 'login';
        break;
    case "register":
        if (getUser($dbconn, $_REQUEST['user'])) {
            echo "Username already exists.";
            break;
        }
        $query = "INSERT INTO appuser VALUES ($1, $2)";
        executeQuery($dbconn, $query, array($_REQUEST['user'], $_REQUEST['password']));
        $_SESSION['state'] = 'login';
        break;
    case "login":
        $query = "SELECT * FROM appuser WHERE userid=$1 AND password=$2";
        $result = executeQuery($dbconn, $query, array($_REQUEST['user'], $_REQUEST['password']));
        $row = pg_fetch_assoc($result);
        if ($row) {
            $_SESSION['user'] = $_REQUEST['user'];
            $_SESSION['state'] = 'vote';
        } else {
            echo "Invalid username or password.";
        }
        break;
    case "vote":
        if (!isset($_SESSION['user'])) {
            echo "Please log in or register to vote.";
            break;
        }
        if (getVote($dbconn, $_SESSION['user'])) {
            $query = "UPDATE votes SET vote=$1 WHERE userid=$2";
            executeQuery($dbconn, $query, array($_POST['vote'], $_SESSION['user']));
        } else {
            $query = "INSERT INTO votes (userid, vote) VALUES ($1, $2)";
            executeQuery($dbconn, $query, array($_SESSION['user'], $_POST['vote']));
        }
        break;
}
if (isset($_SESSION['user'])) getVote($dbconn, $_SESSION['user']);

$_SESSION['yesVotes'] = countVotes($dbconn, 'yes');
$_SESSION['noVotes'] = countVotes($dbconn, 'no');
$view = ($_SESSION['state'] === 'login') ? 'login.php' : 'vote.php';
require_once $view;
?>