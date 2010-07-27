New Entry Notice Extension
=======================

* Version: 1.0
* Author: Carson Sasser (sassercw@cox.net)
* Build Date: 26 July 2010
* Requirements: Tested on Symphony CMS versions 2.0.8RC3 and 2.1.0.

Installation
------------

1. Install the files in a folder named 'new_entry_notice' inside your Symphony 'extensions' folder.

2. Enable it by selecting `New Entry Notice` in the `System -> Extensions` menu, choose Enable from the with-selected menu, and then click Apply.

TODO
----

* Nothing for now.

Change Log
----------

Version 1.0 - 26 July 2010

- Initial Release

Description
-----------

The best way to describe this extension is in terms of the application for which it was developed. On my website the home page consists of a serialization of short remarks in reverse chronological order. Another page serializes longer articles. I wanted a notice placed on the home page when a new article is posted on the Articles page. This extension creates that notice as a new remark entry. The new remark includes the title of the new article as a link to the new article.

The notice is created only when the article Publish field is set to yes when the article is initially created. When an article is edited a notice is created only when the Publish field is changed from no to yes. A notice is also created when the Publish field is changed from no to yes on the article index page using the With Selected/Apply method.

The extension can easily be customized for other similar applications.
