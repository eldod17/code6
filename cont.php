<?php
session_start();

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] != 'admin') {
    header("Location: login.php");
    exit;
}

// الاتصال بقاعدة البيانات
$conn = new mysqli("localhost", "root", "", "educational_platform");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// إضافة أو حذف إذن الوصول
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST["user_id"];
    $lesson_id = $_POST["lesson_id"];
    $action = $_POST["action"];

    if ($action == "allow") {
        $conn->query("INSERT INTO lessons_access (user_id, lesson_id, access_allowed) VALUES ($user_id, $lesson_id, TRUE) ON DUPLICATE KEY UPDATE access_allowed = TRUE");
    } elseif ($action == "deny") {
        $conn->query("UPDATE lessons_access SET access_allowed = FALSE WHERE user_id = $user_id AND lesson_id = $lesson_id");
    }
}

// استعراض المستخدمين والدروس
$users = $conn->query("SELECT id, username FROM users2");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>

    <h3>Manage Lesson Access</h3>
    <form method="post">
        <label for="user_id">Select User:</label>
        <select id="user_id" name="user_id">
            <?php while ($user = $users->fetch_assoc()) { ?>
                <option value="<?php echo $user['id']; ?>"><?php echo $user['username']; ?></option>
            <?php } ?>
        </select><br><br>

        <label for="lesson_id">Lesson ID:</label>
        <input type="text" id="lesson_id" name="lesson_id" required><br><br>

        <button type="submit" name="action" value="allow">Allow Access</button>
        <button type="submit" name="action" value="deny">Deny Access</button>
    </form>

    <br>
    <a href="logout.php">Logout</a>
</body>
</html>
