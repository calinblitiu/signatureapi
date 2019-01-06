<!DOCTYPE html>
<html lang="en">
<head>
  <title>Change Password</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <div class="jumbotron">
    <h1>Change Password</h1>      
   
  </div>
    <div class="panel panel-primary">
      <div class="panel-heading"><?=$user->full_name?>, <?=$user->login_email?></div>
      <div class="panel-body">
        <form action="/changepasswordpost" method="post">
            <div class="form-group">
                <label for="pwd">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="pwd">Confirm Password:</label>
                <input type="password" class="form-control" name="c_password" required>
            </div>
            <input type="hidden" value="<?=$user->forgotpassword_token?>" name="token">
            <button type="submit" class="btn btn-primary">Change Password</button>
        </form>

      </div>
    </div>
</div>

</body>
</html>