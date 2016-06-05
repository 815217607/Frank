/*
 Navicat Premium Data Transfer

 Source Server         : vagrant local
 Source Server Type    : MySQL
 Source Server Version : 50630
 Source Host           : 192.168.33.100
 Source Database       : yuanphp

 Target Server Type    : MySQL
 Target Server Version : 50630
 File Encoding         : utf-8

 Date: 06/05/2016 15:07:00 PM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `assigned_roles`
-- ----------------------------
DROP TABLE IF EXISTS `assigned_roles`;
CREATE TABLE `assigned_roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `assigned_roles_user_id_foreign` (`user_id`),
  KEY `assigned_roles_role_id_foreign` (`role_id`),
  CONSTRAINT `assigned_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE,
  CONSTRAINT `assigned_roles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `assigned_roles`
-- ----------------------------
BEGIN;
INSERT INTO `assigned_roles` VALUES ('1', '1', '1'), ('2', '2', '2');
COMMIT;

-- ----------------------------
--  Table structure for `friendly_link`
-- ----------------------------
DROP TABLE IF EXISTS `friendly_link`;
CREATE TABLE `friendly_link` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `fl_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fl_ico` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fl_url` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fl_state` int(11) NOT NULL DEFAULT '0',
  `fl_sort` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `menus`
-- ----------------------------
DROP TABLE IF EXISTS `menus`;
CREATE TABLE `menus` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` bigint(20) DEFAULT '0',
  `menu_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lang_key` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `rank` char(1) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'D',
  `permission_id` bigint(20) DEFAULT NULL,
  `grade` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `state` int(11) NOT NULL DEFAULT '0',
  `url_falg` int(11) NOT NULL DEFAULT '0',
  `lang_falg` int(11) NOT NULL DEFAULT '0',
  `active` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `platform` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `sort` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `menus`
-- ----------------------------
BEGIN;
INSERT INTO `menus` VALUES ('1', '0', '用户&权限', 'menus.backend.access.title', '#', 'D', '2', null, '0', '1', '0', 'admin/access/*', '1', '0', '2016-05-07 14:34:53', '2016-06-05 07:06:14'), ('2', '1', '角色管理', 'menus.backend.access.roles.management', 'admin/access/roles', 'D', '23', null, '0', '1', '1', 'admin/access/roles*', '1', '0', '2016-05-07 14:34:53', '2016-06-05 06:33:18'), ('3', '1', '会员维护', 'menus.backend.access.title', 'admin.access.users.index', 'D', '22', null, '0', '0', '0', 'admin/access/users*', '1', '0', '2016-05-07 14:34:53', '2016-06-05 06:33:47'), ('4', '1', '权限维护', 'menus.backend.access.permissions.management', 'admin.access.permissions.index', 'D', '25', null, '0', '0', '1', 'admin/access/permissions*', '1', '5', '2016-05-07 14:34:53', '2016-05-07 14:34:53'), ('5', '1', '权限组维护', 'menus.backend.access.permissions.groups.management', 'admin.access.groups.permission-group.index', 'D', '24', null, '0', '0', '1', 'admin/access/groups*', '1', '6', '2016-05-07 14:34:53', '2016-05-07 14:34:53'), ('6', '1', '菜单管理', 'menus.backend.access.menus.management', 'admin/access/menus', 'D', '26', null, '0', '1', '0', 'admin/access/menus', '1', '0', '2016-06-05 06:26:36', '2016-06-05 06:26:54');
COMMIT;

-- ----------------------------
--  Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `permission_dependencies`
-- ----------------------------
DROP TABLE IF EXISTS `permission_dependencies`;
CREATE TABLE `permission_dependencies` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `dependency_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `permission_dependencies_permission_id_foreign` (`permission_id`),
  KEY `permission_dependencies_dependency_id_foreign` (`dependency_id`),
  CONSTRAINT `permission_dependencies_dependency_id_foreign` FOREIGN KEY (`dependency_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_dependencies_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `permission_dependencies`
-- ----------------------------
BEGIN;
INSERT INTO `permission_dependencies` VALUES ('1', '2', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('2', '3', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('3', '3', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('4', '4', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('5', '4', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('6', '5', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('7', '5', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('8', '6', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('9', '6', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('10', '7', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('11', '7', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('12', '8', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('13', '8', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('14', '9', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('15', '9', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('16', '10', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('17', '10', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('18', '11', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('19', '11', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('20', '12', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('21', '12', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('22', '13', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('23', '13', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('24', '14', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('25', '14', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('26', '15', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('27', '15', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('28', '16', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('29', '16', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('30', '17', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('31', '17', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('32', '18', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('33', '18', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('34', '19', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('35', '19', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('36', '20', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('37', '20', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('38', '21', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('39', '21', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('40', '22', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('41', '22', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('42', '23', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('43', '23', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('44', '24', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('45', '24', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('46', '25', '1', '2016-05-07 14:34:55', '2016-05-07 14:34:55'), ('47', '25', '2', '2016-05-07 14:34:55', '2016-05-07 14:34:55');
COMMIT;

-- ----------------------------
--  Table structure for `permission_groups`
-- ----------------------------
DROP TABLE IF EXISTS `permission_groups`;
CREATE TABLE `permission_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `permission_groups`
-- ----------------------------
BEGIN;
INSERT INTO `permission_groups` VALUES ('1', null, 'Access', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('2', '1', 'User', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('3', '1', 'Role', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('4', '1', 'Permission', '3', '2016-05-07 14:34:54', '2016-05-07 14:34:54');
COMMIT;

-- ----------------------------
--  Table structure for `permission_role`
-- ----------------------------
DROP TABLE IF EXISTS `permission_role`;
CREATE TABLE `permission_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_role_permission_id_foreign` (`permission_id`),
  KEY `permission_role_role_id_foreign` (`role_id`),
  CONSTRAINT `permission_role_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_role_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `permission_user`
-- ----------------------------
DROP TABLE IF EXISTS `permission_user`;
CREATE TABLE `permission_user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `permission_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `permission_user_permission_id_foreign` (`permission_id`),
  KEY `permission_user_user_id_foreign` (`user_id`),
  CONSTRAINT `permission_user_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `permission_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `group_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `display_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `system` tinyint(1) NOT NULL DEFAULT '0',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `permissions`
-- ----------------------------
BEGIN;
INSERT INTO `permissions` VALUES ('1', '1', 'view-backend', 'View Backend', '1', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('2', '1', 'view-access-management', 'View Access Management', '1', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('3', '2', 'create-users', 'Create Users', '1', '5', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('4', '2', 'edit-users', 'Edit Users', '1', '6', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('5', '2', 'delete-users', 'Delete Users', '1', '7', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('6', '2', 'change-user-password', 'Change User Password', '1', '8', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('7', '2', 'deactivate-users', 'Deactivate Users', '1', '9', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('8', '2', 'reactivate-users', 'Re-Activate Users', '1', '11', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('9', '2', 'undelete-users', 'Restore Users', '1', '13', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('10', '2', 'permanently-delete-users', 'Permanently Delete Users', '1', '14', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('11', '2', 'resend-user-confirmation-email', 'Resend Confirmation E-mail', '1', '15', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('12', '3', 'create-roles', 'Create Roles', '1', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('13', '3', 'edit-roles', 'Edit Roles', '1', '3', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('14', '3', 'delete-roles', 'Delete Roles', '1', '4', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('15', '4', 'create-permission-groups', 'Create Permission Groups', '1', '1', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('16', '4', 'edit-permission-groups', 'Edit Permission Groups', '1', '2', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('17', '4', 'delete-permission-groups', 'Delete Permission Groups', '1', '3', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('18', '4', 'sort-permission-groups', 'Sort Permission Groups', '1', '4', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('19', '4', 'create-permissions', 'Create Permissions', '1', '5', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('20', '4', 'edit-permissions', 'Edit Permissions', '1', '6', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('21', '4', 'delete-permissions', 'Delete Permissions', '1', '7', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('22', '4', 'user-view-management', 'User View Management', '1', '7', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('23', '4', 'roles-view-management', 'Roles View Management', '1', '7', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('24', '4', 'group-view-management', 'Delete Permissions', '1', '7', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('25', '4', 'permissions-view-management', 'Permissions View Management', '1', '7', '2016-05-07 14:34:54', '2016-05-07 14:34:54'), ('26', '4', 'menu-view-management', 'Manage Menus', '1', '0', '2016-06-05 06:25:03', '2016-06-05 06:25:40');
COMMIT;

-- ----------------------------
--  Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `all` tinyint(1) NOT NULL DEFAULT '0',
  `sort` smallint(5) unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_unique` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `roles`
-- ----------------------------
BEGIN;
INSERT INTO `roles` VALUES ('1', 'Administrator', '1', '1', '2016-05-07 14:34:53', '2016-05-07 14:34:53'), ('2', 'User', '0', '2', '2016-05-07 14:34:53', '2016-05-07 14:34:53');
COMMIT;

-- ----------------------------
--  Table structure for `social_logins`
-- ----------------------------
DROP TABLE IF EXISTS `social_logins`;
CREATE TABLE `social_logins` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `provider` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `provider_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `social_logins_user_id_foreign` (`user_id`),
  CONSTRAINT `social_logins_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `user_sessions`
-- ----------------------------
DROP TABLE IF EXISTS `user_sessions`;
CREATE TABLE `user_sessions` (
  `access_token` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`access_token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci DEFAULT NULL,
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `confirmation_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- ----------------------------
--  Records of `users`
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES ('1', 'Administrator', 'admin@admin.com', '$2y$10$Y/HAdaszCWRnLD1R6V8Oue7SzHq6WxxbSzn1Ja8UbOmxcPPjhdGZq', '1', '9669b185b5f631f868175130c65850c3', '1', 'e26EfXOv3K9GZLnEtKbKnq5e8K77qwN9CWL32LoaFgk2uO6UvLEoX1UwKzEy', '2016-05-07 14:34:53', '2016-06-05 06:53:43', null), ('2', 'Default User', 'user@user.com', '$2y$10$Y/HAdaszCWRnLD1R6V8Oue7SzHq6WxxbSzn1Ja8UbOmxcPPjhdGZq', '1', '341639eddeadd2a9bfe7d1cba129c2f2', '1', null, '2016-05-07 14:34:53', '2016-05-07 14:34:53', null);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
