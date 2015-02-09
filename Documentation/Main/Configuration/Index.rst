.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Configuration
=============


General settings
----------------

[tsref:tt_content.videoce\_videocontent.20.settings]

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:
         default.extLinkIcon

   :Data type:
         string

   :Description:
         Class for i-tag in link to external site.

   :Default:
         fa fa-external-link


 - :Property:
         default.width

   :Data type:
         int

   :Description:
         Default width if not specified in content element.

   :Default:
         300


 - :Property:
         rowClass

   :Data type:
         string

   :Description:
         Video row div class attribute.

   :Default:
         row


 - :Property:
         colClasses.1

   :Data type:
         string

   :Description:
         Video column div class attribute when 1 column selected.

   :Default:
         col-md-12


 - :Property:
         colClasses.2

   :Data type:
         string

   :Description:
         Video column div class attribute when 2 columns selected.

   :Default:
         col-md-6


 - :Property:
         colClasses.3

   :Data type:
         string

   :Description:
         Video column div class attribute when 3 columns selected.

   :Default:
         col-md-4 col-sm-6



 - :Property:
         colClasses.4

   :Data type:
         string

   :Description:
         Video column div class attribute when 4 columns selected.

   :Default:
         col-md-3 col-sm-6


 - :Property:
         colClasses.6

   :Data type:
         string

   :Description:
         Video column div class attribute when 6 columns selected.

   :Default:
         col-md-2 col-sm-4


 - :Property:
         jsFiles.jQueryFitvid

   :Data type:
         string

   :Description:
         Fitvid jquery script. Remove if already included or not needed.

   :Default:
         typo3conf/ext/videoce/Resources/Public/Js/jquery.fitvid.js


 - :Property:
         jsFiles.videoce

   :Data type:
         string

   :Description:
         Initializes fitvid. Remove if not needed.

   :Default:
         typo3conf/ext/videoce/Resources/Public/Js/videoce.js


 - :Property:
         jsIncludeAsFooterFile

   :Data type:
         int

   :Description:
         Use addJsFooterFile() instead of addJsFooterLibrary to include the files.

   :Default:
         0


 - :Property:
         clickEnlargeATagRel

   :Data type:
         string

   :Description:
         Click enlarge link tag rel prefix.

   :Default:
         prettyPhoto



YouTube settings
----------------

[tsref:tt_content.videoce\_videocontent.20.settings.videoTypes.youtube]

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:
         class

   :Data type:
         string

   :Description:
         Domain model class. Extends Model\\ExternalVideo.

   :Default:
         Laxap\\Videoce\\Domain\\Model\\YoutubeVideo


 - :Property:
         config.pattern

   :Data type:
         string

   :Description:
         Pattern used to detect video type and for youtube the video id.

   :Default:
         |ytpatter|


 - :Property:
         config.link.url

   :Data type:
         string

   :Description:
         Used for displaying link to youtube website.

   :Default:
         https://www.youtube.com/watch?v=


 - :Property:
         config.link.urlParam

   :Data type:
         string

   :Description:
         Additional params

   :Default:


 - :Property:
         config.embed.url

   :Data type:
         string

   :Description:
         Url used to embed the video

   :Default:
         //www.youtube.com/embed/


 - :Property:
         config.embed.urlParam

   :Data type:
         string

   :Description:
         Add params to url

   :Default:
         ?rel=0


 - :Property:
         config.embed.urlParamPlaylist

   :Data type:
         string

   :Description:
         Add params to playlist url

   :Default:
         &playlist=


 - :Property:
         config.embed.iframeAttrib

   :Data type:
         string

   :Description:
         iFrame attributes

   :Default:
         frameborder="0" allowfullscreen


 - :Property:
         config.lightbox.enabled

   :Data type:
         int

   :Description:
         Enable lightbox

   :Default:
         1


 - :Property:
         config.lightbox.url

   :Data type:
         string

   :Description:
         Url for lightbox.

   :Default:
         https://www.youtube.com/watch?v=


 - :Property:
         config.lightbox.urlParam

   :Data type:
         string

   :Description:
         URL params for lightbox.

   :Default:
         &width=720&height=400




Vimeo settings
--------------

[tsref:tt_content.videoce\_videocontent.20.settings.videoTypes.vimeo]

Additional and different settings for vimeo.

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:
         class

   :Data type:
         string

   :Description:
         Domain model class. Extends Model\\ExternalVideo.

   :Default:
         Laxap\\Videoce\\Domain\\Model\\VimeoVideo


 - :Property:
         config.pattern

   :Data type:
         string

   :Description:
         Pattern used to detect vimeo video type

   :Default:
         #^(?:https?://)?(?:www\\.)?(?:vimeo\\.com)#x


 - :Property:
         config.link.url

   :Data type:
         string

   :Description:
         Used for displaying link to vimeo website.

   :Default:
         https://vimeo.com/


 - :Property:
         config.embed.url

   :Data type:
         string

   :Description:
         Url used to embed the video

   :Default:
         //player.vimeo.com/video/


 - :Property:
         config.embed.urlParam

   :Data type:
         string

   :Description:
         Add params to url

   :Default:
         ?portrait=0&byline=0


 - :Property:
         config.lightbox.url

   :Data type:
         string

   :Description:
         Url for lightbox.

   :Default:
         https://vimeo.com/


 - :Property:
         config.respectAspectRatio

   :Data type:
         string

   :Description:
        Defines which settings should prevail if the width:height ratio set in a content element does not match the retrieved width:height ratio.

   :Default:
         height


 - :Property:
         config.api.url

   :Data type:
         string

   :Description:
        URL used for api calls.

   :Default:
         http://vimeo.com/api/oembed.json?url=




Dailymotion settings
--------------------

[tsref:tt_content.videoce\_videocontent.20.settings.videoTypes.dailymotion]

Additional and different settings for vimeo.

.. t3-field-list-table::
 :header-rows: 1

 - :Property:
         Property:

   :Data type:
         Data type:

   :Description:
         Description:

   :Default:
         Default:


 - :Property:
         class

   :Data type:
         string

   :Description:
         Domain model class. Extends Model\\ExternalVideo.

   :Default:
         Laxap\\Videoce\\Domain\\Model\\DailymotionVideo


 - :Property:
         config.pattern

   :Data type:
         string

   :Description:
         Pattern used to detect dailymotion video type

   :Default:
         #^(?:https?://)?(?:www\\.)?(?:dailymotion\\.com/video/)#x


 - :Property:
         config.link.url

   :Data type:
         string

   :Description:
         Used for displaying link to Dailymotion website.

   :Default:
         http://www.dailymotion.com/video/


 - :Property:
         config.embed.url

   :Data type:
         string

   :Description:
         Url used to embed the video

   :Default:
         http://www.dailymotion.com/embed/video/


 - :Property:
         config.lightbox.url

   :Data type:
         string

   :Description:
         Url for lightbox.

   :Default:
         http://www.dailymotion.com/embed/video/

 
 - :Property:
         config.api.url

   :Data type:
         string

   :Description:
        URL used for api calls.

   :Default:
         https://api.dailymotion.com/video/