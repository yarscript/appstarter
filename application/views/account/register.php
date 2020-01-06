<div class="content">
    <div class="registerRow">
        <div class="registerMenuWrap">
            <?php if ($err) { ?>
                <div class="alert alert-danger alert-dismissible" role="alert"><?php echo $err ?></div>
            <?php } ?>
            <form action="account/register" method="post" class="registerMenu">
                <h4>Register</h4>
                <hr class="line">
                <p>Entry your email
                    <label class="user_login">
                        <input type="email" name="email" class="registerInput">
                    </label>
                </p>
                <p>Entry your username
                    <label class="user_login">
                        <input type="text" name="username" class="registerInput">
                    </label>
                </p>
                <p>Entry your password
                    <label class="user_login">
                        <input type="text" name="password" class="registerInput">
                    </label>
                </p>
                <p>Confirm your password
                    <label class="user_login">
                        <input type="text" name="confirm" class="registerInput">
                    </label>
                </p>
                <hr class="line">
                <input type="submit" class="submit">
            </form>
        </div>
    </div>
</div>
