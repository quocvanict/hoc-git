



<h1>Login</h1>
<form action="/api/login" method="post">
    <div>
        <p>Email</p>
        <input type="text" name="email" value="" />
    </div>
    <div>
        <p>Pass (default=123456)</p>
        <input type="text" name="password" value=""/>

    </div>

    <input type="submit" name="Submit" value="Login">
</form>

<hr style="margin: 30px 0;"/>
<h1>Logout</h1>
<form action="/api/logout" method="post">
    <div>
        <p>User Id</p>
        <input type="text" name="user_id" value="" />
    </div>
    <div>
        <p>login_token</p>
        <input type="text" name="token" value=""/>
    </div>

    <input type="submit" name="Submit" value="Logout">
</form>


<hr style="margin: 30px 0;"/>
<h1>Register</h1>
<form action="/api/register" method="post">
    <div>
        <select name="school_id">
            <option value="">--School--</option>

        <?php
            foreach($school_list as $_item){
                echo '<option value="'.$_item['School']['school_id'].'">'.$_item['School']['school_name'].'</option>';
//                print"<pre>";
//                print_r($_item);
//                die;

//                echo $_item['School']['school_name'];
            }
        ?>
        </select>

    </div>

    <div>
        Fullname
        <input type="text" name="name" value="Nguyen Van A" />
    </div>
    <div>
        Email
        <input type="text" name="email" value="demo@gmail.com" />
    </div>
    <div>
        DOB
        <input type="text" name="dob" value="2000-01-01" />
    </div>

    <div>
        Password
        <input type="text" name="password" value="123456" />
    </div>


    <input type="submit" name="Submit" value="Register">
</form>

<hr>
<pre>
    <h1>Danh sách user</h1>
<?php

print_r($results_user);
?>
<br/>
    <h1>Token đã login</h1>
<?php
echo "<hr>";

print_r($results_device);

?>