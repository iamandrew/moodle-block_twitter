# Twitter Feed Block for Moodle

Moodle block which a twitter feed with easily stylable markup

### Requirements

This plugin requires Moodle 2.7 or greater

### Changes

*   2016-01-28 - Initial version

## Installation

*   Install the plugin like any other plugin to folder
/blocks/twitter
*   See http://docs.moodle.org/29/en/Installing_plugins for details on installing Moodle plugins
*   To enable the twitter block to contact the twitter API you will need to set up an application for twitter to use.
*   Visit https://apps.twitter.com/ and login with your twitter account to use this application.
*   For configuration on Moodle, you will need a Consuer Key, Consumer Secret, Access Token, and an Access Token Secret.
*   Once you have these details, fill in the relevant settings for the block in moodle through the plugin administration interface.

### Usage

The block_twitter plugin has 2 settings per instance:
A setting for the number of tweets to show on the block.
A setting for the twitter handle to get a list of tweets from.  Currently only 1 handle per block is supported.

### Themes

block_twitter should work with all themes from moodle core.

### Further information

*   This block uses the PHP twitter oauth library from [https://github.com/abraham/twitteroauth](https://github.com/abraham/twitteroauth)
*   block_twitter is found in the Moodle Plugins repository: [https://moodle.org/plugins/view.php?plugin=block_twitter](https://moodle.org/plugins/view.php?plugin=block_twitter)
*   Report a bug or suggest an improvement: [https://github.com/iamandrew/moodle-block_twitter/issues](https://github.com/iamandrew/moodle-block_twitter/issues)

### Thanks

Thanks to Caroline Kennedy for ideas & suggestions

### Copyright

2016 Andrew Davidson