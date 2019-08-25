<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Basic Portfolio Website</title>
    <link rel="stylesheet" href="https://dhbhdrzi4tiry.cloudfront.net/cdn/sites/foundation.min.css">
    <link rel="stylesheet" href="/css/foundation.css">
    <link rel="stylesheet" href="/css/main.css">
  </head>
  <body>

    <div class="off-canvas-wrapper">
      <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>

        <div class="off-canvas position-left reveal-for-large" id="my-info" data-off-canvas data-position="left">
          <div class="row column">
            <br>
            
            <h5 class="menutitle">Main Menu</h5>
            
			<ul class="side-nav mynav">
				<li><a href="/">Home</a></li>

        <?php if (!Auth::check()): ?>
				<li><a href="/login">Login</a></li>
				<li><a href="register">Register</a></li>
        <?php endif; ?>

       <?php if (Auth::check()): ?>
        <li><a href="/gallery/create">Create Gallery</a></li>
        <li><a href="logout">Logout</a></li>
      <?php endif; ?>
			</ul>

          </div>
        </div>

        <div class="off-canvas-content" data-off-canvas-content>
          <div class="title-bar hide-for-large">
            <div class="title-bar-left">
              <button class="menu-icon" type="button" data-open="my-info"></button>
              <span class="title-bar-title">Mike Mikerson</span>
            </div>
          </div>

         @if(Session::has('message')) 

          <div data-alert class="alert-box">

          {{ Session::get('message') }}
        </div>
        @endif

        @yield('content')

        <div class="footnote">
          
          <h3>Our Website:<span>www.abc.com</span></h3>
        </div>

          <hr>

         
        </div>
      </div>
    </div>

    <script src="/js/vendor/jquery.js"></script>
    <script src="/js/vendor/foundation.js"></script>
    <script>
      $(document).foundation();
    </script>
  </body>
</html>







