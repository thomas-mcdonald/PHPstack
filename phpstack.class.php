<?php
/**
 * File: PHPstack
 * 	StackExchange API (http://stackapps.com)
 *
 * Version:
 * 	2010.05.30
 *
 * Copyright:
 * 	2010 Thomas McDonald, and contributors.
 *
 * License:
 * 	Simplified BSD License - http://opensource.org/licenses/bsd-license.php
 *
 * See Also:
 *  (In Progress) Online documentation - http://conceptcoding.co.uk/phpstack
 */

define('API_VERSION', '0.8');

define('PHPSTACK_USERAGENT', 'PHPstack 1');

class PHPstack {

    /**
     * Property: Key
     * The Stack Exchange API key. Used in all requests.
     */
    var $key;

    /**
     * Property: URL
     * The URL of the Stack Exchange site we are querying
     */
    var $url;

    /**
     * Property: Useragent
     * The useragent used by CURL for all requests
     */
    var $useragent;
    
    function __construct($url, $key) {
        if(is_string($url)) {
            $this->url = $url;
        } else {
            trigger_error("An invalid URL was specified", E_USER_ERROR);
        }

        if(!empty($key)) {
            $this->key = $key;
        } else {
            trigger_error("An invalid API key was provided", E_USER_ERROR);
        }

        $this->useragent = PHPSTACK_USERAGENT;

        return true;
    }


    /**
     * Method: setUseragent()
     *  Sets the useragent used by CURL
     *
     * Access:
     *  public
     *
     * Parameters:
     *  ua - _string_ (Required) The useragent you wish to use.
     *
     * Returns:
     *  true on success
     *
     */
    function setUseragent($ua) {
        $this->useragent = '(PHPstack) ' . $ua;
        return true;
    }


    /**
	 * Method: getAnswers()
	 * 	Gets an answer, or set of answers,  by their IDs.
	 *
	 * Access:
	 * 	public
	 *
	 * 	Parameters:
     *  id - _integer_ (Required) A single primary key identifier or a vectorized, semicolon-delimited list of identifiers for the answer(s)
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
     * Keys for the $opt parameter:
     *  body - _boolean_ (Optional) When true, a post's body will be included in the response. Default is false.
     *  comments - _boolean_ (Optional) When true, any comments on a post will be included in the response. Default is false.
     *  sort - _string_ (Optional) How a collection should be sorted. Allowed values are "activity", "creation", "views" or "votes". Default is activity.
     *  order - _string_ (Optional) How the current sort should be ordered, either "asc" or "desc". Default is desc.
	 *  min - _integer_ (Optional) Minimum of the range to include in the response according to the current sort.
     *  max - _integer_ (Optional) Maximum of the range to include in the response according to the current sort.
     *  fromdate - _integer_ (Optional) Unix timestamp of the minimum creation date on a returned item.
     *  todate - _integer_ (Optional) Unix timestamp of the maximum creation date on a returned item.
     *  page - _integer_ (Optional) The pagination offset for the current collection. Affected by the specified pagesize.
     *  pagesize - _integer_ (Optional) The number of collection results to display during pagination. Should be between 1 and 100 inclusive.
     *
	 * Returns:
	 * 	<ResponseCore> object
     * 
	 */
    function getAnswers($id, $opt = NULL) {
        if (!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The answer ID must be numeric", E_USER_ERROR);
        }

        return $this->request('answers/' . $id, $opt);
    }

     /**
	 * Method: getAnswerComments()
	 * 	Gets the comments associated with a set of answers. 
	 *
	 * Access:
	 * 	public
	 *
	 * 	Parameters:
     *  id - _integer_ (Required) A single primary key identifier or a vectorized, semicolon-delimited list of identifiers for the comments(s)
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
     * Keys for the $opt parameter:
     *  sort - _string_ (Optional) How a collection should be sorted. Allowed values are "activity", "creation", "views" or "votes". Default is activity.
     *  order - _string_ (Optional) How the current sort should be ordered, either "asc" or "desc". Default is desc.
	 *  min - _integer_ (Optional) Minimum of the range to include in the response according to the current sort.
     *  max - _integer_ (Optional) Maximum of the range to include in the response according to the current sort.
     *  fromdate - _integer_ (Optional) Unix timestamp of the minimum creation date on a returned item.
     *  todate - _integer_ (Optional) Unix timestamp of the maximum creation date on a returned item.
     *  page - _integer_ (Optional) The pagination offset for the current collection. Affected by the specified pagesize.
     *  pagesize - _integer_ (Optional) The number of collection results to display during pagination. Should be between 1 and 100 inclusive.
     *
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getAnswerComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The answer ID must be numeric");
        }

        return $this->request('answers/' . $id . '/comments', $opt);
    }

    /**
	 * Method: getAllBadges()
	 * 	Gets all standard, non-tag-based badges in alphabetical order. 
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getAllBadges() {
        $opt = array();
        
        return $this->request('badges/name', $opt);
    }

    /**
	 * Method: getBadges()
	 * 	Gets the users that have been awarded the badge identified by 'id'. 
	 *
	 * Access:
	 * 	public
	 *
	 * 	Parameters:
     *  id - _integer_ (Required) A single primary key identifier or a vectorized, semicolon-delimited list of identifiers for the answer(s)
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
     * Keys for the $opt parameter:
     *  fromdate - _integer_ (Optional) Unix timestamp of the minimum creation date on a returned item.
     *  todate - _integer_ (Optional) Unix timestamp of the maximum creation date on a returned item.
     *  page - _integer_ (Optional) The pagination offset for the current collection. Affected by the specified pagesize.
     *  pagesize - _integer_ (Optional) The number of collection results to display during pagination. Should be between 1 and 100 inclusive.
     *
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getBadges($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The badge ID must be numeric", E_USER_ERROR);
        }

        return $this->request('badges/' . $id, $opt);
    }

     /**
	 * Method: getAllBadges()
	 * 	Gets all tag-based badges in alphabetical order.
	 *
	 * Access:
	 * 	public
	 *
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getTagBadges() {
        $opt = array();

        return $this->request('badges/tags', $opt);
    }

    /**
	 * Method: getComments()
	 * 	Gets the comments associated with a set of answers.
	 *
	 * Access:
	 * 	public
	 *
	 * 	Parameters:
     *  id - _integer_ (Required) A single primary key identifier or a vectorized, semicolon-delimited list of identifiers for the comment(s)
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
     * Keys for the $opt parameter:
     *  sort - _string_ (Optional) How a collection should be sorted. Allowed values are "activity", "creation", "views" or "votes". Default is activity.
     *  order - _string_ (Optional) How the current sort should be ordered, either "asc" or "desc". Default is desc.
	 *  min - _integer_ (Optional) Minimum of the range to include in the response according to the current sort.
     *  max - _integer_ (Optional) Maximum of the range to include in the response according to the current sort.
     *  fromdate - _integer_ (Optional) Unix timestamp of the minimum creation date on a returned item.
     *  todate - _integer_ (Optional) Unix timestamp of the maximum creation date on a returned item.
     *  page - _integer_ (Optional) The pagination offset for the current collection. Affected by the specified pagesize.
     *  pagesize - _integer_ (Optional) The number of collection results to display during pagination. Should be between 1 and 100 inclusive.
     *
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The comment ID must be numeric", E_USER_ERROR);
        }

        return $this->request('comments/' . $id, $opt);
    }

    /**
	 * Method: getComments()
	 * 	Simulates an error given a code.
	 *
	 * Access:
	 * 	public
	 *
	 * 	Parameters:
     *  id - _integer_ (Required) ID of the error to simulate
     * 
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getError($id) {
        $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The error ID must be numeric", E_USER_ERROR);
        }

        return $this->request('errors/' . $id, $opt);
    }

    /**
	 * Method: getQuestionsSummary()
	 * 	Gets question summary information. 
	 *
	 * Access:
	 * 	public
	 *
	 * 	Parameters:
     *  id - _integer_ (Required) A single primary key identifier or a vectorized, semicolon-delimited list of identifiers for the comment(s)
	 * 	opt - _array_ (Optional) Associative array of parameters which can have the following keys:
	 *
     * Keys for the $opt parameter:
     *  tagged - _string_ (Optional) List of tags questions must have.
     *  body - _boolean_ (Optional) When true, a post's body will be included in the response. Default is false.
     *  sort - _string_ (Optional) How a collection should be sorted. Allowed values are "activity", "creation", "views" or "votes". Default is activity.
     *  order - _string_ (Optional) How the current sort should be ordered, either "asc" or "desc". Default is desc.
	 *  min - _integer_ (Optional) Minimum of the range to include in the response according to the current sort.
     *  max - _integer_ (Optional) Maximum of the range to include in the response according to the current sort.
     *  fromdate - _integer_ (Optional) Unix timestamp of the minimum creation date on a returned item.
     *  todate - _integer_ (Optional) Unix timestamp of the maximum creation date on a returned item.
     *  page - _integer_ (Optional) The pagination offset for the current collection. Affected by the specified pagesize.
     *  pagesize - _integer_ (Optional) The number of collection results to display during pagination. Should be between 1 and 100 inclusive.
     *
	 * Returns:
	 * 	<ResponseCore> object
     *
	 */
    function getQuestionsSummary($opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('questions', $opt);
    }

    function getQuestions($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The question ID must be numeric", E_USER_ERROR);
        }

        return $this->request('questions/' . $id, $opt);
    }

    function getQuestionAnswers($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The question ID must be numeric", E_USER_ERROR);
        }

        return $this->request('questions/' . $id . '/answers', $opt);
    }

    function getQuestionComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The question ID must be numeric", E_USER_ERROR);
        }

        return $this->request('questions/' . $id . '/comments', $opt);
    }

    function getQuestionTimeline($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The question ID must be numeric", E_USER_ERROR);
        }

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

        if(!is_numeric($id)) {
            trigger_error("The question ID must be numeric", E_USER_ERROR);
        }

        return $this->request('revisions/' . $id, $opt);
    }

    function getRevision($id, $guid, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The question ID must be numeric", E_USER_ERROR);
        }

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

    function getUsersSummary($opt = NULL) {
        if(!$opt) $opt = array();

        return $this->request('users', $opt);
    }

    function getUsers($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id, $opt);
    }

    function getUsersAnswers($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/answers', $opt);
    }

    function getUsersBadges($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/badges', $opt);
    }

    function getUsersComments($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/comments', $opt);
    }

    function getUsersCommentsTo($id, $toid, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/commnets/' . $toid, $opt);
    }

    function getUsersFavourites($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/favourites', $opt);
    }

    function getUsersMentions($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/mentioned', $opt);
    }

    function getUsersQuestions($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/questions', $opt);
    }

    function getUsersReputation($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/reputation', $opt);
    }

    function getUsersTags($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/tags', $opt);
    }

    function getUsersTimeline($id, $opt = NULL) {
        if(!$opt) $opt = array();

        if(!is_numeric($id)) {
            trigger_error("The user ID must be numeric", E_USER_ERROR);
        }

        return $this->request('users/' . $id . '/tags', $opt);
    }


    /**
     * Method: request()
     * 	Handles the requests to the Stack Exchange API
     *
     * Access:
     * 	private
     *
     * 	Parameters:
     *  call - _string_ (Required) The API method to call
     * 	opt - _array_ (Optional) Associative array of parameters, used to build the query part of the URL
     *
     * Returns:
     * 	<ResponseCore> object
     *
     */
     private function request($call, $opt) {
        /* We need to loop through each option and if a boolean true/false is used
           convert it to a string true/false, otherwise http_build_array will use
           them to 1's and 0's, which makes the API return a 500 Internal Server Error. */
        foreach($opt as &$option) {
            if($option === true) {
                $option = 'true';
            } elseif($option === false) {
                $option = 'false';
            }
        }

        /* merge the users API key into the options array */
        $opt = array_merge($opt, array('key' => $this->key));
        $query = http_build_query($opt, '', '&');
        $request = new RequestCore('http://api.' . $this->url . '/' . API_VERSION . '/' . $call . '?' . $query);
        $request->set_useragent($this->useragent);

        $request->send_request();
        $headers = $request->get_response_header();
        $jsonbody = $request->get_response_body();
        $body = json_decode($jsonbody);
        $data = new ResponseCore($headers, $body, $request->get_response_code());
        return $data;
    }
}
