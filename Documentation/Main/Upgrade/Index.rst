.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. include:: ../../Includes.txt


Changes and Upgrade
===================

Changes
-------

**Version 0.9.0**

- Switched to fluid_styled_content.

- Caption position is not supported anymore. Use layouts.

- Switch from old tt_content fields to bodytext and a custom videoce field for the captions.


Upgrade from TYPO3 7.6 to 8.7
-----------------------------

- Deactivate extension videoce but do not remove the fields (image_link, imagecaption).

- Upgrade TYPO3 to v8. Still don't remove the obsolete fields.

- Upgrade to videoce 0.9.x and activate the extension.

- Use the upgrade script to copy the video links and captions to the new fields.