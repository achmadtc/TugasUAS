<?php
/**
* TMDB API v3 PHP class - wrapper to API version 3 of 'themoviedb.org
* API Documentation: http://docs.themoviedb.apiary.io/
*
** v0.0.2:
*    fixed issue #2 (Object created in class php file)
*    added functions latestMovie, nowPlayingMovies
*
*/

###########################
class TMDBv3{
     #<CONSTANTS>
	#@var string url of API TMDB
	const _API_URL_ = "http://api.themoviedb.org/3/";

	#@var string Version of this class
	const VERSION = '0.0.2';

	#@var string API KEY
	private $_apikey;

	#@var string Default language
	private $_lang;

	#@var string url of TMDB images
	private $_imgUrl;
        
        public $config;
     #</CONSTANTS>
###############################################################################################################
	/**
	* Construct Class
	* @param string apikey
	* @param string language default is english
	*/
		public function  __construct($apikey,$lang='en') {
			//Assign Api Key
			$this->setApikey($apikey);
		
			//Setting Language
			$this->setLang($lang);

			//Get Configuration
			$conf = $this->_getConfig();
			if (empty($conf)){echo "";}
                        $this->config = $conf;
			//set Images URL contain in config
			$this->setImageURL($conf);
		}//end of __construct
         
	/** Setter for the API-key
	 * @param string $apikey
	 * @return void
	 */
		private function setApikey($apikey) {
			$this->_apikey = (string) $apikey;
		}//end of setApikey

	/** Getter for the API-key
	 *  no input
	 **  @return string
	 */
		private function getApikey() {
			return $this->_apikey;
		}//end of getApikey

	/** Setter for the default language
	 * @param string $lang
	 * @return void
	 **/
		public function setLang($lang="en") {
			$this->_lang = $lang;
		}//end of setLang

	/** Getter for the default language
	 * no input
	 * @return string
	 **/
		public function getLang() {
			return $this->_lang;
		}//end of getLang

	/**
	* Set URL of images
	* @param  $config Configurarion of API
	* @return array
	*/
		public function setImageURL($config) {
			$this->_imgUrl = (string) $config['images']["base_url"];
		} //end of setImageURL

	/** Getter for the URL images
	 * no input
	 * @return string
	 */
		public function getImageURL($size="original") {
			return $this->_imgUrl . $size;
		}//end of getImageURL

	/**
	* movie Alternative Titles
	* http://api.themoviedb.org/3/movie/$id/alternative_titles
	* @param array  titles
	*/
		public function movieTitles($idMovie) {
			$titleTmp = $this->movieInfo($idMovie,"alternative_titles",false);
			foreach ($titleTmp['titles'] as $titleArr){
				$title[]=$titleArr['title']." - ".$titleArr['iso_3166_1'];
			}
			return $title;
		}//end of movieTitles

	/**
	* movie translations
	* http://api.themoviedb.org/3/movie/$id/translations
	* @param array  translationsInfo
	*/
		public function movieTrans($idMovie)
		{
			$transTmp = $this->movieInfo($idMovie,"translations",false);

			foreach ($transTmp['translations'] as $transArr){
				$trans[]=$transArr['english_name']." - ".$transArr['iso_639_1'];
			}
			return $trans;
		}//end of movieTrans

	/**
	* movie Trailer
	* http://api.themoviedb.org/3/movie/$id/trailers
	* @param array  trailerInfo
	*/
		public function movieTrailer($idMovie) {
			$trailer = $this->movieInfo($idMovie,"trailers",false);
			return $trailer;
		} //movieTrailer


	/**
	* movie Detail
	* http://api.themoviedb.org/3/movie/$id
	* @param array  movieDetail
	*/
		public function movieDetail($idMovie)
		{
			return $this->movieInfo($idMovie,"",false);

		}//end of movieDetail

	/**
	* movie Alternative Titles
	* http://api.themoviedb.org/3/movie/{id}/reviews
	* @param array alternative_titles
	*/
		public function movieReviews($idMovie)
		{
			$titles = $this->movieInfo($idMovie,"reviews",false);
			$titles = $titles['results'];
			return $titles;
		}//end of alternative_titles

	/**
	* movie Alternative Titles
	* http://api.themoviedb.org/3/movie/$id/alternative_titles
	* @param array alternative_titles
	*/
		public function movieAlternativeTitles($idMovie)
		{
			$titles = $this->movieInfo($idMovie,"alternative_titles",false);
			$titles = $titles['titles'];
			return $titles;
		}//end of alternative_titles
	/**
	* movie Poster
	* http://api.themoviedb.org/3/movie/$id/images
	* @param array moviePoster
	*/
		public function moviePoster($idMovie)
		{
			$posters = $this->movieInfo($idMovie,"images",false);
			$posters = $posters['posters'];
			return $posters;
		}//end of 
	/**
	* movie Poster Backdrops
	* http://api.themoviedb.org/3/movie/$id/images
	* @param array moviePoster
	*/
		public function moviePosterB($idMovie)
		{
			$posters = $this->movieInfos($idMovie,"images",false);
			$posters = $posters['backdrops'];
			return $posters;
		}//end of 

		public function movieInfos($idMovie,$option="",$append_request=""){
			$option = (empty($option))?"":"/" . $option;
			$params = "movie/" . $idMovie . $option;
			$movie= $this->_calls($params,$append_request);
				return $movie;
		}//end of movieInfos

	/**
	* movie Casting
	* http://api.themoviedb.org/3/movie/$id/casts
	* @param array  movieCast
	*/
		public function movieCast($idMovie)
		{
			$castingTmp = $this->movieInfo($idMovie,"casts",false);
                        if (is_array($castingTmp['cast'])){
			foreach ($castingTmp['cast'] as $castArr){
				$castings[id]=$castArr['id'];
				$castings[name]=$castArr['name'];
				$castings[character]=$castArr['character'];
                                if ($castArr['profile_path'] != null){
				    $castings[image]='http://image.tmdb.org/t/p/w150'.$castArr['profile_path'];
                                }else{
				    $castings[image]='/images/timthumb.png';
                                }
				$casting[] = $castings;
			}
			return $casting;
                        }
		}//end of movieCast

	/**
	* movie Similar
	* http://api.themoviedb.org/3/movie/$id/similar_movies
	* @param array Similar
	*/
		public function movieSimilar($idMovie)
		{
			$similarTmp = $this->movieInfo($idMovie,"similar_movies",false);
			return $similarTmp;
		}//end of movieCast
	/**
	* Movie Info
         * @param string $append_requst additional request
	* http://api.themoviedb.org/3/movie/$id
	* @param array  movieInfo
         * 
	*/
		public function movieInfo($idMovie,$option="",$append_request=""){
			$option = (empty($option))?"":"/" . $option;
			$params = "movie/" . $idMovie . $option;
			$movie= $this->_call($params,$append_request);
				return $movie;
		}//end of movieInfo


	/**
	* Search Movie
	* http://api.themoviedb.org/3/search/movie?api_keyf&language&query=future
	* @param string  $peopleName
	*/
		public function searchMovie($movieTitle){
			$movieTitle="query=".urlencode($movieTitle);
			return $this->_call("search/movie",$movieTitle,$this->_lang);
		}//end of searchMovie

	/**
	* Get the plot keywords for a specific movie id.
	* http://api.themoviedb.org/3/movie/{id}/keywords
	* @param string
	*/
		public function movie_keywords($id) {
			return $this->_call('movie/'.$id.'/keywords', '');
		}

	/**
	* Get Confuguration of API
	* configuration	
	* http://api.themoviedb.org/3/configuration?apikey
	* @return array
	*/
		private function _getConfig() {
			return $this->_call("configuration","");
		}//end of getConfig

                
                public function getConfig(){
                    return $this->config;
                }
	/**
	* Latest Movie
	* http://api.themoviedb.org/3/movie/latest?api_key
	* @return array
	*/
		public function latestMovie() {
			return $this->_call('movie/latest','');
		}
	/**
	* Now Playing Movies
	* http://api.themoviedb.org/3/movie/now-playing?api_key&language&page
	* @param integer $page
	*/
	public function nowPlayingMovies($page=1) {
		return $this->_call('movie/now_playing', 'page='.$page);
	}

	/**
	* Popular Movies
	* http://api.themoviedb.org/3/movie/popular?api_key&language&page
	* @param integer $page
	*/
	public function PopularMovies($page=1) {
		return $this->_call('movie/popular', 'page='.$page);
	}

	/**
	* Popular Person
	* http://api.themoviedb.org/3/person/popular?api_key&page
	* @param integer $page
	*/
	public function PopularPerson($page=1) {
		return $this->_call('person/popular', 'page='.$page);
	}

	/**
	* People
	* http://api.themoviedb.org/3/person/{id}?api_key&page
	* @param integer $id
	*/
	public function PeopleInfo($idPeople,$append_request=""){
		$params = "person/" . $idPeople;
		$person = $this->_call($params,$append_request);
				return $person;
	}//end of PeopleInfo

	public function PeopleMovieCredits($idPeople,$append_request=""){
		$params = "person/" . $idPeople . "/movie_credits";
		$person = $this->_call($params,$append_request);
				return $person;
	}//end of PeopleMovieCredits

	public function PeopleTaggedImages($idPeople,$append_request=""){
		$params = "person/" . $idPeople . "/images";
		$person = $this->_call($params,$append_request);
				return $person;
	}//end of PeopleTaggedImages

	/**
	* Genre Movies
	* http://api.themoviedb.org/3/genre/{id}/movies?api_key&page
	* @param integer $id
	*/
	public function GenreMovies($id,$page=1){
		$params = 'page='.$page.'&sort_by=popularity.desc&include_adult=true&release_date_gte=1990-01-01&with_genres='.$id;
		$genre = $this->_call('discover/movie',$params);
				return $genre;
	}//end of GenreMovies

	public function GenreMoviesList() {
		return $this->_call('genre/movie/list',$this->_lang);
	}

	/**
	 * Makes the call to the API
	 *
	 * @param string $action	API specific function name for in the URL
	 * @param string $text		Unencoded paramter for in the URL
	 * @return string
	 */
		private function _call($action,$text,$lang=""){
		// # http://api.themoviedb.org/3/movie/11?api_key=XXX
			$lang=(empty($lang))?$this->getLang():$lang;
			$url= self::_API_URL_.$action."?api_key=".$this->getApikey()."&language=".$lang."&".$text; 			// echo "<pre>$url</pre>";
			$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FAILONERROR, 1);

			$results = curl_exec($ch);
			$headers = curl_getinfo($ch);

			$error_number = curl_errno($ch);
			$error_message = curl_error($ch);

			curl_close($ch);
			// header('Content-Type: text/html; charset=iso-8859-1');
			//echo"<pre>";print_r(($results));echo"</pre>";
			$results = json_decode(($results),true);
			return (array) $results;
		}//end of _call

		private function _calls($action,$text){
			$url= self::_API_URL_.$action."?api_key=".$this->getApikey()."&".$text; 			// echo "<pre>$url</pre>";
			$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_FAILONERROR, 1);

			$results = curl_exec($ch);
			$headers = curl_getinfo($ch);

			$error_number = curl_errno($ch);
			$error_message = curl_error($ch);

			curl_close($ch);
			// header('Content-Type: text/html; charset=iso-8859-1');
			//echo"<pre>";print_r(($results));echo"</pre>";
			$results = json_decode(($results),true);
			return (array) $results;
		}//end of _call            
} //end of class
?>
