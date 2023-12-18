<?php

namespace nick97\TraktMovies\Helper;

class Trakt
{


	public function parseMovieId($url): int
	{
		if (stristr($url, 'trakt.tv/')) {
			// preg_match_all USED FOR FUTURE API PARAMETER CAPTURING
			$pattern = "/https:\/\/trakt\.tv\/movies\//";
			$cleanUrl = preg_replace($pattern, "", $url);

			if (!empty($cleanUrl)) {
				$tmdbId = $this->getIdFromTrakt($cleanUrl);
				$movieId = intval($tmdbId);
			} else {
				$movieId = 0;
			}
		} else {
			$movieId = 0;
		}

		return $movieId;
	}

	protected function getIdFromTrakt($id)
	{
		$endpoint = 'https://api.trakt.tv/movies/' . $id;

		$clientKey = \XF::options()->traktMovieThreads_apikey;

		$headers = array(
			'Content-Type: application/json',
			'trakt-api-version: 2',
			'trakt-api-key: ' . $clientKey
		);

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $endpoint);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);

		curl_close($ch);

		$toArray = json_decode($result, true);

		$movieId = $toArray["ids"]["tmdb"];

		if (isset($movieId)) {
			return $movieId;
		} else {
			return 0;
		}
	}

	public function parseGenres(array $apiResponse): array
	{
		$genres = [];
		if (isset($apiResponse['genres'])) {
			foreach ($apiResponse['genres'] as $genre) {
				$genres[] = $genre['name'];
			}
		}

		return $genres;
	}

	public function getGenresList(array $apiResponse)
	{
		return implode(',', $this->parseGenres($apiResponse));
	}

	public function parseDirectors(array $apiResponse): array
	{
		$directors = [];
		if (isset($apiResponse['casts']['crew'])) {
			foreach ($apiResponse['casts']['crew'] as $director) {
				if ($director['job'] == 'Director') {
					$directors[] = $director['name'];
				}
			}
		}

		return $directors;
	}

	public function getDirectorsList(array $apiResponse)
	{
		return implode(',', $this->parseDirectors($apiResponse));
	}

	public function parseCast(array $apiResponse): array
	{
		$cast = [];
		if (isset($apiResponse['casts']['cast'])) {
			foreach ($apiResponse['casts']['cast'] as $actor) {
				$cast[] = $actor['name'];
			}
		}

		return $cast;
	}

	public function getCastList(array $apiResponse)
	{
		return implode(',', $this->parseCast($apiResponse));
	}

	public function parseTrailers(array $apiResponse, string $hosting = 'youtube'): array
	{
		$trailers = [];
		if (isset($apiResponse['trailers'][$hosting])) {
			foreach ($apiResponse['trailers'][$hosting] as $source) {
				$trailers[] = $source['source'];
			}
		}

		return $trailers;
	}

	public function getTrailer(array $apiResponse, string $hosting = 'youtube')
	{
		$trailers = $this->parseTrailers($apiResponse, $hosting);
		return $trailers ? array_values($trailers)[0] : '';
	}

	public function getMovieWatchProviders(array $apiResponse)
	{
		$providers = [];
		if (isset($apiResponse['watch/providers']['results'])) {
			$providers = $apiResponse['watch/providers']['results'];
		}

		return $providers;
	}

	public function getMovieProductionCompanies(array $apiResponse)
	{
		$companies = [];
		if (isset($apiResponse['production_companies'])) {
			$companies = $apiResponse['production_companies'];
		}

		return $companies;
	}

	public function getStandardizedTvData(array $apiResponse)
	{
		return [
			'trakt_title' => $apiResponse['title'] ?? '',
			'trakt_plot' => isset($apiResponse['overview']) ? html_entity_decode($apiResponse['overview']) : '',
			'trakt_image' => $apiResponse['poster_path'] ?? '',
			'trakt_genres' => $this->getGenresList($apiResponse),
			'trakt_director' => $this->getDirectorsList($apiResponse),
			'trakt_cast' => $this->getCastList($apiResponse),
			'trakt_release' => $apiResponse['release_date'] ?? '',
			'trakt_tagline' => $apiResponse['tagline'] ?? '',
			'trakt_runtime' => $apiResponse['runtime'] ?? 0,
			'trakt_status' => $apiResponse['status'] ?? 0,
			'trakt_trailer' => $this->getTrailer($apiResponse),
			'trakt_watch_providers' => $this->getMovieWatchProviders($apiResponse),
		];
	}
}