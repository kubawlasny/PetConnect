<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">PetConnect</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/offers.php">Offers</a></li>
        <?php
        if ((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true)) { 
            
            if($_SESSION['admin']){
                echo '<li><a href="/dashboard-admin.php">Dashboard</a></li>';
            } else {
                echo '<li><a href="/dashboard.php">Dashboard</a></li>';
            }
            
            echo '<li><a href="/add.php">Add</a></li>';
            echo '<li><a href="logout.php">Sign out</a></li>';
        } else {
            echo '<li><a class="login_button" href="">Sign in</a></li>';
            
            echo '<li><a>';
            echo '<form class="login" action="login.php" method="post">';
            echo 'Login: ';
            echo '<input type="text" name="login" />';
            echo ' Password: ';
            echo '<input type="password" name="haslo" />';
            echo '<input type="submit" value="Sign in" />';
            echo ' </form>';
            echo '</a></li>';
                    
            echo '<li><a href="/signup.php">Sign up</a></li>';
        }
        
        ?>
        
       
        <!--<li><a href="/offers.php">Offers</a></li>
        <li><a href="/dashboard.php">Dashboard</a></li>
        <li><a href="/add.php">Add</a></li>-->
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<script type="text/javascript">
        $(document).ready(function() = {
            $('.login_button').Click(function() = {
                $('.login').toggleClass('active');
            });
        });    
        
    $(".form_datetime").datetimepicker({format: 'yyyy-mm-dd hh:ii'});
</script>