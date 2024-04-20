<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8">
    <title>Vote App</title> 
</head> 
<body>
    <h1>Login</h1>
    <form method="post">
        <input type="hidden" name="submit" value="login">
        <label>Username: <input type="text" name="user"></label>
        <label>Password: <input type="password" name="password"></label>
        <button type="submit">Login</button>
    </form>
    <h1>Register</h1>
    <form method="post">
        <input type="hidden" name="submit" value="register">
        <label>Username: <input type="text" name="user"></label>
        <label>Password: <input type="password" name="password"></label>
        <button type="submit">Register</button>
    </form> 
</body> 
</html>