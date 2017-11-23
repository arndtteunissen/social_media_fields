# Social Media Fields
This extension adds fields for use with social graph protocols, like OpenGraph[^1], which enable rich object integration of the web page.

## Motivation
By default you can set these tags in the TypoScript `PAGE` object and default to the page description, categories and titles.
But these are limited and you might want to change the appearance based on a specific network.

## Installation
### Installation using Composer (recommended)
In your TYPO3 site folder run 

`composer require arndtteunissen/social_media_fields`
 
to install this extension.

### Installation from TYPO3 Extension Repository (TER)
Download and install the extension with the extension manager module.

## Usage
1. Include the static file "Social Media Fields" in your template.
2. Edit any page, open the tab "Social Media" and edit the fields according to your needs.

**NOTE:** Your template rendering definition or other plugins might add these tags as well. You might want to check your rendered HTML.

[^1]: http://ogp.me