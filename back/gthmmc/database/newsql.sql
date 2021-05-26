


--    特色美食表
drop table if exists crdc_food;
create table crdc_food(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_food_row_id on crdc_food(row_id);

set @parent_id = 7;
set @code_ = 'food';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('特色美食表', @code_, 'crdc_food', '特色美食表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(6, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(7, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(8, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(9, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);

--    出行管理表
drop table if exists crdc_traffic;
create table crdc_traffic(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_traffic_row_id on crdc_food(row_id);

set @parent_id = 7;
set @code_ = 'traffic';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('出行管理表', @code_, 'crdc_traffic', '出行管理表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);



--    游客服务点表
drop table if exists crdc_servicepoint;
create table crdc_servicepoint(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  lon varchar(100) DEFAULT '',
  lat varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_servicepoint_row_id on crdc_servicepoint(row_id);

set @parent_id = 8;
set @code_ = 'servicepoint';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('游客服务点表', @code_, 'crdc_servicepoint', '游客服务点表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '经度', 'lon', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(4, '纬度', 'lat', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(5, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(6, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(7, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(8, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(9, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(10, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(11, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);



--    一机游信息推送表
drop table if exists crdc_amt_informationpush;
create table crdc_amt_informationpush(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_informationpush_row_id on crdc_amt_informationpush(row_id);

set @parent_id = 8;
set @code_ = 'amt_informationpush';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('一机游信息推送表', @code_, 'crdc_amt_informationpush', '一机游信息推送表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(6, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(7, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(8, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(9, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);
--    一机游优惠活动表
drop table if exists crdc_amt_active;
create table crdc_amt_active(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_active_row_id on crdc_amt_active(row_id);

set @parent_id = 156;
set @code_ = 'amt_active';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('一机游优惠活动表', @code_, 'crdc_amt_active', '一机游优惠活动表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(6, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(7, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(8, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(9, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);
--    求助信息表
drop table if exists crdc_sosinfo;
create table crdc_sosinfo(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  contact_details varchar(300) DEFAULT '',
  lon varchar(100) DEFAULT '',
  lat varchar(100) DEFAULT '',
  remark text,
  sos_time varchar(100) DEFAULT '',
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_sosinfo_row_id on crdc_sosinfo(row_id);

set @parent_id = 9;
set @code_ = 'sosinfo';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('求助信息表', @code_, 'crdc_sosinfo', '求助信息表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '求助人', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '求助电话', 'contact_details', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(3, '经度', 'lon', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(4, '纬度', 'lat', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(4, '备注', 'remark', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '时间', 'sos_time', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(7, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(8, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(9, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(10, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);
--    评论信息表
drop table if exists crdc_comment;
create table crdc_comment(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  content text,
  preson  varchar(100) DEFAULT '',
  publish_date  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_comment_row_id on crdc_comment(row_id);

set @parent_id = 9;
set @code_ = 'comment';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('评论信息表', @code_, 'crdc_comment', '评论信息表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '评论标题', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '评论内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '评论人', 'preson', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '评论日期', 'publish_date', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(6, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(7, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(8, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(9, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(10, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(11, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);

--    常用问答表
drop table if exists crdc_qainfo;
create table crdc_qainfo(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  question varchar(300) DEFAULT '',
  answer varchar(300) DEFAULT '',
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_qainfo_row_id on crdc_qainfo(row_id);

set @parent_id = 9;
set @code_ = 'qainfo';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('常用问答表', @code_, 'crdc_qainfo', '常用问答表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(6, '问题', 'question', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(7, '回答', 'answer', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(8, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(9, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(10, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(11, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);

--    常用电话表
drop table if exists crdc_amt_telephone;
create table crdc_amt_telephone(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  remark varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_telephone_row_id on crdc_amt_telephone(row_id);

set @parent_id = 9;
set @code_ = 'amt_telephone';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('常用电话表', @code_, 'crdc_amt_telephone', '常用电话表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '电话号码', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '备注', 'remark', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(6, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(7, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(8, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);

--    一机游图片配置表
drop table if exists crdc_amt_imageconf;
create table crdc_amt_imageconf(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  modul_id varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_imageconf_row_id on crdc_amt_imageconf(row_id);

set @parent_id = 156;
set @code_ = 'amt_imageconf';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('一机游图片配置表', @code_, 'crdc_amt_imageconf', '一机游图片配置表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(6, '模块名称', 'modul_id', @code_, 0, 'varchar', 1, 1, '', 6, '', now(), 0,0),
(7, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(8, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(9, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(10, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);

--    一机游模块配置表
drop table if exists crdc_amt_modular;
create table crdc_amt_modular(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  parent_id varchar(100),
  is_check tinyint DEFAULT '0', 
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_modular_row_id on crdc_amt_modular(row_id);

set @parent_id = 156;
set @code_ = 'amt_modular';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('一机游模块配置表', @code_, 'crdc_amt_modular', '一机游模块配置表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '模块code', 'code', @code_, 0, 'varchar', 1, 1, '', 6, '', now(), 0,0),
(6, '父级id', 'parent_id', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(7, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(8, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(9, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(10, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);




--   美图欣赏
drop table if exists crdc_amt_picshow;
create table crdc_amt_picshow(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_picshow_row_id on crdc_amt_picshow(row_id);

set @parent_id = 156;
set @code_ = 'amt_picshow';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('一机游美图欣赏表', @code_, 'crdc_amt_picshow', '一机游美图欣赏表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(6, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(7, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(8, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(9, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);



--   精彩视频
drop table if exists crdc_amt_videoshow;
create table crdc_amt_videoshow(
  row_id int(10) unsigned NOT NULL AUTO_INCREMENT,
  name  varchar(100) DEFAULT '',
  depict varchar(300) DEFAULT '',
  content text,
  image varchar(255) DEFAULT '', 
  video varchar(255) DEFAULT '', 
  is_check tinyint DEFAULT '0',  
  `create_time` datetime ,
  destination_id int(10),
  is_delete tinyint DEFAULT 0,
  PRIMARY KEY(row_id)
) ENGINE=MYISAM DEFAULT CHARSET=utf8;
create unique index crdc_amt_videoshow_row_id on crdc_amt_videoshow(row_id);

set @parent_id = 156;
set @code_ = 'amt_videoshow';
 insert into crdc_resourcedirectory(name, code, table_name, description, parent_id, remark, is_edit, is_map, is_relation, is_statistics, create_time, is_delete,is_check) values
('一机游精彩视频表', @code_, 'crdc_amt_videoshow', '一机游精彩视频表', @parent_id, '', 1, 0, 0, 0, now(), 0,0);

insert into crdc_resourcefield(id, name, en_name, code, restraint, type, is_edit, is_intable, associate, show_type, remark, create_time, is_delete,is_statistics) values
(1, '行号', 'row_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(2, '名称', 'name', @code_, 0, 'varchar', 1, 1, '', 1, '', now(), 0,0),
(3, '简介', 'depict', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(4, '内容', 'content', @code_, 0, 'varchar', 1, 1, '', 5, '', now(), 0,0),
(5, '图片', 'image', @code_, 0, 'varchar', 1, 0, '', 6, '', now(), 0,0),
(5, '视频', 'image', @code_, 0, 'varchar', 1, 0, '', 9, '', now(), 0,0),
(6, '是否审核', 'is_check', @code_, 0, 'tinyint', 0, 0, '', 2, '', now(), 0,0),
(7, '目的地id', 'destination_id', @code_, 0, 'int(10)', 0, 0, '', 0, '', now(), 0,0),
(8, '创建时间', 'create_time', @code_, 0, 'datetime', 0, 0, '', 0, '', now(), 0,0),
(9, '是否删除', 'is_delete', @code_, 0, 'tinyint', 0, 0, '', 0, '', now(), 0,0);

