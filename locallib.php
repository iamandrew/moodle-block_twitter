<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Local lib functions
 *
 * @package    block_twitter
 * @copyright  2016 Andrew Davidson
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once($CFG->dirroot.'/blocks/twitter/twitterautoload.php');
use Abraham\TwitterOAuth\TwitterOAuth;

defined('MOODLE_INTERNAL') || die();

function block_twitter_get_tweets($handle) {
    global $CFG, $COURSE, $DB;

    $cache = cache::make('block_twitter', 'tweets');
    $tweets = $cache->get('tweets_'.$handle);
    if ($tweets !== false) {
        return $tweets;
    }

    $tconf = get_config('block_twitter');
    define('CONSUMER_KEY', $tconf->consumerkey);
    define('CONSUMER_SECRET', $tconf->consumersecret);
    define('TWITTER_TOKEN', $tconf->accesstoken);
    define('TWITTER_TOKEN_SECRET', $tconf->accesssecret);

    $connection = new TwitterOAuth(CONSUMER_KEY, CONSUMER_SECRET, TWITTER_TOKEN, TWITTER_TOKEN_SECRET);
    $connection->resetLastResponse();
    $tweets = $connection->get("statuses/user_timeline", ["screen_name" => $handle, 'exclude_replies' => true, 'trim_user' => false]);

    if (isset($tweets->errors)) {
        $error = reset($tweets->errors);
        debugging(get_string('error').' '.$error->code.': '.$error->message, DEBUG_DEVELOPER);
        return '';
    }
    $cache->set('tweets_'.$handle, $tweets);

    return $tweets;
}

function block_twitter_relativetime($ts) {
    if (!ctype_digit($ts)) {
        $ts = strtotime($ts);
    }

    $diff = time() - $ts;
    if ($diff == 0) {
        return 'now';
    } else if ($diff > 0) {
        $daydiff = floor($diff / 86400);
        if ($daydiff == 0) {
            if ($diff < 120) {
                return '1m';
            }
            if ($diff < 3600) {
                return floor($diff / 60) . 'm';
            }
            if ($diff < 7200) {
                return '1h';
            }
            if ($diff < 86400) {
                return floor($diff / 3600) . 'h';
            }
        }
        if ($diff > 31557600) {
            return date('d M Y', $ts);
        }
        return date('d M', $ts);
    }
}