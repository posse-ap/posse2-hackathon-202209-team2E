DROP SCHEMA IF EXISTS posse;
CREATE SCHEMA posse;
USE posse;

DROP TABLE IF EXISTS roles;
CREATE TABLE roles (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    role VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS users;
CREATE TABLE users (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255)NOT NULL,
    github_id VARCHAR(255) UNIQUE,
    role_id INT NOT NULL DEFAULT 1,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

DROP TABLE IF EXISTS password_resets;

CREATE TABLE password_resets (
    id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    token_sent_at DATETIME NOT NULL
);

DROP TABLE IF EXISTS events;
CREATE TABLE events (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  start_at DATETIME,
  end_at DATETIME,
  detail VARCHAR(255),
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME
);

DROP TABLE IF EXISTS event_attendance;
CREATE TABLE event_attendance (
  id INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
  event_id INT NOT NULL,
  user_id INT,
  status VARCHAR(255) NOT NULL DEFAULT "not_submitted",
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
  updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  deleted_at DATETIME,
  FOREIGN KEY (event_id) REFERENCES events(id),
  FOREIGN KEY (user_id) REFERENCES users(id)
);

INSERT INTO roles SET role='user';
INSERT INTO roles SET role='admin';

-- パスワードは全て'password'
INSERT INTO users SET name='小林哲', email='akira@email.com', password='$2y$10$k29VrrWk.zMwycyH8IoSWe1ZTeZ5gwQ3Y6QtOLivUwWWnevhe/6N6';
INSERT INTO users SET name='青柳仁', email='jin@email.com', password='$2y$10$9AajUv0ZwxO.gA0EcxxUyeEMRzMD/LSBT35k45hFgIoyaM6pCfrEy';
INSERT INTO users SET name='寺嶋里紗', email='lisa@email.com', password='$2y$10$XrueV1jzbCGJsJI9CsOGSehojBJDrlI54cmByZH5FAE5g6JG82xQe';
INSERT INTO users SET name='寺下渓志郎', email='keishiro@email.com', password='$2y$10$zrD1aLPbdLLkk./20egMDOH5i1OQTbuUrteDPBUnQ52aPmEwOcqq2';
INSERT INTO users SET name='小谷悠一', email='yuichi@email.com', password='$2y$10$zrD1aLPbdLLkk./20egMDOH5i1OQTbuUrteDPBUnQ52aPmEwOcqq2', role_id=2;
INSERT INTO users SET name='岩村潤', email='jun@email.com', password='$2y$10$zrD1aLPbdLLkk./20egMDOH5i1OQTbuUrteDPBUnQ52aPmEwOcqq2', role_id=2;

INSERT INTO events SET name='HarborSもくもく会vol.23', start_at='2022/08/01 12:00', end_at='2022/08/01 16:00';
INSERT INTO events SET name='Swift勉強会@HarborS #127', start_at='2022/08/02 11:00', end_at='2022/08/02 14:00';
INSERT INTO events SET name='みんなでRustを楽しもうの会!!', start_at='2022/09/010 10:00', end_at='2022/09/10 13:00';
INSERT INTO events SET name='みんなで夏を感じる納涼祭り@多摩川', start_at='2022/09/15 16:00', end_at='2022/09/15 21:00';
INSERT INTO events SET name='再び！Tower to Tower', start_at='2022/09/20 11:00', end_at='2022/09/20 18:00';
INSERT INTO events SET name='小谷さん集中講義~Nginx編~', start_at='2022/09/23 20:00', end_at='2022/09/23 22:00';
INSERT INTO events SET name='すーさんとフロント勉強会', start_at='2022/09/25 21:00', end_at='2022/09/25 23:00';
INSERT INTO events SET name='表参道カフェ巡りvol.3', start_at='2022/09/28 12:00', end_at='2022/09/28 15:00';
INSERT INTO events SET name='HarborSもくもく会vol.24', start_at='2022/09/30 13:00', end_at='2022/09/30 16:00';
INSERT INTO events SET name='オータム！紅葉狩り', start_at='2022/10/03 12:00', end_at='2022/10/03 17:00';
INSERT INTO events SET name='ぶらり浅草モーニング', start_at='2022/10/06 09:00', end_at='2022/10/06 12:00';
INSERT INTO events SET name='南青山定例ゴミ拾いもくもく会(10月)', start_at='2022/10/08 14:00', end_at='2022/10/08 16:00';
INSERT INTO events SET name='JavaScript勉強会#1533', start_at='2022/10/13 14:00', end_at='2022/10/13 17:00';
INSERT INTO events SET name='SQLで遊ぼう！', start_at='2022/10/19 20:00', end_at='2022/10/19 22:00';
INSERT INTO events SET name='LaravelでECサイトを作ろう@HarborS', start_at='2022/10/21 12:00', end_at='2022/10/21 18:00';
INSERT INTO events SET name='あなたは大丈夫？ゼロから始めるGit復習', start_at='2022/10/24 16:00', end_at='2022/10/24 19:00';
INSERT INTO events SET name='3期生と競う！JavaScriptゲーム制作大会', start_at='2022/10/28 12:00', end_at='2022/10/28 19:00';
INSERT INTO events SET name='JOBerと嗜むモダンJavaScript', start_at='2022/10/30 18:00', end_at='2022/10/30 22:00';
INSERT INTO events SET name='初心者向けCSSスタイリング講座', start_at='2022/11/05 18:00', end_at='2022/11/05 22:00';
INSERT INTO events SET name='南青山定例ゴミ拾いもくもく会(11月)', start_at='2022/11/07 14:00', end_at='2022/11/07 16:00';
INSERT INTO events SET name='arborSもくもく会vol.25', start_at='2022/11/10 13:00', end_at='2022/11/10 15:00';
INSERT INTO events SET name='JavaScript勉強会#1534', start_at='2022/11/19 12:00', end_at='2022/11/19 17:00';
INSERT INTO events SET name='Swift勉強会@HarborS #128', start_at='2022/11/23 15:00', end_at='2022/11/23 19:00';
INSERT INTO events SET name='Winter Hackathon 2022', start_at='2022/12/03 12:00', end_at='2022/12/06 20:00';
INSERT INTO events SET name='Next.jsであそぼ！', start_at='2022/12/12 12:00', end_at='2022/12/12 17:00';
INSERT INTO events SET name='あなたとGraphQL', start_at='2022/12/15 14:00', end_at='2022/12/15 18:00';
INSERT INTO events SET name='岩村さんとはじめるCakePHP', start_at='2022/12/18 18:00', end_at='2022/12/18 22:00';
INSERT INTO events SET name='小谷さん集中講義~クリスマスにDocker編~', start_at='2022/12/24 18:00', end_at='2022/12/25 12:00';
INSERT INTO events SET name='他人事じゃない！新春Webセキュリティ講座', start_at='2023/01/1 13:00', end_at='2023/01/01 16:00';
INSERT INTO events SET name='サルでもわかる世界史A', start_at='2023/01/05 15:00', end_at='2023/01/05 18:00';
INSERT INTO events SET name='線形代数もくもく会#38', start_at='2023/01/07 18:00', end_at='2023/01/07 22:00';
INSERT INTO events SET name='みんなのフランス語講座', start_at='2023/01/14 18:00', end_at='2023/01/14 20:00';
INSERT INTO events SET name='期末集中対策もくもく会2023冬', start_at='2023/01/16 14:00', end_at='2023/01/16 20:00';

INSERT INTO event_attendance SET event_id=1, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=1, user_id=2, status='presence';
INSERT INTO event_attendance SET event_id=1, user_id=3, status='absence';
INSERT INTO event_attendance SET event_id=1, user_id=4;
INSERT INTO event_attendance SET event_id=1, user_id=5, status='absence';
INSERT INTO event_attendance SET event_id=1, user_id=6;
INSERT INTO event_attendance SET event_id=2, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=2, user_id=2, status='absence';
INSERT INTO event_attendance SET event_id=2, user_id=3;
INSERT INTO event_attendance SET event_id=2, user_id=4, status='absence';
INSERT INTO event_attendance SET event_id=2, user_id=5, status='absence';
INSERT INTO event_attendance SET event_id=2, user_id=6;
INSERT INTO event_attendance SET event_id=3, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=3, user_id=2, status='absence';
INSERT INTO event_attendance SET event_id=3, user_id=3, status='presence';
INSERT INTO event_attendance SET event_id=3, user_id=4;
INSERT INTO event_attendance SET event_id=3, user_id=5, status='presence';
INSERT INTO event_attendance SET event_id=3, user_id=6, status='presence';
INSERT INTO event_attendance SET event_id=4, user_id=1, status='absence';
INSERT INTO event_attendance SET event_id=4, user_id=2;
INSERT INTO event_attendance SET event_id=4, user_id=3, status='absence';
INSERT INTO event_attendance SET event_id=4, user_id=4, status='absence';
INSERT INTO event_attendance SET event_id=4, user_id=5, status='absence';
INSERT INTO event_attendance SET event_id=4, user_id=6, status='absence';
INSERT INTO event_attendance SET event_id=5, user_id=1, status='absence';
INSERT INTO event_attendance SET event_id=5, user_id=2, status='absence';
INSERT INTO event_attendance SET event_id=5, user_id=3;
INSERT INTO event_attendance SET event_id=5, user_id=4;
INSERT INTO event_attendance SET event_id=5, user_id=5;
INSERT INTO event_attendance SET event_id=5, user_id=6;
INSERT INTO event_attendance SET event_id=6, user_id=1;
INSERT INTO event_attendance SET event_id=6, user_id=2;
INSERT INTO event_attendance SET event_id=6, user_id=3;
INSERT INTO event_attendance SET event_id=6, user_id=4;
INSERT INTO event_attendance SET event_id=6, user_id=5;
INSERT INTO event_attendance SET event_id=6, user_id=6;
INSERT INTO event_attendance SET event_id=7, user_id=1;
INSERT INTO event_attendance SET event_id=7, user_id=2;
INSERT INTO event_attendance SET event_id=7, user_id=3;
INSERT INTO event_attendance SET event_id=7, user_id=4;
INSERT INTO event_attendance SET event_id=7, user_id=5;
INSERT INTO event_attendance SET event_id=7, user_id=6;
INSERT INTO event_attendance SET event_id=8, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=8, user_id=2, status='presence';
INSERT INTO event_attendance SET event_id=8, user_id=3, status='presence';
INSERT INTO event_attendance SET event_id=8, user_id=4, status='presence';
INSERT INTO event_attendance SET event_id=8, user_id=5, status='presence';
INSERT INTO event_attendance SET event_id=8, user_id=6, status='presence';
INSERT INTO event_attendance SET event_id=9, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=9, user_id=2, status='presence';
INSERT INTO event_attendance SET event_id=9, user_id=3, status='presence';
INSERT INTO event_attendance SET event_id=9, user_id=4, status='presence';
INSERT INTO event_attendance SET event_id=9, user_id=5;
INSERT INTO event_attendance SET event_id=9, user_id=6;
INSERT INTO event_attendance SET event_id=10, user_id=1;
INSERT INTO event_attendance SET event_id=10, user_id=2;
INSERT INTO event_attendance SET event_id=10, user_id=3;
INSERT INTO event_attendance SET event_id=10, user_id=4;
INSERT INTO event_attendance SET event_id=10, user_id=5;
INSERT INTO event_attendance SET event_id=10, user_id=6;
INSERT INTO event_attendance SET event_id=11, user_id=1;
INSERT INTO event_attendance SET event_id=11, user_id=2;
INSERT INTO event_attendance SET event_id=11, user_id=3;
INSERT INTO event_attendance SET event_id=11, user_id=4;
INSERT INTO event_attendance SET event_id=11, user_id=5;
INSERT INTO event_attendance SET event_id=11, user_id=6;
INSERT INTO event_attendance SET event_id=12, user_id=1;
INSERT INTO event_attendance SET event_id=12, user_id=2;
INSERT INTO event_attendance SET event_id=12, user_id=3;
INSERT INTO event_attendance SET event_id=12, user_id=4;
INSERT INTO event_attendance SET event_id=12, user_id=5;
INSERT INTO event_attendance SET event_id=12, user_id=6;
INSERT INTO event_attendance SET event_id=13, user_id=1;
INSERT INTO event_attendance SET event_id=13, user_id=2;
INSERT INTO event_attendance SET event_id=13, user_id=3, status='absence';
INSERT INTO event_attendance SET event_id=13, user_id=4, status='absence';
INSERT INTO event_attendance SET event_id=13, user_id=5, status='absence';
INSERT INTO event_attendance SET event_id=13, user_id=6, status='absence';
INSERT INTO event_attendance SET event_id=14, user_id=1, status='absence';
INSERT INTO event_attendance SET event_id=14, user_id=2, status='absence';
INSERT INTO event_attendance SET event_id=14, user_id=3, status='absence';
INSERT INTO event_attendance SET event_id=14, user_id=4, status='absence';
INSERT INTO event_attendance SET event_id=14, user_id=5;
INSERT INTO event_attendance SET event_id=14, user_id=6;
INSERT INTO event_attendance SET event_id=15, user_id=1;
INSERT INTO event_attendance SET event_id=15, user_id=2;
INSERT INTO event_attendance SET event_id=15, user_id=3;
INSERT INTO event_attendance SET event_id=15, user_id=4;
INSERT INTO event_attendance SET event_id=15, user_id=5;
INSERT INTO event_attendance SET event_id=15, user_id=6;
INSERT INTO event_attendance SET event_id=16, user_id=1;
INSERT INTO event_attendance SET event_id=16, user_id=2;
INSERT INTO event_attendance SET event_id=16, user_id=3;
INSERT INTO event_attendance SET event_id=16, user_id=4;
INSERT INTO event_attendance SET event_id=16, user_id=5;
INSERT INTO event_attendance SET event_id=16, user_id=6, status='absence';
INSERT INTO event_attendance SET event_id=17, user_id=1, status='absence';
INSERT INTO event_attendance SET event_id=17, user_id=2, status='absence';
INSERT INTO event_attendance SET event_id=17, user_id=3, status='absence';
INSERT INTO event_attendance SET event_id=17, user_id=4, status='absence';
INSERT INTO event_attendance SET event_id=17, user_id=5, status='absence';
INSERT INTO event_attendance SET event_id=17, user_id=6, status='absence';
INSERT INTO event_attendance SET event_id=18, user_id=1, status='absence';
INSERT INTO event_attendance SET event_id=18, user_id=2, status='absence';
INSERT INTO event_attendance SET event_id=18, user_id=3, status='absence';
INSERT INTO event_attendance SET event_id=18, user_id=4, status='absence';
INSERT INTO event_attendance SET event_id=18, user_id=5, status='absence';
INSERT INTO event_attendance SET event_id=18, user_id=6;
INSERT INTO event_attendance SET event_id=19, user_id=1;
INSERT INTO event_attendance SET event_id=19, user_id=2;
INSERT INTO event_attendance SET event_id=19, user_id=3;
INSERT INTO event_attendance SET event_id=19, user_id=4;
INSERT INTO event_attendance SET event_id=19, user_id=5;
INSERT INTO event_attendance SET event_id=19, user_id=6;
INSERT INTO event_attendance SET event_id=20, user_id=1;
INSERT INTO event_attendance SET event_id=20, user_id=2;
INSERT INTO event_attendance SET event_id=20, user_id=3;
INSERT INTO event_attendance SET event_id=20, user_id=4;
INSERT INTO event_attendance SET event_id=20, user_id=5;
INSERT INTO event_attendance SET event_id=20, user_id=6;
INSERT INTO event_attendance SET event_id=21, user_id=1;
INSERT INTO event_attendance SET event_id=21, user_id=2;
INSERT INTO event_attendance SET event_id=21, user_id=3;
INSERT INTO event_attendance SET event_id=21, user_id=4;
INSERT INTO event_attendance SET event_id=21, user_id=5;
INSERT INTO event_attendance SET event_id=21, user_id=6;
INSERT INTO event_attendance SET event_id=22, user_id=1;
INSERT INTO event_attendance SET event_id=22, user_id=2;
INSERT INTO event_attendance SET event_id=22, user_id=3;
INSERT INTO event_attendance SET event_id=22, user_id=4;
INSERT INTO event_attendance SET event_id=22, user_id=5;
INSERT INTO event_attendance SET event_id=22, user_id=6;
INSERT INTO event_attendance SET event_id=23, user_id=1;
INSERT INTO event_attendance SET event_id=23, user_id=2;
INSERT INTO event_attendance SET event_id=23, user_id=3;
INSERT INTO event_attendance SET event_id=23, user_id=4;
INSERT INTO event_attendance SET event_id=23, user_id=5;
INSERT INTO event_attendance SET event_id=23, user_id=6;
INSERT INTO event_attendance SET event_id=24, user_id=1;
INSERT INTO event_attendance SET event_id=24, user_id=2;
INSERT INTO event_attendance SET event_id=24, user_id=3;
INSERT INTO event_attendance SET event_id=24, user_id=4;
INSERT INTO event_attendance SET event_id=24, user_id=5;
INSERT INTO event_attendance SET event_id=24, user_id=6;
INSERT INTO event_attendance SET event_id=25, user_id=1;
INSERT INTO event_attendance SET event_id=25, user_id=2;
INSERT INTO event_attendance SET event_id=25, user_id=3;
INSERT INTO event_attendance SET event_id=25, user_id=4;
INSERT INTO event_attendance SET event_id=25, user_id=5;
INSERT INTO event_attendance SET event_id=25, user_id=6;
INSERT INTO event_attendance SET event_id=26, user_id=1;
INSERT INTO event_attendance SET event_id=26, user_id=2;
INSERT INTO event_attendance SET event_id=26, user_id=3;
INSERT INTO event_attendance SET event_id=26, user_id=4;
INSERT INTO event_attendance SET event_id=26, user_id=5;
INSERT INTO event_attendance SET event_id=26, user_id=6;
INSERT INTO event_attendance SET event_id=27, user_id=1;
INSERT INTO event_attendance SET event_id=27, user_id=2;
INSERT INTO event_attendance SET event_id=27, user_id=3;
INSERT INTO event_attendance SET event_id=27, user_id=4;
INSERT INTO event_attendance SET event_id=27, user_id=5;
INSERT INTO event_attendance SET event_id=27, user_id=6;
INSERT INTO event_attendance SET event_id=28, user_id=1;
INSERT INTO event_attendance SET event_id=28, user_id=2;
INSERT INTO event_attendance SET event_id=28, user_id=3;
INSERT INTO event_attendance SET event_id=28, user_id=4;
INSERT INTO event_attendance SET event_id=28, user_id=5;
INSERT INTO event_attendance SET event_id=28, user_id=6;
INSERT INTO event_attendance SET event_id=29, user_id=1;
INSERT INTO event_attendance SET event_id=29, user_id=2;
INSERT INTO event_attendance SET event_id=29, user_id=3;
INSERT INTO event_attendance SET event_id=29, user_id=4;
INSERT INTO event_attendance SET event_id=29, user_id=5;
INSERT INTO event_attendance SET event_id=29, user_id=6;
INSERT INTO event_attendance SET event_id=30, user_id=1;
INSERT INTO event_attendance SET event_id=30, user_id=2;
INSERT INTO event_attendance SET event_id=30, user_id=3;
INSERT INTO event_attendance SET event_id=30, user_id=4;
INSERT INTO event_attendance SET event_id=30, user_id=5;
INSERT INTO event_attendance SET event_id=30, user_id=6, status='presence';
INSERT INTO event_attendance SET event_id=31, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=31, user_id=2, status='presence';
INSERT INTO event_attendance SET event_id=31, user_id=3, status='presence';
INSERT INTO event_attendance SET event_id=31, user_id=4, status='presence';
INSERT INTO event_attendance SET event_id=31, user_id=5, status='presence';
INSERT INTO event_attendance SET event_id=31, user_id=6, status='presence';
INSERT INTO event_attendance SET event_id=32, user_id=1, status='presence';
INSERT INTO event_attendance SET event_id=32, user_id=2, status='presence';
INSERT INTO event_attendance SET event_id=32, user_id=3;
INSERT INTO event_attendance SET event_id=32, user_id=4;
INSERT INTO event_attendance SET event_id=32, user_id=5;
INSERT INTO event_attendance SET event_id=32, user_id=6;
INSERT INTO event_attendance SET event_id=33, user_id=1;
INSERT INTO event_attendance SET event_id=33, user_id=2;
INSERT INTO event_attendance SET event_id=33, user_id=3;
INSERT INTO event_attendance SET event_id=33, user_id=4;
INSERT INTO event_attendance SET event_id=33, user_id=5;
INSERT INTO event_attendance SET event_id=33, user_id=6;
