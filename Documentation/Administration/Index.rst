.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../Includes.txt
.. include:: Images.txt


Administration Manual
=====================


Installation
------------

Install the extension. Include the static template in the root template.

|img-includestatic|

Dailymotion specific configuration
----------------------------------
In order to make the "click-enlarge" work with Dailymotion integration, you'll have to replace the default javascript file ``videoce.js`` (the one which contains fitvid initialization).

Here is one way of doing it with typoscript: ::

   tt_content.videoce_videocontent.20.settings{
      jsFiles.videoce >
   }

   page.jsFooterInline{
     10 = TEXT
     10.value = $(".video-wrapper").fitVids({ customSelector: "iframe[src^='http://www.dailymotion.com/embed/video/']"});
   }