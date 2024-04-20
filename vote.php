<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <title>Vote App</title> 
</head> 
<body>
    <h1>Vote</h1>
    <form method="post">
        <label><input type="radio" name="vote" value="yes" <?php if(isset($_SESSION['myVote']) && $_SESSION['myVote'] === 'yes') echo 'checked'; ?>> Yes</label> 
        <label><input type="radio" name="vote" value="no" <?php if(isset($_SESSION['myVote']) && $_SESSION['myVote'] === 'no') echo 'checked'; ?>>No</label> 
        <button type="submit">Vote</button> 
    </form> 
    <p>Yes Votes: <?=$_SESSION['yesVotes']?></p><p>No Votes: <?=$_SESSION['noVotes']?></p>
    <form method="post">
        <input type="hidden" name="submit" value="logout">
        <button type="submit">Logout</button>
    </form>
</body> 
</html>