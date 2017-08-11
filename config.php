<?php
error_reporting(E_ALL ^ E_NOTICE);
include_once('include/tmdb_v3.php');
include_once('include/function.php');

$meta_title  = 'MOVIE DATA LIST';
$your_email  = 'bangga@gmail.com';
$affliasi    = '';
$apikey      = 'accd3ddbbae37c0315fb5c8e19b815a5';

$tmdb_V3     = new TMDBv3($apikey);

if( $watch ) {

        $data        = $tmdb_V3->movieDetail($watch);
        $tmdbid      = $data['id'];
        $title       = $data['original_title'];
        $description = $data['overview'];
        $status      = $data['status'];
        $homepage    = $data['homepage'];
        $release     = $data['release_date'];
        $runtime     = $data['runtime'];
        $ltitle      = $data['title'];
        $vote_count  = $data['vote_count'];
        $tagline     = $data['tagline'];

        $movieCast   = $tmdb_V3->movieCast($watch);
        $movieIMG    = $tmdb_V3->moviePosterB($watch);
        $movieIMGs   = $tmdb_V3->moviePoster($watch);
        $movieTrailer = $tmdb_V3->movieTrailer($watch);
        $movieSimilar = $tmdb_V3->movieSimilar($watch);
        $movieKW     = $tmdb_V3->movie_keywords($watch);
        $AlternativeTitles = $tmdb_V3->movieAlternativeTitles($watch);
        $movieReviews = $tmdb_V3->movieReviews($watch);


        if (is_array($movieIMG)){
        shuffle($movieIMG);
                foreach($movieIMG as $result) {$images = 'http://image.tmdb.org/t/p/w780' . $result['file_path'];}
        } elseif ($movieIMGs!=null){
        shuffle($movieIMG);
                foreach($movieIMGs as $result) {$images = 'http://image.tmdb.org/t/p/w780' . $result['file_path'];}
        } else {
                $images = '/img/no-backdrop.png';
        }

        if ($data['poster_path']!=null){
                $images_small = 'http://image.tmdb.org/t/p/w185' . $data['poster_path'];
        } elseif ($data['backdrop_path']!=null){
                $images_small = 'http://image.tmdb.org/t/p/w185' . $data['backdrop_path'];
        } else {
                $images_small = '/img/no-backdrop.png';
        }
        if (is_array($movieKW['keywords'])){
                foreach($movieKW['keywords'] as $result) {$keyword .= $result['name'].', ';}
        }
        if (is_array($AlternativeTitles)){
                foreach($AlternativeTitles as $result) {$alternative .= '<div class="small-6 columns"><i class="fa fa-chevron-circle-right"></i>'.$result['title'].'</div>';}
        }
        if (is_array($data['genres'])){
                foreach($data['genres'] as $result) {$genre .= $result['name']. ', ';}
        }
        if (is_array($data['languages'])){
                foreach($data['languages'] as $result) {$languages .= $result.' ';}
        }
        if (is_array($data['production_companies'])){
                foreach($data['production_companies'] as $result) {$companies .= $result['name'].' ';}
        }
        if (is_array($data['production_countries'])){
                foreach($data['production_countries'] as $result) {$country .= $result['name'].', ';}
        }
        if (is_array($movieTrailer['youtube'])){
                foreach($movieTrailer['youtube'] as $result) {$youtube = $result['source'];}
        }

        if ($movieCast != null){
                foreach($movieCast as $result) {
                        $cast .= $result['name'] . ', ';             
                }
        }
		
if( $data == null ) {
header("location:/");
}
}