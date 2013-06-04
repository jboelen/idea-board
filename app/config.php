<?php
/**
 * User: James
 * Date: 5/16/13
 */

/**  Database Configuration **/
$DATABASE = array(
    'location' => 'localhost',
    'port' => '3306',
    'username' => 'ideaboard',
    'password' => 'supersecretlongpasswordthatnoonecanguess!@#',
    'database' => 'ideaboard'
);

/**  General Site Configuration **/
$SITE = array(
    'general' => array(                     /** General configuration options **/
        'title' => 'My Idea Board',             //Site Name
        'root' => '/idea/',                          //Site root location
        'idea_type_singular' => 'idea',         //Singular form of site item: idea, secret, whisper, suggestion
        'idea_type_plural' => 'ideas',          //Plural form of site item: ideas, secrets, whispers, suggestions
        'language' => 'en'                      //TODO: Create localizations
    ),
    'submission'=> array(                   /** Submission Options **/
        'anonymous' => true,                    //Keep user names hidden
        'editing' => true,                      //Allow users to edit their submissions
        'editing_timer' => 0                    //Length of time (in minutes) users have to edit their posts (0 = infinite)
    ),
    'voting' => array(                      /** Voting Options **/
        'enable' => true,                       //Allow voting
        'down_votes' => true,                   //Allow down voting
        'tally' => false                        //Show vote tallies
    ),
    'comments' => array(                    /** Comment Options **/
        'enable' => true,                       //Allow comments
        'anonymous' => true,                    //Show user names against comments
    )
);



