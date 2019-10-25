# MediaWiki Extension SelfDOI

This extension provides `<selfdoi />` tag to render self page [doi](https://www.doi.org/).

## Install

To install this extension, add the following to LocalSettings.php.

```PHP
wfLoadExtension("SelfDOI");
$wgSelfDOIPrefix = "10.XXXXXX"; // required
```

### Configuration variables

- `$wgSelfDOIPrefix`
  - set the DOI prefix of this site. (required)
    - e.g. "10.14931" - INCF Japan Node
  - default: `""`
- `$wgSelfDOISiteId`
  - set the site id which used for first part of the DOI suffix.
    - e.g. "bsd" - Brain Science Dictionary
  - default: `""`
- `$wgSelfDOISchema`
  - display schema: "none", "doi" or "url".
    - examples:
      - "none" : `10.14931/bsd.354`
      - "doi" : `doi:10.14931/bsd.354`
      - "url" : `https://doi.org/10.14931/bsd.354`
  - default: `"none"`

## Usage

#### typical case.

```MediaWiki
<selfdoi />
```

#### override display schema to `url`.

```MediaWiki
<selfdoi schema="url" />
```

## License

This software is licensed under the [GNU General Public License 2.0 or later](COPYING).

## Authors

- [Yoshihiro Okumura](https://github.com/orrisroot)

## Usage examples

- https://bsd.neuroinf.jp/ : Brain Science Dictionary project in Japanese.
