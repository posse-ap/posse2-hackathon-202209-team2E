## ハッカソン202109

### ビルド

ディレクトリに移動して以下のコマンドを実行してください

```bash
docker-compose build --no-cache
docker-compose up -d
```

追加で以下を行なってください

```bash
docker-compose exec phpfpm bash
composer install
```

### 動作確認

ブラウザで `http://localhost` にアクセスして、正しく画面が表示されているか確認してください

### メール送信サンプルについて

メール送信
ブラウザで `http://localhost/mailtest.php` にアクセスしてください、テストメールが送信されます

メール受信
ブラウザで `http://localhost:8025/` にアクセスしてください、メールボックスが表示されます
