# フリマアプリ

## 📌 プロジェクトの概要

本アプリは、LaravelおよびDockerを使用して構築されたフリマアプリケーションです。  
ユーザー登録・商品出品・購入・コメント・いいね・カテゴリ検索などの基本的なフリマ機能を備えています。

---

## 🛠 使用技術

- PHP 8.x
- Laravel 8.x
- MySQL 8.0
- Docker / Docker Compose
- Mailhog（メール認証確認用）
- GitHub（バージョン管理）

---

## ⚙️ 環境構築手順（Docker使用）

1. **リポジトリをクローン**

```bash
git clone https://github.com/your-username/your-repo-name.git
cd your-repo-name

##Docker コンテナの起動
docker-compose up -d --build

##Laravel の初期設定
# Laravelの依存インストール
docker-compose exec app composer install

# 環境ファイルをコピー
cp .env.example .env

# アプリケーションキーの生成
docker-compose exec app php artisan key:generate

# 権限の変更
sudo chmod -R 777 storage bootstrap/cache

# マイグレーションとシーディング
docker-compose exec app php artisan migrate:fresh --seed

4.	メール認証確認（Mailhog）

	•	Mailhog: http://localhost:8025

📁 主な機能
	•	ユーザー登録・ログイン（メール認証あり）
	•	プロフィール登録（初回ログイン時に設定）
	•	商品一覧・詳細・出品・編集・削除
	•	商品カテゴリ設定（多対多）
	•	コメント投稿・閲覧
	•	いいね機能（お気に入り）
	•	商品購入処理（SOLD 表示付き）
	•	配送先設定と支払い方法選択（Stripe連携を予定）
	•	管理者機能（ユーザー/商品一覧）

📌 その他
	•	画像アップロードは storage/app/public/products/ に保存され、php artisan storage:link により公開。
	•	.env や .env.example にて環境変数設定を行ってください。
	•	エラー時は docker-compose logs を確認することでデバッグ可能。

##ER図
📄 [ER図（PDF）はこちら](https://github.com/hinaga-rena/furima-app/raw/main/src/docs/er_diagram.pdf)
