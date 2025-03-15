

CREATE TABLE `test` (
 `id` int(11) NOT NULL AUTO_INCREMENT, 
 `name` text DEFAULT NULL, 
 `surname` text DEFAULT NULL, 
 `email` text DEFAULT NULL, 
 `value` text DEFAULT NULL, 
 `img_url` text DEFAULT NULL, 
 `isActive` int(11) NOT NULL DEFAULT 1, 
 `created_at` timestamp NOT NULL DEFAULT current_timestamp(), 
 `created_byId` int(11) DEFAULT NULL, 
 `isUpdated` int(11) NOT NULL DEFAULT 0, 
 `updated_at` timestamp NULL DEFAULT NULL, 
 `updated_byId` int(11) DEFAULT NULL, 
 `isDeleted` int(11) NOT NULL DEFAULT 0, 
 `deleted_at` timestamp NULL DEFAULT NULL, 
 `deleted_byId` int(11) DEFAULT NULL, 
PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `test` 
 ( `name` , `surname` , `email` , `value` , `img_url` , `isActive` , `created_at` , `created_byId` ) VALUES 
( 'deneme','soy','email@de.com','14','/assets/img/user/default.jpg','1','2024-10-29 19:01:29','1' ), 
( 'denemex x','soyx','email.com@denme','2','/assets/img/user/default.jpg','1','2024-10-23 01:33:41','1' ), 
( 'deneme','soy','ema@dee.com','23','/assets/img/user/default.jpg','1','2024-10-23 01:33:19','1' ), 
( 'ad','soyad','email@densad.xom','44','/assets/img/user/default.jpg','1','2024-10-22 22:25:00','1' ), 
( 'adp güncelle','surname 297','test@test.comp','351','/assets/img/user/default.jpg','1','2024-10-22 20:42:24','1' ), 
( 'adp','surname 295','test@test.comp','351','/assets/img/user/default.jpg','1','2024-10-22 20:37:19','1' ), 
( 'adp','surname güncellemep','test@test.comp','351','/assets/img/user/default.jpg','1','2023-11-03 14:58:26','1' ), 
( 'Name','Surname','test@test.com','21','/assets/img/user/default.jpg','1','2023-11-03 14:58:26','1' ), 
( 'Name','Surname','test@test.com','22','/assets/img/user/default.jpg','1','2024-09-09 04:53:23','1' ), 
( 'Name','Surname','test@test.com','23','/assets/img/user/default.jpg','1','2024-09-10 04:53:23','1' ), 
( 'Deneme','Son','end@dfds.com','11','/assets/img/user/default.jpg','0','2024-09-11 04:53:23','1' ), 
( 'ebuenesx','yıldırım','end@dfds.com','34','/assets/img/user/default.jpg','1','2024-09-29 15:27:07','1' ), 
( 'ebuenes','yıldırım','end@dfds.com','223','/assets/img/user/default.jpg','1','2024-10-05 18:46:58','1' ), 
( 'Name','Surname','test@test.com','27','/assets/img/user/default.jpg','1','2023-11-03 14:58:26','1' ), 
( 'Name','Surname','test@test.com','28','/assets/img/user/default.jpg','1','2023-11-03 14:58:26','1' );