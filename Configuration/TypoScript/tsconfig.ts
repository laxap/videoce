# add new content element
mod.wizards.newContentElement.wizardItems.special {
    elements {
        videoce {
            iconIdentifier = tx-videocontent-wizard
            title = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.ctype.title
            description = LLL:EXT:videoce/Resources/Private/Language/locallang_db.xlf:video.ctype.description
            tt_content_defValues {
                CType = videoce_videocontent
            }
        }
    }
    show := addToList(videoce)
}

# change fields for videoce content element
TCEFORM.tt_content {
    imagecols {
        types {
            videoce_videocontent {
                removeItems = 5,7,8
            }
        }
    }
}