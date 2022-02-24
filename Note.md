# 目錄
+ [Laravel基礎用法](#laravel基礎用法)
  + [建立專案](#建立專案)
  + [查詢laravel版本](#查詢laravel版本)
  + [啟動網站伺服器](#啟動網站伺服器)

# Laravel基礎用法

## 建立專案

+ 方法1.透過Laravel安裝工具
  ```bash
  # 安裝laravel安裝工具套件
  composer global require "laravel/installer"
  # 建立laravel專案
  laravel new projectName
  ```

+ 方法2.透過composer下載laravel專案
  ```bash
  # 建立最新版的laravel模板
  composer create-project --prefer-dist laravel/laravel projectName
  # 建立特定版本的laravel
  composer create-project laravel/laravel projectName --prefer-dist "8.*"
  ```

## 查詢laravel版本
```bash
php artisan -V
> Laravel Framework 8.83.0
```

## 啟動網站伺服器
```bash
# 預設ip與port(127.0.0.1:8000)
php artisan serve

# 指定ip與port
php artisan serve --host 140.124.39.131 --port=8080
```
