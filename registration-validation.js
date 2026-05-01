//registration validation file

//only occurs if registration form is submitted
document.getElementById('registration').addEventListener('submit',function(event){
    //grab field values
    let username = document.getElementById('username').value;
    let email = document.getElementById('email').value;
    let phone = document.getElementById('phone').value;
    let password = document.getElementById('password').value;
    let confirmPassword = document.getElementById('confirmPassword').value;
    let role = document.getElementById('role').value;

    if(password.length < 10){
        alert('Password must be at least 10 characters');
        event.preventDefault();
    } else {
        if(password !== confirmPassword){
            alert('Passwords do not match');
            event.preventDefault();
        }
    }
})