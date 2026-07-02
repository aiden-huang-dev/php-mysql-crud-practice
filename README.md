# PHP / MySQL CRUD 留言板練習專案

這是一個 PHP / MySQL CRUD 留言板練習專案，主要用於練習基本網站後端流程、會員登入狀態、資料庫操作與圖片上傳處理。

本專案定位為基礎練習作品，並非正式上線系統。

## 專案功能

### 留言板功能

* 留言列表顯示
* 新增留言
* 修改留言
* 刪除留言
* 表單欄位處理
* checkbox 多選資料處理
* 圖片上傳與顯示

### 會員功能

* 使用者註冊
* 使用者登入
* 使用者登出
* Session 登入狀態判斷
* 限制新增、修改、刪除功能需登入後操作

### 資料庫操作

* 使用 MySQL 儲存留言與會員資料
* 使用 mysqli 連接資料庫
* 使用 prepared statement 處理新增、修改、刪除、查詢
* 匯出 `practise.sql` 作為資料表架構檔

### 基本安全處理

* 使用 `password_hash()` 儲存密碼
* 使用 `password_verify()` 驗證登入密碼
* 使用 `htmlspecialchars()` 處理輸出轉義
* 使用 POST 處理刪除動作
* 圖片上傳限制副檔名與檔案大小

### 圖片上傳處理

* 支援 jpg、jpeg、png、gif、webp
* 限制檔案大小
* 自動建立 uploads 資料夾
* 使用隨機檔名避免檔名衝突
* uploads 資料夾已清空，不包含測試圖片

## 使用技術

* PHP
* MySQL
* mysqli
* HTML
* Session
* phpMyAdmin 匯出 SQL 架構

## 專案結構

```text
practise/
├── add.php
├── auth.php
├── db.php
├── delete.php
├── edit.php
├── helpers.php
├── index.php
├── login.php
├── logout.php
├── register.php
├── practise.sql
└── uploads/
```

## 檔案說明

| 檔案             | 說明                 |
| -------------- | ------------------ |
| `index.php`    | 留言列表首頁，依登入狀態顯示不同操作 |
| `add.php`      | 新增留言               |
| `edit.php`     | 修改留言               |
| `delete.php`   | 刪除留言               |
| `register.php` | 使用者註冊              |
| `login.php`    | 使用者登入              |
| `logout.php`   | 使用者登出              |
| `auth.php`     | Session 與登入狀態檢查    |
| `db.php`       | 資料庫連線設定            |
| `helpers.php`  | 輸出轉義與圖片上傳函式        |
| `practise.sql` | 資料庫結構匯出檔           |
| `uploads/`     | 圖片上傳資料夾，目前不包含測試圖片  |

## 資料庫說明

本專案提供 `practise.sql`，內容保留資料表架構，測試資料已清空。

資料表包含：

* `board`：留言資料表
* `board_users`：會員資料表

匯入方式：

1. 建立 MySQL 資料庫，例如 `practise`
2. 匯入 `practise.sql`
3. 修改 `db.php` 中的資料庫連線資訊
4. 啟動 PHP 本機環境後進入 `index.php`

## 練習重點

這個專案主要用來練習以下內容：

* PHP 基本流程
* 表單送出與後端接收
* MySQL 資料新增、查詢、修改、刪除
* Session 登入狀態判斷
* 會員註冊與登入驗證
* prepared statement 基本使用
* 密碼雜湊與驗證
* 輸出轉義
* 圖片上傳處理
* 基礎後台操作流程

## 專案定位

此專案為 PHP / MySQL CRUD 基礎練習，主要目的是熟悉網站表單、後端接收、資料庫寫入、會員登入、圖片上傳與基本安全處理。

目前仍屬於學習階段作品，未包含完整權限控管、完整錯誤處理、前端版面設計或正式部署設定。
