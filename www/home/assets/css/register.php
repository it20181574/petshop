<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">
      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="assets/css/styles.css">
      <title>Login form</title>
   </head>
   <body>
      <div class="login">
         <img src="assets/img/login-bg.jpg" alt="image" class="login__bg">
         <form method="post" action="register_process.php" class="login__form">
            <h1 class="login__title">Login</h1>

            <div class="login__inputs">

               <div class="login__box">
                  <input type="text" placeholder="Name" required class="login__input"  name="name" required>
                  <i class="ri-mail-fill"></i>
               </div>
               <div class="login__box">
                  <input type="email" placeholder="Email" required class="login__input"  name="email" required>
                  <i class="ri-mail-fill"></i>
               </div>
               <div class="login__box">
                  <input type="number" placeholder="Phone" required class="login__input"  name="phone" required>
                  <i class="ri-mail-fill"></i>
               </div>
               <div class="login__box">
                  <input type="password" placeholder="Password" required class="login__input"  name="password" required>
                  <i class="ri-mail-fill"></i>
               </div>
               <div class="login__box">
                  <input type="password" placeholder="Repeat Password" required class="login__input"  name="repeat_password" required>
                  <i class="ri-mail-fill"></i>
               </div>

            </div>
            <div class="login__check">
               <div class="login__check-box">
                  <input type="checkbox" class="login__check-input" id="user-check">
                  <label for="user-check" class="login__check-label">Remember me</label>
                </div>  
            </div>
            <button type="submit" class="login__button">Login</button>
            <div class="login__register">
               Already have an account? <a href="index.php">Login</a>
            </div>
         </form>
      </div>
   </body>
</html>


