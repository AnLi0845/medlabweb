<!-- login.php -->
<form action="loginHandler.php" method="post">
    <!-- Form fields -->
    <input type="text" name="username" required>
    <input type="password" name="password" required>
    <input type="hidden" name="role" value="patient"> <!-- or "staff" -->
    <input type="submit" value="Login">
</form>
