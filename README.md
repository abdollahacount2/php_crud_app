# Task Manager CRUD Application

A complete multi-page CRUD (Create, Read, Update, Delete) application built with PHP, JavaScript, and MySQL.

## 📁 Project Structure

```
crud-app/
│
├── config.php              # Database configuration and helper functions
├── header.php              # Header template with navigation
├── footer.php              # Footer template
│
├── index.php               # Home page with statistics
├── create.php              # Create new task page
├── list.php                # List all tasks with filters
├── view.php                # View task details
├── edit.php                # Edit task page
├── delete.php              # Delete task handler
│
├── database.sql            # Database setup script
│
└── assets/
    ├── css/
    │   └── style.css       # Main stylesheet
    └── js/
        └── script.js       # JavaScript functions
```

## 🚀 Features

- ✅ **Create** - Add new tasks with title, description, and status
- ✅ **Read** - View all tasks with filtering and sorting options
- ✅ **Update** - Edit existing tasks
- ✅ **Delete** - Remove tasks with confirmation
- 📊 **Dashboard** - View statistics (total, pending, completed tasks)
- 🎨 **Modern UI** - Clean, responsive design with gradient themes
- 🔍 **Filtering** - Filter by status (all, pending, completed)
- 📑 **Sorting** - Sort by date, title, or status
- ⚡ **Fast Navigation** - Multi-page architecture with smooth transitions
- 📱 **Responsive** - Works on desktop, tablet, and mobile devices

## 📋 Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher (or MariaDB)
- Apache/Nginx web server
- phpMyAdmin (optional, for easier database management)

## 🛠️ Installation

### Step 1: Setup Web Server

**For XAMPP:**
1. Download and install [XAMPP](https://www.apachefriends.org/)
2. Start Apache and MySQL services
3. Navigate to `C:\xampp\htdocs\` (Windows) or `/opt/lampp/htdocs/` (Linux)

**For WAMP:**
1. Download and install [WAMP](https://www.wampserver.com/)
2. Start services
3. Navigate to `C:\wamp64\www\`

### Step 2: Create Project Directory

1. Create a folder named `crud-app` in your web server directory
2. Copy all project files into this folder

### Step 3: Setup Database

**Option 1: Using phpMyAdmin**
1. Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)
2. Click "SQL" tab
3. Copy and paste the contents of `database.sql`
4. Click "Go" to execute

**Option 2: Using MySQL Command Line**
```bash
mysql -u root -p < database.sql
```

### Step 4: Configure Database Connection

1. Open `config.php`
2. Update database credentials if needed:

```php
define('DB_HOST', 'localhost');
define('DB_NAME', 'crud_app');
define('DB_USER', 'root');        // Change if different
define('DB_PASS', '');            // Add your password
```

### Step 5: Create Assets Directory

Create the following directory structure:
```
crud-app/
└── assets/
    ├── css/
    │   └── style.css
    └── js/
        └── script.js
```

Copy the CSS and JavaScript files to their respective directories.

### Step 6: Access Application

Open your web browser and navigate to:
```
http://localhost/crud-app/index.php
```

## 📖 Usage Guide

### Home Page (index.php)
- View dashboard with task statistics
- See recent tasks
- Quick access to create and view tasks

### Create Task (create.php)
- Fill in task title (required)
- Add optional description
- Select status (pending/completed)
- Click "Create Task" to save

### List All Tasks (list.php)
- View all tasks in grid layout
- Filter by status (all/pending/completed)
- Sort by date, title, or status
- Choose ascending or descending order
- Quick actions: View, Edit, Delete

### View Task (view.php)
- See complete task details
- View creation and update timestamps
- Edit or delete from this page

### Edit Task (edit.php)
- Modify task title and description
- Change task status
- Update or cancel changes
- Delete task option

## 🎨 Customization

### Changing Colors

Edit `assets/css/style.css`:

```css
/* Main gradient */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Change to your colors */
background: linear-gradient(135deg, #YOUR_COLOR1 0%, #YOUR_COLOR2 100%);
```

### Adding New Fields

1. Add column to database:
```sql
ALTER TABLE tasks ADD COLUMN priority VARCHAR(20) DEFAULT 'medium';
```

2. Update forms (create.php, edit.php):
```php
<div class="form-group">
    <label for="priority">Priority</label>
    <select id="priority" name="priority">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>
</div>
```

3. Update INSERT/UPDATE queries in respective files

## 🔒 Security Features

- ✅ PDO with prepared statements (SQL injection prevention)
- ✅ Password protection for database
- ✅ HTML escaping for output (XSS prevention)
- ✅ Form validation (client and server-side)
- ✅ Session-based flash messages

## 🐛 Troubleshooting

### Database Connection Error
- Check MySQL/MariaDB service is running
- Verify credentials in `config.php`
- Ensure database `crud_app` exists

### Page Not Found
- Check file permissions (755 for directories, 644 for files)
- Verify web server is running
- Check correct URL path

### CSS Not Loading
- Verify `assets/css/style.css` exists
- Check file path in `header.php`
- Clear browser cache

### JavaScript Not Working
- Verify `assets/js/script.js` exists
- Check browser console for errors
- Ensure file path in `footer.php` is correct

## 📝 License

This project is open source and available for educational purposes.

## 👨‍💻 Author

Created as a demonstration of CRUD operations with PHP and JavaScript.

## 🤝 Contributing

Feel free to fork this project and customize it for your needs!

---

**Enjoy building with this CRUD application! 🚀**
