# 🎒 **Adventures Budget App**

Welcome to the **Adventures Budget App** – your ultimate tool for planning epic adventures with friends! 🌍 Let's get ready to organize, budget, and have fun! 🎉

## ✨ **Features at a Glance**

- **📅 Yearly Budgets**: Manage your annual budget, split into 4 easy sections.
- **🛶 Adventure Management**: Add, update, and track your adventures with detailed info like order numbers, providers, coordinators, participant counts, and costs.
- **💰 Budget Overview**: Keep an eye on your capital, balance, and overall financial health.
- **✔️ Approval System**: Approve or disapprove adventures, update real prices, and ensure everything's on track.
- **🔄 Real-Time Updates**: Everything stays up-to-date as you plan!

## 🚀 **Quick Setup**

### 1️⃣ **Migrations**

Get your database ready to roll:

- **Create Migration**:
  ```bash
  php bin/console migrations:diff
  ```
- **Apply Migrations**:
  ```bash
  php bin/console migrations:migrate
  ```
- **Roll Back**:
  ```bash
  php bin/console migrations:migrate prev
  ```
- **Load Sample Data**:
  ```bash
  php bin/console doctrine:fixtures:load
  ```

### 2️⃣ **First Installation**

1. **Build & Run**: 🚧
   ```bash
   docker-compose up --build
   ```
2. **Configure Env Variables**: 🔧
   Create a `local.neon` file and add:
   ```yaml
   doctrine:
       host: your_db_host
       user: your_db_user
       password: your_db_password
       dbname: your_db_name
   ```

### 3️⃣ **Launch** 🚀

- **Start the App**: 🖥️
  ```bash
  docker-compose up -d
  ```
  *(The `-d` flag keeps it running quietly in the background, no spamming logs!)*

### 4️⃣ **Permissions** 🔒

Make sure your `temp` and `log` directories are writable:
```bash
chmod -R 777 ./temp
chmod -R 777 ./log
```

### 🛠️ **Handy Docker Commands**

- **Jump into Docker**: 🐳
  ```bash
  docker-compose exec www /bin/bash
  ```

### 🎨 **Code Quality Tools**

- **PHP CS Fixer**: ✨
  ```bash
  docker-compose exec www /bin/bash
  php vendor/bin/php-cs-fixer fix app
  ```
- **Psalm**: 🧐
  ```bash
  php vendor/bin/psalm
  ```

### 🧹 **Clear the Cache**

- **Quick Cache Clear**: 🧼
  ```bash
  php bin/clearcache
  ```

## 📝 **Final Notes**

This app is all about planning fun adventures with friends while keeping an eye on the cost! 🏞️💸

Happy adventuring! 🎒✨

---

*Fun fact: 🤖 ChatGPT added emojis to this README! 🎉 Thanks to ChatGPT for the help! 🙌*