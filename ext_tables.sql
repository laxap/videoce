#
# Re-add fields removed in 7.x
#
CREATE TABLE tt_content (

  image_link text,
  imagecaption text,
  imagecaption_position varchar(6) NOT NULL DEFAULT ''
);
