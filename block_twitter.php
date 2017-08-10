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
 * Block to show course files and usage
 *
 * @package   block_twitter
 * @copyright 2016 Andrew Davidson
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot.'/blocks/twitter/locallib.php');

class block_twitter extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_twitter');
    }

    public function applicable_formats() {
        return array('all' => true);
    }

    public function has_config() {
        return true;
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function get_content() {
        global $CFG, $DB, $OUTPUT, $COURSE, $PAGE;

        if ($this->content !== null) {
            return $this->content;
        }

        $this->content = new stdClass;
        $this->content->text = '';
        $this->content->footer = '';

        if (empty($this->config)) {
            return $this->content;
        }
        if (empty($this->config->handle)) {
            return $this->content;
        }

        $renderer = $PAGE->get_renderer('block_twitter');

        // Get the top file files used on the course by size.
        $tweets = block_twitter_get_tweets($this->config->handle);

        if (!$tweets) {
            return $this->content;
        }
        if (is_string($tweets)) {
            $this->content->text = $tweets;
            return $this->content;
        }

        $i = 0;
        foreach ($tweets as $tweet) {
            if ($i == $this->config->shownumentries) {
                break;
            }
            $i ++;
            if (isset($tweet->retweeted_status)) {
                $text = $tweet->retweeted_status->text;
                $time = strtotime($tweet->retweeted_status->created_at);
                $user = $tweet->retweeted_status->user->name;
                $handle = $tweet->retweeted_status->user->screen_name;
                $avatar = $tweet->retweeted_status->user->profile_image_url;
                $rt = get_string('retweetedby', 'block_twitter').' '.$tweet->user->screen_name;
            } else {
                $text = $tweet->text;
                $time = strtotime($tweet->created_at);
                $user = $tweet->user->name;
                $handle = $tweet->user->screen_name;
                $avatar = $tweet->user->profile_image_url;
                $rt = false;
            }
            $time = block_twitter_relativetime($time);
            $actions = '';
            $replyurl = new moodle_url('https://twitter.com/intent/tweet', array('in_reply_to'=>$tweet->id));
            $actions .= html_writer::link($replyurl, $renderer->icon('reply'), array('class' => 'replylink'));
            $retweeturl = new moodle_url('https://twitter.com/intent/retweet', array('tweet_id'=>$tweet->id));
            $actions .= html_writer::link($retweeturl, $renderer->icon('retweet'), array('class' => 'retweetlink'));
            $likeurl = new moodle_url('https://twitter.com/intent/like', array('tweet_id'=>$tweet->id));
            $actions .= html_writer::link($likeurl, $renderer->icon('like'), array('class' => 'likelink'));

            $context = new stdClass();
            $context->avatar = $avatar;
            $accounturl = new moodle_url('http://twitter.com/'.$handle);
            $context->accounturl = $accounturl->out();
            $context->time = $time;
            $context->user = $user;
            $context->handle = $handle;
            $context->text = format_text($text);
            $context->icon = $renderer->icon('retweet');
            $context->rt = $rt;
            $context->actions = $actions;

            $this->content->text .= $OUTPUT->render_from_template('block_twitter/tweet', $context);
        }

        return $this->content;
    }

}