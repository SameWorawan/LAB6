<?php
$summary = "";

if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $email    = $_POST['email'];
    $course   = $_POST['course'];
    $type     = $_POST['type'];

    if (isset($_POST['food'])) {
        $food = implode(", ", $_POST['food']);
    } else {
        $food = "ไม่ระบุ";
    }

    $price = ($type == "Onsite") ? 1500 : 800;

    $data = $fullname . "|" . $email . "|" . $course . "|" . $food . "|" . $type . "|" . $price . "\n";
    file_put_contents("register.txt", $data, FILE_APPEND);

    $summary  = "<div class='card success'>";
    $summary .= "<h3>✔ ลงทะเบียนสำเร็จ</h3>";
    $summary .= "<p>ชื่อ: $fullname<br>";
    $summary .= "อีเมล: $email<br>";
    $summary .= "หัวข้ออบรม: $course<br>";
    $summary .= "อาหาร: $food<br>";
    $summary .= "รูปแบบ: $type<br>";
    $summary .= "ค่าลงทะเบียน: <b>" . number_format($price, 2) . " บาท</b></p>";
    $summary .= "</div>";
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="UTF-8">
<title>ฟอร์มลงทะเบียนอบรม</title>

<style>
:root{
  --bg:#05070d;
  --panel:#0b1220;
  --neon:#00f5ff;
  --neon2:#ff00c8;
  --text:#e8f6ff;
  --soft:#9ab4c4;
  --line:rgba(0,245,255,.25);
}
*{box-sizing:border-box;font-family:system-ui,Segoe UI,Tahoma,sans-serif}
body{
  margin:0;min-height:100vh;
  background:radial-gradient(120% 80% at 50% -10%,#101b33 0%,#05070d 60%);
  color:var(--text);
  display:flex;justify-content:center;align-items:flex-start;
  padding:32px;
}
.container{
  width:100%;max-width:900px;
  display:grid;gap:20px;
}
h2,h3{letter-spacing:.5px}
.card{
  background:linear-gradient(145deg,#0d1528 0%,#070a12 100%);
  border:2px solid var(--line);
  border-radius:18px;
  padding:22px 20px;
  box-shadow:0 0 22px rgba(0,245,255,.15), inset 0 0 12px rgba(255,0,200,.12);
}
.card.success{
  border-color:rgba(0,255,130,.4);
  box-shadow:0 0 22px rgba(0,255,130,.18);
}
label{font-size:14px;color:var(--soft)}
input,select{
  width:100%;padding:9px 10px;margin-top:6px;
  border-radius:10px;border:1px solid var(--line);
  background:#0c1221;color:var(--text);
}
input[type="checkbox"],input[type="radio"]{width:auto;margin-right:6px}
button{
  margin-top:10px;
  background:linear-gradient(120deg,var(--neon),var(--neon2));
  border:none;border-radius:10px;
  padding:10px 16px;
  color:#021014;font-weight:600;cursor:pointer;
  box-shadow:0 0 14px rgba(0,245,255,.5);
}
button:hover{filter:brightness(1.1)}
table{
  width:100%;margin-top:10px;
  border-collapse:collapse;
  color:var(--text);
}
th,td{
  padding:8px 10px;border:1px solid var(--line);font-size:13px;
}
th{background:#0f1a2f}
.section-title{
  color:var(--neon);text-shadow:0 0 10px rgba(0,245,255,.7);
}
</style>
</head>

<body>
<div class="container">

<div class="card">
  <h2 class="section-title">ฟอร์มลงทะเบียนอบรม</h2>

  <form method="post" action="">
    <label>ชื่อ-นามสกุล</label>
    <input type="text" name="fullname" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>หัวข้ออบรม</label>
    <select name="course">
      <option value="AI สำหรับงานสำนักงาน">AI สำหรับงานสำนักงาน</option>
      <option value="Excel สำหรับการทำงาน">Excel สำหรับการทำงาน</option>
      <option value="การเขียนเว็บด้วย PHP">การเขียนเว็บด้วย PHP</option>
    </select>

    <label>อาหารที่ต้องการ</label><br>
    <label><input type="checkbox" name="food[]" value="ปกติ">ปกติ</label>
    <label><input type="checkbox" name="food[]" value="มังสวิรัติ">มังสวิรัติ</label>
    <label><input type="checkbox" name="food[]" value="ฮาลาล">ฮาลาล</label><br>

    <label>รูปแบบการเข้าร่วม</label><br>
    <label><input type="radio" name="type" value="Onsite" required>Onsite</label>
    <label><input type="radio" name="type" value="Online">Online</label><br>

    <button type="submit" name="submit">ลงทะเบียน</button>
  </form>
</div>

<?php if ($summary) echo $summary; ?>

<div class="card">
  <h3 class="section-title">รายชื่อผู้ลงทะเบียนทั้งหมด</h3>

<?php
if (file_exists("register.txt")) {
    $lines = file("register.txt");

    if (count($lines) > 0) {
        echo "<table>";
        echo "<tr>
                <th>ชื่อ</th>
                <th>Email</th>
                <th>หัวข้อ</th>
                <th>อาหาร</th>
                <th>รูปแบบ</th>
                <th>ค่าลงทะเบียน</th>
              </tr>";

        foreach ($lines as $line) {
            list($_name,$_email,$_course,$_food,$_type,$_price)=explode("|",trim($line));

            echo "<tr>
                    <td>$_name</td>
                    <td>$_email</td>
                    <td>$_course</td>
                    <td>$_food</td>
                    <td>$_type</td>
                    <td>" . number_format($_price,2) . "</td>
                  </tr>";
        }
        echo "</table>";
    } else echo "ยังไม่มีผู้ลงทะเบียน";
} else echo "ยังไม่มีไฟล์ข้อมูลการลงทะเบียน (register.txt)";
?>
</div>

</div>
</body>
</html>
