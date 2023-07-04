<!DOCTYPE html>
<html>

<head>
    <!-- Standard Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.css" integrity="sha512-KXol4x3sVoO+8ZsWPFI/r5KBVB/ssCGB5tsv2nVOKwLg33wTFP3fmnXa47FdSVIshVTgsYk/1734xSk9aFIa4A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.5.0/semantic.min.js" integrity="sha512-Xo0Jh8MsOn72LGV8kU5LsclG7SUzJsWGhXbWcYs2MAmChkQzwiW/yTQwdJ8w6UA9C6EVG18GHb/TrYpYCjyAQw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style type="text/css">
        body {
            background-color: #DADADA;
        }

        body>.grid {
            height: 100%;
        }

        .image {
            margin-top: -100px;
        }

        .column {
            max-width: 450px;
        }
    </style>
    <script>
        $(document)
            .ready(function() {
                $('.ui.form')
                    .form({
                        fields: {
                            email: {
                                identifier: 'email',
                                rules: [{
                                        type: 'empty',
                                        prompt: 'Please enter your e-mail'
                                    },
                                    {
                                        type: 'email',
                                        prompt: 'Please enter a valid e-mail'
                                    }
                                ]
                            },
                            password: {
                                identifier: 'password',
                                rules: [{
                                        type: 'empty',
                                        prompt: 'Please enter your password'
                                    },
                                    {
                                        type: 'length[6]',
                                        prompt: 'Your password must be at least 6 characters'
                                    }
                                ]
                            }
                        }
                    });
            });
    </script>
</head>

<body>

    <div class="ui middle aligned center aligned grid">
        <div class="column">
            <h2 class="ui teal image header">
                <div class="content">
                    Register your account
                </div>
            </h2>
            <?php if (isset($_SESSION["alert"]["message"])) { ?>
    <div class="ui negative message">
      <i class="close icon"></i>
      <div class="header">
        <?= $_SESSION["alert"]["message"] ?>
      </div>

      </p>
    </div>

  <?php } ?>
  <?php unset($_SESSION["alert"]) ?>

            <form class="ui large form" method="post" action="/users">
                <div class="ui stacked segment">
                    <div class="two fields">
                        <div class="field">
                            <label><i class="user icon"></i> First Name</label>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="field">
                            <label><i class="user icon"></i> Last Name</label>
                            <input type="text" name="last_name" required>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label><i class="mail icon"></i> Email</label>
                            <input type="email" name="contact_email" required>
                        </div>
                        <div class="field">
                            <label><i class="phone icon"></i> Phone</label>
                            <input type="text" name="contact_phone" required>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label><i class="home icon"></i> Address</label>
                            <input type="text" name="address" required>
                        </div>
                        <div class="field">
                            <label><i class="map marker icon"></i> City</label>
                            <input type="text" name="city" required>
                        </div>
                    </div>
                    <div class="two fields">
                        <div class="field">
                            <label><i class="globe icon"></i> Country</label>
                            <input type="text" name="country" required>
                        </div>

                    </div>
                    <div class="field">
                        <label><i class="lock icon"></i> Password</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="field">
                        <label><i class="lock icon"></i> Confirm Password</label>
                        <input type="password" name="confirm_password" required>
                    </div>

                    <div class="field">
                        <label><i class="users icon"></i> User Type</label>
                        <select class="ui dropdown" name="type" required>
                            <option value="student">Student</option>

                        </select>
                    </div>



                    <button class="ui fluid large button teal" type="submit">Submit</button>
                </div>
            </form>



            <div class="ui message">
                Already Have an account? <a href="/login">Login</a>
            </div>
        </div>
    </div>
    <script>
  const passwordField = document.getElementById('password');
  const confirmPasswordField = document.getElementById('confirmPassword');
  const userForm = document.getElementById('userForm');

  function checkPasswordMatch() {
    if (passwordField.value !== confirmPasswordField.value) {
      confirmPasswordField.setCustomValidity("Passwords do not match");
    } else {
      confirmPasswordField.setCustomValidity('');
    }
  }

  passwordField.addEventListener('change', checkPasswordMatch);
  confirmPasswordField.addEventListener('keyup', checkPasswordMatch);

  userForm.addEventListener('submit', (event) => {
    if (!userForm.checkValidity()) {
      event.preventDefault();
    }
    userForm.classList.add('was-validated');
  });
</script>
</body>

</html>