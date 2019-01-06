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
        <div class="alert alert-success">
            <strong>Success!</strong> Password changed successfully!
        </div>
      </div>
    </div>
</div>

</body>
</html>