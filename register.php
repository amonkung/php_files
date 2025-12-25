<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ฟอร์มลงทะเบียน</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            padding: 20px;
            background: linear-gradient(135deg, #f0f4f8, #d9e4f5);
        }
        h2, h3 {
            text-align: center;
            color: #2c3e50;
        }
        form {
            background: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            max-width: 500px;
            margin: 20px auto;
        }
        label {
            font-weight: bold;
            color: #34495e;
        }
        input, select {
            margin-top: 5px;
            padding: 10px;
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 6px;
            box-sizing: border-box;
        }
        input[type="checkbox"], input[type="radio"] {
            width: auto;
            margin-right: 8px;
        }
        button {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 15px;
            transition: 0.3s;
        }
        button:hover {
            background: #2980b9;
        }
        table {
            border-collapse: collapse;
            margin: 30px auto;
            width: 90%;
            background: #fff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th {
            background: #3498db;
            color: white;
            padding: 12px;
        }
        td {
            padding: 10px;
            text-align: center;
        }
        tr:nth-child(even) {
            background: #f9f9f9;
        }
        tr:hover {
            background: #f1f1f1;
        }
        .success {
            text-align: center;
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <h2>ฟอร์มลงทะเบียน</h2>
    <form method="post">
        <label>ชื่อ-นามสกุล:</label><br>
        <input type="text" name="fullname" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>หัวข้ออบรม:</label><br>
        <select name="course">
            <option value="AI สำหรับสำนักงาน">AI สำหรับสำนักงาน</option>
            <option value="Excel สำหรับการทำงาน">Excel สำหรับการทำงาน</option>
            <option value="การเขียนเว็บด้วย PHP">การเขียนเว็บด้วย PHP</option>
        </select><br><br>

        <label>อาหารที่ต้องการ:</label><br>
        <input type="checkbox" name="food[]" value="ปกติ"> ปกติ
        <input type="checkbox" name="food[]" value="มังสวิรัติ"> มังสวิรัติ
        <input type="checkbox" name="food[]" value="ฮาลาล"> ฮาลาล
        <br><br>

        <label>รูปแบบการเข้าร่วม:</label><br>
        <input type="radio" name="type" value="Onsite"> Onsite
        <input type="radio" name="type" value="Online"> Online
        <br><br>

        <button type="submit" name="submit">ลงทะเบียน</button>
    </form>

    <?php
    if (isset($_POST['submit'])) {
        $fullname = $_POST['fullname']; 
        $email = $_POST['email']; 
        $course = $_POST['course']; 
        $type = $_POST['type'];

        // อาหาร (checkbox)
        if (isset($_POST['food'])) {
            $food = implode(", ", $_POST['food']);
        } else {
            $food = "ไม่ระบุ";
        }

        // ค่าลงทะเบียน
        $price = ($type == "Onsite") ? 1500 : 800;

        // บันทึกลงไฟล์
        $data = $fullname. "|". $email. "|".$course. "|" .$food."|" .$type. "|". $price. "\n";
        file_put_contents("register.txt", $data, FILE_APPEND);

        // แสดงผล
        echo "<div class='success'>ลงทะเบียนสำเร็จ!</div>";
        echo "<p style='text-align:center'>ชื่อ: $fullname <br>
              อีเมล: $email <br>
              หัวข้ออบรม: $course <br>
              อาหาร: $food <br>
              รูปแบบ: $type <br>
              ค่าลงทะเบียน: ".number_format($price, 2)." บาท</p>";
    }
    ?>

    <h3>รายชื่อผู้ลงทะเบียนทั้งหมด</h3>
    <?php
    if (file_exists("register.txt")) {
        $lines = file("register.txt");
        echo "<table>";
        echo "<tr>
                <th>ชื่อ-นามสกุล</th>
                <th>Email</th>
                <th>หัวข้ออบรม</th>
                <th>อาหาร</th>
                <th>รูปแบบ</th>
                <th>ค่าลงทะเบียน</th>
              </tr>";
        foreach ($lines as $line) {
            list($_name, $_email, $_course, $_food, $_type, $_price) = explode("|", trim($line));
            echo "<tr>
                    <td>$_name</td>
                    <td>$_email</td>
                    <td>$_course</td>
                    <td>$_food</td>
                    <td>$_type</td>
                    <td>".number_format($_price, 2)." บาท</td>
                  </tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
