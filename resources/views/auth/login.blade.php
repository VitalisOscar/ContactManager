<form action="" method="post">
    @dump($errors->all())
    @csrf
    <input type="email" name="email" placeholder="Email"><br>
    <input type="password" name="password" placeholder="Password"><br>
    <input type="submit" value="Sign In">
</form>
