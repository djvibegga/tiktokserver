<?php

namespace TikTok\Scanner;

class Scanner
{
	/**
	 * @var \Sovit\TikTok\Api
	 */
	private $_api;

	/**
	 * @var boolean
	 */
	private $_debug;

	/**
	 * @param \Sovit\TikTok\Api $api
	 * @param string $debug
	 */
	public function __construct(
		\Sovit\TikTok\Api $api,
		bool             $debug = false
	)
	{
		$this->_api = $api;
		$this->_debug = $debug;
	}

	/**
	 * @param string $pageToScan
	 * @return array|false
	 */
	public function getUserInfo(string $pageToScan)
	{
		try {
			$response = $this->_api->getUser($pageToScan);
		} catch (\Exception $e) {
			echo 'Unable to fetch profile information: ' . $pageToScan . "\n";
			return false;
		}
		if (! empty($response)) {
			return [
				'id' => $response->user->id,
				'username' => $response->user->uniqueId,
				'fullname' => $response->user->nickname,
				'avatar' => $response->user->avatarThumb,
				'followersCount' => $response->stats->followerCount,
				'videosCount' => $response->stats->videoCount
			];
		}
		return false;
	}

	/**
	 * @param string $pageToScan
	 * @param string $offset
	 * @return array|false
	 */
	public function getAllPosts(string $pageToScan, int $offset = 0)
	{
		try {
			$response = $this->_api->getUserFeed($pageToScan, $offset);
		} catch (\Exception $e) {
			echo 'Unable to request via API the profile: ' . $pageToScan . "\n";
			return false;
		}
		if (! empty($response)) {
			$ret = [];
			foreach ($response->items as $item) {
				$ret['videos'][] = [
					'id' => $item->id,
					'picture' => $item->video->originCover,
					'animatedPicture' => $item->video->dynamicCover,
					'likesCount' => $item->stats->diggCount,
					'commentsCount' => $item->stats->commentCount
				];
			}
			$ret['hasNextPage'] = $response->hasMore;
			$ret['nextPageOffset'] = $response->hasMore ? $response->maxCursor : 0;
			return $ret;
		}
	}
}