DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

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


INSERT INTO events SET name='縦モク', start_at='2022/08/01 21:00', end_at='2022/08/01 23:00';
INSERT INTO events SET name='横モク', start_at='2022/08/02 21:00', end_at='2022/08/02 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/08/03 20:00', end_at='2022/08/03 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/08/08 21:00', end_at='2022/08/08 23:00';
INSERT INTO events SET name='横モク', start_at='2022/08/09 21:00', end_at='2022/08/09 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/08/10 20:00', end_at='2022/08/10 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/08/15 21:00', end_at='2022/08/15 23:00';
INSERT INTO events SET name='横モク', start_at='2022/08/16 21:00', end_at='2022/08/16 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/08/17 20:00', end_at='2022/08/17 22:00';
INSERT INTO events SET name='縦モク', start_at='2022/08/22 21:00', end_at='2022/08/22 23:00';
INSERT INTO events SET name='横モク', start_at='2022/08/23 21:00', end_at='2022/08/23 23:00';
INSERT INTO events SET name='スペモク', start_at='2022/08/24 20:00', end_at='2022/08/24 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/22 18:00', end_at='2022/09/22 22:00';
INSERT INTO events SET name='ハッカソン', start_at='2022/09/03 10:00', end_at='2022/09/03 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/06 18:00', end_at='2022/09/06 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/09 18:00', end_at='2022/09/06 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/09 18:00', end_at='2022/09/06 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/10 18:00', end_at='2022/09/06 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/28 18:00', end_at='2022/09/06 22:00';
INSERT INTO events SET name='遊び', start_at='2022/09/26 18:00', end_at='2022/09/06 22:00';

INSERT INTO event_attendance SET event_id=1;
INSERT INTO event_attendance SET event_id=1;
INSERT INTO event_attendance SET event_id=1;
INSERT INTO event_attendance SET event_id=2;
INSERT INTO event_attendance SET event_id=2;
INSERT INTO event_attendance SET event_id=3;