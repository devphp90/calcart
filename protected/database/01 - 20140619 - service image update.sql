ALTER TABLE `Service`
CHANGE `image` `image` text NULL,
DROP `image_filename`,
DROP `image_filetype`,
DROP `thumbnail`,
DROP `thumbnail_filename`,
DROP `thumbnail_filetype`;