

<div class="container">
    <div class="forgot_box">
        <h1>Create new password</h1>
        <form action="" method="post">
            @csrf
            <input type="hidden" name="token" value="{{$token}}">
            <label class="my_label">Email</label>
            <input type="email" name='email' class="forgot_input mt-5">
            <label class="my_label">Old Password</label>
            <input type="password" name='password' class="forgot_input mt-5">
            <label class="my_label">New Password</label>
            <input type="password" name='confirm-password' class="forgot_input mt-5">
            <a href="#" class="reset_button"><b>Reset</b></a>
        </form>
    </div>
</div>
