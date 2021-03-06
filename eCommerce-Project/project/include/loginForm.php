<script>

    function validateLog()
    {
        //Small note: variable and form names indicate email, but in reality it is the username
        var email = document.forms["logForm"]["email"].value;
        var password = document.forms["logForm"]["password"].value;

        //If email field is empty, adds error class
        if (email == "")
        {
            var a = document.getElementById("emailField");
            a.className += " error";
        }
        //If password is field is empty, adds error class
        if(password == "")
        {
            var b = document.getElementById("passwordField");
            b.className += " error";
        }

        //Removes error field/stays the same
        if (email != "")
        {
            document.getElementById("emailField").className = "";
            document.getElementById("emailField").className = "field";
        }

        if (password != "")
        {
            document.getElementById("passwordField").className = "";
            document.getElementById("passwordField").className = "field";
        }



        if(email!="" && password !="")
        {

            //Storing the username and password in javascript objects then converting to JSON
            var user = new Object();
            user.email = email;
            user.password = password;
            var jsonString = JSON.stringify(user);

            //Sending http request to the php file for validation
            request = new XMLHttpRequest();
            request.open("POST", "include/loginValidate.php", true);
            request.setRequestHeader("Content-type", "application/json");

            //Testing new way of doing stuff
            request.send(jsonString);

            request.onreadystatechange = processRequest;
            function processRequest(e)
            {
                if (request.readyState == 4 && request.status == 200)
                {
                    var response = JSON.parse(request.responseText);
                    console.log(response.answer);

                    //If validation is true then php session variable should be set and the login modal should close
                    if(response.answer=="true")
                    {

                        window.location.replace("./account.php");

                        $('.ui.modal.login')
                            .modal('hide')
                        ;
                    }


                    //If validation is false then error message should appear
                    if(response.answer=="false")
                    {
                        document.getElementById("failureMessage").style.display = "block";
                    }

                }
            }


        }
    }
</script>


<div class="ui middle aligned center aligned grid">
     <div class="column">
         <h2 class="ui teal image header">

             <div class="content" id="logHeader">
                 Login to your account
             </div>
         </h2>
         <form class="ui large form" name="logForm" method="post">
             <div class="ui stacked segment">

                 <div id="failureMessage" class="ui negative message">
                     <div class="header">
                         We're sorry an error occured
                     </div>
                     <p>Username or password is incorrect</p>
                 </div>

                 <div class="field" id="emailField">
                     <div class="ui left icon input">
                         <i class="user icon"></i>
                         <input type="text" name="email" placeholder="Username">
                     </div>
                 </div>
                 <div class="field" id="passwordField">
                     <div class="ui left icon input">
                         <i class="lock icon"></i>
                         <input type="password" name="password" placeholder="Password">
                     </div>
                 </div>
                 <div class="ui fluid large teal submit button" id="logButton" onclick="validateLog()">Login</div>
             </div>


         </form>

         <div class="ui message">
             New to us? <a href="register.php">Sign Up</a>
         </div>
     </div>
