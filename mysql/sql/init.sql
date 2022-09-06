DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255)NOT NULL
);

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(10) NOT NULL,
  start_at DATETIME,
  end_at DATETIME,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS event_attendance;
CREATE TABLE event_attendance (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT,
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

INSERT INTO users SET name='小林哲', email='akira@email.com', password='$2y$10$k29VrrWk.zMwycyH8IoSWe1ZTeZ5gwQ3Y6QtOLivUwWWnevhe/6N6';
INSERT INTO users SET name='青柳仁', email='jin@email.com', password='$2y$10$9AajUv0ZwxO.gA0EcxxUyeEMRzMD/LSBT35k45hFgIoyaM6pCfrEy';
INSERT INTO users SET name='寺嶋里紗', email='lisa@email.com', password='$2y$10$XrueV1jzbCGJsJI9CsOGSehojBJDrlI54cmByZH5FAE5g6JG82xQe';
INSERT INTO users SET name='寺下渓志郎', email='keishiro@email.com', password='$2y$10$zrD1aLPbdLLkk./20egMDOH5i1OQTbuUrteDPBUnQ52aPmEwOcqq2';

INSERT INTO events SET name='縦モク', start_at='2021/08/01 21:00', end_at='2021/08/01 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/02 21:00', end_at='2021/08/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/03 20:00', end_at='2021/08/03 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/08 21:00', end_at='2021/08/08 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/09 21:00', end_at='2021/08/09 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/10 20:00', end_at='2021/08/10 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/15 21:00', end_at='2021/08/15 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/16 21:00', end_at='2021/08/16 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/17 20:00', end_at='2021/08/17 22:00';
INSERT INTO events SET name='縦モク', start_at='2021/08/22 21:00', end_at='2021/08/22 23:00';
INSERT INTO events SET name='横モク', start_at='2021/08/23 21:00', end_at='2021/08/23 23:00';
INSERT INTO events SET name='スペモク', start_at='2021/08/24 20:00', end_at='2021/08/24 22:00';
INSERT INTO events SET name='遊び', start_at='2021/09/22 18:00', end_at='2021/09/22 22:00';
INSERT INTO events SET name='ハッカソン', start_at='2021/09/03 10:00', end_at='2021/09/03 22:00';
INSERT INTO events SET name='遊び', start_at='2021/09/06 18:00', end_at='2021/09/06 22:00';

INSERT INTO event_attendance SET event_id=1;
INSERT INTO event_attendance SET event_id=1;
INSERT INTO event_attendance SET event_id=1;
INSERT INTO event_attendance SET event_id=2;
INSERT INTO event_attendance SET event_id=2;
INSERT INTO event_attendance SET event_id=3;
