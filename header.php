<?php require_once('config.php');?>
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php movie_title( $meta_title, ' - ' );?></title>
    <meta name="description" property="og:description" content="MOVIE LIST <?php echo $title;?> DATABASE.">
  
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Dosis" type="text/css" media="all" />

    <link rel="stylesheet" href="/css/foundation.min.css" type="text/css" media="all" />
    <link rel="stylesheet" href="/css/style.css" type="text/css" media="all" />

    <script src="/js/vendor/modernizr.js"></script>
  </head>
  <body>
    
      <div class="row">
        <div class="large-12 columns">
     
         
          <div class="row">
            <div class="large-12 columns">
     
              <nav class="top-bar" data-topbar>
                <ul class="title-area">
                   
                  <li class="name">
                    <h1>
                      <a href="/">
                        <?php echo get_domain( home_url() );?>
                      </a>
                    </h1>
                  </li>
                  <li class="toggle-topbar menu-icon"><a href="#"><span>menu</span></a></li>
                </ul>
             
                <section class="top-bar-section">
                  <ul class="left">
                  <li class="has-form">
                      <div class="row collapse">
                         <form method="get" action="/search.php">
                          <div class="large-8 small-9 columns">
                              <input type="text" name="q" placeholder="Search by title...">
                          </div>
                          <div class="large-4 small-3 columns">
                              <input type="submit" value="Search" class="alert button expand">
                          </div>
                      </div>
                  </li> 
                  </ul>                  
                  <ul class="right">
                    <li class="divider"></li>
                    <li><a href="/popular">Popular</a></li>
                    <li class="divider"></li>
                    <li><a href="/toprated">Toprated</a></li>
                    <li class="divider"></li>
                    <li><a href="/playing">In Theaters</a></li>
                  </ul>
                </section>
              </nav>
               
            </div>
          </div>
<hr>