
# --- Add new content element ---
#
mod.wizards.newContentElement.wizardItems.special.elements.videoce {
    icon = ../typo3conf/ext/videoce/Resources/Public/Icons/wizard_videocontent.png
    title = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.ctype.title
    description = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.ctype.description
    tt_content_defValues {
        CType = videoce_videocontent
    }
}
mod.wizards.newContentElement.wizardItems.special.show := addToList(videoce)



# --- Rename labels (from image to video) ---
#
TCEFORM.tt_content {
    image_link {
        types {
            videoce_videocontent.label = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.links
        }
    }

    imagecaption {
        types {
            videoce_videocontent.label = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.caption
        }
    }

    imagewidth {
        types {
            videoce_videocontent.label = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.width
        }
    }
    imageheight {
        types {
            videoce_videocontent.label = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.height
        }
    }
    imagecaption_position {
        types {
            videoce_videocontent.label = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.position
        }
    }
    imagecols {
        types {
            videoce_videocontent {
                removeItems = 5,7,8
            }
        }
    }
}

