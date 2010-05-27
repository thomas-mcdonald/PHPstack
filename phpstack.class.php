<?php
/**
 * File: PHPstack
 * 	StackExchange API (http://stackapps.com)
 *
 * Version:
 * 	2010.05.27
 *
 * Copyright:
 * 	2010 Thomas McDonald, and contributors.
 *
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 *
 * See Also:
 */

define('API_VERSION', '0.8');

define('PHPSTACK_USERAGENT', 'PHPstack 0.1');

class PHPstack {

    var $key;

    var $url;
    
    function __construct($url, $key) {
        if(is_string($url)) {
            $this->url = $url;
        } else {
            die('No URL was specified');
        }

        $this->key = $key;
    }

    function getAnswer($id, $opt = NULL) {
        if (!$opt) $opt = array();

        return $this->request('answers/' . $id, $opt);
    }

    function getAnswerComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('answers/' . $id . '/comments', $opt);
    }

    function getBadges() {
        $opt = array();
        
        return $this->request('badges/name', $opt);
    }

    function getBadge($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('badges/' . $id, $opt);
    }

    function getTagBadges() {
        $opt = array();

        return $this->request('badges/tags', $opt);
    }

    function getComment($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('comments/' . $id, $opt);
    }

    function getError($id) {
        $opt = array();

        return $this->request('errors/' . $id, $opt);
    }

    function getQuestions($opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions', $opt);
    }

    function getQuestion($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions/' . $id, $opt);
    }

    function getQuestionAnswers($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions/' . $id . '/answers', $opt);
    }

    function getQuestionComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions/' . $id . '/comments', $opt);
    }

    function getQuestionTimeline($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions/' . $id . '/timeline', $opt);
    }

    function getQuestionsTagged($tags, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions/tagged/' . $tags, $opt);
    }

    function getQuestionsUnanswered($opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions/unanswered', $opt);
    }

    function getRevisions($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('revisions/' . $id, $opt);
    }

    function getRevision($id, $guid, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('revisions/' . $id . '/' . $guid, $opt);
    }

    function getStats() {
        $opt = array();

        return $this->request('stats', $opt);
    }

    function getTags($opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('tags', $opt);
    }

    function getUsers($opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users', $opt);
    }

    function getUser($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id, $opt);
    }

    function getUsersAnswers($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/answers', $opt);
    }

    function getUsersBadges($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/badges', $opt);
    }

    function getUsersComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/comments', $opt);
    }

    function getUsersCommentsTo($id, $toid, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/commnets/' . $toid, $opt);
    }

    function getUsersFavourites($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/favourites', $opt);
    }

    function getUsersMentions($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/mentioned', $opt);
    }

    function getUsersQuestions($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/questions', $opt);
    }

    function getUsersReputation($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/reputation', $opt);
    }

    function getUsersTags($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/tags', $opt);
    }

    function getUsersTimeline($id, $opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users/' . $id . '/tags', $opt);
    }

    function request($call, $opt) {
        $opt = array_merge($opt, array('key' => $this->key));
        $query = http_build_query($opt, '', '&');
        $request = new RequestCore('http://api.' . $this->url . '/' . API_VERSION . '/' . $call . '?' . $query);
        $request->set_useragent(PHPSTACK_USERAGENT);

        $request->send_request();
        $headers = $request->get_response_header();

		$data = new ResponseCore($headers, $request->get_response_body(), $request->get_response_code());
        return $data;
    }
}
