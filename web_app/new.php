<?php
require '../connection.php';
$connection = connect();
$sql = "select * from genders";
global $genders;
$genders = $connection->query($sql);

if ($_POST) {
    $name = '"' . $connection->real_escape_string($_POST['name']) . '"';
    $phone_number = '"' . $connection->real_escape_string($_POST['phone_number']) . '"';
    $email = '"' . $connection->real_escape_string($_POST['email']) . '"';
    $employee_type = '"' . $connection->real_escape_string($_POST['employee_type']) . '"';
    $gender = (int)$connection->real_escape_string($_POST['gender']);

    $sql = "insert into employee (`name`, `phone_number`, `email`, `type`, `gender_id`) VALUES ($name, $phone_number, $email, $employee_type, $gender)";
    $result = $connection->query($sql);

    if (!$result) {
        die("<h2>Sorry could not add employee: " . mysqli_error($connection). "</h2>" );

    }

    $timestamp = date("d/m/y h:i:s");
    $sql = "insert into audit_log (`message`) VALUES ('{$_POST['name']} was added on $timestamp')";
    $connection->query($sql);

    $uniq = $_POST['password'];
    mail($_POST['email'], "Thanks for registering", "Dear " . $_POST['name'] . ",\nThanks for registering with AwesomeCorp!! your password is $uniq.\nYou can login at: http://www.awesomecorp.com/login.\nRegards,\nAwesomeCorp");


    $sql = "select max(id) from employee";
    $row = mysqli_fetch_row($connection->query($sql));
    $id = $row[0];
    $_SESSION["logged_in_user_id"] = $id;

    $sql = "update employee set password = '".sha1($uniq)."', email_sent = 1 where id = $id";

    $connection->query($sql);
    $newURL= "dashboard.php";
    header('Location: '.$newURL);
}
?>

<h1>Create New Employee</h1>
<form action="" method="post">
    <ul>
        <li>
            Employee Name:
            <input name="name" type="text" />
        </li>
        <li>
            Phone Number:
            <input name="phone_number" type="text"/>
        </li>
        <li>
            Password:
            <input name="password" type="password" />
        </li>
        <li>
            Email:
            <input name="email" type="text"/>
        </li>
        <li>
            Employee Type:
            <select name="employee_type">
                <option value="1">Part Time</option>
                <option value="2">Full Time</option>
            </select>
        </li>
        <li>

            Gender:
            <select name="gender">
                <?php
                foreach ($genders as $gender) {
                    echo "<option value=". $gender["id"] .">".$gender["name"]."</option>";
                }
                ?>
            </select>
        </li>
    </ul>
    <input type="submit" value="Create">
</form>
