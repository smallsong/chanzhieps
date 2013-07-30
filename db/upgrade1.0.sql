-- add primary field of image.
alter table xr_file add `primary` enum('1','0')  not null default '0';

-- add hidden field to thread and reply.
ALTER TABLE `xr_thread` ADD `hidden` ENUM( '1', '0' ) NOT NULL DEFAULT '0';
ALTER TABLE `xr_reply` ADD `hidden` ENUM( '1', '0' ) NOT NULL DEFAULT '0';
