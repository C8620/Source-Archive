# Source Archive
 This repo contains source code of GCG.moe's Source Archive. This code is independently developed and is used at https://src.gcg.moe/. This piece of code uses PHP.

## Requirements
 - PHP 7.0+
 - MySQL
 - A compactable library of contents
 
## Content Format
 All contents stored here should end with ```.txt.json```, this is to in comply with another tool developed to geenrate JSON files from acting script.
 
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
