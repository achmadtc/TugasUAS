<?php include('header.php');?>
     
          <div class="row">
            <div class="large-12 columns">
              <div class="row">

               <?php 
               $themovie = $tmdb_V3->nowPlayingMovies();
             //echo"<pre>";print_r($themovie);echo"</pre>";
               if ($themovie['results'] != null){
               $i = 0;
               foreach($themovie['results'] as $row) {
               if ($row['backdrop_path']!=null){$image = 'http://image.tmdb.org/t/p/w300'.$row['backdrop_path'];}else{$image = '/img/no-backdrop.png';}
               ?>     
                <div class="large-4 small-6 columns">
                  <a title="<?php echo $row['original_title'];?>" href="/play.php?watch=<?php echo $row['id'];?>"><img src="<?php echo $image;?>"></a>
     
                  <div class="panel">
                    <a title="<?php echo $row['original_title'];?>" href="/play.php?watch=<?php echo $row['id'];?>"><h5><?php echo $row['original_title'];?></h5></a>
                  </div>
                </div>
               <?php 
               $i++;
               if ($i == 18) break;
               }   
               }
               ?>

              </div>
            </div>
          </div>
     
<?php include('footer.php');?>