# Source Archive (OG)
 This repo contains source code of GCG.moe's Source Archive. This code is independently developed and was used at https://src.gcg.moe/. A modified version is currently running at https://gcgsrc.csdcdo.org/. You will need a HK/MO/TW/SG IP to visit the website or you will be barred by a 418 error.
 
 Unfortunately, for securaty reasons, we are unable to publish the current version serving on http://src.gcg.moe/, but the core elements remain the same.

## Requirements
 - PHP 7.0+
 - MySQL
 - A compactable library of contents (under `lib` folder)
 
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
