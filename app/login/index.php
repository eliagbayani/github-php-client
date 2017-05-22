<?php
$params =& $_GET;
if(!$params) $params =& $_POST;
// echo "<pre>"; print_r($params); echo "</pre>"; exit;
?>
<html>
<head>
  <title>GitHub Login</title>
  
  <!-- used local copy instead
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.3/css/bootstrap.min.css">
  <script type = "text/javascript" src = "https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  -->
  
  <link rel="stylesheet" href="../css/bootstrap.min.css"> <!-- load bootstrap via CDN -->
  <script type = "text/javascript" src = "../js/jquery.min.js"></script>
  
  <script type = "text/javascript" language = "javascript">
    $(document).ready(function() {
      $("#driver").click(function(event){
        
        //$('.form-group').removeClass('has-error'); // remove the error class
        $('.help-block').remove(); // remove the error text
        
        var username = $("#username").val();
        var password = $("#password").val();
        var view_type = "<?php echo $params['view_type'] ?>";
        
        if(!username)
        {
          // $('#stage').addClass('has-error'); // add the error class to show red input
          $('#stage').append('<div class="help-block">Please enter Username</div>');
        }
        if(!password) $('#stage').append('<div class="help-block">Please enter Password</div>');
        
        if(password && username)
        {
          $("#stage").load('result.php', {"username":username, "password":password, "view_type":view_type} );
          $("#login_form").hide();
          $('#stage').append('<div class="help-block"><br>Please wait, loading...<br><br></div>'); // add the actual error message under our input
        }
        
        });
    });
  </script>
</head>
<body>
  <div align="center">
      <div><br>Fresh Data - Monitors admin page needs a GitHub account to be accessed.</div>
      <div><img src="../images/github_logo.png"></div>
      <div id = "login_form">
          <p>Enter your GitHub username and password:</p><br />
          Username: <input type = "input"    id = "username"  size = "40" /><br /><br />
          Password: <input type = "password" id = "password"  size = "40" /><br /><br />
          <button id="driver" type="submit" class="btn btn-success">Login</button>
          <button id="cancel" type="submit" class="btn btn-success" onClick="javascript:history.go(-1)">Cancel</button>

      </div>
      <div id = "stage" style = "background-color:white;"></div>
  </div>
</body>
</html>
