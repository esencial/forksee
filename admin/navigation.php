// part of orsee. see orsee.org.
//
// menu entry format:
//     0         1          2      3   4     5     6        7          8	   9
// entrytype|menu__area|lang_item|url|icon|target|addp?|showonlyifp?|hideifp?|options_condition
//
// uncomment line with // if not needed
//

head|admindata|current_user_data_box|
        
headlink|mainpage|mainpage|/admin/|home

head|experiments|experiments||experiments

link|experiments_main|overview|/admin/experiment_main.php

link|experiments_my|my_experiments|/admin/experiment_my.php

link|experiments_new|create_new|/admin/experiment_edit.php?addit=true

link|experiments_old|finished_experiments|/admin/experiment_old.php
 
head|participants|participants||participants

link|participants_main|overview|/admin/participants_main.php

link|participant_create|create_new|/admin/participants_edit.php

headlink|calendar|calendar|/admin/calendar_main.php|calendario

headlink|download|downloads|/admin/download_main.php|download

headlink|options|options|/admin/options_main.php|options

headlink|statistics|statistics|/admin/statistics_main.php|statistics

headlink|logout|logout|/admin/admin_logout.php|logout


