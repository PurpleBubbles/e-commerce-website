//buyer_registration validation file
import 'db_connection.php';
//only occurs if buyer_registration form is submitted
document.getElementById('buyer_registration').addEventListener('submit',function(event){
    //grab field values
    let userName = document.getElementById('userName').value;
    let email = document.getElementById('email').value;
    let phoneNumber = document.getElementById('phoneNumber').value;
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

    if(email.length < 10){

    }
})