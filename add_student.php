<?php
// إعدادات قاعدة البيانات
$dbhost = "localhost";
$dbname = "educational_platform";
$dbuser = "root";
$dbpass = "";

// إنشاء الاتصال
$conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);

// التحقق من الاتصال
if ($conn->connect_error) {
    die("فشل الاتصال: " . $conn->connect_error);
}

// التحقق من إرسال النموذج
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];

    // حذف الطالب
    $deleteQuery = "DELETE FROM users2 WHERE username = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $username);

    if ($stmt->execute()) {
        echo "<script>alert('تم حذف الطالب بنجاح!'); window.location.href = 'index.php';</script>";
    } else {
        echo "خطأ في حذف الطالب: " . $stmt->error;
    }

    $stmt->close();
}

// إغلاق الاتصال
$conn->close();
?>
