# Source Archive / Postscript Service
 This repo contains source code of GCG.moe's Source Archive. This code is independently developed and was used at https://src.gcg.moe/. A modified version is currently running at https://gcgsrc.csdcdo.org/ and https://script.gcg.moe/. You will need a HK/MO/TW/SG IP for the former and IP of any publishing area of Girl Cafe Gun for the latter to visit the website, or you will be barred by a 418 error.
 
 Unfortunately, for securaty reasons, we are unable to publish the current version serving on http://src.gcg.moe/, but the core elements remain the same.

## Requirements
 - PHP 8.0+
 - MySQL
 - A compactable library of contents (under `lib` folder)

## Setting up
There are several files needs to be changed before using this system.

1. Fill database and MS Graph information in `/inc/_config.inc` and then rename it to `/config.inc`.
2. Fill your turnstile secret and domain in `/inc/turnstile.php`.
3. Fill the database containing your data index to `/inc/connect.php`

## Database
The database sample could be found in the SQL file. DO NOT UPLOAD THE SQL FILE TO YOUR WEBSITE.
 
## Content Format
 All contents stored here should end with `.txt.json`, this is to in comply with another tool developed to geenrate JSON files from acting script.
 
 A most simple example of file is as follows:
 
 ```
{
  "1": [
    { "a": "speaker_1", "b": "line_1" },
    { "a": "speaker_2", "b": "line_2" },
    { "a": "(Option)", "b": "option_1", "c": "target_sectiom" }
  ],
  "target_section": [
    { "a": "speaker_1", "b": "line_1" },
    { "a": "speaker_2", "b": "line_2" }
  ]
}
```
