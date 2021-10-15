<?php
echo"
<section class='menu menu1 cid-sdNkInY0se d-none d-xl-block' once='menu' id='menu1-24'>
  <nav class='navbar navbar-dropdown navbar-fixed-top navbar-expand-lg' style ='background-color: #013369; fill: #013369;'>
      <div class='container-fluid'>
          <div class='navbar-brand' >
              <span class='navbar-caption-wrap'><a class='navbar-caption text-white display-7' href='dashboard.php'><i class='fas fa-dog'></i> DOGGING</a></span>
          </div>

          <button class='navbar-toggler' type='button' data-toggle='collapse' data-target='#navbarSupportedContent' aria-controls='navbarNavAltMarkup' aria-expanded='false' aria-label='Toggle navigation'>
              <div class='hamburger'>
                  <span></span>
                  <span></span>
                  <span></span>
                  <span></span>
              </div>
          </button>
          <div class='collapse navbar-collapse' id='navbarSupportedContent'>
              <ul class='navbar-nav nav-dropdown' data-app-modern-menu='true'><li class='nav-item'><a class='nav-link link text-white display-4' href='dashboard.php'><span class='mbrib-home mbr-iconfont mbr-iconfont-btn'></span>Clubhouse</a></li>
              <ul class='navbar-nav nav-dropdown' data-app-modern-menu='true'><li class='nav-item'><a class='nav-link link text-white display-4' href='week.php'><i class='material-icons mobilenav__icon'>sports_football</i></span>Week {$_SESSION['gameWeek']}</a></li>
            <li class='nav-item'><a class='nav-link link text-white display-4' href= 'banter.php'><i class='material-icons mobilenav__icon'>question_answer</i></span>Bantz</a></li>
                  <li class='nav-item'><a class='nav-link link text-white display-4' href= 'more.php'><i class='material-icons mobilenav__icon'>add</i></span>More</a></li>
              <div class='navbar-buttons mbr-section-btn'><a class='btn btn-primary display-4' href='logout.php'>Logout</a></div>
          </div>
      </div>
  </nav>
</section>";

?>
