<?php namespace App\Services\Movie;

use App\Helpers\MovieHelper;
use Log;
use App\Helpers\CURLHelper as CURL;
/**
 * TODO intelligently return the search result order by
 * release year descendently
 */
class OmdbService {
    private static $URL = 'http://www.omdbapi.com/';
	public static function searchByTitle($title) {
		$year = date('Y');
		for ($idx=0; $idx<3; $idx++) {
			$omdbRespJson = self::search($title, $year-$idx);
			if (self::isMovieJustReleased($omdbRespJson)) {
				return $omdbRespJson;
			}
		}
		return null;
	}

    public static function searchByImdb($imdbId) {
        $params = array(
            'i'=>$imdbId,
            'r'=>'json',
            'plot'=>'short',
			'tomatoes' =>'true'
        );
        $response = CURL::get(self::$URL, $params);
        return json_decode($response, true);
    }

	public static function getImdbRatingByImdbId($imdbId) {
		$resp = self::searchByImdb($imdbId);
		return $resp['imdbRating'];
	}

	private static function search($title, $year) {
		$title = OmdbService::removeYearFromTitle($title);
		$params = array(
				'plot'=>'short',
				'r'=>'json',
				'y'=>$year,
				't'=>$title
		);
		$response = CURL::get(self::$URL, $params);
		return json_decode($response, true);
	}

	public static function removeYearFromTitle($title) {
		$year = substr($title, -6);
		if (preg_match('/\(\d{4}\)/', $year) === 1) {
			return trim(substr($title, 0, strlen($title)-6));
		} else {
			return trim($title);
		}
	}
	private static function isMovieJustReleased($omdbRespJson)
	{
		return $omdbRespJson['Response'] !== 'False' && self::isJustReleased($omdbRespJson);
	}

	private static function isJustReleased($omdbResp) {
		if ($omdbResp['Released']==='N/A') {
			return false;
		} else {
			return MovieHelper::isMovieJustReleased($omdbResp['Released'], 'd M Y');
		}
	}
}