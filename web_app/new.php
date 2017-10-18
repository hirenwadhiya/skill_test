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
    </ul>
    <input type="submit" value="Create">
</form>

<?php

if ($_POST) {
    $dbConnection = mysql_connect("localhost", "root");
    mysql_select_db("test");

    $sql = "insert into employee (`name`, `phone_number`, `email`, `type`) VALUES ('" .
        mysql_escape_string($_POST['name']) . "', '" . mysql_escape_string($_POST['phone_number']) . "', '" . mysql_escape_string($_POST['email']) . "', '" . mysql_escape_string($_POST['employee_type']) . "')";
    $result = mysql_query($sql);

    if (!$result) {
        die("<h2>Sorry could not add employee: " . mysql_error(). "</h2>" );

    }

    $timestamp = date("d/m/y h:i:s");
    $sql = "insert into audit_log (`message`) VALUES ('{$_POST['name']} was added on $timestamp')";
    mysql_query($sql);

    $uniq = $_POST['password'];
    mail($_POST['email'], "Thanks for registering", "Dear " . $_POST['name'] . ",\nThanks for registering with AwesomeCorp!! your password is $uniq.\nYou can login at: http://www.awesomecorp.com/login.\nRegards,\nAwesomeCorp");


    $sql = "select max(id) from employee";
    $row = mysql_fetch_row(mysql_query($sql));
    $id = $row[0];
    $_SESSION["logged_in_user_id"] = $id;

    $sql = "update employee set password = '".sha1($uniq)."', email_sent = 1 where id = $id";
    mysql_query($sql);
    $newURL= "dashboard.php";
    header('Location: '.$newURL);
}



