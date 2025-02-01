# Postscript Service System (Previously Source Archive)

This repo contains a modified version of GCGDS's Postscript Service (previously
source archive). This code is independently developed and is forked from current
version of code running at https://memory.girl.cafe.

The system has a simple i18n support, but translations needs to be provided by
creating files in `/inc/i18n/`. Contents and external services, such as CDN
and/or audio dispensing service, is not provided and needs to be built for this
code to work.

Organisation names, copyright holder names, as well as configurations, have been
replaced. Configuration have been removed but template is provided. API keys for
1st- and 3rd-party services needs to be built. Where secret is needed, it is
recommended to use long and secure mutual secret.

Some of the protection measures have been removed or modified to ensure security
of some methods currently used, since not many methods are available for use.

An earlier version could be found under 'V2-Origin' branch of this repository.

## Requirements

- PHP 8.0+
- MySQL
- A compactable library of contents (under `lib` folder).
- Cloudflare Turnstile sitekey and secret, AND/OR
- GeeTest (V4) sitekey and secret.
- CDN for dispensing required files.
- Translation dictionaries, if multi-language is needed.
- Audio dispensing service (if audio is enabled).
- Microsoft Entra ID tenent with MS Graph capabilities.

## Setting up

There are several files needs to be changed before using this system.

1. Fill configuration information in `/inc/config.inc` .
2. Fill the database containing your data index to `/inc/connect.php`
3. Place the data in the `lib-[languageCode]` folder
4. Have audio dispensing service ready and built up.
5. Have Geolocation API service ready and built up.
6. (Optional) have Turnstile proxy ready and built up.

There remain some part of the code where parts of the information remain
hard-coded. Efforts have been made to make them reasonable but you still need
to change them to fit your own purpose.

## Database

The database sample could be found in the SQL file. DO NOT UPLOAD THE SQL FILE
TO YOUR WEBSITE.

Overall structure for contents are three-layered, Type -> Category -> Entry.
**Type** is a larger category of what contents it is, and contain a list of
categories. Type is identified by a string. **Category** contain a list of
entries.

Due to historical reasons and easy management, link between category and entries
are done by assigning each category with an additional number other than its ID,
which is only unique within each type. Entries would have, therefore, a type and
type-specific ID to link to its category.

If a category / entry have common name of an indexing language missing, then
that object would not show up when performing listing in that language.

## Content Format

All contents stored here should end with `.json` and could be successfully parsed.
Different types of content would have slightly different structure.

### Plot (Galgame-alike)

```
{
 "1": [
   { "a": "speaker_1", "b": "line_1" , "v": "Voice_Tag_1"},
   { "a": "speaker_2", "b": "line_2" , "v": "Voice_Tag_2"},
   { "a": "(Option)", "b": "option_1", "c": "target_section" }
 ],
 "target_section": [
   { "a": "speaker_1", "b": "line_1" },
   { "a": "speaker_2", "b": "line_2" }
 ]
}
```

Section 1 must exist, or the entry could not be properly loaded without section
parameter. `"v"` for voice tag does not have to exit.

### Moments (BBS-Alike)

```
{
  "TopicCreator": "NPC_Name",
  "TopicCreaterAvatar": "NPC_Avatar.png",
  "TopicContent": "The quick brown fox jumps over the lazy dog",
  "Replies": [
    { "a": "playername", "o": ["quick brown fox jumped", "over the lazy dog"], "p": "player.png" },
    { "a": "NPC_Name", "b": "NPC Reply", "p": "NPC_Avatar.png" }
  ]
}
```

In this example, player makes the first reply, and player has two choices, as
listed under `"o"` key, which can have only one.

Images would be translated to `_CDN_URL/TA/[filename]` at output and users will
attempt to obtain file over there.

### Direct Messages (Chat-alike)

```
{
  "npc": "NPC_Name",
  "npcAvatar": "NPC_Avatar.png",
  "contents": [
    {
      "branch": 0,
      "isPlayer": false,
      "content": "The quick brown fox jumps over the lazy dog",
      "action": 0
    },
    {
      "branch": 0,
      "isPlayer": true,
      "choices": { "1": "quick brown fox jumped ", "2": "over the lazy dog" },
      "action": 0
    },
    {
      "branch": 1,
      "isPlayer": false,
      "content": "You said: quick brown fox jumped ",
      "action": 1
    },
    {
      "branch": 2,
      "isPlayer": false,
      "content": "You said: over the lazy dog",
      "action": 1
    },
    {
      "branch": 0,
      "isPlayer": false,
      "content": "But it should be \"The quick brown fox jumps over the lazy dog\"!",
      "action": 0
    },
    { "branch": 0, "isPlayer": true, "content": "Okay. You are the quick dog.", "action": 0 },
    {
      "branch": 0,
      "isPlayer": true,
      "content": "........................",
      "action": 2
    }
  ]
}
```

Private message sessions only has two parties, as indicated by the `isPlayer`
field. When there are choices to make, `choices` field should show up, otherwise
`content` would appear. `choices` field should not exist when `isPlayer` is set
to `false`. Choice made would lead to a switch to branch, and before branch is
changed, only lines with matching branch number would appear. Branch number is
defaulted to `0`, and could be reset to such when `action` field is set to `1`.
Session terminates when `session` is set to `2`, but it does not have to be in
place for the last message - the session would automatically terminate when it
reached the end.