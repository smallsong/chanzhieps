-- add primary field of image.
alter table xr_file add `primary` enum('1','0')  not null default '0';
