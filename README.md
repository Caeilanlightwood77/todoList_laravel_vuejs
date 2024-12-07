# 📝 To-Do List Application with Laravel and Vue.js

This is a **To-Do List Application** built using **Laravel** and **Vue.js**. It provides a simple yet powerful interface for managing tasks, with features like task creation, editing, deletion, marking tasks as completed, search, sorting, filtering, and dark mode.

## 🚀 **Features**

- ✅ **Add Tasks**: Quickly add new tasks to your list.
- ✏️ **Edit Tasks**: Update task titles inline.
- ❌ **Delete Tasks**: Delete tasks with a confirmation modal for safety.
- 🎯 **Mark as Completed**: Mark tasks as completed or pending with a single click.
- 🔍 **Search**: Search tasks by title.
- 🔄 **Sort**: Sort tasks:
  - A-Z
  - Z-A
  - Newest First
  - Oldest First
- 🗂️ **Filter**: Filter tasks by:
  - All Tasks
  - Completed Tasks
  - Pending Tasks
- 🌗 **Dark Mode**: Toggle between dark and light mode for a better user experience.
- 🔒 **Authentication**: Secure user authentication with Google OAuth (if implemented).

## 🛠️ **Tech Stack**

- **Frontend**: Vue.js, Vuetify, Axios
- **Backend**: Laravel
- **Database**: PostgreSQL (or any other supported by Laravel)
- **Version Control**: Git and GitHub

## 📥 **Installation**

Follow these steps to set up the project locally:

### 1. **Clone the Repository**

```bash
git clone https://github.com/Caeilanlightwood77/todoList_laravel_vuejs.git
cd todoList_laravel_vuejs
```

### 2. **Install Dependencies**

#### Backend (Laravel)

```bash
composer install
```

#### Frontend (Vue.js)

```bash
npm install
```

### 3. **Set Up Environment Variables**

Copy the `.env.example` file to create a `.env` file:

```bash
cp .env.example .env
```

Update the `.env` file with your database configurations:

```plaintext
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### 4. **Generate Application Key**

```bash
php artisan key:generate
```

### 5. **Run Database Migrations**

```bash
php artisan migrate
```

### 6. **Run the Development Servers**

#### Start the Backend Server

```bash
php artisan serve
```

#### Start the Frontend Server

```bash
npm run dev
```

The application should now be accessible at: [http://127.0.0.1:8000](http://127.0.0.1:8000)

---

## ✅ **Available API Endpoints**

| **Method** | **Endpoint**      | **Description**             |
|------------|-------------------|-----------------------------|
| `GET`     | `/api/tasks`      | Fetch all tasks             |
| `POST`    | `/api/tasks`      | Create a new task           |
| `PUT`     | `/api/tasks/{id}` | Update a task (title/status)|
| `DELETE`  | `/api/tasks/{id}` | Delete a task               |

---

## 📝 **Contributing**

Contributions are welcome! To contribute:

1. Fork the repository.
2. Create a new branch:

   ```bash
   git checkout -b feature/YourFeature
   ```

3. Commit your changes:

   ```bash
   git commit -m "Add new feature"
   ```

4. Push to the branch:

   ```bash
   git push origin feature/YourFeature
   ```

5. Submit a pull request.

---

## 🛡️ **License**

This project is licensed under the **MIT License**.

---

## 📬 **Contact**

For questions or feedback, feel free to reach out:

- **GitHub**: [Caeilanlightwood77](https://github.com/Caeilanlightwood77)

---

## 🔗 **Useful Links**

- **Laravel Documentation**: [https://laravel.com/docs](https://laravel.com/docs)  
- **Vue.js Documentation**: [https://vuejs.org](https://vuejs.org)

---
